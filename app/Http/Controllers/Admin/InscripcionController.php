<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Curso;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class InscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.matricular.crear')->only('store', 'matricular', 'buscarDNI');
    }

    public function index()
    {
    }

    public function create()
    {
    }

    public function validateFields($request)
    {
        $validator = Validator::make($request->all(), [
            'curso' => 'required|string',
            'name' => 'required|string',
            'apellidos' => 'required|string',
            'dni' => 'required|string|digits:8',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|string|min:8',
            'status' => 'required|in:0,1',
        ]);

        return $validator;
    }

    public function store(Request $request)
    {
        // Validar campos
        // Iniciar la transacción
        DB::beginTransaction();
        try {

            $user_id = $request->user_id;
            if ($user_id) {
                $curso_id = $request->id;
                $user = User::where('id', $user_id)->first();
                // Verificar si el usuario ya está inscrito en el curso
                $inscripcionExistente = DB::table('curso_user')
                    ->where('curso_id', $curso_id)
                    ->where('user_id', $user_id)
                    ->exists();
                if ($inscripcionExistente) {
                    DB::commit();
                    session()->flash('transaction_failed', true);
                    return back()->withErrors(['info' => 'El usuario ya esta matriculado en el curso']);
                } else {
                    $user->assignRole('estudiante');
                    DB::table('curso_user')->insert([
                        'curso_id' => $curso_id,
                        'user_id' => $user_id,
                        'status' => 1,
                    ]);
                    DB::commit();
                }
            } else {
                $validator = $this->validateFields($request);

                // Si la validación falla, redirigir de vuelta con los errores
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                // Registrar el usuario
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();

                // Asignar el rol de "estudiante" al usuario
                $user->assignRole('estudiante');

                // Obtener el ID del usuario recién creado
                $user_id = $user->id;

                // Registrar el perfil
                $profile = new Profile();
                $profile->user_id = $user_id;
                $profile->apellidos = $request->apellidos;
                $profile->dni = $request->dni;
                $profile->status = $request->status;
                $profile->save();

                // Obtener el ID del curso desde el formulario
                $curso_id = $request->id;

                // Guardar la relación entre el usuario y el curso en la tabla intermedia
                DB::table('curso_user')->insert([
                    'curso_id' => $curso_id,
                    'user_id' => $user_id,
                    'status' => $request->status,
                ]);
                DB::commit();
                // Confirmar la transacción si todo está bien

            }

            // Redireccionar a donde quieras después de guardar los datos
            return redirect()->route('admin.curso.index');
        } catch (Throwable $e) {
            // En caso de error, revertir la transacción
            DB::rollBack();
            session()->flash('transaction_failed', true);

            // Manejar el error como prefieras
            // Por ejemplo, podrías redirigir de nuevo con un mensaje de error
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al guardar los datos. Por favor, inténtelo de nuevo.']);
        }
    }


    public function buscarDNI(Request $request)
    {
        // Obtener el DNI de la solicitud
        $dni = $request->dni;

        // Verificar si el DNI ya existe en la base de datos
        $perfil = Profile::where('DNI', $dni)->first();
        // Si se encuentra un perfil asociado al DNI en la base de datos
        if ($perfil) {
            // Retornar los datos del perfil junto con un mensaje indicando que ya existe en la base de datos
            return response()->json([
                'success' => true,
                'nombres' => $perfil->user->name,
                'apellidos' => $perfil->apellidos,
                'email' => $perfil->user->email,
                'user_id' => $perfil->user->id,
            ]);
        } else {
            $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImtyaXZlcmFyb2phczQ0QGdtYWlsLmNvbSJ9.vdnwHkb3e0nx9VtKCN7U-FGdMzQdn_K9M_I_hdkzG-Q';

            // Construir la URL de la API con el DNI y el token
            $url = 'https://dniruc.apisperu.com/api/v1/dni/' . $dni . '?token=' . $token;

            try {
                // Realizar la solicitud GET a la API
                $response = file_get_contents($url);

                // Decodificar el JSON a un arreglo asociativo
                $data = json_decode($response, true);

                // Verificar si la consulta fue exitosa
                if ($data['success']) {
                    return response()->json($data);
                } else {
                    // Si no se encontraron resultados, devolver el JSON con el mensaje correspondiente
                    return response()->json($data);
                }
            } catch (\Exception $e) {
                // Si ocurre un error durante la solicitud, devolver un mensaje de error
                return response()->json(['error' => 'Ocurrió un error al realizar la consulta'], 500);
            }
        }
    }



    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function editar(Curso $curso, User $user)
    {
        return view('admin.inscripciones.edit', compact('user', 'curso'));
    }

    public function update(Request $request, User $user)
    {
        $curso_id = $request->id;
        $user_id = $request->user_id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required|in:0,1',
            'password' => 'nullable|string|min:8',
            'curso' => 'nullable|string', // Ajusta la validación según tus necesidades
        ]);

        // Verificar si se ha ingresado una nueva contraseña
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Verificar si se ha activado el cambio de curso y se ha proporcionado un código de curso
        if ($request->filled('codigo')) {
            // Buscar el curso por el código proporcionado
            $curso = Curso::where('codigo', $request->codigo)->first();

            if ($curso) {
                // Verificar si el usuario ya está inscrito en el nuevo curso
                $inscripcionExistente = DB::table('curso_user')
                    ->where('curso_id', $curso->id)
                    ->where('user_id', $user_id)
                    ->exists();

                if ($inscripcionExistente) {
                    return back()->withErrors(['error' => 'El usuario ya está matriculado en el curso al que intenta cambiar.']);
                }
                // Desvincular al usuario del curso anterior
                $user->cursos()->detach($curso_id);
                // Vincular al usuario con el nuevo curso y actualizar su estado
                $user->cursos()->attach($curso->id, ['status' => $request->status]);
            } else {
                return back()->withErrors(['error' => 'El código de curso proporcionado no es válido.']);
            }
        }

        // Actualizar datos del usuario
        $user->email = $request->email;
        $user->save();

        // Obtener la entrada en la tabla intermedia curso_user para el usuario y el curso en cuestión
        $cursoUserEntry = DB::table('curso_user')
            ->where('user_id', $user_id)
            ->where('curso_id', $curso_id)
            ->first();

        // Si se encontró la entrada en la tabla intermedia, actualizar el estado
        if ($cursoUserEntry) {
            DB::table('curso_user')
                ->where('user_id', $user_id)
                ->where('curso_id', $curso_id)
                ->update(['status' => $request->status]);
        }

        // Redireccionar con un mensaje de éxito
        return redirect()->route('admin.curso.index')->with('success', 'Usuario actualizado correctamente.');
    }


    // public function update(Request $request, User $user)
    // {

    //     $request->validate([
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         'status' => 'required|in:0,1',
    //         'password' => 'nullable|string|min:8',
    //         'status' => 'required|in:0,1',
    //         'curso' => 'nullable|string', // Aquí puedes ajustar la validación según tus necesidades
    //     ]);

    //     // Verificar si se ha ingresado una nueva contraseña
    //     if ($request->filled('password')) {
    //         $user->password = bcrypt($request->password);
    //     }

    //     // Verificar si se ha activado el cambio de curso y se ha proporcionado un código de curso
    //     if ($request->filled('codigo')) {
    //         // Buscar el curso por el código proporcionado
    //         $curso = Curso::where('codigo', $request->codigo)->first();

    //         if ($curso) {
    //             // Actualizar la relación entre el usuario y el curso
    //             $user->cursos()->sync([$curso->id]);
    //         } else {
    //             return back()->withErrors(['error' => 'El código de curso proporcionado no es válido.']);
    //         }
    //     }
    //     // Actualizar datos del usuario
    //     $user->email = $request->email;

    //     // Obtener el estado actual del perfil
    //     $perfilEstadoActual = $user->profile->status;

    //     if ($request->status != $perfilEstadoActual) {
    //         // Si el estado ha cambiado, realizar las acciones necesarias
    //         if ($request->status == 0) {
    //             $user->roles()->detach(); // Eliminar el rol asociado al usuario
    //         } else {
    //             $user->assignRole('Estudiante');
    //         }

    //         DB::table('curso_user')->insert([                
    //             'status' => $request->status, // Aquí se actualiza el estado en la tabla curso_user
    //         ]);
    //         $user->profile->save();
    //     }


    //     $user->save();
    //     // Redireccionar con un mensaje de éxito
    //     return redirect()->route('admin.curso.index')->with('success', 'Usuario actualizado correctamente.');
    // }


    public function destroy(string $id)
    {
    }


    public function matricular(Curso $curso)
    {
        return view('admin.inscripciones.create', compact('curso'));
    }
}
