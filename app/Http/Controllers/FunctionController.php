<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Settings\User;
use App\Models\Settings\States;
use App\Models\Settings\Municipalities;
use App\Models\Settings\Templates;
use App\Models\Management\Address;
use App\Models\Management\Properties;
use App\Models\Management\Signers;
use App\Models\Management\Notarials;
use App\Models\Management\Contrats;
use App\Models\Management\ContratsSigners;
use App\Models\Management\Policies;
use App\Models\Management\PoliciesSigners;
use App\Models\PoliciesExternal\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Luecano\NumeroALetras\NumeroALetras;

class FunctionController extends Controller
{
    public function longDate($date){
        $fecha  = explode('-', $date);
        $mes    = '';

        if ((int)$fecha[1] === 1):
            $mes = 'Enero';
        elseif ((int)$fecha[1] === 2):
            $mes = 'Febrero';
        elseif ((int)$fecha[1] === 3):
            $mes = 'Marzo';
        elseif ((int)$fecha[1] === 4):
            $mes = 'Abril';
        elseif ((int)$fecha[1] === 5):
            $mes = 'Mayo';
        elseif ((int)$fecha[1] === 6):
            $mes = 'Junio';
        elseif ((int)$fecha[1] === 7):
            $mes = 'Julio';
        elseif ((int)$fecha[1] === 8):
            $mes = 'Agosto';
        elseif ((int)$fecha[1] === 9):
            $mes = 'Septiembre';
        elseif ((int)$fecha[1] === 10):
            $mes = 'Octubre';
        elseif ((int)$fecha[1] === 11):
            $mes = 'Noviembre';
        elseif ((int)$fecha[1] === 12):
            $mes = 'Diciembre';
        endif;

        return "$fecha[0] de $mes del año $fecha[2]";
    } 
    
    public function shortDate($date){
        $fecha  = explode('-', $date);

        return "$fecha[2]-$fecha[1]-$fecha[0]";
    } 

