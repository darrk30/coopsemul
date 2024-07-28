<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\user_examen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExamsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('can:admin.examenes.index')->only('index');
        $this->middleware('can:admin.examenes.edit')->only('edit', 'update');
        $this->middleware('can:admin.examenes.create')->only('create', 'store');
        $this->middleware('can:admin.examenes.destroy')->only('destroy');
        $this->middleware('can:admin.examenes.show')->only('show');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Estudiante')) {
            // Obtener solo los exámenes que están publicados
            $examenes = Exam::where('status', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } elseif ($user->hasRole('Profesor')) {
            // Obtener solo los exámenes creados por el profesor
            $examenes = Exam::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } else {
            // Obtener todos los exámenes para el administrador
            $examenes = Exam::orderBy('created_at', 'desc')
                ->paginate(12);
        }

        return view('admin.examenes.index', compact('examenes'));
    }


    public function create()
    {
        return view('admin.examenes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'tiempo' => 'required|integer',
            'fecha' => 'required|string',
            'estado' => 'required|string|in:0,1',
        ], [
            'titulo.required' => 'El titulo es obligatorio',
            'tiempo.required' => 'El tiempo del examen es obligatorio',
            'fecha.required' => 'La fecha es obligatoria',
            'estado.in' => 'El estado debe ser Publicado o No Publicado.',
        ]);

        $userId = Auth::id();

        $examen = Exam::create([
            'titulo' => $request->titulo,
            'tiempo' => $request->tiempo,
            'fecha' => $request->fecha,
            'status' => $request->estado,
            'user_id' => $userId,
        ]);

        if ($request->file('file')) {
            $url = Storage::disk('s3')->put('imagenesExamen', $request->file('file'));
            $examen->image()->create([
                'url' => $url
            ]);
        }

        return redirect()->route('admin.questions.index', $examen)->with('info', 'Examen creado exitosamente.');
    }

    public function show(Exam $exam)
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $rol = $user->roles()->first()->name;
        if ($user->hasRole('Estudiante')) {
            // Buscar el registro en UserExamen que coincida con el id del alumno y el id del examen
            $userExamen = user_examen::where('user_id', $user->id)->where('exam_id', $exam->id)->first();
            if (!$userExamen) {
                // Si no se encuentra el registro, manejar el caso
                abort(403, 'No se encontró el registro del examen para este estudiante.');
            }
            // Pasar el registro encontrado a la vista showEstudiante
            return view('admin.examenes.show', compact('exam', 'userExamen', 'rol'));
        } elseif ($user->hasRole('Administrador') || $user->hasRole('Profesor')) {
            // Obtener todos los registros del modelo UserExamen para este examen
            $userExamenes = user_examen::where('exam_id', $exam->id)->get();
            // Pasar todos los registros a la vista show
            return view('admin.examenes.show', compact('exam', 'userExamenes', 'rol'));
        } else {
            // Manejar el caso en que el usuario no tenga ninguno de los roles esperados
            abort(403, 'No tienes permiso para ver esta página.');
        }
    }

    public function edit(Exam $exam, Request $request)
    {
        return view('admin.examenes.edit', compact('exam'));
    }

    public function update(Exam $exam, Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tiempo' => 'required|integer',
            'fecha' => 'required|date',
            'estado' => 'required|integer',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048'
        ]);
        $exam->titulo = $request->input('titulo');
        $exam->tiempo = $request->input('tiempo');
        $exam->fecha = $request->input('fecha');
        $exam->status = $request->input('estado');
        if ($request->hasFile('file')) {
            if ($exam->image) {
                Storage::disk('s3')->delete($exam->image->url);
                $exam->image()->delete();
            }
            $path = $request->file('file')->store('exams', 's3');
            $exam->image()->create([
                'url' => $path
            ]);
        }
        $exam->save();
        return redirect()->route('admin.examenes.index')->with('info', 'Examen actualizado con éxito');
    }

    public function destroy(Exam $exam)
    {
        $userExamCount = user_examen::where('exam_id', $exam->id)->count();

        if ($userExamCount > 0) {
            return redirect()->route('admin.examenes.index')->with('error', 'No se puede eliminar el examen porque tiene usuarios asociados.');
        }
        if ($exam->image) {
            Storage::disk('s3')->delete($exam->image->url);
            $exam->image()->delete();
        }
        $exam->delete();
        return redirect()->route('admin.examenes.index')->with('info', 'Examen eliminado con éxito.');
    }
}
