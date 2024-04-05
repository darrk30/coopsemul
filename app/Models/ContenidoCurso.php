<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContenidoCurso extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function curso(){
        return $this->belongsTo('App\Models\Curso');
    }

    public function lesions(){
        return $this->hasMany('App\Models\Lesion');
    }
}
