<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Baner;
use App\Models\Documento;
use App\Models\Noticia;


use Illuminate\Http\Request;

class NoticiasController extends Controller
{
    public function index()
    {   
        $documentos = Documento::where('status', 1)->get();
        $noticias= Noticia::where('status', 1)->get();
        // $banersPC = Baner::where('status', 1)
        //     ->where('dispositivo', 'PC')
        //     ->where('pagina', 'noticias')
        //     ->get();

        // $banersMovil = Baner::where('status', 1)
        //     ->where('dispositivo', 'Movil')
        //     ->where('pagina', 'inicio')
        //     ->get();
        return view('noticias.index', compact('noticias', 'documentos'));
    }
}
