<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DocentesController extends Controller
{
    public function index(){
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Estudiante');
        })->whereHas('profile', function ($query) {
            $query->where('status', 1);
        })->with('profile')->paginate(100);
        return view('docentes.index', compact('users'));
    }
}
