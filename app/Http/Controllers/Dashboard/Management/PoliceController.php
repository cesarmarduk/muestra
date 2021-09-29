<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\PoliciesExternal\PoliciesEx;
use App\Models\Management\Policies;
use App\Models\Files;
use App\Models\Settings\States;
use App\Models\Settings\PoliciesType;
use App\Models\Settings\PoliciesPrice;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\PdfController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    private function root(){ 
        return 'https://sis.legalglobalconsulting.com/uploads/folios/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('policy.index')) :
            $policie = Policies::orderBy('id', 'DESC')->get();
        else:
            $policie = Policies::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        endif;

        $policies = [];
        $array = [];
        if ($policie): 
            foreach($policie as $row) :
                $folio      = "";
                $poliza     = "";
                $cont_arre  = "";
                $cont_serv  = "";
                $pagare     = "";

                if ($row->status === 'Autorizada'):
                    $pol = PoliciesEx::where('externa_poliza_id', '=', $row->id)->first();

                    if ($pol) :
                        $folio      = $pol->folio;
                        $poliza     = '<a href="'.$this->root().'polizas/poliza_'.$folio.'.pdf" class="btn btn-success" target="_blank" download="poliza_'.$folio.'.pdf">Descarga</a>';
                        $cont_arre  = '<a href="'.$this->root().'contratos/contrato_arrendamiento_'.$folio.'.pdf" class="btn btn-success" target="_blank" download="contrato_arrendamiento_'.$folio.'.pdf">Descarga</a>';
                        $cont_serv  = '<a href="'.$this->root().'contratos/contrato_servicio_'.$folio.'.pdf" class="btn btn-success" target="_blank" download="contrato_servicio_'.$folio.'.pdf">Descarga</a>';
                        $pagare     = '<a href="'.$this->root().'pagares/pagare_'.$folio.'.pdf" class="btn btn-success" target="_blank" download="pagare_'.$folio.'.pdf">Descarga</a>';
                    endif;
                endif;
                $cost=(int)str_replace(",","",$row->cost);

                $array[] = array(
                    'folio'         => $folio,
                    'poliza'        => $poliza,
                    'cont_arre'     => $cont_arre,
                    'cont_serv'     => $cont_serv,
                    'pagare'        => $pagare,
                    'type'          => $row->type,
                    'policy_type'   => $row->policy_type->name,
                    'date_beginning'=> $row->date_beginning,
                    'date_finish'   => $row->date_finish,
                    'cost'          => number_format($cost, '2', '.', ','),
                    'status'        => $row->status
                );
            endforeach;

            $policies = $array;
        endif;
        

        //$_SERVER["DOCUMENT_ROOT"]

        return view('dashboard.management.contrats.policy.index', compact('policies'));
    }

    public function amount(Request $request)
    {
        $amount=0;
        $monto=0;
        if ($request) :     
            if((int)$request->val === 1 OR (int)$request->val === 2):
                $prices = PoliciesPrice::where('policy_type_id', '=', $request->val)->get();
                foreach($prices as $price) :
                    if ($request->rent_monthly >= $price->price_beginning):
                        if ($price->price_type === '$'):
                            $amount = $price->price;
                        else:
                            $amount = $request->rent_monthly * $price->price / 100;
                        endif;
                    endif;
                endforeach;
                $monto+=$amount;
           
            endif;
            // if($request->services):
            //     foreach($request->services as $service):
            //         if($service=="extincion")
            //             $monto+=150;                    
            //         if($service=="firma")
            //             $monto+=1500;                    
            //     endforeach;

            // endif;
            $message="<strong>$ ".number_format($monto, 2, '.', '')."</strong>";
        endif;

     
        
        return response()->json(['message' => $message], 200); 
    }

    public function create()
    {
        $auth = Auth::user();
        
       
        $states = States::orderBy('name', 'ASC')->get();

        //$_SERVER["DOCUMENT_ROOT"]

        return view('dashboard.management.contrats.policy.create', compact('states'));
    }

    public function exportPdfAjax(Request $request){
        $message    = FALSE;
        $texto      = "";
        $status     = 422;
        $policy     = Policies::find(Crypt::decrypt($request->pol));

        if ($policy):
            if ($policy->type === 'Fiador') : 
                $code = 'Poliza-Fiador';
            elseif ($policy->type === 'Sin Fiador') : 
                $code = 'Poliza-SinFiador';
            elseif ($policy->type === 'Obligado Solidario') : 
                $code = 'Poliza-Obligado';
            endif;

            $function = (new FunctionController())->replaceVariablesPolicies(6, $code, $policy->id);

            if ($function !== FALSE):
                $storage_path   = storage_path('app/public/policies/'.$policy->id.'/');

                if (!file_exists($storage_path)):
                    \File::makeDirectory($storage_path, 0755, true);
                endif;

                $filename   = 'poliza_'.$policy->type.'_folio000'.$policy->id.'.pdf';
                $filename   = str_replace(' ', '_', $filename);
                
                (new PdfController())->converter($storage_path.$filename, $function);

                if($policy->file_id === NULL):
                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => 'public/policies/'.$policy->id.'/'.$filename,
                        'type'      => 'Policy'
                    ]);

                    Policies::where('id', '=', $policy->id)->update([
                        'file_id' => $files->id
                    ]);
                endif;

                $status  = 200;
                $message = '<a href="'.route('dashboard.management.policies.file.pdf', Crypt::encrypt($policy->id)).'" download="'.$filename.'" target="_blank">Descargar archivo</a>';
            endif;
        endif;

        return response()->json(['message' => $message], $status);
    }
}
