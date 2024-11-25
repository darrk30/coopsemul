<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ciclo;
use App\Models\Pagos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PagosController extends Controller
{

    public function index()
    {
        $docentes = User::role('Profesor')->get();
        return view('admin.pagos.index', compact('docentes'));
    }

    public function ciclos(Request $request, $docenteId)
    {
        // Obtén el docente utilizando el ID
        $docente = User::find($docenteId);

        // Verifica si el docente existe
        if (!$docente) {
            return redirect()->route('admin.pagos.index')->with('error', 'Docente no encontrado.');
        }

        // Inicializa la consulta base para los ciclos
        $query = Ciclo::whereHas('curso', function ($query) use ($docenteId) {
            $query->where('user_id', $docenteId);
        });

        // Filtrar por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->input('nombre') . '%');
        }

        // Filtrar por fecha de inicio
        if ($request->filled('fechaInicio')) {
            $query->where('fechaInicio', '>=', $request->input('fechaInicio'));
        }

        // Filtrar por fecha de fin
        if ($request->filled('fechaFin')) {
            $query->where('fechaFin', '<=', $request->input('fechaFin'));
        }

        // Obtener los ciclos filtrados
        $ciclos = $query->paginate(10); // Cambia el número según tu preferencia

        // Devuelve la vista con los datos del docente y los ciclos
        return view('admin.pagos.ciclos', compact('docente', 'ciclos'));
    }

    public function pagos(Request $request)
    {
        $pagos = Pagos::orderBy('created_at', 'desc')->get();
        $ciclo = $request->ciclo;
        return view('admin.pagos.pagos', compact('pagos', 'ciclo'));
    }


    public function create() {}

    public function store(Request $request)
    {
        //return $request;

        $ciclo = $request->ciclo;

        $pago = Pagos::create([
            'fecha_pago' => $request->fechaPago,
            'monto' => $request->monto,
            'descripcion' => $request->descripcion,
            'ciclo_id' => $ciclo,
        ]);

        if ($request->file('file')) {
            $url = Storage::disk('s3')->put('pagos', $request->file('file'));
            $pago->image()->create([
                'url' => $url
            ]);
        }

        return redirect()->route('admin.pagos.listadepagos', ['ciclo' => $ciclo])->with('info', 'Pago registrado.');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, Pagos $pago)
    {
        // Validar la información recibida
        $request->validate([
            'fechapago' => 'required|date',
            'monto' => 'required|numeric',
            'descripcion' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Validar solo si la imagen se sube
        ]);

        // Actualizar los campos del pago
        $pago->fecha_pago = $request->input('fechapago');
        $pago->monto = $request->input('monto');
        $pago->descripcion = $request->input('descripcion');

        // Verificar si se ha subido una nueva imagen
        if ($request->hasFile('file')) {
            if ($pago->image) {
                Storage::disk('s3')->delete($pago->image->url);
                $pago->image()->delete();
            }
            $path = $request->file('file')->store('pagos', 's3');
            $pago->image()->create([
                'url' => $path
            ]);
        }

        // Guardar los cambios en el modelo Pagos
        $pago->save();

        // Redirigir a la vista anterior con un mensaje de éxito
        return redirect()->back()->with('success', 'Pago actualizado exitosamente.');
    }


    public function destroy(string $id) {}
}
