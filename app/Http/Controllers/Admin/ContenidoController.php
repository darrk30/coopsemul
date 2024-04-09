<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContenidoCurso;
use Illuminate\Http\Request;

class ContenidoController extends Controller
{

    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos en la solicitud
        $request->validate([
            'curso_id' => 'required|exists:cursos,id', // Asegura que el curso exista en la base de datos
            'title' => 'required|string|max:255', // Valida el campo title
            // Agrega aquí las validaciones para otros campos si es necesario
        ]);

        // Crea un nuevo contenido utilizando los datos recibidos
        $contenido = new ContenidoCurso();
        $contenido->titulo = $request->title;
        $contenido->curso_id = $request->curso_id;
        $contenido->descripcion = "Contenido del Curso";
        // Asigna otros campos si es necesario
        $contenido->save();

        // Puedes devolver la respuesta con el contenido creado
        return response()->json([
            'success' => true,
            'titulo' => $contenido->titulo,
            'id' => $contenido->id,
            // Agrega otros datos que quieras devolver
        ]);
    }


    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function modificar(Request $request)
    {
        // Obtener el ID del contenido a modificar
        $contenidoId = $request->contenido_id;

        // Buscar el contenido por su ID
        $contenido = ContenidoCurso::findOrFail($contenidoId);

        // Modificar los atributos del contenido según los datos enviados
        $contenido->titulo = $request->titulo;

        // Guardar los cambios en la base de datos
        $contenido->save();

        // Devolver una respuesta JSON (si es necesario)
        return response()->json([
            'success' => true,
            'titulo' => $contenido->titulo, // Puedes devolver los datos del contenido modificado si lo necesitas en el frontend
            'id' => $contenido->id,
        ]);
    }

    public function destroy(ContenidoCurso $contenido)
    {
        // Elimina el contenido
        $contenido->delete();

        // Redirige a la página o retorna una respuesta JSON, según tus necesidades
        return redirect()->back()->with('success', 'Contenido eliminado correctamente');
    }
}
