<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_examen extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function UserExamen()
    {
        return $this->belongsTo('App\Models\user_examen');
    }

    
}
