<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Models\Settings\User;
use App\Models\Settings\Emails;
use App\Models\Settings\Files;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('users.index')) :
            $users = User::orderBy('fullname', 'ASC')->get();
            return view('dashboard.settings.users.index', compact('users'));
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        
        if($auth->can('users.create')) :
            $roles = Role::all();
            return view('dashboard.settings.users.create', compact('roles'));
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = Auth::user();
        
        if($auth->can('users.store')) :
            $validator = Validator::make($request->all(), [
                'fullname'  => ['required', 'string', 'max:255'],
                'email'     => ['required', 'email', 'max:255', 'unique:users'],
                'role_id'   => ['required']
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();
                $roles  = Role::all();

                return view('dashboard.settings.users.create', compact('errors', 'roles'));
            endif;

            $password = $request['email'];

            $user = User::create([
                'fullname'          => $request['fullname'],
                'email'             => $request['email'],
                'remember_token'    => Hash::make($request['email']),
                'password'          => Hash::make($password),
                'pass'              => $password,
                'phone'             => $request['phone'],
                'address'           => $request['address'],
                'status'            => 'Active',
                'verified'          => 'Not Verified'
            ]);

            $role = Role::where('id', '=', $request->role_id)->get();

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
                } catch (Exception $e) {
                }
            endif;
            
            return redirect()->route('dashboard.settings.user.index');
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auth = Auth::user();
        
        if($auth->can('users.edit')) :
            $roles  = Role::all();
            $user   = User::find(Crypt::decrypt($id));
            $rol    = DB::table('model_has_roles')->where('model_id', '=', Crypt::decrypt($id))->get();

            return view('dashboard.settings.users.edit', compact('roles', 'user', 'rol'));
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auth = Auth::user();
        
        if($auth->can('users.update')) :
            $user = User::find(Crypt::decrypt($id));

            if ($user):
                if ($user->email === $request->email):
                    $validator = Validator::make($request->all(), [
                        'fullname'  => ['required', 'string', 'max:255'],
                        'email'     => ['required', 'email', 'max:255'],
                        'role_id'   => ['required']
                    ]);
                else: 
                    $validator = Validator::make($request->all(), [
                        'fullname'  => ['required', 'string', 'max:255'],
                        'email'     => ['required', 'email', 'max:255', 'unique:users'],
                        'role_id'   => ['required']
                    ]);
                endif;

                if ($validator->fails()):
                    $errors = $validator->errors();
                    $roles  = Role::all();
                    $rol    = DB::table('model_has_roles')->where('model_id', '=', $user->id)->get();

                    return view('dashboard.settings.users.edit', compact('errors', 'roles', 'user', 'rol'));
                endif;

                if ($user->email === $request->email):
                    User::where('id', '=', $user->id)->update([
                        'fullname'          => $request['fullname'],
                        'phone'             => $request['phone'],
                        'address'           => $request['address'],
                        'updated_at'        => date('Y-m-d')
                    ]);
                else:
                    User::where('id', '=', $user->id)->update([
                        'fullname'          => $request['fullname'],
                        'email'             => $request['email'],
                        'remember_token'    => Hash::make($request['email']),
                        'phone'             => $request['phone'],
                        'address'           => $request['address'],
                        'updated_at'        => date('Y-m-d')
                    ]);

                    $email = Emails::where('code', '=', 'user-update')->get();
                    
                    if ($email):
                        $userNew  = User::find($user->id);
                        $template = str_replace('[NAME]', $userNew->fullname, $email[0]->template);
                        $template = str_replace('[USER]', $userNew->email, $template);
                        $template = str_replace('[PASSWORD]', $userNew->pass, $template);

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
                            $mail->addAddress($userNew->email, $userNew->fullname); 
                            $mail->send(); 
                        } catch (Exception $e) {
                        }
                    endif;
                endif;

                $rol = DB::table('model_has_roles')->where('model_id', '=', $user->id)->get();

                if (count($rol) === 0) :
                    $role = Role::where('id', '=', $request->role_id)->get();
        
                    $user->assignRole($role);
                else:
                    DB::table('model_has_roles')->where('model_id', '=', $user->id)->update([
                        'role_id' => $request->role_id
                    ]);
                endif;

                return redirect()->route('dashboard.settings.user.index');
            else: 
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auth = Auth::user();
        
        if($auth->can('users.destroy')) :
            $user  = User::find(Crypt::decrypt($id));
            
            if ($user):
                User::where('id', '=', $user->id)->update([
                    'status'        => 'Inactive',
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.user.index');
            else: 
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
