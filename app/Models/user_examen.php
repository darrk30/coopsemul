<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_examen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detalleExamen()
    {
        return $this->hasOne('App\Models\detalle_examen');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function Examenes(){
        return $this->belongsTo('App\Models\Exam');
    }

    public function resultado_examens()
    {
        return $this->hasMany('App\Models\resultado_examen');
    }
}
