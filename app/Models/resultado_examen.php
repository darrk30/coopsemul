<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resultado_examen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Question(){
        return $this->belongsTo('App\Models\Question');
    }

    public function Option(){
        return $this->belongsTo('App\Models\Option');        
    }

    public function userExamen(){
        return $this->belongsTo('App\Models\user_examen');
    }
}
