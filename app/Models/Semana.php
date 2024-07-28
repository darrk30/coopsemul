<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semana extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function ciclo()
    {
        return $this->belongsTo('App\Models\Ciclo');
    }

    public function recursos()
    {
        return $this->hasMany('App\Models\Recurso');
    }

    public function examenes()
    {
        return $this->hasMany('App\Models\Exam');
    }

}
