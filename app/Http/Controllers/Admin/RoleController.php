<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.roles.index')->only('index');
        $this->middleware('can:admin.roles.edit')->only('edit', 'update');
        $this->middleware('can:admin.roles.create')->only('create', 'store');
        $this->middleware('can:admin.roles.destroy')->only('destroy');
        
    }

    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }
   public function create()
    {
        $permisos = Permission::all();
        return view('admin.roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        $role = Role::create($request->all());
        $role->permissions()->sync($request->permisos);

        return redirect()->route('admin.roles.edit', $role)->with('info', 'El rol se creo con exito');
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permisos = Permission::all();
        return view('admin.roles.edit', compact('role', 'permisos'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role->update($request->all());
        $role->permissions()->sync($request->permisos);

        return redirect()->route('admin.roles.edit', $role)->with('info', 'El rol se actualizo con exito');
    }

   
   public function destroy(Role  $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('info', 'El rol se elimino con exito');
    }
}
