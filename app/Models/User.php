<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function adminlte_image()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el usuario tiene una imagen asociada
        if ($user) {
            // Devolver la URL de la imagen del usuario
            return $user->profile_photo_url;
        }

        // Si no hay imagen asociada, puedes devolver una imagen por defecto
        //return 'ruta/a/imagen/por/defecto.jpg';
    }

    public function adminlte_desc()
    {
        // Obtenemos el usuario autenticado
        $usuario = Auth::user();

        // Verificamos si el usuario tiene roles asignados
        if ($usuario->roles->isNotEmpty()) {
            // Obtenemos el primer rol del usuario (puedes ajustar esto según tus necesidades)
            $rol = $usuario->roles->first()->name;

            return $rol;
        }

        return "Sin rol asignado";
    }

    public function adminlte_profile_url()
    {
        // Genera la URL del perfil utilizando el nombre de la ruta proporcionado por Jetstream
        return route('profile.show');
    }
    
    //para obtener los cursos del profesor
    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function ciclos()
    {
        return $this->belongsToMany(Ciclo::class)->withPivot('status');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }
}
