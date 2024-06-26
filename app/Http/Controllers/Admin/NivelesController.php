<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NivelesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.niveles.index')->only('index');
        //$this->middleware('can:admin.categorias.edit')->only('edit', 'update');
        $this->middleware('can:admin.niveles.create')->only('create', 'store');
        $this->middleware('can:admin.niveles.destroy')->only('destroy');
    }

    public function index()
    {
        $niveles = Level::latest()->paginate(5);
        return view('admin.niveles.index', compact('niveles'));
    }

    public function create()
    {
        return view('admin.niveles.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        // Crear un nuevo precio con los datos proporcionados
        $nivel = new Level();
        $nivel->nombre = $request->nombre;
        $nivel->status = $request->status;
        $nivel->save();

        // Redireccionar a la página de index de precios con un mensaje de éxito
        return redirect()->route('admin.categorias.index')->with('info', 'Nivel creado correctamente.');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(Level $level)
    {


        try {
            // Iniciar una transacción
            DB::beginTransaction();

            // Verificar si la categoría está siendo utilizada en otro registro
            if ($level->curso()->exists()) {
                return redirect()->back()->with('info', 'No puedes eliminar este Nivel porque está siendo utilizada en otros registros.');
            }

            // Eliminar la categoría si no está siendo utilizada en ningún registro
            $deleted = $level->delete();

            // Confirmar la transacción si todas las operaciones fueron exitosas
            DB::commit();

            // Verificar si el nivel se ha eliminado correctamente
            if (!$deleted) {
                $errors = $level->getErrors();
                return redirect()->back()->with('error', 'Error al eliminar el Nivel: ' . $errors->toJson());
            }

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->back()->with('info', 'Nivel eliminado correctamente');
        } catch (\Exception $e) {
            // Revertir la transacción si ocurre algún error
            DB::rollback();

            // Redirigir con un mensaje de error
            return redirect()->back()->with('error', 'Error al eliminar el Nivel: ' . $e->getMessage());
        }
    }
}
