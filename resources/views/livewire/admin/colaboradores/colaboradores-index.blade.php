<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-slate-500 text-xl">Lista de Colaboradores</h1>
        {{-- @can('admin.curso.create') --}}
        <a class="btn btn-primary btn-sm" href="{{ route('admin.colaboradores.create') }}">Nuevo Colaborador</a>
        {{-- @endcan --}}
    </div>
    <div class="input-group mb-3">
        <input wire:model.live="search" type="text" class="form-control rounded" placeholder="Buscar Colaborador">
    </div>

    @if ($colaboradores->count())
        <div class="container">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Status</th>
                                <th colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colaboradores as $colaborador)
                                <tr>
                                    <td>
                                        @if ($colaborador->profile_photo_url )
                                            <img src="{{ $colaborador->profile_photo_url }}" alt="Imagen Predeterminada"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        @else
                                            <!-- Si no hay imagen, puedes mostrar una imagen predeterminada o un marcador de posición -->
                                            <img src="ruta/a/imagen_predeterminada.jpg" alt="Imagen Predeterminada"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        @endif


                                    </td>

                                    <td>{{ $colaborador->name }}</td>
                                    <td>{{ $colaborador->profile->apellidos ?? '' }}</td>
                                    <td>{{ $colaborador->profile->DNI ?? '' }}</td>


                                    <td>{{ $colaborador->email }}</td>
                                    <td>
                                        @foreach ($colaborador->getRoleNames() as $role)
                                            <span class="badge badge-warning">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    
                                    

                                    <td>
                                        @if (optional($colaborador->profile)->status == 1)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-secondary">No activo</span>
                                        @endif

                                    </td>
                                    {{-- @can('admin.colaborador.edit') --}}
                                    <td width="10px">
                                        <a href="{{ route('admin.colaboradores.edit', $colaborador) }}"
                                            class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    </td>
                                    {{-- @endcan --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card-footer">
                {{ $colaboradores->links() }}
            </div>
        </div>
    @else
        <div class="card-body text-center">
            <strong>No se encontro registro para <span class="text-red">{{ $search }}</span></strong>
        </div>
    @endif


</div>
