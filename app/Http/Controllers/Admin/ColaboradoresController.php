<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Throwable;


class ColaboradoresController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:admin.colaboradores.index')->only('index');
        $this->middleware('can:admin.colaboradores.create')->only('store', 'create');
        $this->middleware('can:admin.colaboradores.show')->only('show');
        $this->middleware('can:admin.colaboradores.edit')->only('edit', 'update');
    }


    public function index()
    {
        return view('admin.colaboradores.index');
    }

    public function create()
    {
        $roles = Role::where('name', '<>', 'Estudiante')->get();
        return view('admin.colaboradores.create', compact('roles'));
    }

    public function store(Request $request)
    {

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'DNI' => 'required|string|max:8|unique:profiles',
            'apellidos' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        // Iniciar una transacción
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            // Buscar el nombre del rol correspondiente al ID proporcionado
            //$role = Role::findOrFail($request->role)->name;
            // Asignar roles al usuario
            if ($request->has('roles')) {
                foreach ($request->roles as $roleId) {
                    $role = Role::findOrFail($roleId);
                    $user->assignRole($role->name);
                }
            }
            // Obtener el ID del usuario recién creado
            $user_id = $user->id;
            // Registrar el perfil
            $profile = new Profile();
            $profile->user_id = $user_id;
            $profile->apellidos = $request->apellidos;
            $profile->DNI = $request->DNI;
            $profile->status = $request->status;
            $profile->biografia = $request->biografia;
            $profile->especialidad = $request->especialidad;
            $profile->save();
            // Confirmar la transacción
            DB::commit();
            // Redireccionar con un mensaje de éxito
            return redirect()->route('admin.colaboradores.index')->with('info', 'Usuario creado exitosamente.');
        } catch (Throwable $e) {
            // En caso de error, revertir la transacción
            DB::rollback();
            session()->flash('transaction_failed', true);
            $errorMessage = 'Hubo un problema al guardar los datos. ';
            if ($e instanceof \Illuminate\Database\QueryException) {
                // Error relacionado con la base de datos
                $errorMessage .= 'Error en la base de datos: ' . $e->getMessage();
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                // Error de validación
                $errorMessage .= 'Error de validación: ' . $e->getMessage();
            } else {
                // Otro tipo de error
                $errorMessage .= 'Error desconocido: ' . $e->getMessage();
            }
            // Redirigir con un mensaje de error específico
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
    }


    public function show(string $id)
    {
    }

    public function edit(User $user)
    {

        $roles = Role::where('name', '<>', 'Estudiante')->get();
        return view('admin.colaboradores.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'DNI' => 'required|string|max:8|unique:profiles,DNI,' . $user->profile->id,
            'apellidos' => 'required|string|max:100',
            'status' => 'required|in:0,1',
            'biografia' => 'required|string|max:255',
            'especialidad' => 'required|string|max:100',
            'roles' => 'required|array|min:1',
        ]);

        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        // Verificar si se ha enviado una nueva contraseña
        if ($request->filled('password')) {
            // Validar la contraseña
            if (strlen($request->password) < 8) {
                return redirect()->back()->withErrors(['password' => 'La contraseña debe tener al menos 8 caracteres.'])->withInput();
            }
            // Hash y actualización de la contraseña
            $user->password = Hash::make($request->password);
        }
        // Guardar los cambios en el usuario
        $user->save();

        // Actualizar los datos del perfil del usuario
        $user->profile->apellidos = $request->apellidos;
        $user->profile->DNI = $request->DNI;
        $user->profile->biografia = $request->biografia;
        $user->profile->especialidad = $request->especialidad;
        // Actualizar los roles del usuario

        $perfilEstadoActual = $user->profile->status;
        if ($request->status != $perfilEstadoActual || ($request->has('roles') && $request->roles != $user->roles()->pluck('id')->toArray())) {
            if ($request->status == 0) {
                $user->roles()->detach(); // Eliminar el rol asociado al usuario
            } else {
                if ($request->has('roles')) {
                    $user->roles()->sync($request->roles);
                } 
            }
            // Actualizar el estado del perfil
            $user->profile->status = $request->status;
        } 
        // $user->profile->status = $request->status;
        // // Actualizar los roles del usuario
        // if ($request->has('roles')) {
        //     $user->roles()->sync($request->roles);
        // } else {
        //     // Si no se seleccionaron roles, eliminar todos los roles asociados al usuario
        //     $user->roles()->detach();
        // }
        $user->profile->save();
        // Redireccionar con un mensaje de éxito
        return redirect()->route('admin.colaboradores.index')->with('success', 'Usuario actualizado exitosamente.');
    }


    public function destroy(string $id)
    {
    }
}
