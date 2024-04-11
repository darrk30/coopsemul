<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'create_at', 'update_at'];

    public function getRouteKeyName()
    {
        return "slug";
    }



    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function contenidos(){
        return $this->hasMany(ContenidoCurso::class);
    }

    // public function user(){
    //     return $this->belongsTo('App\Models\User');
    // }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class)->withPivot('status');;
    // }
    public function ciclo(){
        return $this->hasMany('App\Models\Ciclo');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    

    public function link()
    {
        return $this->hasOne('App\Models\Link');
    }

    public function precio(){
        return $this->belongsTo('App\Models\Precio');
    }

    public function level(){
        return $this->belongsTo('App\Models\Level');
    }

}
