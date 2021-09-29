<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ErrorsController extends Controller
{
    public function index403(){
        $error = 403;
        if (Auth::user()):
            return view('dashboard.errors.errors', compact('error'));
        else: 
            return view('errors.errors', compact('error'));
        endif;
    }
    
    public function index404(){
        $error = 404;
        if (Auth::user()):
            return view('dashboard.errors.errors', compact('error'));
        else: 
            return view('errors.errors', compact('error'));
        endif;
    }
    
    public function index405(){
        $error = 405;
        if (Auth::user()):
            return view('dashboard.errors.errors', compact('error'));
        else: 
            return view('errors.errors', compact('error'));
        endif;
    }
    
    public function index500(){
        $error = 500;
        if (Auth::user()):
            return view('dashboard.errors.errors', compact('error'));
        else: 
            return view('errors.errors', compact('error'));
        endif;
    }
    
    public function index505(){
        $error = 505;
        if (Auth::user()):
            return view('dashboard.errors.errors', compact('error'));
        else: 
            return view('errors.errors', compact('error'));
        endif;
    }
}