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
use Illuminate\Support\Facades\Storage;

class CursosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.cursos.index')->only('index');
        $this->middleware('can:admin.cursos.store')->only('store');
        $this->middleware('can:admin.cursos.show')->only('show');
        //$this->middleware('can:admin.cursos.edit')->only('edit', 'update');
        //$this->middleware('can:admin.cursos.destroy')->only('destroy');
        $this->middleware('can:admin.cursos.crear_recurso')->only('crear_recurso');
        $this->middleware('can:admin.cursos.formulario')->only('formularioRecurso');
        $this->middleware('can:admin.cursos.descargar_recurso')->only('descargarRecurso');
        $this->middleware('can:admin.cursos.eliminar_S_R')->only('eliminar');
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
                $MisCursos = $usuario->curso()->where('status', 1)->get();

                return view('admin.cursos.index', compact('MisCursos'));
            } elseif ($rol === "Estudiante") {
                // Si el usuario es estudiante, también obtén los cursos del estudiante
                $MisCursos = $usuario->cursos()->wherePivot('status', 1)->get();
                return view('admin.cursos.index', compact('MisCursos'));
            } else {
                // En caso de que el usuario no tenga ningún rol asignado, lanza una excepción
                abort(403, 'Usuario no tiene roles asignados');
            }
        }
    }


    public function crear_recurso(Request $request, $id_semana)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,png,gif|max:10240', // 10 MB como máximo
            'urlRecurso' => 'nullable|url', // Opcional: debe ser una URL válida si se proporciona
        ]);
        // Subir archivo del documento a S3 si se envió
        if ($request->hasFile('file')) {
            $archivoPath = Storage::disk('s3')->put('RecursosAulaVirtual', $request->file('file'));
            $name = $request->file('file')->getClientOriginalName();
        } else {
            $archivoPath = null;
        }

        // Crear el recurso en la base de datos
        $recurso = new Recurso();
        $recurso->title = $request->title;
        $recurso->nombre = $name;
        $recurso->documento = $archivoPath; // Guardar la ruta del archivo en el bucket de S3
        $recurso->url = $request->urlRecurso;
        $recurso->semana_id = $id_semana; // Asociar el recurso con la semana
        $recurso->save();

        // Redireccionar o devolver una respuesta JSON o lo que sea necesario
        return redirect()->back()->with('success', 'Recurso creado correctamente.');
    }

    public function store(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string',
            'curso_id' => 'required|exists:cursos,id',
        ]);
        $semana = new Semana();
        $semana->nombre = $request->nombre;
        $semana->descripcion = $request->descripcion;
        $semana->curso_id = $request->curso_id;
        $semana->save();
        return back()->with('success', 'La semana se ha creado correctamente.');
    }




    public function show(Curso $curso)
    {
        //return $curso;
        //Verificar si el usuario tiene permiso para ver el curso
        $user = Auth::user();
        // Verificar si el usuario es el profesor del curso
        $isProfessor = $curso->user()->where('users.id', $user->id)->exists();

        // Verificar si el usuario es un alumno inscrito en el curso
        $isStudent = $curso->users()->where('users.id', $user->id)->exists();

        if (!$isProfessor && !$isStudent) {
            abort(403, 'PAGINA NO ENCONTRADA');
        }

        // Obtener todas las semanas del curso con sus recursos
        $semanas = $curso->semanas()->with('recursos')->get();

        // Devolver la vista con los datos
        return view('admin.cursos.show', compact('curso', 'semanas'));
    }




    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function eliminar($tipo, $id)
    {
        // Verificar el tipo de elemento a eliminar
        if ($tipo === 'semana') {
            // Eliminar la semana y todos sus recursos asociados
            $semana = Semana::findOrFail($id);
            foreach ($semana->recursos as $recurso) {
                // Eliminar el archivo asociado al recurso en S3
                Storage::disk('s3')->delete($recurso->documento);
                $recurso->delete();
            }
            $semana->delete(); // Eliminar la semana
            return redirect()->back()->with('error', 'Semana eliminada correctamente');
        } elseif ($tipo === 'recurso') {
            // Eliminar el recurso y su archivo asociado en S3
            $recurso = Recurso::findOrFail($id);
            Storage::disk('s3')->delete($recurso->documento);
            $recurso->delete();
            return redirect()->back()->with('error', 'Recurso eliminado correctamente');
        } else {
            return redirect()->back()->with('error', 'ERROR');
        }
    }

    public function formularioRecurso(Request $request)
    {
        // Aquí puedes obtener la semana_id del request y usarla para generar el formulario
        $semana_id = $request->input('semana_id');

        $formulario = '<form action="' . route('admin.cursos.crear_recurso', ['semana_id' => $semana_id]) . '" method="POST" enctype="multipart/form-data">';
        $formulario .= csrf_field(); // Agregamos el token CSRF de forma dinámica
        $formulario .= '<div class="form-group">';
        $formulario .= '<label for="title">Titulo</label>';
        $formulario .= '<input type="text" class="form-control" id="title" name="title" required>';
        $formulario .= '</div>';
        $formulario .= '<div class="form-group">';
        $formulario .= '<label for="archivo">Archivo</label>';
        $formulario .= '<input type="file" class="form-control-file" id="file" name="file" required>';
        $formulario .= '</div>';
        $formulario .= '<div class="form-group">';
        $formulario .= '<label for="urlRecurso">Url del video (opcional)</label>';
        $formulario .= '<input type="text" class="form-control" id="urlRecurso" name="urlRecurso">';
        $formulario .= '</div>';
        $formulario .= '<button type="submit" class="btn btn-primary">Guardar</button>';
        $formulario .= '</form>';

        return $formulario;
    }

    public function descargarRecurso($recursoId)
    {
        $recurso = Recurso::findOrFail($recursoId);

        // Obtener la URL del archivo en el disco S3
        $urlArchivo = Storage::disk('s3')->url($recurso->documento);
    
         // Obtener el nombre original del archivo desde la base de datos
         $nombreArchivo = $recurso->nombre;

        // Descargar el archivo con su nombre original y establecer el tipo de contenido
        return response()->streamDownload(function () use ($urlArchivo) {
            echo file_get_contents($urlArchivo);
        }, $nombreArchivo, ['Content-Type' => 'application/octet-stream']);
    }
}
