<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    public function resultadosExamen()
    {
        return $this->hasMany('App\Models\resultado_examen');
    }
    
    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    
}
