<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\detalle_examen;
use App\Models\Exam;
use App\Models\resultado_examen;
use App\Models\user_examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetalleExamen extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
        $this->middleware('can:admin.detalleExamen.store')->only('store');        
    }


    public function store(Request $request)
    {
        // Paso 1: Guardar en UserExamen
        $userExamen = user_examen::create([
            'user_id' => Auth::id(),
            'exam_id' => $request->examId,
        ]);
        $exam = Exam::findOrFail($request->examId);
        // Paso 2: Obtener el ID del UserExamen
        $userExamenId = $userExamen->id;

        // Inicializar contadores
        $correctas = 0;
        $incorrectas = 0;
        $enBlanco = 0;
        $puntajeTotal = 0;

        // Paso 3 y 4: Guardar en ResultadoExamen y realizar la comparación
        foreach ($request->questions as $question) {
            $questionId = $question['id'];
            $selectedOption = $question['selected_option'] ?? null;

            // Guardar en ResultadoExamen
            resultado_examen::create([
                'user_examen_id' => $userExamenId,
                'question_id' => $questionId,
                'option_id' => $selectedOption,
            ]);

            // Obtener la opción correcta de la pregunta
            $opcionCorrecta = DB::table('options')
                ->where('question_id', $questionId)
                ->where('correct_option', 1)
                ->first();

            if (is_null($selectedOption)) {
                // Pregunta en blanco
                $enBlanco++;
            } elseif ($selectedOption == $opcionCorrecta->id) {
                // Respuesta correcta
                $correctas++;
                $puntajePregunta = DB::table('questions')
                    ->where('id', $questionId)
                    ->value('puntaje');
                $puntajeTotal += $puntajePregunta;
            } else {
                // Respuesta incorrecta
                $incorrectas++;
            }
        }

        // Paso 5: Guardar los resultados finales en DetalleExamen
        detalle_examen::create([
            'user_examen_id' => $userExamenId,
            'puntaje' => $puntajeTotal,
            'preguntasCorrectas' => $correctas,
            'preguntasEnBlanco' => $enBlanco,
            'preguntasIncorrectas' => $incorrectas,
            'tiempoConsumido' => $request->tiempoConsumido,
        ]);

        return redirect()->route('admin.examenes.show', $exam)->with('info', 'Examen evaluado exitosamente.');
    }
}
