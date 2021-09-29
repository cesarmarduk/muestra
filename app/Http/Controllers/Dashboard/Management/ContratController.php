<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Files;
use App\Models\Settings\User;
use App\Models\Settings\States;
use App\Models\Settings\Cities;
use App\Models\Settings\Templates;
use App\Models\Management\Address;
use App\Models\Management\Properties;
use App\Models\Management\Signers;
use App\Models\Management\Notarials;
use App\Models\Management\Contrats;
use App\Models\Management\ContratsSigners;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PdfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class ContratController extends Controller
{
    public function simple()
    {
        $states = States::orderBy('name', 'ASC')->get();

        return view('forms.simple.index', compact('states'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $mount = NULL;

        $validator = Validator::make($request->all(), [
            'manager_name'      => ['required', 'string', 'max:255'],
            'manager_email'     => ['required', 'email', 'max:255'],
            'manager_phone'     => ['required']
        ]);

        if ($validator->fails()):
            $errors = $validator->errors();

            return redirect()->route('contrats.simple')->with(['errors' => $errors]);
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

            $user = User::find($manager->id);
        endif;

        $user_id = $user->id;

        $address_property_id = Address::create([
            'type_road'     => $request->property_type_road,
            'name_road'     => $request->property_name_road,
            'exterior'      => $request->property_exterior,
            'interior'      => $request->property_interior,
            'colonia'       => $request->property_colonia,
            'postal_code'   => $request->property_postal_code,
            'municipal'     => $request->property_municipal,
            'entity'        => $request->property_entity,
            'user_id'       => $user_id
        ]);

        $property_id = Properties::create([
            'address_id'    => $address_property_id->id,
            'user_id'       => $user_id
        ]);

        $date_beginning = $request->contrat_beginning_year.'-'.$request->contrat_beginning_mounth.'-'.$request->contrat_beginning_day;
        $date_finish    = $request->contrat_finish_year.'-'.$request->contrat_finish_mounth.'-'.$request->contrat_finish_day;

        $contrat_id = Contrats::create([
            'date_beginning'    => $date_beginning,
            'date_finish'       => $date_finish,
            'mount_term'        => $mount,
            'rent_annual'       => $request->rent_annual,
            'rent_monthly'      => $request->rent_monthly,
            'payment_beginning' => $request->payment_beginning,
            'payment_finish'    => $request->payment_finish,
            'deposit'           => $request->deposit,
            'bank_institution'  => $request->institution,
            'bank_titular'      => $request->titular,
            'bank_account'      => $request->account,
            'bank_clabe'        => $request->clabe,
            'use'               => $request->use,
            'property_id'       => $property_id->id,
            'city_id'           => $request->city_id,
            'user_id'           => $user_id
        ]);

        for ($i = 0; $i < count($request->owner_type); $i++):
            $owner_email = trim($request->owner_email[$i]);
            $owner_email = strtolower($owner_email);

            $owner_id = Signers::where('email', '=', $owner_email)->first();

            if ($owner_id === NULL) :
                $address_id = Address::create([
                    'type_road'     => $request->owner_type_road[$i],
                    'name_road'     => $request->owner_name_road[$i],
                    'exterior'      => $request->owner_exterior[$i],
                    'interior'      => $request->owner_interior[$i],
                    'colonia'       => $request->owner_colonia[$i],
                    'postal_code'   => $request->owner_postal_code[$i],
                    'municipal'     => $request->owner_municipal[$i],
                    'entity'        => $request->owner_entity[$i],
                    'user_id'       => $user_id
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

                $owner_id = Signers::create([
                    'company'       => $company,
                    'rfc'           => $rfc,
                    'name'          => $name,
                    'email'         => $owner_email,
                    'phone'         => $request->owner_phone[$i],
                    'type'          => $request->owner_type[$i],
                    'address_id'    => $address_id->id,
                    'user_id'       => $user_id
                ]);
            endif;

            ContratsSigners::create([
                'type'          => 'Propietario',
                'contrat_id'    => $contrat_id->id,
                'signer_id'     => $owner_id->id
            ]);
        endfor;
        
        for ($k = 0; $k < count($request->tenant_type); $k++):
            $tenant_email = trim($request->tenant_email[$k]);
            $tenant_email = strtolower($tenant_email);

            $tenant_id = Signers::where('email', '=', $tenant_email)->first();

            if ($tenant_id === NULL) :
                $address_id = Address::create([
                    'type_road'     => $request->tenant_type_road[$k],
                    'name_road'     => $request->tenant_name_road[$k],
                    'exterior'      => $request->tenant_exterior[$k],
                    'interior'      => $request->tenant_interior[$k],
                    'colonia'       => $request->tenant_colonia[$k],
                    'postal_code'   => $request->tenant_postal_code[$k],
                    'municipal'     => $request->tenant_municipal[$k],
                    'entity'        => $request->tenant_entity[$k],
                    'user_id'       => $user_id
                ]);

                if ($request->tenant_type[$k] === 'Fisico'): 
                    $company    = NULL;
                    $rfc        = NULL;
                    $name       = $request->tenant_name[$k];
                else : 
                    $company    = $request->tenant_name[$k];
                    $rfc        = $request->tenant_rfc[$k];
                    $name       = NULL;
                endif;

                $tenant_id = Signers::create([
                    'company'       => $company,
                    'rfc'           => $rfc,
                    'name'          => $name,
                    'email'         => $tenant_email,
                    'phone'         => $request->tenant_phone[$k],
                    'type'          => $request->tenant_type[$k],
                    'address_id'    => $address_id->id,
                    'user_id'       => $user_id
                ]);
            endif;

            ContratsSigners::create([
                'type'          => 'Inquilino',
                'contrat_id'    => $contrat_id->id,
                'signer_id'     => $tenant_id->id
            ]);
        endfor;

        if ($request->fiador_type === 'Sin Fiador'):
            $code       = 'contrato-arrendamiento-sin-fiador';
            $filename   = 'sin_fiador';
        else:
            $guarantor_email = trim($request->guarantor_email);
            $guarantor_email = strtolower($guarantor_email);

            $guarantor_id = Signers::where('email', '=', $guarantor_email)->first();

            if ($guarantor_id === NULL) :
                $address_id = Address::create([
                    'type_road'     => $request->guarantor_type_road,
                    'name_road'     => $request->guarantor_name_road,
                    'exterior'      => $request->guarantor_exterior,
                    'interior'      => $request->guarantor_interior,
                    'colonia'       => $request->guarantor_colonia,
                    'postal_code'   => $request->guarantor_postal_code,
                    'municipal'     => $request->guarantor_municipal,
                    'entity'        => $request->guarantor_entity,
                    'user_id'       => $user_id
                ]);

                if ($request->guarantor_type === 'Fisico'):
                    $company    = NULL;
                    $rfc        = NULL;
                    $name       = $request->guarantor_name;
                else : 
                    $company    = $request->guarantor_name;
                    $rfc        = $request->guarantor_rfc;
                    $name       = NULL;
                endif;

                $guarantor_id = Signers::create([
                    'company'       => $company,
                    'rfc'           => $rfc,
                    'name'          => $name,
                    'email'         => $guarantor_email,
                    'phone'         => $request->guarantor_phone,
                    'type'          => $request->guarantor_type,
                    'address_id'    => $address_id->id,
                    'user_id'       => $user_id
                ]);
            endif;

            if ($request->fiador_type === 'Fiador'):
                $notarial_date  = $request->notarial_year.'-'.$request->notarial_mounth.'-'.$request->notarial_day;

                $notarial_id = Notarials::create([
                    'address'   => $request->notarial_address,
                    'writing'   => $request->notarial_writing,
                    'volume'    => $request->notarial_volume,
                    'book'      => $request->notarial_address,
                    'date'      => $notarial_date,
                    'notary'    => $request->notarial_notary,
                    'invoice'   => $request->notarial_invoice,
                    'place'     => $request->notarial_place,
                    'user_id'   => $user_id
                ]);

                ContratsSigners::create([
                    'type'          => 'Fiador',
                    'contrat_id'    => $contrat_id->id,
                    'signer_id'     => $guarantor_id->id,
                    'notarial_id'   => $notarial_id->id
                ]);

                $code       = 'contrato-arrendamiento-fiador';
                $filename   = 'fiador';
            elseif ($request->fiador_type === 'Obligado Solidario'):
                ContratsSigners::create([
                    'type'          => 'Obligado Solidario',
                    'contrat_id'    => $contrat_id->id,
                    'signer_id'     => $guarantor_id->id
                ]);

                $code       = 'contrato-arrendamiento-obligado';
                $filename   = 'obligado_solidario';
            endif;
        endif;

        $function = (new FunctionController())->replaceVariables($code, $contrat_id->id);

        if ($function !== FALSE):
            $storage_path   = storage_path('app/public/contrats/simple/'.$contrat_id->id.'/');

            if (!file_exists($storage_path)):
                \File::makeDirectory($storage_path, 0755, true);
            endif;

            $filename   = 'contrato_de_arrendamiento_'.$filename.'_'.$contrat_id->id.'.pdf';
            
            (new PdfController())->converter($storage_path.$filename, $function);

            $files = Files::create([
                'name'      => $filename,
                'path'      => 'public/contrats/simple/'.$contrat_id->id.'/'.$filename,
                'type'      => 'Pdf'
            ]);

            Contrats::where('id', '=', $contrat_id->id)->update([
                'file_id' => $files->id
            ]);

            $twilio  = new Client('AC0b16a776d73f4981358c5c5d28bd61a5', 'c76fe80eb5843daba71722da3663f20b');
            
            $phone   =  $contrat_id->user->phone;
            
            $message =  $twilio->messages->create('whatsapp:+'.$phone, [
                            "from" => "whatsapp:+14155238886",
                            "body" => 'Legal Global Consulting a generado su Contrato de Arrendamiento, descárguelo en este link ===> https://documents.legalglobalconsulting.com/contratos/simple/descarga/'.$phone.'/'.$contrat_id->id
                        ]);

            return redirect()->route('contrats.simple.success', Crypt::encrypt($contrat_id->id));
        endif;
    }

    public function success($contrat_id){
        $contrat = Contrats::find(Crypt::decrypt($contrat_id));

        if ($contrat === NULL): 
            $message = 'El contrato no se encuentra registrado';
            $color   = 'danger';
        else:
            $message = 'El contrato se registro correctamente, revisa tu whtasapp para descargar tu contrato';
            $color   = 'success';
        endif;
            
        return view('forms.simple.success', compact('message', 'color'));
    }
    
    public function download($phone, $contrat_id){
        $message = 'El contrato no se encuentra registrado';
        $color   = 'danger';
        $file    = '';
        $error   = TRUE;
        $contrat = Contrats::find($contrat_id);

        if ($contrat !== NULL): 
            if ($phone === $contrat->user->phone):
                $file    = Crypt::encrypt($contrat->id);
                $message = 'Descarga tu contrato aqui';
                $color   = 'success';
                $error   = FALSE;
            else :
                $message = 'El telefono del gestor no cohincide con el contrato';
            endif;
        endif;

        return view('forms.simple.download', compact('message', 'color', 'error', 'file'));
    }
}
