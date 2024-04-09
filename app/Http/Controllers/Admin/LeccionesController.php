<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesion;
use Illuminate\Http\Request;

class LeccionesController extends Controller
{

    public function index()
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        //return $request;
        // Validar los datos recibidos en la solicitud

        // Crea un nuevo contenido utilizando los datos recibidos
        $leccion = new Lesion();
        $leccion->nombre = $request->nombre;
        $leccion->contenido_curso_id = $request->contenido_id;
        // Asigna otros campos si es necesario
        $leccion->save();

        // Puedes devolver la respuesta con el contenido creado
        return response()->json([
            'success' => true,
            'id' => $leccion->id,
            'nombre' => $leccion->nombre,
            'contenido_id' => $leccion->contenido_curso_id,            // Agrega otros datos que quieras devolver
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
        $leccionId = $request->leccion_id;

        // Buscar el contenido por su ID
        $leccion = Lesion::findOrFail($leccionId);

        // Modificar los atributos del contenido según los datos enviados
        $leccion->nombre = $request->nombre;

        // Guardar los cambios en la base de datos
        $leccion->save();

        // Devolver una respuesta JSON (si es necesario)
        return response()->json([
            'success' => true,
            'nombre' => $leccion->nombre, // Puedes devolver los datos del contenido modificado si lo necesitas en el frontend
            'id' => $leccion->id,
        ]);
    }

    public function destroy($id)
    {

        try {
            // Busca la lección por su ID en la base de datos
            $leccion = Lesion::findOrFail($id);

            // Elimina la lección
            $leccion->delete();

            // Redirige a la página anterior con un mensaje de éxito
            return redirect()->back()->with('success', 'Lección eliminada correctamente');
        } catch (\Exception $e) {
            // Si ocurre algún error, redirige con un mensaje de error
            return redirect()->back()->with('error', 'Error al eliminar la lección: ' . $e->getMessage());
        }
    }
}
