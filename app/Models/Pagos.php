<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function ciclo()
    {
        return $this->belongsTo('App\Models\Ciclo');
    }

    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
