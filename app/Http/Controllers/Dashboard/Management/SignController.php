<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Management\Contrats;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('extintion.index')) :
            $signs = Contrats::with('contrat_signers')->where('has_sign',true)
                                ->orderBy('id', 'DESC')
                                ->get();
        else:
            $signs = Contrats::with('contrat_signers')->where('has_sign',true)
                                ->where('user_id', '=', Auth::user()->id)
                                ->orderBy('id', 'DESC')
                                ->get();
        endif;

        return view('dashboard.management.signs.index', compact('signs'));
    }

    public function details(Request $request)
    {
       
       
        $sign = Contrats::with(['contrat_signers.signer.address','property.address','file','user'])->where('id','=',$request->contrat)->first();

        return response()->json($sign);
    }

    public function restartProcess(Request $request)
    {
       
       
        $sign = Contrats::with(['contrat_signers.signer.address','property.address','file','user'])->where('id','=',$request->id)->first();

        return response()->json(['continue'=>true]);
    }

    public function test(Request $request)
    {
       
       
        $id=Crypt::encrypt(7);

        return response()->json($id);
    }
}
