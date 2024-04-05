<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function curso(){
        return $this->hasMany('App\Models\Curso');
    }

    
}
