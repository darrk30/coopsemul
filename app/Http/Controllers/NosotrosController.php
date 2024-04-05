<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NosotrosController extends Controller
{
    public function index()
    {
        // Obtener a los usuarios con el rol de "Profesor" y que tengan un perfil con estado 1
        $profesoresConPerfil = User::whereHas('roles', function ($query) {
            $query->where('name', 'Profesor');
        })->whereHas('profile', function ($query) {
            $query->where('status', 1);
        })->with('profile')->get();

        return view('nosotros.index', compact('profesoresConPerfil'));
    }
}
