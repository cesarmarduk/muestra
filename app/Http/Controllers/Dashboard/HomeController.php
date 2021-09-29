<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Settings\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.home.index');
    }

    public function profile()
    {
        return view('dashboard.home.profile');
    }

    public function editProfile()
    {
        return view('dashboard.home.editProfile');
    }

    public function updateProfile(Request $request)
    
    {
        $user=User::find(auth()->id());

        $user->fullname=$request->nombre;
        $user->email=$request->email;
        $user->phone=$request->telefono;
        if($request->password){
            $user->password=Hash::make($request->password);
            $user->pass=$request->password;
        }
    
        if ($request->hasFile('photo')):
        
            $path=$user->getPathAvatar();
            $fileI = $request->file('photo');
            $name = $fileI->getClientOriginalName();
            $user->photo=$name;
          

            if(storeFile($fileI,$path,$name)):
                $user->save();
                return response()->json(['error'=>false,'message'=>'Se guardo la informacion con exito!']);
            endif;                   
        endif;    
        $user->save();
        return response()->json(['error'=>false,'message'=>'Se guardo la informacion con exito!']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
