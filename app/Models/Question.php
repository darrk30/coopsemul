<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function exam()
    {
        return $this->belongsTo('App\Models\Exam');
    }

    public function options()
    {
        return $this->hasMany('App\Models\Option');
    }

    public function resultadosExamen()
    {
        return $this->hasMany('App\Models\resultado_examen');
    }

    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
