<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Recurso;
use App\Models\Semana;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CursosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.cursos.index')->only('index');
    }



    public function index()
    {
        $usuario = Auth::user();
        $id = $usuario->id;


        // Verifica si el usuario tiene roles asignados
        if ($usuario->roles->isNotEmpty()) {
            // Obtenemos el primer rol del usuario
            $rol = $usuario->roles->first()->name;

            // Verifica si el usuario tiene el rol de "Profesor"
            if ($rol === "Profesor") {
                // Obtén los cursos del profesor directamente a través de la relación cursos
                $MisCursos = $usuario->cursos()
                    ->where('status', 1)
                    ->with('ciclo')
                    ->whereHas('ciclo', function ($query) {
                        $query->where('status', 1);
                    })->get();

                $MisCursos2 = $usuario->curso()->get();
                
                return view('admin.cursos.index', compact('MisCursos', 'MisCursos2'));
            } elseif ($rol === "Estudiante") {
                // Si el usuario es estudiante, también obtén los cursos del estudiante
                $MisCiclos = $usuario->ciclos()
                    ->wherePivot('status', 1)
                    ->where('ciclos.status', 1)
                    ->get();


                return view('admin.cursos.index', compact('MisCiclos'));
            } else {
                // En caso de que el usuario no tenga ningún rol asignado, lanza una excepción
                abort(403, 'Usuario no tiene roles asignados');
            }
        }
    }



    public function store(Request $request, Curso $curso)
    {
    }


    public function show(Curso $curso)
    {
    }


    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }
}
