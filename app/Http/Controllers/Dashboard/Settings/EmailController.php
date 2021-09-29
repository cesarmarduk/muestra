<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Models\Settings\Emails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('emails.index')) :
            $emails = Emails::where('status', '=', 'Active')->orderBy('code', 'ASC')->get();
            return view('dashboard.settings.emails.index', compact('emails'));
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
        
        if($auth->can('emails.create')) :
            return view('dashboard.settings.emails.create');
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
        
        if($auth->can('emails.store')) :
            $validator = Validator::make($request->all(), [
                'code'          => ['required', 'string', 'max:255', 'unique:emails'],
                'host'          => ['required', 'string', 'max:255'],
                'port'          => ['required', 'string', 'max:255'],
                'username'      => ['required'],
                'password'      => ['required'],
                'encryptation'  => ['required'],
                'from'          => ['required', 'string', 'max:255'],
                'fromname'      => ['required', 'string', 'max:255'],
                'subject'       => ['required', 'string', 'max:255'],
                'template'      => ['required']
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();

                return view('dashboard.settings.emails.create', compact('errors'));
            endif;

            Emails::create([
                'code'          => $request->code,
                'host'          => $request->host,
                'port'          => $request->port,
                'username'      => $request->username,
                'password'      => $request->password,
                'encryptation'  => $request->encryptation,
                'from'          => $request->from,
                'fromname'      => $request->fromname,
                'subject'       => $request->subject,
                'template'      => $request->template,
                'user_id'       => Auth::user()->id
            ]);

            return redirect()->route('dashboard.settings.email.index');
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
        
        if($auth->can('emails.edit')) :
            $email = Emails::find(Crypt::decrypt($id));
            return view('dashboard.settings.emails.edit', compact('email'));
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
        
        if($auth->can('emails.update')) :
            $email = Emails::find(Crypt::decrypt($id));

            if ($email):
                if ($email->code === $request->code):
                    $validator = Validator::make($request->all(), [
                        'code'          => ['required', 'string', 'max:255'],
                        'host'          => ['required', 'string', 'max:255'],
                        'port'          => ['required', 'string', 'max:255'],
                        'username'      => ['required'],
                        'password'      => ['required'],
                        'encryptation'  => ['required'],
                        'from'          => ['required', 'string', 'max:255'],
                        'fromname'      => ['required', 'string', 'max:255'],
                        'subject'       => ['required', 'string', 'max:255'],
                        'template'      => ['required']
                    ]);
                else:
                    $validator = Validator::make($request->all(), [
                        'code'          => ['required', 'string', 'max:255', 'unique:emails'],
                        'host'          => ['required', 'string', 'max:255'],
                        'port'          => ['required', 'string', 'max:255'],
                        'username'      => ['required'],
                        'password'      => ['required'],
                        'encryptation'  => ['required'],
                        'from'          => ['required', 'string', 'max:255'],
                        'fromname'      => ['required', 'string', 'max:255'],
                        'subject'       => ['required', 'string', 'max:255'],
                        'template'      => ['required']
                    ]);
                endif;

                if ($validator->fails()):
                    $errors = $validator->errors();

                    return view('dashboard.settings.emails.edit', compact('errors', 'email'));
                endif;

                Emails::where('id', '=', $email->id)->update([
                    'code'          => $request->code,
                    'host'          => $request->host,
                    'port'          => $request->port,
                    'username'      => $request->username,
                    'password'      => $request->password,
                    'encryptation'  => $request->encryptation,
                    'from'          => $request->from,
                    'fromname'      => $request->fromname,
                    'subject'       => $request->subject,
                    'template'      => $request->template,
                    'id_user'       => Auth::user()->id,
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.email.index');
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
        
        if($auth->can('emails.destroy')) :
            $email  = Emails::find(Crypt::decrypt($id));
            
            if ($email):
                Emails::where('id', '=', $email->id)->update([
                    'status'        => 'Inactive',
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.email.index');
            else:
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
