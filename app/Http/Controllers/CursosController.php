<?php

namespace App\Http\Controllers;

use App\Models\ContenidoCurso;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index()
    {
        return view('cursos.index');
    }

    public function show(Curso $curso)
    {
        $contenidos = ContenidoCurso::where('curso_id', $curso->id)->get();

        // Cargar la relación entre el curso y el usuario que lo dicta, así como el perfil del usuario
        $curso->load('user.profile');

        return view('cursos.show', compact('curso', 'contenidos'));
    }
}
