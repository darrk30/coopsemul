<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Libro;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MiBiblioteca extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.miBiblioteca.index')->only('index');
        $this->middleware('can:admin.miBiblioteca.show')->only('show');
    }

    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        $id = $user->id;
        $rol = $user->roles->first()->name;

        // Inicializar la variable $libros como una colección vacía
        $libros = collect([]);
        $categorias = collect([]);

        // Verificar el rol del usuario
        if ($rol === "Estudiante") {
            // Obtener los cursos en los que está inscrito el estudiante
            $MisCursos = User::find($id)->cursos()->get();

            // Iterar sobre los cursos del estudiante
            foreach ($MisCursos as $curso) {
                // Obtener las categorías asociadas al curso
                $categoriasCurso = $curso->category()->get();

                // Iterar sobre las categorías del curso
                foreach ($categoriasCurso as $categoria) {
                    // Obtener los libros asociados a la categoría
                    $librosCategoria = $categoria->libros()
                        ->where('status', 1) // Filtrar por libros con estatus 1
                        ->orderBy('created_at', 'desc') // Ordenar por fecha de publicación en orden descendente
                        ->take(10) // Obtener solo los primeros 10 libros
                        ->get();

                    // Agregar los libros de la categoría a la colección de libros
                    $libros = $libros->merge($librosCategoria);

                    // Agregar la categoría a la colección de categorías si aún no está presente
                    if (!$categorias->contains('id', $categoria->id)) {
                        $categorias->push($categoria);
                    }
                }
            }
        } elseif ($rol === "Profesor" || $rol === "Administrador") {
            // Si el usuario es profesor o administrador, obtener todos los libros
            $libros = Libro::where('status', 1) // Filtrar por libros con estatus 1
                ->orderBy('created_at', 'desc') // Ordenar por fecha de publicación en orden descendente
                ->take(10) // Obtener solo los primeros 10 libros
                ->get();

            // Obtener las categorías de los libros
            $categorias = $libros->pluck('category')->unique();
        }

        // Retornar la vista con los libros y categorías disponibles para el usuario
        return view('admin.miBiblioteca.index', compact('libros', 'categorias'));
    }


    public function show(Category $categoria)
    {
        $user = Auth::user();
        $id = $user->id;
        $rol = $user->roles->first()->name;
        // Verificar si el usuario autenticado es un administrador
        if ($rol === "Administrador" || $rol === "Profesor") {
            // Si el usuario es administrador, permitir el acceso directamente
            $libros = $categoria->libros()
                ->where('status', 1) // Filtrar por libros con estatus 1
                ->orderBy('created_at', 'desc') // Ordenar por fecha de publicación en orden descendente
                ->get();
        } else {
            // Si el usuario no es administrador, realizar la verificación de cursos asociados a la categoría
            $user = Auth::user();
            $id = $user->id;
            $tieneCursos = User::find($id)->cursos()->whereHas('category', function ($query) use ($categoria) {
                $query->where('categories.id', $categoria->id);
            })->exists();

            if (!$tieneCursos) {
                // Si el usuario no tiene cursos asociados a esta categoría, lanzar una excepción de autorización
                throw new AuthorizationException('No tienes autorización para ver esta categoría.');
            }

            // Obtener los libros asociados a la categoría
            $libros = $categoria->libros()
                ->where('status', 1) // Filtrar por libros con estatus 1
                ->orderBy('created_at', 'desc') // Ordenar por fecha de publicación en orden descendente
                ->get();
        }

        $nombreCategoria = $categoria->nombre;

        // Retornar la vista con los libros de la categoría
        return view('admin.miBiblioteca.show', compact('libros', 'nombreCategoria'));
    }
}
