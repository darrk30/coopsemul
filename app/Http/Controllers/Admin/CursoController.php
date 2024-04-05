<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Curso;
use App\Models\Level;
use App\Models\Precio;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.curso.index')->only('index');
        $this->middleware('can:admin.curso.edit')->only('edit', 'update');
        $this->middleware('can:admin.curso.create')->only('create', 'store');
        $this->middleware('can:admin.curso.contenido')->only('Contenido');
        $this->middleware('can:admin.curso.students')->only('Students');
    }

    public function index()
    {

        return view('admin.curso.index');
    }

    public function create()
    {
        $categorias = Category::pluck('nombre', 'id');
        $niveles = Level::pluck('nombre', 'id');
        $precios = Precio::pluck('value', 'id');
        return view('admin.curso.create', compact('categorias', 'niveles', 'precios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'duracion' => 'required|integer',
            'certificado' => 'required|in:0,1',
            'user_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        $userExists = User::where('id', $value)->exists();
                        $profileExists = Profile::where('user_id', $value)->where('status', 1)->exists();

                        if (!$userExists || !$profileExists) {
                            $fail('El usuario no está activo.');
                        }
                    }
                }
            ],

            'category_id' => 'required|exists:categories,id',
            'precio_id' => 'required|exists:precios,id',
            'level_id' => 'required|exists:levels,id',
            'status' => 'required|in:0,1',
            'slug' => 'required|unique:cursos',
            'file' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'codigo.required' => 'El código es obligatorio.',
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'duracion.required' => 'La duración es obligatoria.',
            'duracion.integer' => 'La duración debe ser un número entero.',
            'certificado.required' => 'El campo de certificado es obligatorio.',
            'certificado.in' => 'El certificado debe ser 0 o 1.',
            'user_id.exists' => 'El ID de usuario proporcionado no es válido.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría proporcionada no es válida.',
            'precio_id.required' => 'El precio es obligatorio.',
            'precio_id.exists' => 'El precio proporcionado no es válido.',
            'level_id.required' => 'El nivel es obligatorio.',
            'level_id.exists' => 'El nivel proporcionado no es válido.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser 0 o 1.',
            'slug.required' => 'El slug es obligatorio.',
            'file.image' => 'El archivo debe ser una imagen.',
            'file.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            'file.max' => 'La imagen no debe ser mayor a 2MB.',
        ]);

        $curso = Curso::create($request->all());
        if ($request->file('file')) {
            $url = Storage::put('public/cursos', $request->file('file'));
            $curso->image()->create([
                'url' => $url
            ]);
        }
        return redirect()->route('admin.curso.index', $curso);
    }

    public function edit(Curso $curso)
    {
        $categorias = Category::pluck('nombre', 'id');
        $niveles = Level::pluck('nombre', 'id');
        $precios = Precio::pluck('value', 'id');
        return view('admin.curso.edit', compact('curso', 'categorias', 'niveles', 'precios'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'user_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        $userExists = User::where('id', $value)->exists();
                        $profileExists = Profile::where('user_id', $value)->where('status', 1)->exists();

                        if (!$userExists || !$profileExists) {
                            $fail('El usuario no está activo.');
                        }
                    }
                }
            ],
            'descripcion' => 'required|string',
            'duracion' => 'required|integer',
            'certificado' => 'required|in:0,1',
            'category_id' => 'required|exists:categories,id',
            'precio_id' => 'required|exists:precios,id',
            'level_id' => 'required|exists:levels,id',
            'status' => 'required|in:0,1',
            'slug' => "required|unique:cursos,slug,$curso->id",
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'codigo.required' => 'El código es obligatorio.',
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'duracion.required' => 'La duración es obligatoria.',
            'duracion.integer' => 'La duración debe ser un número entero.',
            'certificado.required' => 'El campo de certificado es obligatorio.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría proporcionada no es válida.',
            'precio_id.required' => 'El precio es obligatorio.',
            'precio_id.exists' => 'El precio proporcionado no es válido.',
            'level_id.required' => 'El nivel es obligatorio.',
            'level_id.exists' => 'El nivel proporcionado no es válido.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser 0 o 1.',
            'slug.required' => 'El slug es obligatorio.',
            'file.image' => 'El archivo debe ser una imagen.',
            'file.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            'file.max' => 'La imagen no debe ser mayor a 2MB.',
        ]);


        $curso->update($request->all());

        if ($request->file('file')) {
            $url = Storage::put('public/cursos', $request->file('file')); // el metodo put guarda la imagen en la carpeta public storage posts

            if ($curso->image) {
                Storage::delete($curso->image->url);
                $curso->image->update([
                    'url' => $url
                ]);
            } else {
                $curso->image()->create([
                    'url' => $url
                ]);
            }
        }

        return redirect()->route('admin.curso.index', $curso)->with('info', 'El curso se actualizo con exito');
    }


    public function BuscarProfesor(Request $request)
    {
        $searchQuery = $request->input('search');
        // Realizar la búsqueda en la tabla profiles por el DNI
        $profile = Profile::where('DNI', $searchQuery)->first();
        if ($profile) {
            // Si se encuentra el perfil, obtener el ID del usuario asociado
            $userId = $profile->user_id;
            // Devolver el ID del usuario y un mensaje de éxito
            return response()->json(['user_id' => $userId, 'message' => 'Profesor encontrado']);
        } else {
            // Si no se encuentra el perfil, devolver un mensaje de error
            return response()->json(['message' => 'Profesor no encontrado'], 404);
        }
    }

    public function Contenido(Curso $curso)
    {
        return view('admin.curso.contenido', compact('curso'));
    }

    public function Students(Curso $curso)
    {
        return view('admin.curso.students', compact('curso'));
    }
}
