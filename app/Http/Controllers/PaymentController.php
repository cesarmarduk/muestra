<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Settings\User;
use App\Models\Settings\States;
use App\Models\Settings\Cities;
use App\Models\Settings\PoliciesType;
use App\Models\Settings\PoliciesPrice;
use App\Models\Management\Address;
use App\Models\Management\Properties;
use App\Models\Management\PropertiesWarranty;
use App\Models\Management\Signers;
use App\Models\Management\Representatives;
use App\Models\Management\Notarials;
use App\Models\Management\Contrats;
use App\Models\Management\ContratsSigners;
use App\Models\Management\Policies;
use App\Models\Management\PoliciesSigners;
use App\Models\Management\PoliciesFiles;
use App\Models\Management\Payments;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct() {
        \Conekta\Conekta::setApiKey("key_izk8xmyqA8pPza3CTbowWQ");
        \Conekta\Conekta::setApiVersion("2.0.0");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function amount(Request $request)
    {
        $message = 'Información en construcción'; 
        $contrat = Contrats::find(Crypt::decrypt($request->contrat));
        $monto=0;
        if ($contrat) :     
            if((int)$request->upgrade === 1 OR (int)$request->upgrade === 2):
                $prices = PoliciesPrice::where('policy_type_id', '=', $request->val)->get();
                foreach($prices as $price) :
                    if ($contrat->rent_monthly >= $price->price_beginning):
                        if ($price->price_type === '$'):
                            $amount = $price->price;
                        else:
                            $amount = $contrat->rent_monthly * $price->price / 100;
                        endif;
                    endif;
                endforeach;
                $monto+=$amount;
            elseif ((int)$request->upgrade === 3) :
                $monto+=2000;
            endif;
            if($request->services):
                foreach($request->services as $service):
                    if($service=="extincion")
                        $monto+=150;                    
                    if($service=="firma")
                        $monto+=1500;                    
                endforeach;

            endif;
            $message="<strong>$ ".number_format($monto, 2, '.', '')."</strong>";
        endif;

     
        
        return response()->json(['message' => $message], 200); 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $status = 422;
        $upgrade = 1;

        $date               = date("Y-m-d H:i:s");
        $mod_date           = strtotime($date."+ 2 days");
        $customer_name      = ''; 
        $customer_email     = ''; 
        $customer_phone     = ''; 
        $message            = 'El contrato simple no está registrado';
        $contrat            = Contrats::find(Crypt::decrypt($request->contrat));
        
        if ($contrat) : 
            $message = 'El contrato simple ya se ecuentra pagado';
            $payment = Payments::where('contrat_id', '=', $contrat->id)->first();
            
            if ($payment === NULL) : 
                $customer_name  = $contrat->user->fullname;
                $customer_email = $contrat->user->email;
                $customer_phone = $contrat->user->phone;
                $amount         = 0;
                $name='';
                $description='';
                if ((int)$request->upgrade === 1 OR (int)$request->upgrade === 2): 
                    if((int)$request->upgrade === 1):
                        $name           = 'Protección Básica';
                        $description    = 'Upgrade a Protección Básica';
                    endif;
                    if((int)$request->upgrade === 2):
                        $name           = 'Protección Total';
                        $description    = 'Upgrade a Póliza Total';
                    endif;

                    $prices = PoliciesPrice::where('policy_type_id', '=', (int)$request->upgrade)->get();

                    foreach($prices as $price) :
                        if ($contrat->rent_monthly >= $price->price_beginning):
                            if ($price->price_type === '$'):
                                $amount = $price->price;
                            else:
                                $amount = $contrat->rent_monthly * $price->price / 100;
                            endif;
                        endif;
                    endforeach;
                elseif ((int)$request->upgrade === 3): 
                    $name           = 'Protección Cobranza';
                    $description    = 'Upgrade a Póliza de Cobranza';
                    $amount         = 2000;
                endif;
                if($request->services):
                    foreach($request->services as $service):
                        if($service=="extincion"):
                            $name           .= ' + Contrato de Extinción';
                            $description    .= ' + Upgrade a Contrato de Extinción';
                            $amount         += 150;
                            $contrat->has_extincion = true; 
                        endif;                  
                        if($service=="firma"):
                            $name           = ' + Firma Electronica';
                            $description    .= ' + Realizar firma electronica del documento';
                            $amount          += 1500;
                            $contrat->has_sign = true; 
                        endif;                 
                    endforeach;
                endif;
            

                if ($request->payment_type === 'OXXO'): 
                    $token_id = NULL;
                    try {
                        $order = \Conekta\Order::create([
                            "line_items" => [
                                [
                                    'name'        => $name,
                                    'description' => $description,
                                    'unit_price'  => (float)$amount*100,
                                    'quantity'    => 1
                                ]
                            ],
                            "currency" => "MXN",
                            "customer_info" => [
                                "name" => $customer_name,
                                "email" => $customer_email,
                                "phone" => '+'.$customer_phone
                            ], 
                            "charges" => [
                                [
                                    "payment_method" => [
                                        "type" => "oxxo_cash",
                                        "expires_at" => $mod_date
                                    ],
                                    'amount' => (float)$amount*100
                                ] 
                            ] 
                        ]);
                    } catch (\Conekta\ParameterValidationError $error){
                        $order = $error->getMessage();
                    } catch (\Conekta\Handler $error){
                        $order = $error->getMessage();
                    }
                elseif ($request->payment_type === 'CARD'): 
                    $token_id = $request->token_id;
                    try {
                        $order = \Conekta\Order::create([
                            "line_items" => [
                                [
                                    'name'        => $name,
                                    'description' => $description,
                                    'unit_price'  => (float)$amount*100,
                                    'quantity'    => 1
                                ]
                            ],
                            "currency" => "MXN",
                            "customer_info" => [
                                "name" => $customer_name,
                                "email" => $customer_email,
                                "phone" => '+'.$customer_phone
                            ], 
                            "charges" => [
                                [
                                    "payment_method" => [
                                        "token_id" => $request->token_id,
                                        'type' => 'card',
                                        "expires_at" => $mod_date
                                    ],
                                    'amount' => (float)$amount*100
                                ] 
                            ] 
                        ]);
                    } catch (\Conekta\ParameterValidationError $error){
                        $order = $error->getMessage();
                    } catch (\Conekta\Handler $error){
                        $order = $error->getMessage();
                    }
                endif; 

                if ($order->payment_status === 'paid' OR $order->payment_status === 'pending_payment'):
                    $contrat->save();
                    $pol_id = "";
                    $reference = "";
                    if ($request->payment_type === 'OXXO'): 
                        $reference = $order->charges[0]->payment_method->reference;
                    endif;
                    // $total  = "$". $order->amount/100 . $order->currency;

                    $payment = Payments::create([
                        'date_payment'      => date('Y-m-d'),
                        'payment_type'      => $request->payment_type,
                        'order_id'          => $order->id,
                        'token_id'          => $token_id,
                        'amount'            => number_format($amount, 2, '.', ','),
                        'status'            => $order->payment_status,
                        'type'              => $name,
                        'contrat_id'        => $contrat->id,
                        'user_id'           => $contrat->user_id
                    ]);

                    if ($contrat->has_extincion == 1) : 
                        if ($payment->contrat->type === 'Fiador' OR $payment->contrat->type === 'Fiador - Extinción Dominio'): 
                            $type = 'Fiador - Extinción Dominio';
                            $code = 'contrato-arrendamiento-fiador-dominio';
                            $name = 'contrato_de_arrendamiento_fiador_exition_dominio_'.$payment->contrat_id.'.pdf';
                        elseif ($payment->contrat->type === 'Obligado Solidario' OR $payment->contrat->type === 'Obligado Solidario - Extinción Dominio'): 
                            $type = 'Obligado Solidario - Extinción Dominio';
                            $code = 'contrato-arrendamiento-obligado-dominio';
                            $name = 'contrato_de_arrendamiento_obligado_solidario_exition_dominio_'.$payment->contrat_id.'.pdf';
                        elseif ($payment->contrat->type === 'Sin Fiador' OR $payment->contrat->type === 'Sin Fiador - Extinción Dominio'): 
                            $type = 'Sin Fiador - Extinción Dominio';
                            $code = 'contrato-arrendamiento-sin-fiador-dominio';
                            $name = 'contrato_de_arrendamiento_sin_fiador_exition_dominio_'.$payment->contrat_id.'.pdf';
                        endif;

                        $function   = (new FunctionController())->replaceVariables($code, $payment->contrat_id);

                        if ($function !== FALSE):
                            Contrats::where('id', '=', $payment->contrat_id)->update([
                                'type' => $type
                            ]);

                            User::where('id', '=', $payment->contrat->user_id)->update([
                                'verified' => 'Verified'
                            ]);

                            $storage_path   = storage_path('app/public/contrats/simple/'.$payment->contrat_id.'/');

                            if (!file_exists($storage_path)):
                                \File::makeDirectory($storage_path, 0755, true);
                            endif;

                            (new PdfController())->converter($storage_path.$name, $function);

                            Files::where('id', '=', $payment->contrat->file_id)->update([
                                'name'      => $name,
                                'path'      => 'public/contrats/simple/'.$payment->contrat_id.'/'.$name
                            ]);
                        endif;
                    endif; 
                  
                    if ($payment->type === 'Protección Básica') : 
                        $upgrade = 1;
                    elseif ($payment->type === 'Protección Total') : 
                        $upgrade = 2;
                    elseif ($payment->type === 'Protección Cobranza') : 
                        $upgrade = 9;
                    endif;

                    if($upgrade == 1 OR $upgrade == 2 OR $upgrade == 9):
                      
                        $prices = PoliciesPrice::where('policy_type_id', '=', $upgrade)->get();

                        foreach($prices as $price) :
                            if ($payment->contrat->rent_monthly >= $price->price_beginning):
                                if ($price->price_type === '$'):
                                    $cost = $price->price;
                                else:
                                    $cost = $payment->contrat->rent_monthly * $price->price / 100;
                                endif;
                            endif;
                        endforeach;

                      
                        if ($payment->contrat->type === 'Fiador' OR $payment->contrat->type === 'Fiador - Extinción Dominio'): 
                            $type = 'Fiador';
                        elseif ($payment->contrat->type === 'Obligado Solidario' OR $payment->contrat->type === 'Obligado Solidario - Extinción Dominio'): 
                            $type = 'Obligado Solidario';
                        elseif ($payment->contrat->type === 'Sin Fiador' OR $payment->contrat->type === 'Sin Fiador - Extinción Dominio'): 
                            $type = 'Sin Fiador';
                        endif;

                        if ((int)$request->upgrade === 1 OR (int)$request->upgrade === 2 OR (int)$request->upgrade === 3): 
                            $policy = Policies::create([
                                'type'              => $type,
                                'date_beginning'    => $payment->contrat->date_beginning,
                                'date_finish'       => $payment->contrat->date_finish,
                                'cost'              => number_format($cost, 2, '.', ','),
                                'deposit'           => number_format($payment->contrat->rent_monthly, 2, '.', ','),
                                'deposit'           => number_format($payment->contrat->deposit, 2, '.', ','),
                                'bank_institution'  => $payment->contrat->institution,
                                'bank_titular'      => $payment->contrat->titular,
                                'bank_account'      => $payment->contrat->account,
                                'bank_clabe'        => $payment->contrat->clabe,
                                'use'               => $payment->contrat->use,
                                'policy_type_id'    => $upgrade,
                                'contrat_id'        => $payment->contrat_id,
                                'property_id'       => $payment->contrat->property_id,
                                'user_id'           => $payment->contrat->user_id
                            ]);

                            User::where('id', '=', $payment->contrat->user_id)->update([
                                'verified' => 'Verified'
                            ]);

                            $contratssigners = ContratsSigners::where('contrat_id', '=', Crypt::decrypt($request->contrat))->orderBy('id', 'ASC')->get();

                            foreach($contratssigners as $row) :
                                if ($row->type === 'Fiador'):
                                    PoliciesSigners::create([
                                        'type'          => $row->type,
                                        'representative'=> 'No',
                                        'policy_id'     => $policy->id,
                                        'signer_id'     => $row->signer_id,
                                        'notarial_id'   => $row->notarial_id
                                    ]);
                                else :
                                    PoliciesSigners::create([
                                        'type'          => $row->type,
                                        'representative'=> 'No',
                                        'policy_id'     => $policy->id,
                                        'signer_id'     => $row->signer_id
                                    ]);
                                endif;
                            endforeach;

                            $pol_id = '<a class="btn btn-danger" href="'.route('policies.upgrade.owner', Crypt::encrypt($policy->id)).'" style="display: block !important; margin: auto;"><i class="icon-check"></i> Siguiente</a>';
                      
                           
                        elseif($request->services):
                           
                                foreach($request->services as $service):
                                    if($service=="extincion"):
                                        $pol_id = "Se agrego la extincion al contrato";
                                    endif;                  
                                    if($service=="firma"):
                                        $pol_id = '<a class="btn btn-danger" href="'.route('contrats.upgrade.sign', Crypt::encrypt($contrat->id)).'" style="display: block !important; margin: auto;"><i class="icon-check"></i> Siguiente</a>';
                                    endif;                 
                                endforeach;
                            
                        
                           
                        endif;

                        
                    endif;
                    (new MailController())->resendPasswordContrat( Crypt::encrypt($contrat->id) );
                    $message = ['reference' => $reference, 'policy' => $pol_id, 'payment'=>true];
                    $status  = 200;
                else: 
                    $message = 'El pago no se realizó con éxito';
                endif;
            endif;
        endif;





       

        return response()->json(['message' => $message], $status); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function order(Request $request)
    {
        $status = 200;
        $message = 'Estatus Pagado'; 
        $upgrade = 1;
        $payment = Payments::where('contrat_id', '=', Crypt::decrypt($request->contrat))->first();

        if ($payment->payment_type === 'OXXO') : 
            $status     = 422;
            $message    = 'Estatus Pendiente'; 
            $order      = \Conekta\Order::find($request->order);
            $order->capture();

            if ($order->payment_status === 'pending_payment'):
                $pol_id = "";

                Payments::where('contrat_id', '=', Crypt::decrypt($request->contrat))->update([
                    'status' => $order->payment_status
                ]);

                if ($payment->contrat->has_extincion == 1 ) : 
                    if ($payment->contrat->type === 'Fiador' OR $payment->contrat->type === 'Fiador - Extinción Dominio'): 
                        $type = 'Fiador - Extinción Dominio';
                        $code = 'contrato-arrendamiento-fiador-dominio';
                        $name = 'contrato_de_arrendamiento_fiador_exition_dominio_'.$payment->contrat_id.'.pdf';
                    elseif ($payment->contrat->type === 'Obligado Solidario' OR $payment->contrat->type === 'Obligado Solidario - Extinción Dominio'): 
                        $type = 'Obligado Solidario - Extinción Dominio';
                        $code = 'contrato-arrendamiento-obligado-dominio';
                        $name = 'contrato_de_arrendamiento_obligado_solidario_exition_dominio_'.$payment->contrat_id.'.pdf';
                    elseif ($payment->contrat->type === 'Sin Fiador' OR $payment->contrat->type === 'Sin Fiador - Extinción Dominio'): 
                        $type = 'Sin Fiador - Extinción Dominio';
                        $code = 'contrato-arrendamiento-sin-fiador-dominio';
                        $name = 'contrato_de_arrendamiento_sin_fiador_exition_dominio_'.$payment->contrat_id.'.pdf';
                    endif;

                    $function   = (new FunctionController())->replaceVariables($code, $payment->contrat_id);

                    if ($function !== FALSE):
                        Contrats::where('id', '=', $payment->contrat_id)->update([
                            'type' => $type
                        ]);

                        User::where('id', '=', $payment->contrat->user_id)->update([
                            'verified' => 'Verified'
                        ]);

                        $storage_path   = storage_path('app/public/contrats/simple/'.$payment->contrat_id.'/');

                        if (!file_exists($storage_path)):
                            \File::makeDirectory($storage_path, 0755, true);
                        endif;

                        (new PdfController())->converter($storage_path.$name, $function);

                        Files::where('id', '=', $payment->contrat->file_id)->update([
                            'name'      => $name,
                            'path'      => 'public/contrats/simple/'.$payment->contrat_id.'/'.$name
                        ]);
                    endif;
                endif; 
                
                if ($payment->type === 'Protección Básica') : 
                    $upgrade = 1;
                elseif ($payment->type === 'Protección Total') : 
                    $upgrade = 2;
                elseif ($payment->type === 'Protección Cobranza') : 
                    $upgrade = 9;
                endif;


                if($upgrade == 1 OR $upgrade == 2 OR $upgrade == 9):
                        $prices = PoliciesPrice::where('policy_type_id', '=', $upgrade)->get();

                        foreach($prices as $price) :
                            if ($payment->contrat->rent_monthly >= $price->price_beginning):
                                if ($price->price_type === '$'):
                                    $cost = $price->price;
                                else:
                                    $cost = $payment->contrat->rent_monthly * $price->price / 100;
                                endif;
                            endif;
                        endforeach;
                  
                 

                    if ($payment->contrat->type === 'Fiador' OR $payment->contrat->type === 'Fiador - Extinción Dominio'): 
                        $type = 'Fiador';
                    elseif ($payment->contrat->type === 'Obligado Solidario' OR $payment->contrat->type === 'Obligado Solidario - Extinción Dominio'): 
                        $type = 'Obligado Solidario';
                    elseif ($payment->contrat->type === 'Sin Fiador' OR $payment->contrat->type === 'Sin Fiador - Extinción Dominio'): 
                        $type = 'Sin Fiador';
                    endif;

                   

                        $policy = Policies::create([
                            'type'              => $type,
                            'date_beginning'    => $payment->contrat->date_beginning,
                            'date_finish'       => $payment->contrat->date_finish,
                            'cost'              => number_format($cost, 2, '.', ','),
                            'deposit'           => number_format($payment->contrat->rent_monthly, 2, '.', ','),
                            'deposit'           => number_format($payment->contrat->deposit, 2, '.', ','),
                            'bank_institution'  => $payment->contrat->institution,
                            'bank_titular'      => $payment->contrat->titular,
                            'bank_account'      => $payment->contrat->account,
                            'bank_clabe'        => $payment->contrat->clabe,
                            'use'               => $payment->contrat->use,
                            'policy_type_id'    => $upgrade,
                            'contrat_id'        => $payment->contrat_id,
                            'property_id'       => $payment->contrat->property_id,
                            'user_id'           => $payment->contrat->user_id
                        ]);

                        User::where('id', '=', $payment->contrat->user_id)->update([
                            'verified' => 'Verified'
                        ]);

                        $contratssigners = ContratsSigners::where('contrat_id', '=', Crypt::decrypt($request->contrat))->orderBy('id', 'ASC')->get();

                        foreach($contratssigners as $row) :
                            if ($row->type === 'Fiador'):
                                PoliciesSigners::create([
                                    'type'          => $row->type,
                                    'representative'=> 'No',
                                    'policy_id'     => $policy->id,
                                    'signer_id'     => $row->signer_id,
                                    'notarial_id'   => $row->notarial_id
                                ]);
                            else :
                                PoliciesSigners::create([
                                    'type'          => $row->type,
                                    'representative'=> 'No',
                                    'policy_id'     => $policy->id,
                                    'signer_id'     => $row->signer_id
                                ]);
                            endif;
                        endforeach;

                        $pol_id = '<a class="btn primary-button" href="'.route('policies.upgrade.owner', Crypt::encrypt($policy->id)).'" style="display: block !important; margin: auto;"><i class="icon-check"></i> Siguiente</a>';
                   
                elseif($request->services):
                           
                    foreach($request->services as $service):
                        if($service=="extincion"):
                            $pol_id = "Se agrego la extincion al contrato";
                        endif;                  
                        if($service=="firma"):
                            $pol_id = '<a class="btn primary-button" href="'.route('contrats.upgrade.sign', Crypt::encrypt($payment->contrat_id)).'" style="display: block !important; margin: auto;"><i class="icon-check"></i> Siguiente</a>';
                        endif;                 
                    endforeach;
                    
                endif;
                (new MailController())->resendPasswordContrat($payment->contrat_id);
                $message = ['status' => 'Estatus Pagado', 'policy' => $pol_id];
                $status  = 200;
            endif;
        else: 
            $pol_id = "";

            $policy = Policies::where('contrat_id', '=', Crypt::decrypt($request->contrat))->first();

            if ($policy === NULL):
                if ($payment->contrat->has_extincion == 1) :
                    if ($payment->contrat->type === 'Fiador' OR $payment->contrat->type === 'Fiador - Extinción Dominio'): 
                        $type = 'Fiador - Extinción Dominio';
                        $code = 'contrato-arrendamiento-fiador-dominio';
                        $name = 'contrato_de_arrendamiento_fiador_exition_dominio_'.$payment->contrat_id.'.pdf';
                    elseif ($payment->contrat->type === 'Obligado Solidario' OR $payment->contrat->type === 'Obligado Solidario - Extinción Dominio'): 
                        $type = 'Obligado Solidario - Extinción Dominio';
                        $code = 'contrato-arrendamiento-obligado-dominio';
                        $name = 'contrato_de_arrendamiento_obligado_solidario_exition_dominio_'.$payment->contrat_id.'.pdf';
                    elseif ($payment->contrat->type === 'Sin Fiador' OR $payment->contrat->type === 'Sin Fiador - Extinción Dominio'): 
                        $type = 'Sin Fiador - Extinción Dominio';
                        $code = 'contrato-arrendamiento-sin-fiador-dominio';
                        $name = 'contrato_de_arrendamiento_sin_fiador_exition_dominio_'.$payment->contrat_id.'.pdf';
                    endif;

                    $function   = (new FunctionController())->replaceVariables($code, $payment->contrat_id);

                    if ($function !== FALSE):
                        Contrats::where('id', '=', $payment->contrat_id)->update([
                            'type' => $type
                        ]);

                        User::where('id', '=', $payment->contrat->user_id)->update([
                            'verified' => 'Verified'
                        ]);

                        $storage_path   = storage_path('app/public/contrats/simple/'.$payment->contrat_id.'/');

                        if (!file_exists($storage_path)):
                            \File::makeDirectory($storage_path, 0755, true);
                        endif;

                        (new PdfController())->converter($storage_path.$name, $function);

                        Files::where('id', '=', $payment->contrat->file_id)->update([
                            'name'      => $name,
                            'path'      => 'public/contrats/simple/'.$payment->contrat_id.'/'.$name
                        ]);
                    endif;
                endif; 
                if ($payment->type === 'Protección Básica') : 
                    $upgrade = 1;
                elseif ($payment->type === 'Protección Total') : 
                    $upgrade = 2;
                elseif ($payment->type === 'Protección Cobranza') : 
                    $upgrade = 9;
                endif;


                if ((int)$request->upgrade === 1 OR (int)$request->upgrade === 2 OR (int)$request->upgrade === 3): 
                        $prices = PoliciesPrice::where('policy_type_id', '=', $upgrade)->get();

                        foreach($prices as $price) :
                            if ($payment->contrat->rent_monthly >= $price->price_beginning):
                                if ($price->price_type === '$'):
                                    $cost = $price->price;
                                else:
                                    $cost = $payment->contrat->rent_monthly * $price->price / 100;
                                endif;
                            endif;
                        endforeach;
                  

                    $prices = PoliciesPrice::where('policy_type_id', '=', $upgrade)->get();

                    foreach($prices as $price) :
                        if ($payment->contrat->rent_monthly >= $price->price_beginning):
                            if ($price->price_type === '$'):
                                $cost = $price->price;
                            else:
                                $cost = $payment->contrat->rent_monthly * $price->price / 100;
                            endif;
                        endif;
                    endforeach;

                    if ($payment->contrat->type === 'Fiador' OR $payment->contrat->type === 'Fiador - Extinción Dominio'): 
                        $type = 'Fiador';
                    elseif ($payment->contrat->type === 'Obligado Solidario' OR $payment->contrat->type === 'Obligado Solidario - Extinción Dominio'): 
                        $type = 'Obligado Solidario';
                    elseif ($payment->contrat->type === 'Sin Fiador' OR $payment->contrat->type === 'Sin Fiador - Extinción Dominio'): 
                        $type = 'Sin Fiador';
                    endif;

                    $policy = Policies::create([
                        'type'              => $type,
                        'date_beginning'    => $payment->contrat->date_beginning,
                        'date_finish'       => $payment->contrat->date_finish,
                        'cost'              => number_format($cost, 2, '.', ','),
                        'rent_monthly'      => number_format($payment->contrat->rent_monthly, 2, '.', ','),
                        'deposit'           => number_format($payment->contrat->deposit, 2, '.', ','),
                        'bank_institution'  => $payment->contrat->institution,
                        'bank_titular'      => $payment->contrat->titular,
                        'bank_account'      => $payment->contrat->account,
                        'bank_clabe'        => $payment->contrat->clabe,
                        'use'               => $payment->contrat->use,
                        'policy_type_id'    => $upgrade,
                        'contrat_id'        => $payment->contrat_id,
                        'property_id'       => $payment->contrat->property_id,
                        'user_id'           => $payment->contrat->user_id
                    ]);

                    User::where('id', '=', $payment->contrat->user_id)->update([
                        'verified' => 'Verified'
                    ]);

                    $contratssigners = ContratsSigners::where('contrat_id', '=', Crypt::decrypt($request->contrat))->orderBy('id', 'ASC')->get();

                    foreach($contratssigners as $row) :
                        if ($row->type === 'Fiador'):
                            PoliciesSigners::create([
                                'type'          => $row->type,
                                'representative'=> 'No',
                                'policy_id'     => $policy->id,
                                'signer_id'     => $row->signer_id,
                                'notarial_id'   => $row->notarial_id
                            ]);
                        else :
                            PoliciesSigners::create([
                                'type'          => $row->type,
                                'representative'=> 'No',
                                'policy_id'     => $policy->id,
                                'signer_id'     => $row->signer_id
                            ]);
                        endif;
                    endforeach;

                    $pol_id = '<a class="btn primary-button" href="'.route('policies.upgrade.owner', Crypt::encrypt($policy->id)).'" style="display: block !important; margin: auto;"><i class="icon-check"></i> Siguiente</a>';
                endif;
                
                if($payment->contrat->has_extincion)
                    $pol_id = "Se agrego la extincion al contrato";
                if($payment->contrat->has_sign)
                    $pol_id = '<a class="btn primary-button" href="'.route('contrats.upgrade.sign', Crypt::encrypt($contrat->id)).'" style="display: block !important; margin: auto;"><i class="icon-check"></i> Siguiente</a>';
             
             

                $message = ['status' => 'Estatus Pagado', 'policy' => $pol_id];
                $status  = 200;
            endif;
        endif;

        return response()->json(['message' => $message], $status); 
    }
}
