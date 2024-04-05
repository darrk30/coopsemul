<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'autor', 'descripcion', 'anio_publicacion', 'category_id'];

    // Relación con la categoría
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
