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

class InvestigationController extends Controller
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
            $investigations = Contrats::where('has_investigation', true)
                                ->orderBy('id', 'DESC')
                                ->get();
        else:
            $investigations = Contrats::where('has_investigation', true)
                                ->where('user_id', '=', Auth::user()->id)
                                ->orderBy('id', 'DESC')
                                ->get();
        endif;

        return view('dashboard.management.contrats.investigations.index', compact('investigations'));
    }
}
