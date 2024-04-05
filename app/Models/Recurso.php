<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function semana()
    {
        return $this->belongsTo('App\Models\Semana');
    }
}
