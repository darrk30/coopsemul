<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ciclo;
use App\Models\Curso;
use App\Models\Recurso;
use App\Models\Semana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Aws\S3\S3Client;

class CiclosController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.ciclos.index')->only('index');
        $this->middleware('can:admin.ciclos.create')->only('create', 'store');
        $this->middleware('can:admin.ciclos.show')->only('show');
        $this->middleware('can:admin.ciclos.students')->only('Students');
        $this->middleware('can:admin.ciclos.agregarSemana')->only('agregarSemana');
        $this->middleware('can:admin.ciclos.crear_recurso')->only('crear_recurso');
        $this->middleware('can:admin.ciclos.formulario')->only('formularioRecurso');
        $this->middleware('can:admin.ciclos.descargar-recurso')->only('descargar_recurso');
        $this->middleware('can:admin.ciclos.eliminar_S_R')->only('eliminar');
    }

    public function index()
    {
        return view('admin.ciclos.index');
    }

    public function create()
    {
        $cursos = Curso::pluck('nombre', 'id'); // Obtener los cursos como un array de id => nombre
        return view('admin.ciclos.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'nombre' => 'required|max:255',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after:fechaInicio',
            'status' => 'required|boolean',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        // Crear un nuevo ciclo
        Ciclo::create($request->all());

        // Registrar la actividad
        //activity()->log('Creó un nuevo ciclo: ' . $ciclo->nombre);

        // Retornar una respuesta exitosa
        return view('admin.ciclos.index')->with('info', 'Se Creo el ciclo con exito');
    }

    public function show(Ciclo $ciclo)
    {

        //return $curso;
        //Verificar si el usuario tiene permiso para ver el curso
        $user = Auth::user();
        // Verificar si el usuario es el profesor del curso
        $isProfessor = $ciclo->curso->user()->where('users.id', $user->id)->exists();

        // Verificar si el usuario es un alumno inscrito en el curso
        $isStudent = $ciclo->users()->where('users.id', $user->id)->exists();

        if (!$isProfessor && !$isStudent) {
            abort(403, 'PAGINA NO ENCONTRADA');
        }

        // Obtener todas las semanas del curso con sus recursos
        $semanas = $ciclo->semanas()->with('recursos')->get();

        // Devolver la vista con los datos
        return view('admin.ciclos.show', compact('ciclo', 'semanas'));
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }


    public function descargar_recurso($recursoId)
    {
        $recurso = Recurso::findOrFail($recursoId);

        // Obtener la URL del archivo en el disco S3
        $urlArchivo = Storage::disk('s3')->url($recurso->documento);

        // Obtener el nombre original del archivo desde la base de datos
        $nombreArchivo = $recurso->nombre;

        // Descargar el archivo con su nombre original y establecer el tipo de contenido
        return response()->streamDownload(function () use ($urlArchivo) {
            $file = fopen($urlArchivo, 'r');
            fpassthru($file);
            fclose($file);
        }, $nombreArchivo, [
            'Content-Type' => 'application/octet-stream',
        ]);
    }


    public function Students(Ciclo $ciclo)
    {
        return view('admin.ciclos.students', compact('ciclo'));
    }

    public function agregarSemana(Request $request)
    {
        //return $request;
        $request->validate([
            'nombre' => 'required|string',
        ]);
        $semana = new Semana();
        $semana->nombre = $request->nombre;
        $semana->descripcion = $request->descripcion;
        $semana->ciclo_id = $request->ciclo_id;
        $semana->save();
        return back()->with('success', 'La semana se ha creado correctamente.');
    }

    public function formularioRecurso(Request $request)
    {
        // Aquí puedes obtener la semana_id del request y usarla para generar el formulario
        $semana_id = $request->input('semana_id');
        $curso_nombre = $request->curso_nombre;
        $ciclo_nombre = $request->ciclo_nombre;

        $formulario = '<form action="' . route('admin.ciclos.crear_recurso', ['semana_id' => $semana_id, 'curso_nombre' => $curso_nombre, 'ciclo_nombre' => $ciclo_nombre]) . '" method="POST" enctype="multipart/form-data">';
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

    public function crear_recurso(Request $request, $id_semana, $curso_nombre, $ciclo_nombre)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,png,gif|max:10240', // 10 MB como máximo
            'urlRecurso' => 'nullable|url', // Opcional: debe ser una URL válida si se proporciona
        ]);
        $curso_nombre = $this->normalizeString($curso_nombre);
        $ciclo_nombre = $this->normalizeString($ciclo_nombre);
        // Subir archivo del documento a S3 si se envió
        if ($request->hasFile('file')) {
            $archivoPath = Storage::disk('s3')->put('recursosaulavirtual/' . $curso_nombre . '/' . $ciclo_nombre , $request->file('file'));            
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


    private function normalizeString($string)
    {
        $string = strtolower($string); // Convertir a minúsculas
        $string = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'a', 'e', 'i', 'o', 'u', 'n'],
            $string
        );
        return preg_replace('/[^a-z0-9]/', '', $string); // Eliminar caracteres no alfanuméricos
    }
}