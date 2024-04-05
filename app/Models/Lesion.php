<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesion extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function contenidoCurso(){
        return $this->belongsTo('App\Models\ContenidoCurso');
    }
}
