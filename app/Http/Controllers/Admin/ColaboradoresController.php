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
        $perfilID = $user->profile ? $user->profile->id : null;
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'DNI' => 'required|string|max:8|unique:profiles,DNI,' . $perfilID,
            'apellidos' => 'required|string|max:100',
            'status' => 'required|in:0,1',
            'biografia' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:100',
            'roles' => 'required|array|min:1',
        ]);

        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;

        // Verificar si se ha enviado una nueva contraseña
        if ($request->filled('password')) {
            // Validar la contraseña
            $request->validate([
                'password' => 'string|min:8',
            ]);

            // Hash y actualización de la contraseña
            $user->password = Hash::make($request->password);
        }

        // Guardar los cambios en el usuario
        $user->save();

        // Validar si el usuario tiene un perfil
        if ($user->profile) {
            // Si tiene un perfil, actualizar sus datos
            $user->profile->update([
                'apellidos' => $request->apellidos,
                'DNI' => $request->DNI,
                'biografia' => $request->biografia,
                'especialidad' => $request->especialidad,
                'status' => $request->status,
                // Otras actualizaciones del perfil...
            ]);
        } else {
            // Si no tiene un perfil, crear uno nuevo
            $user->profile()->create([
                'apellidos' => $request->apellidos,
                'DNI' => $request->DNI,
                'biografia' => $request->biografia,
                'especialidad' => $request->especialidad,
                'status' => $request->status,
                // Otros campos del perfil...
            ]);
        }

        // Redireccionar con un mensaje de éxito
        return redirect()->route('admin.colaboradores.index')->with('success', 'Usuario actualizado exitosamente.');
    }


    public function destroy(string $id)
    {
    }
}
