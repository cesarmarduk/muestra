<?php

namespace App\Http\Controllers\Auth;

use App\Models\Settings\User;
use App\Models\Settings\Emails;
use App\Models\Management\Contrats;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\MailController;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'min:6'],
            'password_confirmation' => ['required', 'same:password', 'min:6'],
        ]);

        if ($validator->fails()):
            $errors = $validator->errors();

            return view('auth.register', compact('errors'));
        endif;

        $password = $request['password'];

        $user = User::create([
            'fullname'          => $request['fullname'],
            'email'             => $request['email'],
            'remember_token'    => Hash::make($request['email']),
            'password'          => Hash::make($password),
            'pass'              => $password,
            'status'             => 'Active',
            'verified'          => 'Not Verified'
        ]);

        $role = Role::where('name', '=', 'Gestor')->get();

        $user->assignRole($role);

        $email = Emails::where('code', '=', 'user-register')->get();
        
        if ($email):
            $template = str_replace('[NAME]', $user->fullname, $email[0]->template);
            $template = str_replace('[LINK]', env('APP_URL').'registrate/verificacion/'.Crypt::encrypt($user->id), $template);

            $mail = new PHPMailer(true);
            try { 
                $mail->isSMTP(); 
                $mail->CharSet = "utf-8"; 
                $mail->SMTPAuth = true; 
                $mail->SMTPSecure = $email[0]->encryptation;
                $mail->Host = $email[0]->host; 
                $mail->Port = $email[0]->port;
                $mail->Username = $email[0]->username; 
                $mail->Password = $email[0]->password; 
                $mail->setFrom($email[0]->from, $email[0]->fromname); 
                $mail->Subject = $email[0]->subject; 
                $mail->MsgHTML($template); 
                $mail->addAddress($user->email, $user->fullname); 
                $mail->send(); 
                return redirect('/');
            } catch (Exception $e) {
                return redirect()->route('errors.405');
            }
        endif;
    }

    public function index(){
        return view('auth.register');
    }
    
    public function verification($id){
        $color   = 'danger';
        $message = 'No se puede verificar al usuario porque no se encuentra registrado';
        $user    = User::find(Crypt::decrypt($id));
      
        if ($user): 
            if ($user->verified === 'Verified'): 
                $message = 'No se puede verificar al usuario '.$user->fullname.' ('.$user->email.') porque ya ha sido verificado anteriormente';
            elseif ($user->verified === 'Not Verified'): 

                $resp = (new MailController())->sendVerificationConfirm($user);
                $message=$resp['message'];
                $color=$resp['color'];
            endif;
        endif;

        return view('auth.verify', compact('color', 'message'));
    }

    public function resendPasswordContrat(Request $request){

        $validator = Validator::make($request->all(), [
            'contrat'  => ['required']
        ]);

        if ($validator->fails()):
            $errors = $validator->errors();

            return response()->json(["message"=>"No se recibio el identificador del contrato"],417);
        endif;
     
     
        (new MailController())->resendPasswordContrat($request->contrat);

        return response()->json(["message"=>"Se ha enviado la informacion"],200);
       
    }
    
}
