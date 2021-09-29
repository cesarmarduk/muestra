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

class ExtincionController extends Controller
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
            $contrats = Contrats::where('type', '!=', 'Fiador')
                                ->where('type', '!=', 'Sin Fiador')
                                ->where('type', '!=', 'Obligado Solidario')
                                ->orderBy('id', 'DESC')
                                ->get();
        else:
            $contrats = Contrats::where('type', '!=', 'Fiador')
                                ->where('type', '!=', 'Sin Fiador')
                                ->where('type', '!=', 'Obligado Solidario')
                                ->where('user_id', '=', Auth::user()->id)
                                ->orderBy('id', 'DESC')
                                ->get();
        endif;

        return view('dashboard.management.contrats.extintion.index', compact('contrats'));
    }
}
