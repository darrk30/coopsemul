<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuscarCertificadoController extends Controller
{
    public function BuscarCertificado(Request $request)
{
    // Valida el DNI recibido en la solicitud
    $request->validate([
        'dni' => 'required|numeric|digits:8',
    ]);

    // Buscamos los certificados usando el DNI
    $certificados = Certificado::whereHas('user.profile', function($query) use ($request) {
        $query->where('dni', $request->dni);
    })->get();

    // Si no se encuentran certificados
    if ($certificados->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontraron certificados para este DNI.',
        ]);
    }

    // Formatear los datos de cada certificado
    $data = $certificados->map(function($certificado) {
        return [
            'dni' => $certificado->user->profile->DNI,
            'nombres' => $certificado->user->name,
            'apellidos' => $certificado->user->profile->apellidos,
            'curso' => $certificado->curso,
            'documento' => Storage::disk('s3')->url($certificado->rutaArchivo),
            'codigo' => $certificado->codigo,
            'resolucion' => $certificado->resolucion,
        ];
    });

    return response()->json([
        'success' => true,
        'data' => $data,
    ]);
}

    
}
