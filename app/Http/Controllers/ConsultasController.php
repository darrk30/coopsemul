<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultasController extends Controller
{
    public function index(){
        return view('consultas');
    }

    public function resolucion(Request $request)
    {
        //return $request;
        try {
            // Obtener los datos del formulario
            $Dni = $request->input('Dni');
            $ResolucionValor = $request->input('Resolucion');
            $codigo = $request->input('codigo');

            $Resolucion = [
                '1' => 'Seleccionar',
                '2' => '001-A2022-DUPG/CC.SS',
                '3' => '909/2021 EPG - UNT',
            ];

            $response = []; // Crear un array para la respuesta

            if ($ResolucionValor != 1) {
                $ResolucionSeleccionada = $Resolucion[$ResolucionValor];

                if (!empty($codigo) && !empty($Dni)) {
                    // Realizar la consulta utilizando la conexión "otra_conexion"
                    $resultados = DB::connection('conexion_codigos')
                                    ->table('clientes')
                                    ->where('numeroDoc', $Dni)
                                    ->where('apellidos', $ResolucionSeleccionada)
                                    ->where('direccion', $codigo)
                                    ->first();

                    // Comprobar si se encontraron resultados
                    if ($resultados) {
                        $response['success'] = true;
                        $response['data'] = [
                            'documento' => $resultados->numeroDoc,
                            'nombres' => $resultados->nombres 
                        ];
                    } else {
                        $response['success'] = false;
                        $response['message'] = "No se encontraron resultados.";
                    }
                } else {
                    // Si el código o el DNI están vacíos, mostrar un mensaje
                    $response['success'] = false;
                    $response['message'] = "Por favor, ingrese su DNI y CÓDIGO.";
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Por favor, seleccione la resolución.";
            }

            // Devolver la respuesta en formato JSON
            return response()->json($response);
        } catch (\Exception $e) {
            // Manejar cualquier error
            $response['success'] = false;
            $response['message'] = "Error: " . $e->getMessage();
            return response()->json($response);
        }
    }
}
