<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso', 'rutaArchivo', 'codigo', 'resolucion', 'empresa',
        'users_id', 'users_id_promotor', 'users_id_trabajador', 'tipo_pago_id', 'tipo_inscripcion_id', 'especialidad_id'
    ];
    

    public function tipoPago()
    {
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id');
    }

    public function tipoInscripcion()
    {
        return $this->belongsTo(TipoInscripcion::class, 'tipo_inscripcion_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function promotor()
    {
        return $this->belongsTo(User::class, 'users_id_promotor');
    }

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'users_id_trabajador');
    }
}
