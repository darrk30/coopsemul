<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use App\Models\Empresas;
use App\Models\Especialidad;
use App\Models\Profile;
use App\Models\TipoInscripcion;
use App\Models\TipoPago;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificadosController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.certificados.index')->only('index');
        $this->middleware('can:admin.certificados.create')->only('create', 'store');
        $this->middleware('can:admin.certificados.edit')->only('edit', 'update');
    }
    public function index()
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();
    
        // Verificar si el usuario tiene el rol "Administrador"
        if ($usuario->hasRole('Administrador')) {
            // Mostrar todos los certificados para administradores con paginación de 30 en 30
            $certificados = Certificado::orderBy('id', 'desc')->paginate(2);
        } else {
            // Mostrar solo los certificados relacionados con el usuario autenticado con paginación de 30 en 30
            $certificados = Certificado::where('users_id_trabajador', $usuario->id)->orderBy('id', 'desc')->paginate(30);
        }
    
        return view('admin.certificados.index', compact('certificados'));
    }
    

    public function create()
    {
        // Obtener las empresas, tipos de pago y especialidades
        // $empresas = Empresas::all();
        $empresas = Empresas::where('user_id', auth()->id())->get();
        $tiposPago = TipoPago::all();
        $tipoInscripciones = TipoInscripcion::all();
        $especialidades = Especialidad::all();
        // Obtener usuarios con roles específicos usando Spatie
        $promotores = User::role('Promotor')->get(); // Asegúrate de tener un rol llamado "Promotor"
        $trabajadores = User::role('Trabajador')->get(); // Asegúrate de tener un rol llamado "Trabajador"

        return view('admin.certificados.create', compact('empresas', 'promotores', 'trabajadores', 'tiposPago', 'especialidades', 'tipoInscripciones'));
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'curso' => 'required|string|max:45',
            'rutaArchivo' => 'required|file|mimes:pdf,doc,docx|max:10048', // Ajusta los tipos y tamaños según necesidad
            'codigo' => 'required|string|max:45|unique:certificados,codigo',
            'resolucion' => 'required|string|max:45',
            'users_id_trabajador' => 'required|exists:users,id',
            'tipo_pago_id' => 'nullable|exists:tipo_pagos,id',
            'tipo_inscripcion_id' => 'nullable|exists:tipo_inscripcions,id',
            'especialidad_id' => 'nullable|exists:especialidads,id',
            'dni' => 'required|string|max:15',  // Validación del DNI
            'name' => 'required|string|max:45', // Validación del nombre
            'apellidos' => 'required|string|max:45', // Validación de apellidos
        ]);

        // Verificar si ya existe el `user_id`
        $userId = $request->input('user_id');

        // Obtener el ID de la empresa del formulario


        if (!$userId) {
            // Si no existe el `user_id`, creamos un nuevo usuario

            // Generar un correo único con un número iterativo
            $baseEmail = 'AGREGADO';
            $email = $baseEmail . $this->getUniqueEmailNumber() . '@coopsemul.com';

            // Generar una contraseña aleatoria entre 1 y 9
            $password = rand(1, 9);

            // Crear el nuevo usuario
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $email,  // Correo único
                'password' => bcrypt($password),  // Contraseña aleatoria
            ]);

            // Crear un perfil para el nuevo usuario
            $profile = new Profile();
            $profile->dni = $request->input('dni');
            $profile->apellidos = $request->input('apellidos');
            $profile->user_id = $user->id;  // Relacionar el perfil con el usuario recién creado
            $profile->status = 0;
            $profile->save();

            // Usar el ID del nuevo usuario
            $userId = $user->id;
        }


        // Obtener el DNI del usuario autenticado
        $dniUsuario = $request->input('dni');
        // Obtener el user_id del trabajador (usuario que fue buscado o recién creado)
        $users_id = $userId;

        // Subir archivo a S3 con la ruta personalizada
        if ($request->hasFile('rutaArchivo')) {
            // Generar un nombre único para el archivo basado en el nombre original
            $fileName = time() . '_' . $request->file('rutaArchivo')->getClientOriginalName();

            // Construir la ruta donde se guardará el archivo en S3
            $filePath = 'Coopsemul/clientes/' . $dniUsuario . '/certificados/' . $fileName;

            // Subir el archivo a S3
            $filePath = $request->file('rutaArchivo')->storeAs('', $filePath, 's3');
        }

        $empresaId = $request->input('empresas_id');

        // Buscar la empresa con ese ID
        $empresa = Empresas::find($empresaId);
        if ($empresa) {
            // Si la empresa existe, asignamos su nombre
            $empresaNombre = $empresa->nombre;
        } else {
            // Si no se encuentra la empresa, asignamos un valor por defecto o gestionamos el error
            $empresaNombre = 'Empresa no encontrada';
        }


        // Crear el certificado
        Certificado::create([
            'curso' => $request->input('curso'),
            'rutaArchivo' => $filePath ?? null, // Guardar la ruta del archivo en la base de datos
            'codigo' => $request->input('codigo'),
            'resolucion' => $request->input('resolucion'),
            'empresa' => $empresaNombre,
            'users_id' => $users_id, // Guardar el user_id del trabajador (usuario buscado o recién creado)
            'users_id_trabajador' => auth()->user()->id, // El ID del usuario autenticado como creador
            'users_id_promotor' => $request->input('users_id_promotor'),
            'tipo_pago_id' => $request->input('tipo_pago_id'),
            'tipo_inscripcion_id' => $request->input('tipo_inscripcion_id'),
            'especialidad_id' => $request->input('especialidad_id'),
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.certificados.index')->with('success', 'Certificado creado correctamente.');
    }

    private function getUniqueEmailNumber()
    {
        // Contar cuántos usuarios con el prefijo 'AGREGADO' ya existen en la base de datos
        $count = User::where('email', 'like', 'AGREGADO%')->count();

        // Retornar el siguiente número iterativo
        return $count + 1;
    }

    public function show(string $id) {}

    public function edit(Certificado $certificado)
    {
        $empresas = Empresas::all();
        $tiposPago = TipoPago::all();
        $tipoInscripciones = TipoInscripcion::all();
        $especialidades = Especialidad::all();
        $promotores = User::role('Promotor')->get(); // Asegúrate de tener un rol llamado "Promotor"
        // Obtén los datos necesarios para editar el certificado
        return view('admin.certificados.edit', compact('certificado', 'tiposPago', 'especialidades', 'tipoInscripciones', 'empresas', 'promotores'));
    }

    public function update(Request $request, Certificado $certificado)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'curso' => 'required|string|max:255',
            'resolucion' => 'required|string|max:255',
            'codigo' => "required|unique:certificados,codigo,$certificado->id",
            'especialidad_id' => 'required|exists:especialidads,id',
            'rutaArchivo' => 'nullable|file|mimes:pdf,jpg,png|max:10048',
            'tipo_pago_id' => 'required|exists:tipo_pagos,id',
            'users_id_promotor' => 'required|exists:users,id',
            'tipo_inscripcion_id' => 'required|exists:tipo_inscripcions,id',
            'empresas_id' => 'required|exists:empresas,id',
        ]);

        // Buscar el certificado por su ID
        $certificado = Certificado::findOrFail($certificado->id);

        // Obtener el ID de la empresa del formulario
        $empresaId = $request->input('empresas_id');

        // Buscar la empresa con ese ID
        $empresa = Empresas::find($empresaId);

        if ($empresa) {
            // Si la empresa existe, asignamos su nombre
            $empresaNombre = $empresa->nombre;
        } else {
            // Si no se encuentra la empresa, asignamos un valor por defecto o gestionamos el error
            $empresaNombre = 'Empresa no encontrada';
        }

        // Actualizar los campos del certificado
        $certificado->users_id = $validatedData['user_id'];
        $certificado->curso = $validatedData['curso'];
        $certificado->resolucion = $validatedData['resolucion'];
        $certificado->codigo = $validatedData['codigo'];
        $certificado->especialidad_id = $validatedData['especialidad_id'];
        $certificado->tipo_pago_id = $validatedData['tipo_pago_id'];
        $certificado->users_id_promotor = $validatedData['users_id_promotor'];
        $certificado->tipo_inscripcion_id = $validatedData['tipo_inscripcion_id'];
        $certificado->empresa = $empresaNombre;

        if ($request->hasFile('rutaArchivo')) {
            // Si existe un archivo previo en S3, eliminarlo
            if ($certificado->rutaArchivo) {
                // Eliminar el archivo anterior en S3
                Storage::disk('s3')->delete($certificado->rutaArchivo);
            }

            // Obtener el DNI del usuario para construir la ruta
            $dniUsuario = $certificado->user->profile->DNI;

            // Generar un nombre único para el archivo basado en el nombre original
            $fileName = time() . '_' . $request->file('rutaArchivo')->getClientOriginalName();

            // Construir la ruta donde se guardará el archivo en S3
            $filePath = 'Coopsemul/clientes/' . $dniUsuario . '/certificados/' . $fileName;

            // Subir el archivo a S3 en la misma ruta
            $filePath = $request->file('rutaArchivo')->storeAs('', $filePath, 's3');

            // Actualizar la ruta del archivo en el modelo
            $certificado->rutaArchivo = $filePath;
        }

        // Guardar los cambios
        $certificado->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.certificados.index')->with('success', 'Certificado actualizado correctamente.');
    }


    public function destroy(string $id) {}


    public function descargar_recurso($recursoId)
    {
        $recurso = Certificado::findOrFail($recursoId);

        // Obtener la URL del archivo en el disco S3
        $urlArchivo = Storage::disk('s3')->url($recurso->rutaArchivo);

        // Obtener el nombre original del archivo desde la base de datos
        $nombreArchivo = basename($recurso->rutaArchivo);

        // Descargar el archivo con su nombre original y establecer el tipo de contenido
        return response()->streamDownload(function () use ($urlArchivo) {
            $file = fopen($urlArchivo, 'r');
            fpassthru($file);
            fclose($file);
        }, $nombreArchivo, [
            'Content-Type' => 'application/octet-stream',
        ]);
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
                'user_id' => $perfil->user->id,
            ]);
        }
    }
}
