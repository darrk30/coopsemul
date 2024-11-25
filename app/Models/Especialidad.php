<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'status'];

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'especialidad_id');
    }
}
