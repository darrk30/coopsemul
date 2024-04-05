<?php

namespace App\Http\Controllers;

use App\Models\Baner;
use App\Models\Curso;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()                
    {
        $cursos = Curso::where('status', 1)->latest('id')->take(8)->get();
        return view('welcome', compact('cursos'));

        //$cursos = Curso::where('status', 1)->take(9)->get();

        // $servicios = Servicio::where('status', 1)->take(4)->get();

        // $banersPC = Baner::where('status', 1)
        //     ->where('dispositivo', 'PC')
        //     ->where('pagina', 'inicio')
        //     ->get();

        // $banersMovil = Baner::where('status', 1)
        //     ->where('dispositivo', 'Movil')
        //     ->where('pagina', 'inicio')
        //     ->get();


        // $usuariosMaestros = User::whereHas('roles', function ($query) {
        //     $query->where('name', 'maestro');
        // })->get();
        //return view('home.index', compact('cursos'));
    }
}
