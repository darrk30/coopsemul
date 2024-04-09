<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Precio;
use Illuminate\Http\Request;


class PreciosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.precios.index')->only('index');
        //$this->middleware('can:admin.categorias.edit')->only('edit', 'update');
        $this->middleware('can:admin.precios.create')->only('create', 'store');
        $this->middleware('can:admin.precios.destroy')->only('destroy');
        
    }

    public function index()
    {
        $precios = Precio::latest()->paginate(5);
        return view('admin.precios.index', compact('precios'));
    }

    public function create()
    {
        return view('admin.precios.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'value' => 'required|numeric',
            'estado' => 'required|in:0,1',
        ]);

        // Crear un nuevo precio con los datos proporcionados
        $precio = new Precio();
        $precio->nombre = $request->nombre;
        $precio->value = $request->value;
        $precio->status = $request->estado;
        $precio->save();

        // Redireccionar a la página de index de precios con un mensaje de éxito
        return redirect()->route('admin.precios.index')->with('info', 'Precio creado correctamente.');
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

    public function destroy(Precio $precio)
    {
        try {
            if ($precio->curso()->exists()) {
                return redirect()->back()->with('info', 'No puedes eliminar este precio porque está siendo utilizado en otros registros.');
            }
            // Eliminar el precio
            $precio->delete();

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->back()->with('info', 'Precio eliminado correctamente');
        } catch (\Exception $e) {
            // Si ocurre algún error, redirigir con un mensaje de error
            return redirect()->back()->with('error', 'Error al eliminar el precio: ' . $e->getMessage());
        }
    }
}
