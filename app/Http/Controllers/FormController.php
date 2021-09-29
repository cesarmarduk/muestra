<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Settings\User;
use App\Models\Settings\Offices;
use App\Models\Settings\States;
use App\Models\Settings\Municipalities;
use App\Models\Settings\Templates;
use App\Models\Management\Address;
use App\Models\Management\Properties;
use App\Models\Management\Signers;
use App\Models\Management\Notarials;
use App\Models\Management\Contrats;
use App\Models\Management\ContratsSigners;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\PdfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = States::orderBy('name', 'ASC')->get();

        return view('forms.simple.index', compact('states'));
    }

    public function store(Request $request)
    {
        if ($request->fiador_type === 'Fiador'):
            $validator = Validator::make($request->all(), [
                // 'owner_name'            => ['required'],
                // 'owner_email'           => ['required'],
                // 'owner_phone'           => ['required'],
                // 'owner_address'         => ['required'],
                // 'owner_exterior'        => ['required'],
                // 'owner_colonia'         => ['required'],
                // 'owner_postal_code'     => ['required'],
                // 'owner_state'           => ['required'],
                // 'owner_municipality'    => ['required'],
                // 'guarantor_name'        => ['required'],
                // 'guarantor_email'       => ['required'],
                // 'guarantor_phone'       => ['required'],
                // 'guarantor_address'     => ['required'],
                // 'guarantor_exterior'    => ['required'],
                // 'guarantor_colonia'     => ['required'],
                // 'guarantor_postal_code' => ['required'],
                // 'guarantor_state'       => ['required'],
                // 'guarantor_municipality'=> ['required'],
                // 'tenant_name'           => ['required'],
                // 'tenant_email'          => ['required'],
                // 'tenant_phone'          => ['required'],
                'property_address'      => ['required'],
                'property_exterior'     => ['required'],
                'property_colonia'      => ['required'],
                'property_postal_code'  => ['required'],
                'rent_monthly'          => ['required'],
                'deposit'               => ['required'],
                'payment_beginning'     => ['required'],
                'payment_finish'        => ['required'],
                'institution'           => ['required'],
                'titular'               => ['required'],
                'account'               => ['required'],
                'clabe'                 => ['required'],
                'state_id'              => ['required'],
                'municipality_id'       => ['required'],
                'manager_name'          => ['required', 'string', 'max:255'],
                'manager_email'         => ['required', 'email', 'max:255'],
                'manager_phone'         => ['required']
            ]); 
        elseif ($request->fiador_type === 'Obligado Solidario'):
            $validator = Validator::make($request->all(), [
                // 'owner_name'            => ['required'],
                // 'owner_email'           => ['required'],
                // 'owner_phone'           => ['required'],
                // 'owner_address'         => ['required'],
                // 'owner_exterior'        => ['required'],
                // 'owner_colonia'         => ['required'],
                // 'owner_postal_code'     => ['required'],
                // 'owner_state'           => ['required'],
                // 'owner_municipality'    => ['required'],
                // 'guarantor_name'        => ['required'],
                // 'guarantor_email'       => ['required'],
                // 'guarantor_phone'       => ['required'],
                // 'guarantor_address'     => ['required'],
                // 'guarantor_exterior'    => ['required'],
                // 'guarantor_colonia'     => ['required'],
                // 'guarantor_postal_code' => ['required'],
                // 'guarantor_state'       => ['required'],
                // 'guarantor_municipality'=> ['required'],
                // 'tenant_name'           => ['required'],
                // 'tenant_email'          => ['required'],
                // 'tenant_phone'          => ['required'],
                'property_address'      => ['required'],
                'property_exterior'     => ['required'],
                'property_colonia'      => ['required'],
                'property_postal_code'  => ['required'],
                'rent_monthly'          => ['required'],
                'deposit'               => ['required'],
                'payment_beginning'     => ['required'],
                'payment_finish'        => ['required'],
                'institution'           => ['required'],
                'titular'               => ['required'],
                'account'               => ['required'],
                'clabe'                 => ['required'],
                'state_id'              => ['required'],
                'municipality_id'       => ['required'],
                'manager_name'          => ['required', 'string', 'max:255'],
                'manager_email'         => ['required', 'email', 'max:255'],
                'manager_phone'         => ['required']
            ]); 
        elseif ($request->fiador_type === 'Sin Fiador'):
            $validator = Validator::make($request->all(), [
                // 'owner_name'          => ['required'],
                // 'owner_email'         => ['required'],
                // 'owner_phone'         => ['required'],
                // 'owner_address'       => ['required'],
                // 'owner_exterior'      => ['required'],
                // 'owner_colonia'       => ['required'],
                // 'owner_postal_code'   => ['required'],
                // 'owner_state'         => ['required'],
                // 'owner_municipality'  => ['required'],
                // 'tenant_name'         => ['required'],
                // 'tenant_email'        => ['required'],
                // 'tenant_phone'        => ['required'],
                'property_address'      => ['required'],
                'property_exterior'     => ['required'],
                'property_colonia'      => ['required'],
                'property_postal_code'  => ['required'],
                'rent_monthly'          => ['required'],
                'deposit'               => ['required'],
                'payment_beginning'     => ['required'],
                'payment_finish'        => ['required'],
                'institution'           => ['required'],
                'titular'               => ['required'],
                'account'               => ['required'],
                'clabe'                 => ['required'],
                'state_id'              => ['required'],
                'municipality_id'       => ['required'],
                'manager_name'          => ['required', 'string', 'max:255'],
                'manager_email'         => ['required', 'email', 'max:255'],
                'manager_phone'         => ['required']
            ]); 
        endif;

        if ($validator->fails()):
            $errors = $validator->errors();

            return redirect()->route('contrats.simple.index')->with(['errors' => $errors]);
        endif;
                  
        $manager  = User::where('email', '=', $request->manager_email)->first();
        
        $phone = str_replace('+', '', $request->manager_phone);
        $phone = trim($phone);

        if ($manager === NULL):
            $email = trim($request->manager_email);
            $email = strtolower($email);

            $user  = User::create([
                'fullname'          => $request->manager_name,
                'email'             => $email,
                'remember_token'    => Hash::make($email),
                'password'          => Hash::make($email),
                'pass'              => $email,
                'phone'             => $phone,
                'status'            => 'Active',
                'verified'          => 'Not Verified'
            ]);
        else :
            User::where('id', '=', $manager->id)->update([
                'phone' => $phone
            ]);

            $user  = User::find($manager->id);
        endif;

        $address_property = Address::create([
            'address'           => $request->property_address,
            'exterior'          => $request->property_exterior,
            'interior'          => $request->property_interior,
            'colonia'           => $request->property_colonia,
            'postal_code'       => $request->property_postal_code,
            'municipality_id'   => $request->municipality_id,
            'user_id'           => $user->id
        ]);

        $property = Properties::create([
            'address_id'    => $address_property->id,
            'user_id'       => $user->id
        ]);

        $date_beginning = $request->contrat_beginning_year.'-'.$request->contrat_beginning_mounth.'-'.$request->contrat_beginning_day;
        $date_finish    = $request->contrat_finish_year.'-'.$request->contrat_finish_mounth.'-'.$request->contrat_finish_day;

        $contrat = Contrats::create([
            'type'              => $request->fiador_type,
            'date_beginning'    => $date_beginning,
            'date_finish'       => $date_finish,
            'rent_monthly'      => $request->rent_monthly,
            'payment_beginning' => $request->payment_beginning,
            'payment_finish'    => $request->payment_finish,
            'deposit'           => $request->deposit,
            'bank_institution'  => $request->institution,
            'bank_titular'      => $request->titular,
            'bank_account'      => $request->account,
            'bank_clabe'        => $request->clabe,
            'use'               => $request->use,
            'property_id'       => $property->id,
            'user_id'           => $user->id
        ]);

        for ($i = 0; $i < count($request->owner_type); $i++):
            $address_owner = Address::create([
                'address'           => $request->owner_address[$i],
                'exterior'          => $request->owner_exterior[$i],
                'interior'          => $request->owner_interior[$i],
                'colonia'           => $request->owner_colonia[$i],
                'postal_code'       => $request->owner_postal_code[$i],
                'municipal'         => $request->owner_municipal[$i],
                'municipality_id'   => $request->owner_municipality[$i],
                'user_id'           => $user->id
            ]);

            if ($request->owner_type[$i] === 'Fisico'): 
                $company    = NULL;
                $rfc        = NULL;
                $name       = $request->owner_name[$i];
            else : 
                $company    = $request->owner_name[$i];
                $rfc        = $request->owner_rfc[$i];
                $name       = NULL;
            endif;

            $owner_email = trim($request->owner_email[$i]);
            $owner_email = strtolower($owner_email);

            $owner = Signers::where('email_comercia', '=', $owner_email)->first();

            if ($owner === NULL):
                $owner = Signers::create([
                    'company'           => $company,
                    'rfc'               => $rfc,
                    'name'              => $name,
                    'email_comercia'    => $owner_email,
                    'phone'             => $request->owner_phone[$i],
                    'type'              => $request->owner_type[$i],
                    'address_id'        => $address_owner->id,
                    'user_id'           => $user->id
                ]);
            endif;

            ContratsSigners::create([
                'type'          => 'Propietario',
                'contrat_id'    => $contrat->id,
                'signer_id'     => $owner->id
            ]);
        endfor;
        
        for ($k = 0; $k < count($request->tenant_type); $k++):
            // $address_tenant = Address::create([
            //     'type_road'     => $request->tenant_type_road[$k],
            //     'name_road'     => $request->tenant_name_road[$k],
            //     'exterior'      => $request->tenant_exterior[$k],
            //     'interior'      => $request->tenant_interior[$k],
            //     'colonia'       => $request->tenant_colonia[$k],
            //     'postal_code'   => $request->tenant_postal_code[$k],
            //     'municipal'     => $request->tenant_municipal[$k],
            //     'entity'        => $request->tenant_entity[$k],
            //     'user_id'       => $user->id
            // ]);

            if ($request->tenant_type[$k] === 'Fisico'): 
                $company    = NULL;
                $rfc        = NULL;
                $name       = $request->tenant_name[$k];
            else : 
                $company    = $request->tenant_name[$k];
                $rfc        = $request->tenant_rfc[$k];
                $name       = NULL;
            endif;

            $tenant_email = trim($request->tenant_email[$k]);
            $tenant_email = strtolower($tenant_email);

            $tenant = Signers::where('email_comercia', '=', $tenant_email)->first();

            if ($tenant === NULL):
                $tenant = Signers::create([
                    'company'           => $company,
                    'rfc'               => $rfc,
                    'name'              => $name,
                    'email_comercia'    => $tenant_email,
                    'phone'             => $request->tenant_phone[$k],
                    'type'              => $request->tenant_type[$k],
                    'address_id'        => NULL,
                    'user_id'           => $user->id
                ]);
            endif;

            ContratsSigners::create([
                'type'          => 'Inquilino',
                'contrat_id'    => $contrat->id,
                'signer_id'     => $tenant->id
            ]);
        endfor;

        if ($request->fiador_type === 'Sin Fiador'):
            $code       = 'contrato-arrendamiento-sin-fiador';
            $filename   = 'sin_fiador';
        else:
            for ($m = 0; $m < count($request->guarantor_type); $m++):
                $address_guarantor = Address::create([
                    'address'           => $request->guarantor_address[$m],
                    'exterior'          => $request->guarantor_exterior[$m],
                    'interior'          => $request->guarantor_interior[$m],
                    'colonia'           => $request->guarantor_colonia[$m],
                    'postal_code'       => $request->guarantor_postal_code[$m],
                    'municipality_id'   => $request->guarantor_municipality[$m],
                    'user_id'           => $user->id
                ]);

                if ($request->guarantor_type[$m] === 'Fisico'):
                    $company    = NULL;
                    $rfc        = NULL;
                    $name       = $request->guarantor_name[$m];
                else : 
                    $company    = $request->guarantor_name[$m];
                    $rfc        = $request->guarantor_rfc[$m];
                    $name       = NULL;
                endif;

                $guarantor_email = trim($request->guarantor_email[$m]);
                $guarantor_email = strtolower($guarantor_email);

                $guarantor = Signers::where('email_comercia', '=', $guarantor_email)->first();

                if ($guarantor === NULL):
                    $guarantor = Signers::create([
                        'company'           => $company,
                        'rfc'               => $rfc,
                        'name'              => $name,
                        'email_comercia'    => $guarantor_email,
                        'phone'             => $request->guarantor_phone[$m],
                        'type'              => $request->guarantor_type[$m],
                        'address_id'        => $address_guarantor->id,
                        'user_id'           => $user->id
                    ]);
                endif;

                if ($request->fiador_type === 'Fiador'):
                    $notarial_date  = $request->notarial_year[$m].'-'.$request->notarial_mounth[$m].'-'.$request->notarial_day[$m];

                    $notarial = Notarials::create([
                        'address'   => $request->notarial_address[$m],
                        'writing'   => $request->notarial_writing[$m],
                        'volume'    => $request->notarial_volume[$m],
                        'book'      => $request->notarial_address[$m],
                        'date'      => $notarial_date,
                        'notary'    => $request->notarial_notary[$m],
                        'invoice'   => $request->notarial_invoice[$m],
                        'place'     => $request->notarial_place[$m],
                        'user_id'   => $user->id
                    ]);

                    ContratsSigners::create([
                        'type'          => 'Fiador',
                        'contrat_id'    => $contrat->id,
                        'signer_id'     => $guarantor->id,
                        'notarial_id'   => $notarial->id
                    ]);

                    $code       = 'contrato-arrendamiento-fiador';
                    $filename   = 'fiador';
                elseif ($request->fiador_type === 'Obligado Solidario'):
                    ContratsSigners::create([
                        'type'          => 'Obligado Solidario',
                        'contrat_id'    => $contrat->id,
                        'signer_id'     => $guarantor->id
                    ]);

                    $code       = 'contrato-arrendamiento-obligado';
                    $filename   = 'obligado_solidario';
                endif;
            endfor;
        endif;

        $message    = '<h5><strong>El contrato se registro correctamente, pero hubo un error al generar el contrato</strong></h5>';
        $color      = 'danger';
        $function   = (new FunctionController())->replaceVariables($code, $contrat->id);

        if ($function !== FALSE):
            $storage_path   = storage_path('app/public/contrats/simple/'.$contrat->id.'/');

            if (!file_exists($storage_path)):
                \File::makeDirectory($storage_path, 0755, true);
            endif;

            $filename   = 'contrato_de_arrendamiento_'.$filename.'_'.$contrat->id.'.pdf';
            
            (new PdfController())->converter($storage_path.$filename, $function);

            $files = Files::create([
                'name'      => $filename,
                'path'      => 'public/contrats/simple/'.$contrat->id.'/'.$filename,
                'type'      => 'Contrat'
            ]);

            Contrats::where('id', '=', $contrat->id)->update([
                'file_id' => $files->id
            ]);

            $twilio  = new Client('AC0b16a776d73f4981358c5c5d28bd61a5', 'c76fe80eb5843daba71722da3663f20b');
            
            $phone   = $contrat->user->phone;

            $twilio->messages->create('+'.$phone, [
                "from" => "+19362434452",
                "body" => 'Legal Global Consulting a generado su Contrato de Arrendamiento, descárguelo en este link ===> https://documents.legalglobalconsulting.com/contratos/simple/descarga/'.$contrat->id.'/'.$phone
            ]);

            $message = '<h5><strong>El contrato se registro correctamente, revisa tu whtasapp para descargar tu contrato</strong></h5>';
            $color   = 'success';
        endif;

        return redirect()->route('contrats.simple.message', [Crypt::encrypt($contrat->id), Crypt::encrypt($message), Crypt::encrypt($color)]);
    }

    public function message($contrat_id, $message, $color){
        $message = Crypt::decrypt($message);
        $color   = Crypt::decrypt($color);

        return view('forms.simple.message', compact('message', 'color'));
    }

    public function messageSignLogin($contrat_id){
        $message = '<h5><strong>Firma pagada con éxito! ingrese al sistema para gestionar tus firmas</strong></h5>';
        $color   = 'success';
     
        $servicio = "Firma Electrónica";

        $contrat   = Crypt::decrypt($contrat_id);
        return view('forms.simple.messageSignLogin', compact('message', 'color','servicio','contrat'));
    }    
    
    public function download($contrat_id, $phone){
        $error      = TRUE;
        $cobranza   = FALSE;
        $message    = 'El contrato no se encuentra registrado';
        $contrat    = '';        
        $contrat    = Contrats::where('id', '=', $contrat_id)->first();

        if ($contrat): 
            $office = Offices::where('municipality_id', '=', $contrat->property->address->municipality_id)->first();

            if ($office): 
                $cobranza= TRUE;
            endif;

            if ($phone === $contrat->user->phone):
                $contrat = $contrat->id;
                $message = 'Descarga tu contrato aqui';
                $error   = FALSE;
            else:
                $message = 'El telefono del gestor no cohincide con el contrato';
            endif;
        endif;

        return view('forms.simple.download', compact('error', 'message', 'cobranza', 'contrat'));
    }
}
