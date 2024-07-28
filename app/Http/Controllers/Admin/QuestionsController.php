<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\detalle_examen;
use App\Models\Exam;
use App\Models\Image;
use App\Models\Option;
use App\Models\Question;
use App\Models\resultado_examen;
use App\Models\user_examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('can:admin.questions.index')->only('index');
        $this->middleware('can:admin.questions.edit')->only('edit', 'update');
        $this->middleware('can:admin.questions.create')->only('create', 'store');
        $this->middleware('can:admin.questions.destroy')->only('destroy');
    }

    public function index(Exam $exam)
    {
        $user = auth()->user();
        $userRole = $user->roles->first()->name;

        // Verifica si el examen está activo
        if ($userRole == 'Estudiante' && $exam->status != 1) {
            // Lanza una excepción de error 404 solo para los alumnos
            throw new NotFoundHttpException('El examen no está activo.');
        }

        // Obtén el registro del examen del usuario y sus respuestas si existe
        $userExam = user_examen::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        // Obtén las preguntas del examen
        $questions = $exam->questions;

        // Muestra la vista con los datos necesarios
        return view('admin.questions.index', [
            'exam' => $exam,
            'questions' => $questions,
            'userExam' => $userExam,
            'userRole' => $userRole
        ]);
    }




    public function create(Exam $examId)
    {
        return view('admin.questions.create', compact('examId'));
    }


    public function store(Request $request)
    {

        try {
            // Validar datos del formulario si es necesario
            $request->validate([
                'ExamId' => 'required',
                'puntaje' => 'nullable|integer',
                'pregunta' => 'nullable|string',
                'alternatives' => 'required|array',
                'correct' => 'required|array',
            ]);

            // Crear la pregunta principal
            $question = new Question();
            $question->exam_id = $request->ExamId;
            $question->puntaje = $request->puntaje;
            $question->pregunta = $request->pregunta; // Dejar el contenido nulo por ahora
            $question->save();

            // Guardar las alternativas con las imágenes correspondientes
            foreach ($request->alternatives as $key => $alternative) {
                //$url = null;
                // Guardar la alternativa
                $option = new Option();
                $option->question_id = $question->id; // Obtener el ID de la pregunta que acabamos de guardar
                $option->option = $alternative;
                $option->correct_option = in_array((string)$key, $request->correct); // Verificar si es correcta basado en el índice
                $option->save();
                // Procesar la imagen de la alternativa si está presente
                if ($request->hasFile('file') && isset($request->file[$key]) && $request->file[$key]->isValid()) {
                    //$path = $request->file[$key]->store('imagenesAlternativas', 's3'); // Guardar en S3 con el disco 's3'
                    //$url = Storage::disk('s3')->url($path); // Obtener la URL del archivo en S3
                    $url = Storage::disk('s3')->put('imagenesAlternativas', $request->file[$key]);
                    if ($url) {
                        $image = new Image();
                        $image->url = $url;
                        $image->imageable_id = $option->id; // ID de la alternativa al que pertenece la imagen
                        $image->imageable_type = Option::class; // Tipo de modelo al que pertenece la imagen (Opción)
                        $image->save();
                    }
                }
                // Verificar si existe una URL para la imagen y guardar en la tabla polimórfica Image
            }

            return redirect()->route('admin.questions.index', ['exam' => $request->ExamId])->with('info', 'Pregunta creada correctamente.');
        } catch (\Exception $e) {
            // Capturar y devolver el error
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }



    public function show(string $id)
    {
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }


    public function update(Request $request, Question $question)
    {
        // Determinar cuál es la opción correcta
        $OpcionCorrecta = $request->correct[0];

        // Guardar el puntaje original para comparar después
        $puntajeOriginal = $question->puntaje;

        foreach ($question->options as $option) {
            if ($option->correct_option == 1) {
                $OpcionCorrectaOriginal = $option->id;
            }
        }

        // Actualizar la pregunta
        $question->pregunta = $request->input('pregunta');
        $question->puntaje = $request->input('puntaje');
        $question->save();

        // Actualizar opciones existentes
        foreach ($request->options as $id => $optionText) {
            foreach ($optionText as $index => $item) {
                $option = Option::find($index);
                if ($option) {
                    $option->option = $item;
                    $option->correct_option = ($index == $OpcionCorrecta) ? 1 : 0;
                    $option->save();

                    if ($request->hasFile("fileOptions.$index")) {
                        // Eliminar la imagen existente
                        if ($option->image) {
                            Storage::disk('s3')->delete($option->image->url);
                            $option->image()->delete();
                        }

                        // Guardar la nueva imagen
                        $path = $request->file("fileOptions.$index")->store('imagenesAlternativas', 's3');
                        $option->image()->create([
                            'url' => $path
                        ]);
                    }
                }
            }
        }

        // Verificar si hay nuevas alternativas antes de iterar
        if (!empty($request->alternatives)) {
            // Agregar nuevas alternativas
            foreach ($request->alternatives as $tempId => $altText) {
                foreach ($altText as $newIndex => $newOption) {
                    $option = new Option();
                    $option->option = $newOption;
                    $option->question_id = $question->id;
                    $option->correct_option = ($OpcionCorrecta == $newIndex) ? 1 : 0;
                    $option->save();

                    // Manejar la imagen de la nueva opción
                    if ($request->hasFile("file.$newIndex")) {
                        $path = $request->file("file.$newIndex")->store('imagenesAlternativas', 's3');
                        $option->image()->create([
                            'url' => $path
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.questions.index', ['exam' => $question->exam])
            ->with('info', 'Pregunta Actualizada correctamente.');
    }




    public function destroy(Request $request, $id)
    {
        // Encuentra la pregunta por ID
        $question = Question::findOrFail($id);

        // Elimina las opciones asociadas a la pregunta
        foreach ($question->options as $option) {
            // Verifica si la opción tiene una imagen asociada
            if ($option->image) {
                // Elimina la imagen de S3
                Storage::disk('s3')->delete($option->image->url);
            }
            // Elimina la opción
            $option->delete();
        }

        // Elimina la pregunta
        $question->delete();

        // Retorna una respuesta JSON
        return response()->json(['success' => true]);
    }



    public function destroyImage($optionId)
    {
        $option = Option::findOrFail($optionId);

        // Eliminar la imagen de S3
        if ($option->image->url) {
            Storage::disk('s3')->delete($option->image->url);
            $option->image()->delete();
        }
        return response()->json(['message' => 'Imagen eliminada correctamente.'], 200);
    }


    public function destroyOption($optionId)
    {
        // Buscar la opción por ID
        $option = Option::find($optionId);

        if (!$option) {
            return response()->json(['error' => 'Option not found'], 404);
        }
        if ($option->image->url) {
            Storage::disk('s3')->delete($option->image->url);
            $option->image()->delete();
        }
        // Eliminar la opción
        $option->delete();

        return response()->json(['success' => 'Option deleted successfully']);
    }
}
