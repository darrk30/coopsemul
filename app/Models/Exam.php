<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }
    

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function userExamen()
    {
        return $this->hasMany('App\Models\user_examen');
    }
}
