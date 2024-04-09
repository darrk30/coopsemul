<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.categorias.index')->only('index');
        //$this->middleware('can:admin.categorias.edit')->only('edit', 'update');
        $this->middleware('can:admin.categorias.create')->only('create', 'store');
        $this->middleware('can:admin.categorias.destroy')->only('destroy');
        
    }

    public function index()
    {
        $categorias = Category::latest()->paginate(5);
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|in:0,1',
        ]);

        // Crear un nuevo precio con los datos proporcionados
        $categoria = new Category();
        $categoria->nombre = $request->nombre;
        $categoria->status = $request->estado;
        $categoria->save();

        // Redireccionar a la página de index de precios con un mensaje de éxito
        return redirect()->route('admin.categorias.index')->with('info', 'Categoria creada correctamente.');
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

    public function destroy(Category $categoria)
    {
        try {
            // Verificar si la categoría está siendo utilizada en otro registro
            if ($categoria->curso()->exists()) {
                return redirect()->back()->with('info', 'No puedes eliminar esta categoría porque está siendo utilizada en otros registros.');
            }

            // Eliminar la categoría si no está siendo utilizada en ningún registro
            $categoria->delete();

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->back()->with('info', 'Categoría eliminada correctamente');
        } catch (\Exception $e) {
            // Si ocurre algún error, redirigir con un mensaje de error
            return redirect()->back()->with('error', 'Error al eliminar la categoría: ' . $e->getMessage());
        }
    }
}
