<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    protected $guarded = ['id', 'create_at', 'update_at'];
    use HasFactory;

    public function cantidadUsuarios()
    {
        return $this->users()->count();
    }

    public function curso(){
        return $this->belongsTo('App\Models\Curso');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('status');
    }

    public function semanas()
    {
        return $this->hasMany('App\Models\Semana');
    }

    public function pagos()
    {
        return $this->hasMany('App\Models\Pagos');
    }

    
}
