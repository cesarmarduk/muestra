<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Settings\User;
use App\Models\Settings\States;
use App\Models\Settings\Cities;
use App\Models\Settings\Templates;
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
use App\Models\Management\PoliciesSignersJob;
use App\Models\Management\PoliciesSignersReferences;
use App\Models\Management\PoliciesFiles;
use App\Models\PoliciesExternal\CountFolio;
use App\Models\PoliciesExternal\ContratsEx;
use App\Models\PoliciesExternal\PoliciesEx;
use App\Models\PoliciesExternal\PoliciesProperties;
use App\Models\PoliciesExternal\PoliciesProPerson;
use App\Models\PoliciesExternal\PoliciesProCompany;
use App\Models\PoliciesExternal\PoliciesTenant;
use App\Models\PoliciesExternal\PoliciesInqPerson;
use App\Models\PoliciesExternal\PoliciesInqCompany;
use App\Models\PoliciesExternal\PoliciesGuarantor;
use App\Models\PoliciesExternal\PoliciesGarPerson;
use App\Models\PoliciesExternal\PoliciesGarCompany;
use App\Models\PoliciesExternal\Property;
use App\Models\PoliciesExternal\AddressEx;
use App\Models\PoliciesExternal\Persons;
use App\Models\PoliciesExternal\Companies;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UpgradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function owner($policy_id)
    {
        $error          = TRUE;
        $policy_signers = '';
        $policy_files   = '';
        $policy         = Policies::find(Crypt::decrypt($policy_id));

        if ($policy) :
            $policy_signers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Propietario')->orderBy('id', 'ASC')->get();
            
            $error = FALSE;
        endif;

        return view('forms.upgrade.owner', compact('error', 'policy', 'policy_signers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOwner(Request $request)
    {
        $policy = Policies::find(Crypt::decrypt($request->policy));

        if ($policy) :
            $policy_signers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Propietario')->orderBy('id', 'ASC')->get();
            
            for($i = 0; $i < count($policy_signers); $i++) : 
                if ($request->owner_id[$i] !== NULL) :
                    $file       = $request->file('owner_id')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/owners/$filename", file_get_contents($request->file('owner_id')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/owners/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
                
                if ($request->owner_address[$i] !== NULL) :
                    $file       = $request->file('owner_address')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/owners/$filename", file_get_contents($request->file('owner_address')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/owners/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
            endfor;

            return redirect()->route('policies.upgrade.tenant', Crypt::encrypt($policy->id));
        endif;

        return redirect()->route('policies.upgrade.owner', $request->policy);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tenant($policy_id)
    {
        $error          = TRUE;
        $policy_signers = '';
        $policy_files   = '';
        $policy         = Policies::find(Crypt::decrypt($policy_id));

        if ($policy) :
            $policy_signers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Inquilino')->orderBy('id', 'ASC')->get();
            
            $error = FALSE;
        endif;

        return view('forms.upgrade.tenant', compact('error', 'policy', 'policy_signers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTenant(Request $request)
    {
        $policy = Policies::find(Crypt::decrypt($request->policy));

        if ($policy) :
            $policy_signers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Inquilino')->orderBy('id', 'ASC')->get();
            
            for($i = 0; $i < count($policy_signers); $i++) : 
                if ($request->tenant_type[$i] === 'Fisico'): 
                    if ($request->job_name[$i] !== NULL): 
                        $policies_signers_job = PoliciesSignersJob::where('policy_id', '=', $policy->id)->where('signer_id', '=', $policy_signers[$i]->signer_id)->first();

                        if ($policies_signers_job === NULL): 
                            PoliciesSignersJob::create([
                                'name'      => $request->job_name[$i], 
                                'email'     => $request->job_email[$i], 
                                'phone'     => $request->job_phone[$i],
                                'address'   => $request->job_address[$i],
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        else: 
                            PoliciesSignersJob::where('id', '=', $policies_signers_job->id)->update([
                                'name'      => $request->job_name[$i], 
                                'email'     => $request->job_email[$i], 
                                'phone'     => $request->job_phone[$i],
                                'address'   => $request->job_address[$i],
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        endif;
                    endif;
                else : 
                    Signers::where('id', '=', $policy_signers[$i]->signer_id)->update([
                        'company'   => $request->tenant_name[$i],
                        'rfc'       => $request->tenant_rfc[$i],
                        'email'     => $request->tenant_email[$i],
                        'phone'     => $request->tenant_phone[$i]
                    ]);

                    $notarial_date  = $request->notarial_year[$i].'-'.$request->notarial_mounth[$i].'-'.$request->notarial_day[$i];

                    if ($policy_signers[$i]->notarial_id === NULL): 
                        $notarial = Notarials::create([
                            'address'   => $request->notarial_address[$i],
                            'writing'   => $request->notarial_writing[$i],
                            'volume'    => $request->notarial_volume[$i],
                            'book'      => $request->notarial_address[$i],
                            'date'      => $notarial_date,
                            'notary'    => $request->notarial_notary[$i],
                            'invoice'   => $request->notarial_invoice[$i],
                            'place'     => $request->notarial_place[$i],
                            'user_id'   => $policy->user_id
                        ]);

                        $notarial_id = $notarial->id;
                    else :
                        Notarials::where('id', '=', $policy_signers[$i]->notarial_id)->update([
                            'address'   => $request->notarial_address[$i],
                            'writing'   => $request->notarial_writing[$i],
                            'volume'    => $request->notarial_volume[$i],
                            'book'      => $request->notarial_address[$i],
                            'date'      => $notarial_date,
                            'notary'    => $request->notarial_notary[$i],
                            'invoice'   => $request->notarial_invoice[$i],
                            'place'     => $request->notarial_place[$i]
                        ]);

                        $notarial_id = $policy_signers[$i]->notarial_id;
                    endif;

                    if ($request->representative[$i] === 'Si'):
                        if ($policy_signers[$i]->representative_id === NULL): 
                            $representative = Representatives::create([
                                'first_name'    => $request->representative_first_name[$i], 
                                'last_name'     => $request->representative_last_name[$i], 
                                'email'         => $request->representative_email[$i], 
                                'phone'         => $request->representative_phone[$i], 
                                'address'       => $request->representative_address[$i],
                                'user_id'       => $policy->user_id
                            ]);
    
                            $representative_id = $representative->id;
                        else :
                            Representatives::where('id', '=', $policy_signers[$i]->representative_id)->update([
                                'first_name'    => $request->representative_first_name[$i], 
                                'last_name'     => $request->representative_last_name[$i], 
                                'email'         => $request->representative_email[$i], 
                                'phone'         => $request->representative_phone[$i], 
                                'address'       => $request->representative_address[$i]
                            ]);
    
                            $representative_id = $policy_signers[$i]->representative_id;
                        endif;
                    else :
                        $representative_id = NULL;
                    endif;

                    PoliciesSigners::where('id', '=', $policy_signers[$i]->id)->update([
                        'notarial_id'       => $notarial_id,
                        'representative_id' => $representative_id
                    ]);
                endif;

                if ($i === 0):
                    if ($request->ref_family_name !== NULL) : 
                        $policies_signers_references = PoliciesSignersReferences::where('policy_id', '=', $policy->id)->where('signer_id', '=', $policy_signers[$i]->signer_id)->first();

                        if ($policies_signers_references === NULL): 
                            PoliciesSignersReferences::create([
                                'name'      => $request->ref_family_name, 
                                'email'     => $request->ref_family_email, 
                                'phone'     => $request->ref_family_phone,
                                'mobile'    => $request->ref_family_mobile,
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        else: 
                            PoliciesSignersReferences::where('id', '=', $policies_signers_references->id)->update([
                                'name'      => $request->ref_family_name, 
                                'email'     => $request->ref_family_email, 
                                'phone'     => $request->ref_family_phone,
                                'mobile'    => $request->ref_family_mobile,
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        endif;
                    endif;
                    
                    if ($request->ref_no_family_name !== NULL) : 
                        $policies_signers_no_references = PoliciesSignersReferences::where('policy_id', '=', $policy->id)->where('signer_id', '=', $policy_signers[$i]->signer_id)->first();

                        if ($policies_signers_no_references === NULL): 
                            PoliciesSignersReferences::create([
                                'name'      => $request->ref_no_family_name, 
                                'email'     => $request->ref_no_family_email, 
                                'phone'     => $request->ref_no_family_phone,
                                'mobile'    => $request->ref_no_family_mobile,
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        else: 
                            PoliciesSignersReferences::where('id', '=', $policies_signers_no_references->id)->update([
                                'name'      => $request->ref_no_family_name, 
                                'email'     => $request->ref_no_family_email, 
                                'phone'     => $request->ref_no_family_phone,
                                'mobile'    => $request->ref_no_family_mobile,
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        endif;
                    endif;
                endif;

                if ($request->tenant_id[$i] !== NULL) :
                    $file       = $request->file('tenant_id')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/tenants/$filename", file_get_contents($request->file('tenant_id')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/tenants/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
                
                if ($request->tenant_address[$i] !== NULL) :
                    $file       = $request->file('tenant_address')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/tenants/$filename", file_get_contents($request->file('tenant_address')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/tenants/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
                
                if ($request->tenant_earnings[$i] !== NULL) :
                    $file       = $request->file('tenant_earnings')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/tenants/$filename", file_get_contents($request->file('tenant_earnings')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/tenants/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
            endfor;

            if ($policy->type === 'Sin Fiador') : 
                if ($policy->status === "Creada"): 
                    $message = '<h5><strong>La póliza se registro correctamente, se envió la solicitud para ser autorizada, en las próximas 24 horas estaremos comunicandonos con usted por medio de su email de contacto ('.$policy->user->email.')</strong></h5>';
                    $color   = 'success';
                    
                    $count_folio = CountFolio::find(1);
                    $fol    = $count_folio->count + 2;
                    $folio  = 'LGCWEB00'.$fol;

                    if($policy->contrat->has_sign):
                        $message = "Se ha registrado correctamente en el sistema y se enviara el documento para la revision por parte del gestor y el posterior envio de las firmas";
                        $folio  = 'LGCSIGN00'.$fol;
                    endif;

                    $address = AddressEx::create([
                        'direccion'   => $policy->property->address->type_road.', '.$policy->property->address->name_road.', Número exterior: '.$policy->property->address->exterior.', Número interior: '.$policy->property->address->interior.', '.$policy->property->address->colonia.', '.$policy->property->address->postal_code.', '.$policy->property->address->municipal.', '.$policy->property->address->entity
                    ]);
                    
                    $property = Property::create([
                        'monto_renta'   => $policy->contrat->rent_monthly,
                        'deposito'      => $policy->contrat->deposit,
                        'uso'           => $policy->contrat->use,
                        'institucion'   => $policy->contrat->bank_institution,
                        'num_cuenta'    => $policy->contrat->bank_account,
                        'titular'       => $policy->contrat->bank_titular,
                        'clabe'         => $policy->contrat->bank_clabe,
                        'direccion'     => $address->id
                    ]);
                    
                    $pol = PoliciesEx::create([
                        'fecha_inicio'      => $policy->date_beginning,
                        'fecha_termino'     => $policy->date_finish,
                        'costo'             => $policy->cost,
                        'folio'             => $folio,
                        'solicitud'         => 1,
                        'tipo'              => $policy->type,
                        'estado'            => 1,
                        'estado_pago'       => 0,
                        'inmueble'          => $property->id,
                        'estado_jurisdiccion' => $policy->city->state_id ?? 0,
                        'externa_type'      => 'Si',
                        'has_sign'          => true,
                        'externa_poliza_id' => $policy->id,
                        'externa_email'     => $policy->user->email
                    ]);

                    if ($pol) :
                        CountFolio::where('id', '=', 1)->update([
                            'count' => $fol
                        ]);

                        ContratsEx::create([
                            'fecha_inicio'      => $policy->contrat->date_beginning,
                            'fecha_termino'     => $policy->contrat->date_finish,
                            'poliza'            => $pol->id
                        ]);

                        $pro_singers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Propietario')->orderBy('id', 'ASC')->get();
                
                        foreach($pro_singers as $pro) : 
                            $direccion_pro = AddressEx::create([
                                'direccion'   => $pro->signer->address->type_road.', '.$pro->signer->address->name_road.', Número exterior: '.$pro->signer->address->exterior.', Número interior: '.$pro->signer->address->interior.', '.$pro->signer->address->colonia.', '.$pro->signer->address->postal_code.', '.$pro->signer->address->municipal.', '.$pro->signer->address->entity
                            ]);

                            if ($pro->signer->type === 'Fisico') : 
                                $propietario_tipo = 1;

                                $person = Persons::create([
                                    'nombre'    => $pro->signer->name,
                                    'correo'    => $pro->signer->email,
                                    'telefono'  => $pro->signer->phone,
                                    'direccion' => $direccion_pro->id
                                ]);
                                
                                $propietario = PoliciesProPerson::create([
                                    'persona' => $person->id
                                ]);
                            else :
                                $propietario_tipo = 2;

                                $company = Companies::create([
                                    'nombre'    => $pro->signer->company,
                                    'rfc'       => $pro->signer->rfc,
                                    'correo'    => $pro->signer->email,
                                    'telefono'  => $pro->signer->phone,
                                    'direccion' => $direccion_pro->id
                                ]);
                                
                                $propietario = PoliciesProCompany::create([
                                    'empresa' => $company->id
                                ]);
                            endif;

                            PoliciesProperties::create([
                                'propietario_tipo'  => $propietario_tipo, 
                                'propietario'       => $propietario->id,
                                'inmueble'          => $property->id
                            ]);
                        endforeach; 
                        
                        $inq_singers = PoliciesSigners::with(['signer'])->where('policy_id', '=', $policy->id)->where('type', '=', 'Inquilino')->orderBy('id', 'ASC')->get();
                
                        foreach($inq_singers as $inq) : 
                            $na=$inq->signer->name;
                            $dirString="Revisar Direccion $na";
                            if(isset($inq->signer->address)):
                                $dirString=$inq->signer->address->type_road.', '.$inq->signer->address->name_road.', Número exterior: '.$inq->signer->address->exterior.', Número interior: '.$inq->signer->address->interior.', '.$inq->signer->address->colonia.', '.$inq->signer->address->postal_code.', '.$inq->signer->address->municipal.', '.$inq->signer->address->entity;
                            endif;
                            $direccion_inq = AddressEx::create([
                                'direccion'   =>  $dirString
                            ]);

                            if ($inq->signer->type === 'Fisico') : 
                                $inquilino_tipo = 1;

                                $person = Persons::create([
                                    'nombre'    => $inq->signer->name,
                                    'correo'    => $inq->signer->email,
                                    'telefono'  => $inq->signer->phone,
                                    'direccion' => $direccion_inq->id
                                ]);
                                
                                $inquilino = PoliciesInqPerson::create([
                                    'persona' => $person->id
                                ]);
                            else :
                                $inquilino_tipo = 2;

                                $company = Companies::create([
                                    'nombre'    => $inq->signer->company,
                                    'rfc'       => $inq->signer->rfc,
                                    'correo'    => $inq->signer->email,
                                    'telefono'  => $inq->signer->phone,
                                    'direccion' => $direccion_inq->id
                                ]);
                                
                                $inquilino = PoliciesInqCompany::create([
                                    'empresa' => $company->id
                                ]);
                            endif;

                            PoliciesTenant::create([
                                'inquilino_tipo'    => $inquilino_tipo, 
                                'inquilino'         => $inquilino->id,
                                'poliza'            => $pol->id
                            ]);
                        endforeach; 
                        
                        $gar_singers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Inquilino')->orderBy('id', 'ASC')->get();
                
                        foreach($gar_singers as $gar) : 
                            $na=$gar->signer->name;
                            $dirString="Revisar Direccion $na";
                            if(isset($gar->signer->address)):
                                $dirString=$gar->signer->address->type_road.', '.$gar->signer->address->name_road.', Número exterior: '.$gar->signer->address->exterior.', Número interior: '.$gar->signer->address->interior.', '.$gar->signer->address->colonia.', '.$gar->signer->address->postal_code.', '.$gar->signer->address->municipal.', '.$gar->signer->address->entity;
                            endif;
                            $direccion_gar = AddressEx::create([
                                'direccion'   =>  $dirString
                            ]);

                           

                            if ($gar->signer->type === 'Fisico') : 
                                $garante_tipo = 1;

                                $person = Persons::create([
                                    'nombre'    => $gar->signer->name,
                                    'correo'    => $gar->signer->email,
                                    'telefono'  => $gar->signer->phone,
                                    'direccion' => $direccion_gar->id
                                ]);
                                
                                $garante = PoliciesGarPerson::create([
                                    'persona' => $person->id
                                ]);
                            else :
                                $garante_tipo = 2;

                                $company = Companies::create([
                                    'nombre'    => $gar->signer->company,
                                    'rfc'       => $gar->signer->rfc,
                                    'correo'    => $gar->signer->email,
                                    'telefono'  => $gar->signer->phone,
                                    'direccion' => $direccion_gar->id
                                ]);
                                
                                $garante = PoliciesGarCompany::create([
                                    'empresa' => $company->id
                                ]);
                            endif;

                            PoliciesGuarantor::create([
                                'garante_tipo'      => $garante_tipo, 
                                'garante'           => $garante->id,
                                'poliza'            => $pol->id
                            ]);
                        endforeach;            

                        if ($policy->type === 'Sin Fiador'):
                        elseif ($policy->type === 'Obligado Solidario'):
                        endif;

                        (new MailController())->sendRequest($folio);

                        Policies::where('id', '=', $policy->id)->update([
                            'status' => 'Solicitud'
                        ]);
                    endif;
                else: 
                    $message    = '<h5><strong>La póliza ya ha sido solicitada</strong></h5>';
                    $color      = 'danger';
                endif;

                return redirect()->route('policies.upgrade.message', [Crypt::encrypt($policy->id), Crypt::encrypt($message), Crypt::encrypt($color)]);
            else :
                return redirect()->route('policies.upgrade.guarantor', Crypt::encrypt($policy->id));
            endif;
        endif;

        return redirect()->route('policies.upgrade.tenant', $request->policy);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guarantor($policy_id)
    {
        $error          = TRUE;
        $policy_signers = '';
        $policy_files   = '';
        $policy         = Policies::find(Crypt::decrypt($policy_id));

        if ($policy) :
            $policy_signers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '!=', 'Propietario')->where('type', '!=', 'Inquilino')->orderBy('id', 'ASC')->get();
            
            $error = FALSE;
        endif;

        return view('forms.upgrade.guarantor', compact('error', 'policy', 'policy_signers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGuarantor(Request $request)
    {
        $policy     = Policies::with('contrat')->find(Crypt::decrypt($request->policy));

        if ($policy) :
            $policy_signers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '!=', 'Propietario')->where('type', '!=', 'Inquilino')->orderBy('id', 'ASC')->get();
            
            for($i = 0; $i < count($policy_signers); $i++) : 
                if ($request->guarantor_type[$i] === 'Fisico'): 
                    Signers::where('id', '=', $policy_signers[$i]->signer_id)->update([
                        'name'      => $request->guarantor_name[$i],
                        'email'     => $request->guarantor_email[$i],
                        'phone'     => $request->guarantor_phone[$i]
                    ]);
                else : 
                    Signers::where('id', '=', $policy_signers[$i]->signer_id)->update([
                        'company'   => $request->guarantor_name[$i],
                        'rfc'       => $request->guarantor_rfc[$i],
                        'email'     => $request->guarantor_email[$i],
                        'phone'     => $request->guarantor_phone[$i]
                    ]);

                    $notarial_date  = $request->notarial_year[$i].'-'.$request->notarial_mounth[$i].'-'.$request->notarial_day[$i];

                    if ($policy_signers[$i]->notarial_id === NULL): 
                        $notarial = Notarials::create([
                            'address'   => $request->notarial_address[$i],
                            'writing'   => $request->notarial_writing[$i],
                            'volume'    => $request->notarial_volume[$i],
                            'book'      => $request->notarial_address[$i],
                            'date'      => $notarial_date,
                            'notary'    => $request->notarial_notary[$i],
                            'invoice'   => $request->notarial_invoice[$i],
                            'place'     => $request->notarial_place[$i],
                            'user_id'   => $policy->user_id
                        ]);

                        $notarial_id = $notarial->id;
                    else :
                        Notarials::where('id', '=', $policy_signers[$i]->notarial_id)->update([
                            'address'   => $request->notarial_address[$i],
                            'writing'   => $request->notarial_writing[$i],
                            'volume'    => $request->notarial_volume[$i],
                            'book'      => $request->notarial_address[$i],
                            'date'      => $notarial_date,
                            'notary'    => $request->notarial_notary[$i],
                            'invoice'   => $request->notarial_invoice[$i],
                            'place'     => $request->notarial_place[$i]
                        ]);

                        $notarial_id = $policy_signers[$i]->notarial_id;
                    endif;

                    if ($request->representative[$i] === 'Si'):
                        if ($policy_signers[$i]->representative_id === NULL): 
                            $representative = Representatives::create([
                                'first_name'    => $request->representative_first_name[$i], 
                                'last_name'     => $request->representative_last_name[$i], 
                                'email'         => $request->representative_email[$i], 
                                'phone'         => $request->representative_phone[$i], 
                                'address'       => $request->representative_address[$i],
                                'user_id'       => $policy->user_id
                            ]);
    
                            $representative_id = $representative->id;
                        else :
                            Representatives::where('id', '=', $policy_signers[$i]->representative_id)->update([
                                'first_name'    => $request->representative_first_name[$i], 
                                'last_name'     => $request->representative_last_name[$i], 
                                'email'         => $request->representative_email[$i], 
                                'phone'         => $request->representative_phone[$i], 
                                'address'       => $request->representative_address[$i]
                            ]);
    
                            $representative_id = $policy_signers[$i]->representative_id;
                        endif;
                    else :
                        $representative_id = NULL;
                    endif;

                    PoliciesSigners::where('id', '=', $policy_signers[$i]->id)->update([
                        'notarial_id'           => $notarial_id,
                        'representative_id'     => $representative_id
                    ]);
                endif;

                $warranty_date  = $request->warranty_year[$i].'-'.$request->warranty_mounth[$i].'-'.$request->warranty_day[$i];

                if ($policy_signers[$i]->property_warranty_id === NULL): 
                    $property_warranty = PropertiesWarranty::create([
                        'address'   => $request->warranty_address[$i],
                        'writing'   => $request->warranty_writing[$i],
                        'volume'    => $request->warranty_volume[$i],
                        'book'      => $request->warranty_address[$i],
                        'date'      => $warranty_date,
                        'notary'    => $request->warranty_notary[$i],
                        'invoice'   => $request->warranty_invoice[$i],
                        'place'     => $request->warranty_place[$i],
                        'user_id'   => $policy->user_id
                    ]);

                    $property_warranty_id = $property_warranty->id;
                else :
                    PropertiesWarranty::where('id', '=', $policy_signers[$i]->property_warranty_id)->update([
                        'address'   => $request->warranty_address[$i],
                        'writing'   => $request->warranty_writing[$i],
                        'volume'    => $request->warranty_volume[$i],
                        'book'      => $request->warranty_address[$i],
                        'date'      => $warranty_date,
                        'notary'    => $request->warranty_notary[$i],
                        'invoice'   => $request->warranty_invoice[$i],
                        'place'     => $request->warranty_place[$i]
                    ]);

                    $property_warranty_id = $policy_signers[$i]->property_warranty_id;
                endif;

                PoliciesSigners::where('id', '=', $policy_signers[$i]->id)->update([
                    'property_warranty_id'  => $property_warranty_id
                ]);

                if ($i === 0):
                    if ($request->ref_family_name !== NULL) : 
                        $policies_signers_references = PoliciesSignersReferences::where('policy_id', '=', $policy->id)->where('signer_id', '=', $policy_signers[$i]->signer_id)->first();

                        if ($policies_signers_references === NULL): 
                            PoliciesSignersReferences::create([
                                'name'      => $request->ref_family_name, 
                                'email'     => $request->ref_family_email, 
                                'phone'     => $request->ref_family_phone,
                                'mobile'    => $request->ref_family_mobile,
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        else: 
                            PoliciesSignersReferences::where('id', '=', $policies_signers_references->id)->update([
                                'name'      => $request->ref_family_name, 
                                'email'     => $request->ref_family_email, 
                                'phone'     => $request->ref_family_phone,
                                'mobile'    => $request->ref_family_mobile,
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        endif;
                    endif;
                    
                    if ($request->ref_no_family_name !== NULL) : 
                        $policies_signers_no_references = PoliciesSignersReferences::where('policy_id', '=', $policy->id)->where('signer_id', '=', $policy_signers[$i]->signer_id)->first();

                        if ($policies_signers_no_references === NULL): 
                            PoliciesSignersReferences::create([
                                'name'      => $request->ref_no_family_name, 
                                'email'     => $request->ref_no_family_email, 
                                'phone'     => $request->ref_no_family_phone,
                                'mobile'    => $request->ref_no_family_mobile,
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        else: 
                            PoliciesSignersReferences::where('id', '=', $policies_signers_no_references->id)->update([
                                'name'      => $request->ref_no_family_name, 
                                'email'     => $request->ref_no_family_email, 
                                'phone'     => $request->ref_no_family_phone,
                                'mobile'    => $request->ref_no_family_mobile,
                                'policy_id' => $policy->id,
                                'signer_id' => $policy_signers[$i]->signer_id,
                            ]);
                        endif;
                    endif;
                endif;

                if ($request->guarantor_id[$i] !== NULL) :
                    $file       = $request->file('guarantor_id')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/guarantors/$filename", file_get_contents($request->file('guarantor_id')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/guarantors/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
                
                if ($request->guarantor_address[$i] !== NULL) :
                    $file       = $request->file('guarantor_address')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/guarantors/$filename", file_get_contents($request->file('guarantor_address')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/guarantors/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
                
                if ($request->guarantor_earnings[$i] !== NULL) :
                    $file       = $request->file('guarantor_earnings')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/guarantors/$filename", file_get_contents($request->file('guarantor_earnings')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/guarantors/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
                
                if ($request->guarantor_writing[$i] !== NULL) :
                    $file       = $request->file('guarantor_writing')[$i];
                    $filename   = time().'.'.$file->getClientOriginalName();
                    $filename   = str_replace(' ', '_', $filename);
                    $filename   = str_replace('-', '_', $filename);
                    Storage::put("public/policies/$policy->id/guarantors/$filename", file_get_contents($request->file('tenant_writing')[$i]->getRealPath()));

                    $files = Files::create([
                        'name'      => $filename,
                        'path'      => "public/policies/$policy->id/guarantors/$filename",
                        'type'      => 'Policy'
                    ]);

                    PoliciesFiles::create([
                        'policy_id' => $policy->id,
                        'signer_id' => $policy_signers[$i]->signer_id,
                        'file_id'   => $files->id
                    ]);
                endif;
            endfor;

            if ($policy->status === "Creada"): 
                $message = '<h5><strong>La póliza se registro correctamente, se envió la solicitud para ser autorizada, en las próximas 24 horas estaremos comunicandonos con usted por medio de su email de contacto ('.$policy->user->email.')</strong></h5>';
                $color   = 'success';
             
                $count_folio = CountFolio::find(1);
                $fol    = $count_folio->count + 2;
                $folio  = 'LGCWEB00'.$fol;
                if($policy->contrat->has_sign):
                    $message = "<h5>Se ha registrado correctamente en el sistema y se enviara el documento para la revision por parte del gestor y el posterior envio de las firmas</h5>";
                    $folio  = 'LGCSIGN00'.$fol;
                endif;
                $address = AddressEx::create([
                    'direccion'   => $policy->property->address->type_road.', '.$policy->property->address->name_road.', Número exterior: '.$policy->property->address->exterior.', Número interior: '.$policy->property->address->interior.', '.$policy->property->address->colonia.', '.$policy->property->address->postal_code.', '.$policy->property->address->municipal.', '.$policy->property->address->entity
                ]);
                
                $property = Property::create([
                    'monto_renta'   => $policy->contrat->rent_monthly,
                    'deposito'      => $policy->contrat->deposit,
                    'uso'           => $policy->contrat->use,
                    'institucion'   => $policy->contrat->bank_institution,
                    'num_cuenta'    => $policy->contrat->bank_account,
                    'titular'       => $policy->contrat->bank_titular,
                    'clabe'         => $policy->contrat->bank_clabe,
                    'direccion'     => $address->id
                ]);
                
                $pol = PoliciesEx::create([
                    'fecha_inicio'      => $policy->date_beginning,
                    'fecha_termino'     => $policy->date_finish,
                    'costo'             => $policy->cost,
                    'folio'             => $folio,
                    'solicitud'         => 1,
                    'tipo'              => $policy->type,
                    'estado'            => 1,
                    'estado_pago'       => 0,
                    'inmueble'          => $property->id,
                    'estado_jurisdiccion' => $policy->city->state_id,
                    'externa_type'      => 'Si',
                    'externa_poliza_id' => $policy->id,
                    'externa_email'     => $policy->user->email
                ]);

                if ($pol) :
                    CountFolio::where('id', '=', 1)->update([
                        'count' => $fol
                    ]);

                    ContratsEx::create([
                        'fecha_inicio'      => $policy->contrat->date_beginning,
                        'fecha_termino'     => $policy->contrat->date_finish,
                        'poliza'            => $pol->id
                    ]);

                    $pro_singers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Propietario')->orderBy('id', 'ASC')->get();
            
                    foreach($pro_singers as $pro) : 
                        $direccion_pro = AddressEx::create([
                            'direccion'   => $pro->signer->address->type_road.', '.$pro->signer->address->name_road.', Número exterior: '.$pro->signer->address->exterior.', Número interior: '.$pro->signer->address->interior.', '.$pro->signer->address->colonia.', '.$pro->signer->address->postal_code.', '.$pro->signer->address->municipal.', '.$pro->signer->address->entity
                        ]);

                        if ($pro->signer->type === 'Fisico') : 
                            $propietario_tipo = 1;

                            $person = Persons::create([
                                'nombre'    => $pro->signer->name,
                                'correo'    => $pro->signer->email,
                                'telefono'  => $pro->signer->phone,
                                'direccion' => $direccion_pro->id
                            ]);
                            
                            $propietario = PoliciesProPerson::create([
                                'persona' => $person->id
                            ]);
                        else :
                            $propietario_tipo = 2;

                            $company = Companies::create([
                                'nombre'    => $pro->signer->company,
                                'rfc'       => $pro->signer->rfc,
                                'correo'    => $pro->signer->email,
                                'telefono'  => $pro->signer->phone,
                                'direccion' => $direccion_pro->id
                            ]);
                            
                            $propietario = PoliciesProCompany::create([
                                'empresa' => $company->id
                            ]);
                        endif;

                        PoliciesProperties::create([
                            'propietario_tipo'  => $propietario_tipo, 
                            'propietario'       => $propietario->id,
                            'inmueble'          => $property->id
                        ]);
                    endforeach; 
                    
                    $inq_singers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Inquilino')->orderBy('id', 'ASC')->get();
            
                    foreach($inq_singers as $inq) : 
                        $direccion_inq = AddressEx::create([
                            'direccion'   => $inq->signer->address->type_road.', '.$inq->signer->address->name_road.', Número exterior: '.$inq->signer->address->exterior.', Número interior: '.$inq->signer->address->interior.', '.$inq->signer->address->colonia.', '.$inq->signer->address->postal_code.', '.$inq->signer->address->municipal.', '.$inq->signer->address->entity
                        ]);

                        if ($inq->signer->type === 'Fisico') : 
                            $inquilino_tipo = 1;

                            $person = Persons::create([
                                'nombre'    => $inq->signer->name,
                                'correo'    => $inq->signer->email,
                                'telefono'  => $inq->signer->phone,
                                'direccion' => $direccion_inq->id
                            ]);
                            
                            $inquilino = PoliciesInqPerson::create([
                                'persona' => $person->id
                            ]);
                        else :
                            $inquilino_tipo = 2;

                            $company = Companies::create([
                                'nombre'    => $inq->signer->company,
                                'rfc'       => $inq->signer->rfc,
                                'correo'    => $inq->signer->email,
                                'telefono'  => $inq->signer->phone,
                                'direccion' => $direccion_inq->id
                            ]);
                            
                            $inquilino = PoliciesInqCompany::create([
                                'empresa' => $company->id
                            ]);
                        endif;

                        PoliciesTenant::create([
                            'inquilino_tipo'    => $inquilino_tipo, 
                            'inquilino'         => $inquilino->id,
                            'poliza'            => $pol->id
                        ]);
                    endforeach; 
                    
                    $gar_singers = PoliciesSigners::where('policy_id', '=', $policy->id)->where('type', '=', 'Inquilino')->orderBy('id', 'ASC')->get();
            
                    foreach($gar_singers as $gar) : 
                        $direccion_gar = AddressEx::create([
                            'direccion'   => $gar->signer->address->type_road.', '.$gar->signer->address->name_road.', Número exterior: '.$gar->signer->address->exterior.', Número interior: '.$gar->signer->address->interior.', '.$gar->signer->address->colonia.', '.$gar->signer->address->postal_code.', '.$gar->signer->address->municipal.', '.$gar->signer->address->entity
                        ]);

                        if ($gar->signer->type === 'Fisico') : 
                            $garante_tipo = 1;

                            $person = Persons::create([
                                'nombre'    => $gar->signer->name,
                                'correo'    => $gar->signer->email,
                                'telefono'  => $gar->signer->phone,
                                'direccion' => $direccion_gar->id
                            ]);
                            
                            $garante = PoliciesGarPerson::create([
                                'persona' => $person->id
                            ]);
                        else :
                            $garante_tipo = 2;

                            $company = Companies::create([
                                'nombre'    => $gar->signer->company,
                                'rfc'       => $gar->signer->rfc,
                                'correo'    => $gar->signer->email,
                                'telefono'  => $gar->signer->phone,
                                'direccion' => $direccion_gar->id
                            ]);
                            
                            $garante = PoliciesGarCompany::create([
                                'empresa' => $company->id
                            ]);
                        endif;

                        PoliciesGuarantor::create([
                            'garante_tipo'      => $garante_tipo, 
                            'garante'           => $garante->id,
                            'poliza'            => $pol->id
                        ]);
                    endforeach;            

                    if ($policy->type === 'Sin Fiador'):
                    elseif ($policy->type === 'Obligado Solidario'):
                    endif;

                    (new MailController())->sendRequest($folio);

                    Policies::where('id', '=', $policy->id)->update([
                        'status' => 'Solicitud'
                    ]);
                endif;
            else: 
                $message    = '<h5><strong>La póliza ya ha sido solicitada</strong></h5>';
                $color      = 'danger';
            endif;

            return redirect()->route('policies.upgrade.message', [$request->policy, Crypt::encrypt($message), Crypt::encrypt($color)]);
        endif;

        return redirect()->route('policies.upgrade.guarantor', $request->policy);
    }

    public function message($policy, $message, $color){
        $message = Crypt::decrypt($message);
        $color   = Crypt::decrypt($color);

        return view('forms.upgrade.message', compact('message', 'color'));
    }

    
}