    public function replaceVariables($code, $contrat_id){
        $response = FALSE;

        $template = Templates::where('code', '=', $code)->first();

        if ($template) : 
            $contrat = Contrats::find($contrat_id);
            
            if ($contrat) : 
                $numbertoletter     = new NumeroALetras();
                $pro_name           = '';
                $pro_address        = '';
                $pro_email          = '';
                $pro_firm           = '';
                $pro_firm_digital   = '';
                $inq_name           = '';
                $inq_address        = '';
                $inq_email          = '';
                $inq_firm           = '';
                $inq_firm_digital   = '';
                $gar_name           = '';
                $gar_address        = '';
                $gar_firm           = '';
                $gar_firm_digital   = '';
                $inmueble_garantia_direccion = "";
                $notarial_escritura = "";
                $notarial_volumen   = "";
                $notarial_fecha     = "";
                $notarial_notario   = "";
                $notarial_folio     = "";
                $notarial_lugar     = "";
                $date_beginning     = '';
                $date_finish        = '';
                $plazo              = '';
                $property           = '';
                $bank_institution   = '';
                $bank_account       = '';
                $bank_clabe         = '';
                $bank_titular       = '';
                $deposit            = '';
                $rent_annual        = '';
                $rent_monthly       = '';

                $contrats_signers  = ContratsSigners::where('contrat_id', '=', $contrat->id)->get();

                if ($contrats_signers):
                    foreach($contrats_signers as $row):
                        if ($row->type === 'Propietario'): 
                            if ($row->signer->type === 'Fisico'):
                                $pro_name .= $row->signer->name.', ';
                                $pro_firm .= $row->signer->name.'<br>'.$row->signer->email_comercia.'<br>'.$row->signer->phone.'<br>';
                            else: 
                                $pro_name .= $row->signer->company.', ';
                                $pro_firm .= $row->signer->company.'<br>'.$row->signer->email_comercia.'<br>'.$row->signer->phone.'<br>';
                            endif;
                            
                            // $pro_email .= $row->signer->email.', ';
                            $pro_email .= $row->signer->email_comercia.', ';
                            
                            if ($row->signer->address_id !== NULL):
                                if ($row->signer->address->interior === NULL):
                                    $pro_address .= $row->signer->address->address.', Número exterior: '.$row->signer->address->exterior.', colonia: '.$row->signer->address->colonia.', código postal: '.$row->signer->address->postal_code.', en el Estado de '.$row->signer->address->municipality->state->name.' y Municipio '.$row->signer->address->municipality->name.', ';
                                else: 
                                    $pro_address .= $row->signer->address->address.', Número exterior: '.$row->signer->address->exterior.', Número interior: '.$row->signer->address->interior.', colonia: '.$row->signer->address->colonia.', código postal: '.$row->signer->address->postal_code.', en el Estado de '.$row->signer->address->municipality->state->name.' y Municipio '.$row->signer->address->municipality->name.', ';
                                endif;
                            endif;
                        elseif ($row->type === 'Inquilino'): 
                            if ($row->signer->type === 'Fisico'):
                                $inq_name .= $row->signer->name.', ';
                                $inq_firm .= $row->signer->name.'<br>'.$row->signer->email_comercia.'<br>'.$row->signer->phone.'<br>';
                            else: 
                                $inq_name .= $row->signer->company.', ';
                                $inq_firm .= $row->signer->company.'<br>'.$row->signer->email_comercia.'<br>'.$row->signer->phone.'<br>';
                            endif;

                            // $inq_email .= $row->signer->email.', ';
                            $inq_email .= $row->signer->email_comercia.', ';
                            
                            // if ($row->signer->address_id !== NULL):
                            //     if ($row->signer->address->interior === NULL):
                            //         $inq_address = $row->signer->address->type_road.', '.$row->signer->address->name_road.', Número exterior: '.$row->signer->address->exterior.', '.$row->signer->address->colonia.', '.$row->signer->address->postal_code.', '.$row->signer->address->municipal.', '.$row->signer->address->entity.', ';
                            //     else: 
                            //         $inq_address = $row->signer->address->type_road.', '.$row->signer->address->name_road.', Número exterior: '.$row->signer->address->exterior.', Número interior: '.$row->signer->address->interior.', '.$row->signer->address->colonia.', '.$row->signer->address->postal_code.', '.$row->signer->address->municipal.', '.$row->signer->address->entity.', ';
                            //     endif;
                            // endif;
                        elseif ($row->type === 'Fiador'): 
                            if ($row->signer->type === 'Fisico'):
                                $gar_name .= $row->signer->name.', ';
                                $gar_firm .= $row->signer->name.'<br>'.$row->signer->email_comercia.'<br>'.$row->signer->phone;
                            else: 
                                $gar_name .= $row->signer->company.', ';
                                $gar_firm .= $row->signer->company.'<br>'.$row->signer->email_comercia.'<br>'.$row->signer->phone;
                            endif;
                            
                            if ($row->signer->address_id !== NULL):
                                if ($row->signer->address->interior === NULL):
                                    $gar_address .= $row->signer->address->address.', Número exterior: '.$row->signer->address->exterior.', colonia: '.$row->signer->address->colonia.', código postal: '.$row->signer->address->postal_code.', en el Estado de '.$row->signer->address->municipality->state->name.' y Municipio '.$row->signer->address->municipality->name.', ';
                                else: 
                                    $gar_address .= $row->signer->address->address.', Número exterior: '.$row->signer->address->exterior.', Número interior: '.$row->signer->address->interior.', colonia: '.$row->signer->address->colonia.', código postal: '.$row->signer->address->postal_code.', en el Estado de '.$row->signer->address->municipality->state->name.' y Municipio '.$row->signer->address->municipality->name.', ';
                                endif;
                            endif;

                            if ($row->notarial_id !== NULL):
                                $inmueble_garantia_direccion .= $row->notarial->address.', ';
                                $notarial_escritura .= $row->notarial->writing.', ';
                                $notarial_volumen   .= $row->notarial->volume.', ';
                                $notarial_notario   .= $row->notarial->notary.', ';
                                $notarial_folio     .= $row->notarial->invoice.', ';
                                $notarial_lugar     .= $row->notarial->place.', ';

                                if ($row->notarial->date !== NULL):
                                    $notarial_fecha .= $this->shortDate($row->notarial->date);
                                endif;
                            endif;
                        elseif ($row->type === 'Obligado Solidario'): 
                            if ($row->signer->type === 'Fisico'):
                                $gar_name .= $row->signer->name.', ';
                                $gar_firm .= $row->signer->name.'<br>'.$row->signer->email_comercia.'<br>'.$row->signer->phone;
                            else: 
                                $gar_name .= $row->signer->company.', ';
                                $gar_firm .= $row->signer->company.'<br>'.$row->signer->email_comercia.'<br>'.$row->signer->phone;
                            endif;
                            
                            if ($row->signer->address_id !== NULL):
                                if ($row->signer->address->interior === NULL):
                                    $gar_address .= $row->signer->address->address.', Número exterior: '.$row->signer->address->exterior.', colonia: '.$row->signer->address->colonia.', código postal: '.$row->signer->address->postal_code.', en el Estado de '.$row->signer->address->municipality->state->name.' y Municipio '.$row->signer->address->municipality->name.', ';
                                else: 
                                    $gar_address .= $row->signer->address->address.', Número exterior: '.$row->signer->address->exterior.', Número interior: '.$row->signer->address->interior.', colonia: '.$row->signer->address->colonia.', código postal: '.$row->signer->address->postal_code.', en el Estado de '.$row->signer->address->municipality->state->name.' y Municipio '.$row->signer->address->municipality->name.', ';
                                endif;
                            endif;
                        endif;
                    endforeach;

                    if (substr($pro_name, -2) === ", "): 
                        $pro_name = substr($pro_name, 0, -2);
                    endif;
                    
                    if (substr($pro_address, -2) === ", "): 
                        $pro_address = substr($pro_address, 0, -2);
                    endif;
                    
                    if (substr($pro_email, -2) === ", "): 
                        $pro_email = substr($pro_email, 0, -2);
                    endif;
                    
                    if (substr($inq_name, -2) === ", "): 
                        $inq_name = substr($inq_name, 0, -2);
                    endif;
                    
                    // if (substr($inq_address, -2) === ", "): 
                    //     $inq_address = substr($inq_address, 0, -2);
                    // endif;
                    
                    if (substr($inq_email, -2) === ", "): 
                        $inq_email = substr($inq_email, 0, -2);
                    endif;
                    
                    if (substr($gar_name, -2) === ", "): 
                        $gar_name = substr($gar_name, 0, -2);
                    endif;
                    
                    if (substr($gar_address, -2) === ", "): 
                        $gar_address = substr($gar_address, 0, -2);
                    endif;
                    
                    if (substr($inmueble_garantia_direccion, -2) === ", "): 
                        $inmueble_garantia_direccion = substr($inmueble_garantia_direccion, 0, -2);
                    endif;
                    
                    if (substr($notarial_escritura, -2) === ", "): 
                        $notarial_escritura = substr($notarial_escritura, 0, -2);
                    endif;
                    
                    if (substr($notarial_volumen, -2) === ", "): 
                        $notarial_volumen = substr($notarial_volumen, 0, -2);
                    endif;
                    
                    if (substr($notarial_volumen, -2) === ", "): 
                        $notarial_volumen = substr($notarial_volumen, 0, -2);
                    endif;
                    
                    if (substr($notarial_notario, -2) === ", "): 
                        $notarial_notario = substr($notarial_notario, 0, -2);
                    endif;
                    
                    if (substr($notarial_folio, -2) === ", "): 
                        $notarial_folio = substr($notarial_folio, 0, -2);
                    endif;
                    
                    if (substr($notarial_lugar, -2) === ", "): 
                        $notarial_lugar = substr($notarial_lugar, 0, -2);
                    endif;
                    
                    if (substr($notarial_fecha, -2) === ", "): 
                        $notarial_fecha = substr($notarial_fecha, 0, -2);
                    endif;
                endif;

                if ($contrat->property->address_id !== NULL):
                    if ($contrat->property->address->interior === NULL):
                        $property = $contrat->property->address->address.', Número exterior: '.$contrat->property->address->exterior.', colonia: '.$contrat->property->address->colonia.', código postal: '.$contrat->property->address->postal_code.', en el Estado de '.$contrat->property->address->municipality->state->name.' y Municipio '.$contrat->property->address->municipality->name.', ';
                    else: 
                        $property = $contrat->property->address->address.', Número exterior: '.$contrat->property->address->exterior.', Número interior: '.$contrat->property->address->interior.', colonia: '.$contrat->property->address->colonia.', código postal: '.$contrat->property->address->postal_code.', en el Estado de '.$contrat->property->address->municipality->state->name.' y Municipio '.$contrat->property->address->municipality->name.', ';
                    endif;
                endif;

                if ($contrat->date_beginning !== NULL) : 
                    $date_beginning     = $this->longDate($this->shortDate($contrat->date_beginning));
                endif;
                
                if ($contrat->date_finish !== NULL) : 
                    $date_finish        = $this->longDate($this->shortDate($contrat->date_finish));
                endif;
                
                if ($contrat->date_beginning !== NULL AND $contrat->date_finish !== NULL) : 
                    $datetime1      = date_create($contrat->date_beginning);
                    $datetime2      = date_create($contrat->date_finish);
                    $interval  	    = $datetime1->diff($datetime2);
                    $intervalMeses  = $interval->format("%m");
                    $intervalAnio   = $interval->format("%y");

                    if ($intervalAnio < 1) : 
                        $plazo = $intervalMeses;
                    elseif ($intervalAnio >= 1) :
                        $plazo = ($intervalAnio * 12) + $intervalMeses;
                    endif;
                endif;
                
                if ($contrat->bank_institution !== NULL) : 
                    $bank_institution   = $contrat->bank_institution;
                endif;
                
                if ($contrat->bank_account !== NULL) : 
                    $bank_account       = $contrat->bank_account;
                endif;
                
                if ($contrat->bank_clabe !== NULL) : 
                    $bank_clabe         = $contrat->bank_clabe;
                endif;
                
                if ($contrat->bank_titular !== NULL) : 
                    $bank_titular       = $contrat->bank_titular;
                endif;

                if ($contrat->rent_annual !== NULL):
                    $rent_annual_number = number_format($contrat->rent_annual, '2', '.', ',');
                    $rent_annual_words  = $numbertoletter->toInvoice(round($rent_annual_number), 2, 'MXN');

                    $rent_annual = $rent_annual_number.' ('.$rent_annual_words.')';
                endif;
                
                if ($contrat->rent_monthly !== NULL):
                    $rent_monthly_number = number_format($contrat->rent_monthly, '2', '.', ',');
                    $rent_monthly_words  = $numbertoletter->toInvoice(round($rent_monthly_number), 2, 'MXN');

                    $rent_monthly = $rent_monthly_number.' ('.$rent_monthly_words.')';
                endif;

                if ($contrat->deposit !== NULL):
                    $deposit_number = number_format($contrat->deposit, '2', '.', ',');
                    $deposit_words  = $numbertoletter->toInvoice(round($deposit_number), 2, 'MXN');

                    $deposit = $deposit_number.' ('.$deposit_words.')';
                endif;
                //OWNER SECTION
                $template = $template->template;
                $template = str_replace('[PRO_NOMBRE]', $pro_name, $template);
                $template = str_replace('[PRO_DIRECCION]', $pro_address, $template);
                $template = str_replace('[PRO_EMAIL]', $pro_email, $template);
                $template = str_replace('[PRO_FIRMA]', $pro_firm, $template);
                $template = str_replace('[PRO_FIRMA_DIGITAL]', $pro_firm_digital, $template);
                //TENANT SECTION
                $template = str_replace('[INQ_NOMBRE]', $inq_name, $template);
                $template = str_replace('[INQ_DIRECCION]', $property, $template);
                $template = str_replace('[INQ_EMAIL]', $inq_email, $template);
                $template = str_replace('[INQ_FIRMA]', $inq_firm, $template);
                $template = str_replace('[INQ_FIRMA_DIGITAL]', $inq_firm_digital, $template);
                //GUARANTOR SECTION
                $template = str_replace('[GAR_NOMBRE]', $gar_name, $template);
                $template = str_replace('[GAR_DIRECCION]', $gar_address, $template);
                $template = str_replace('[GAR_FIRMA]', $gar_firm, $template);
                $template = str_replace('[GAR_FIRMA_DIGITAL]', $gar_firm_digital, $template);
                $template = str_replace('[INMUEBLE_GARANTIA_DIRECCION]', $inmueble_garantia_direccion, $template);
                $template = str_replace('[NOTARIAL_ESCRITURA]', $notarial_escritura, $template);
                $template = str_replace('[NOTARIAL_VOLUMEN]', $notarial_volumen, $template);
                $template = str_replace('[NOTARIAL_FECHA]', $notarial_fecha, $template);
                $template = str_replace('[NOTARIAL_NOTARIO]', $notarial_notario, $template);
                $template = str_replace('[NOTARIAL_FOLIO]', $notarial_folio, $template);
                $template = str_replace('[NOTARIAL_LUGAR]', $notarial_lugar, $template);
                //PROPERTY SECTION
                $template = str_replace('[INMUEBLE_DIRECCION]', $property, $template);
                //CONTRAT SECTION
                $template = str_replace('[CONTRATO_FECHA_INICIO]', $date_beginning, $template);
                $template = str_replace('[CONTRATO_FECHA_CULMINACION]', $date_finish, $template);
                $template = str_replace('[CONTRATO_FECHA]', $date_beginning, $template);
                $template = str_replace('[PLAZO_ARRENDAMIENTO]', $plazo, $template);
                $template = str_replace('[CONTRATO_PAGO_DESDE]', $contrat->payment_beginning, $template);
                $template = str_replace('[CONTRATO_PAGO_HASTA]', $contrat->payment_finish, $template);
                $template = str_replace('[BANCO_INSTITUCION]', $bank_institution, $template);
                $template = str_replace('[BANCO_CUENTA]', $bank_account, $template);
                $template = str_replace('[BANCO_CLABE]', $bank_clabe, $template);
                $template = str_replace('[BANCO_TITULAR]', $bank_titular, $template);
                $template = str_replace('[CONTRATO_USO]', $contrat->use, $template);
                $template = str_replace('[CONTRATO_MONTO_RENTA_MENSUAL]', $rent_monthly, $template);
                $template = str_replace('[CONTRATO_DEPOSITO]', $deposit, $template);
                $template = str_replace('[JURISDICCION]', $contrat->property->address->municipality->state->name, $template);

                $template = str_replace("&ntilde;", 'ñ', $template);
                $template = str_replace("&ntilde", 'ñ', $template);
                $template = str_replace("&Ntilde;", 'Ñ', $template);
                $template = str_replace("&Ntilde", 'Ñ', $template);

                $response = $template;
            endif;
        endif;

        return $response;
    }
}
