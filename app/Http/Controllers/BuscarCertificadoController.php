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
            'dni' => 'required|numeric|digits:8', // Ajusta la validación según tus necesidades
        ]);
    
        // Buscamos el certificado usando el DNI del perfil del usuario asociado al certificado
        $certificado = Certificado::whereHas('user.profile', function($query) use ($request) {
            $query->where('dni', $request->dni);
        })->first();
    
        // Si no se encuentra el certificado
        if (!$certificado) {
            return response()->json([
                'success' => false,
                'message' => 'Certificado no encontrado.',
            ]);
        }
    
        // Genera la URL pública de S3 para el archivo
        $documentoUrl = Storage::disk('s3')->url($certificado->rutaArchivo);
    
        // Si se encuentra, retornamos los datos
        return response()->json([
            'success' => true,
            'data' => [
                'dni' => $certificado->user->profile->DNI, // Obtener el DNI desde el perfil del usuario
                'nombres' => $certificado->user->name, // Suponiendo que el campo 'nombres' está en el modelo User
                'apellidos' => $certificado->user->profile->apellidos, // Lo mismo con 'apellidos'
                'curso' => $certificado->curso,
                'documento' => $documentoUrl, // Usamos la URL pública para el archivo
                'codigo' => $certificado->codigo,
                'resolucion' => $certificado->resolucion,
            ],
        ]);
    }
    
}
