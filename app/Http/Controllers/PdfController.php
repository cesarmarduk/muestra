<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function converter($filename, $template){
        $pdf = PDF::loadHTML($template)
                    ->setPaper('legal', 'portrait')
                    ->save($filename);

        return $pdf;
    }
}
