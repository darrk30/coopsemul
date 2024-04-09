<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesion;
use Illuminate\Http\Request;

class LeccionesController extends Controller
{


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

    public function eliminar(Request $request)
    {
        $id = $request->id;

        // Buscar el contenido del curso por su ID
        $LeccionCurso = Lesion::find($id);

        if ($LeccionCurso) {
            // Si se encuentra el contenido del curso, eliminarlo
            $LeccionCurso->delete();

            // Retornar una respuesta exitosa
            return response()->json(['message' => 'La Leccion del Contenido se eliminado correctamente']);
        } else {
            // Si no se encuentra el contenido del curso, retornar un mensaje de error
            return response()->json(['message' => 'No se encontró la Leccion del Contenido con el ID proporcionado'], 404);
        }
    }

}
