<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BibliotecaController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.libros.index')->only('index');
        $this->middleware('can:admin.libros.create')->only('store, create');
        $this->middleware('can:admin.libros.edit')->only('edit', 'update');
        $this->middleware('can:admin.libros.descargar-libro')->only('descargarLibro');
        $this->middleware('can:admin.libros.abrir-archivo')->only('abrirArchivo');
    }


    public function index()
    {
        return view('admin.biblioteca.index');
    }

    public function create()
    {
        $categorias = Category::pluck('nombre', 'id');
        return view('admin.biblioteca.create', compact('categorias'));
    }


    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'titulo' => 'required|string',
            'autor' => 'required|string',
            'descripcion' => 'required|string',
            'anio_publicacion' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'archivo' => 'required_without:image|mimes:pdf,doc,docx|max:10240', // 10MB en kilobytes
            'image' => 'required_without:archivo|image|mimes:jpeg,png,jpg,gif|max:2048', // requerido si no se envió un archivo
        ]);

        // Asignar $archivoPath y $name utilizando operador ternario
        $archivoPath = $request->hasFile('archivo') ? Storage::disk('s3')->put('libros', $request->file('archivo')) : null;
        $name = $request->hasFile('archivo') ? $request->file('archivo')->getClientOriginalName() : null;

        // Asignar $imagePath utilizando operador ternario
        $imagePath = $request->hasFile('image') ? Storage::disk('s3')->put('imagenlibro', $request->file('image')) : null;


        // Crear una nueva instancia del modelo Libro
        $libro = new Libro();
        $libro->titulo = $request->titulo;
        $libro->autor = $request->autor;
        $libro->descripcion = $request->descripcion;
        $libro->anio_publicacion = $request->anio_publicacion;
        $libro->category_id = $request->category_id;
        $libro->status = $request->status;

        // Asignar la ruta del archivo y el nombre
        $libro->url = $archivoPath;
        $libro->nombreArchivo = $name;

        // Guardar el libro
        $libro->save();

        // Guardar la imagen en la tabla polimórfica Image si se envió
        if ($imagePath) {
            $libro->image()->create(['url' => $imagePath]);
        }

        return redirect()->route('admin.libros.index')->with('info', 'Libro creado correctamente.');
    }


    public function show(string $id)
    {
    }

    public function edit(Libro $libro)
    {
        $categorias = Category::pluck('nombre', 'id');
        return view('admin.biblioteca.edit', compact('categorias', 'libro'));
    }


    public function update(Request $request, Libro $libro)
    {
        // Validación de los datos del formulario
        $request->validate([
            'titulo' => 'required|string',
            'autor' => 'required|string',
            'descripcion' => 'required|string',
            'anio_publicacion' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'archivo' => 'nullable|mimes:pdf,doc,docx', // Archivo opcional
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Imagen opcional
        ]);

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // Verificar y actualizar el archivo del libro
            if ($request->hasFile('archivo')) {
                // Eliminar el archivo anterior si existe
                if ($libro->url) {
                    Storage::disk('s3')->delete($libro->url);
                }
                // Subir el nuevo archivo al disco S3
                $archivoUrl = $request->file('archivo')->store('libros', 's3');
                $name = $request->file('archivo')->getClientOriginalName();
                // Guardar la URL del archivo en el modelo Libro
                $libro->url = $archivoUrl;
                // Guardar el nombre original del archivo en el modelo Libro
                $libro->nombreArchivo = $name;
            }

            // Verificar y actualizar la imagen del libro
            if ($request->hasFile('image')) {
                // Eliminar la imagen anterior si existe
                if ($libro->image) {
                    Storage::disk('s3')->delete($libro->image->url);
                    $libro->image()->delete();
                }
                // Subir la nueva imagen al disco S3
                $imagenUrl = $request->file('image')->store('imagenlibro', 's3');
                $libro->image()->create([
                    'url' => $imagenUrl,
                ]);
            }

            // Actualizar otros campos del libro
            $libro->titulo = $request->titulo;
            $libro->autor = $request->autor;
            $libro->descripcion = $request->descripcion;
            $libro->anio_publicacion = $request->anio_publicacion;
            $libro->category_id = $request->category_id;
            $libro->status = $request->status;

            // Guardar los cambios en el libro
            $libro->save();

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('admin.libros.index')->with('info', 'Libro actualizado correctamente.');
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            DB::rollback();

            // Manejar el error como desees, por ejemplo, redirigiendo con un mensaje de error
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el libro. Por favor, inténtalo de nuevo.');
        }
    }

    public function destroy(string $id)
    {
    }


    public function descargarLibro($LibroId)
    {
        $recurso = Libro::findOrFail($LibroId);

        // Obtener la URL del archivo en el disco S3
        $urlArchivo = Storage::disk('s3')->url($recurso->url);

        // Obtener el nombre original del archivo desde la base de datos
        $nombreArchivo = $recurso->nombreArchivo; // Asegúrate de que esto sea el nombre correcto del archivo

        // Descargar el archivo con su nombre original y establecer el tipo de contenido
        return response()->streamDownload(function () use ($urlArchivo) {
            echo file_get_contents($urlArchivo);
        }, $nombreArchivo, ['Content-Type' => 'application/octet-stream']);
    }



    public function abrirArchivo($LibroId)
    {
        $libro = Libro::findOrFail($LibroId);

        // Obtener la URL del libro
        $urlArchivo = $libro->url;
        // Verificar la autenticación y los permisos del usuario aquí
        return view('admin.biblioteca.verArchivo', compact('urlArchivo'));
    }
}
