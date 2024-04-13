<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-slate-500 text-xl">Lista de Ciclos</h1>
        {{-- 
            <a class="btn btn-primary btn-sm" href="{{ route('admin.curso.create') }}">Nuevo Curso</a>
         --}}
        @can('admin.ciclos.create')
            <a class="btn btn-primary btn-sm" href="{{ route('admin.ciclos.create') }}">Nuevo Ciclo</a>
        @endcan
    </div>
    <div class="input-group mb-3">
        <input wire:model.live.debounce.250ms="search" type="text" class="form-control rounded" placeholder="Buscar Ciclo">
    </div>


    @if ($ciclos->count())
        <div class="container">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-auto">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Curso</th>
                                <th>Ciclo</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Inscritos</th>
                                <th>Status</th>
                                <th colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ciclos as $ciclo)
                                <tr>
                                    <td>
                                        @if ($ciclo->curso->image)
                                            <img src="{{ Storage::disk('s3')->url($ciclo->curso->image->url) }}"
                                                alt="Imagen del Curso"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        @else
                                            <img src="ruta/a/imagen_predeterminada.jpg" alt="Imagen Predeterminada"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        @endif
                                    </td>
                                    <td>{{ $ciclo->curso->nombre }}</td>
                                    <td>{{ $ciclo->nombre }}</td>
                                    <td>{{ $ciclo->fechaInicio }}</td>
                                    <td>{{ $ciclo->fechaFin }}</td>
                                    <td>
                                        <a href="{{ route('admin.ciclos.students', $ciclo) }}">
                                            <i class="fas fa-users"></i> {{ $ciclo->users_count }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($ciclo->status == 1)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-secondary">No activo</span>
                                        @endif
                                    </td>
                                    @can('admin.matricular.crear')
                                    <td width="10px">
                                        <a href="{{ route('admin.matricular.crear', $ciclo) }}"
                                        class="btn btn-success btn-sm"><i class="fas fa-user-graduate"></i></a>
                                    </td>
                                    @endcan
                                    @can('admin.ciclos.create')
                                        <td width="10px">
                                            <a href="{{ route('admin.ciclos.edit', $ciclo) }}"
                                                class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card-footer">
                {{ $ciclos->links() }}
            </div>
        </div>
    @else
        <div class="card-body text-center">
            <strong>No se encontro registro para <span class="text-red">{{ $search }}</span></strong>
        </div>
    @endif


</div>
