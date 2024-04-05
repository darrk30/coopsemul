<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semana extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function curso()
    {
        return $this->belongsTo('App\Models\Curso');
    }

    public function recursos()
    {
        return $this->hasMany('App\Models\Recurso');
    }

}
