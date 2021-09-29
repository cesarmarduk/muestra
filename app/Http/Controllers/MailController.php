<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Settings\User;
use App\Models\Management\Contrats;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    private function mailConfig($host, $port, $from, $fromname, $encryption, $username, $password)
    {
        $configMail = [
            'driver' => 'smtp',
            'host' => $host,
            'port' => (int)$port,
            'from' => [
                'address' => $from,
                'name' => $fromname,
            ],
            'encryption' => $encryption,
            'username' => $username,
            'password' => $password,
            'sendmail' => '/usr/sbin/sendmail -bs',
            'pretend'   => false
        ];

        config()->set('mail', $configMail);
    }

    public function sendRequest($folio){
        $status = 404;

        $email  = Emails::where('code', '=', 'creacion-poliza')->first();

        if ($email):
            $template = str_replace('[FOLIO]', $folio, $email->template);

            $this->mailConfig($email->host, $email->port, $email->from, $email->fromname, $email->encryptation, $email->username, $email->password);

            // Mail::to('ejecutivo@lgc.com.mx')->send(new SendMail($email->subject, $template));
            Mail::to('eduardoest@netstudios.com.mx')->send(new SendMail($email->subject, $template));

            $status = 200;
        endif;

        return $status;
    }

    public function resendPasswordContrat($contrat_id){
        $status = 404;

        $contrat_id=Crypt::decrypt($contrat_id);
        $contrato = Contrats::with(['user'])->find( $contrat_id );
      
        if($contrato->user->verified === 'Verified'):
            $email = Emails::where('code', '=', 'user-information')->first();
        else:
            $email = Emails::where('code', '=', 'user-register')->first();
        endif;

        if ($email):
         
            $this->mailConfig($email->host, $email->port, $email->from, $email->fromname, $email->encryptation, $email->username, $email->password);

            // Mail::to('ejecutivo@lgc.com.mx')->send(new SendMail($email->subject, $template));
         

            $template = str_replace('[NAME]', $contrato->user->fullname, $email->template);
            $template = str_replace('[EMAIL]', $contrato->user->email, $template);
            $template = str_replace('[PASSWORD]', $contrato->user->pass, $template);
            
            $template = str_replace('[LINK]', env('APP_URL').'registrate/verificacion/'.Crypt::encrypt($contrato->user->id), $template);

            Mail::to($contrato->user->email)->send(new SendMail($email->subject, $template));

          
        endif;
        return true;
    }

    public function sendVerificationConfirm($user){
        $status = 404;
        $color   = 'danger';
      
        $email = Emails::where('code', '=', 'user-confirm')->first();
        $message = 'No se ha configurado un email de confirmacion';
        if ($email):
            $this->mailConfig($email->host, $email->port, $email->from, $email->fromname, $email->encryptation, $email->username, $email->password);
            $template = str_replace('[NAME]', $user->fullname, $email->template);
            $template = str_replace('[EMAIL]', $user->email, $template);
            $template = str_replace('[PASSWORD]', $user->pass, $template);
            Mail::to($user->email)->send(new SendMail($email->subject, $template));
            User::where('id', '=', $user->id)->update([
                'verified'  => 'Verified',
            ]);

            $message =  'Bienvenido a Sistema de Firma Eletrónica. El usuario '.$user->fullname.' ('.$user->email.') ha sido verificado, revisa su busón de correo para obtener tus credenciales de acceso nuestra plataforma';
            $color   = 'success';
          
        endif;
       return ['message'=>$message,'color'=>$color];
    }
}
