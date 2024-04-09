<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-slate-500 text-xl">Lista de Cursos</h1>
        @can('admin.curso.create')
            <a class="btn btn-primary btn-sm" href="{{ route('admin.curso.create') }}">Nuevo Curso</a>
        @endcan
    </div>
    <div class="input-group mb-3">
        <input wire:model.live="search" type="text" class="form-control rounded" placeholder="Buscar Curso">
    </div>

    @if ($cursos->count())
        <div class="container">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Inscritos</th>
                                <th>Profesor</th>
                                <th>Status</th>
                                <th colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cursos as $curso)
                                <tr>
                                    <td>
                                        @if ($curso->image)
                                        <img src="{{ Storage::disk('s3')->url($curso->image->url) }}" alt="Imagen del Curso" style="width: 50px; height: 50px; border-radius: 50%;">
                                        @else
                                            <!-- Si no hay imagen, puedes mostrar una imagen predeterminada o un marcador de posición -->
                                            <img src="ruta/a/imagen_predeterminada.jpg" alt="Imagen Predeterminada"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        @endif
                                    </td>

                                    <td>{{ $curso->nombre }}</td>
                                    <td>{{ $curso->descripcion }}</td>
                                    <td>
                                        <a href="{{ route('admin.curso.students', $curso) }}">
                                            <i class="fas fa-users"></i> {{ $curso->users_count }}
                                        </a>
                                    </td>

                                    <td>{{ $curso->user->name }}</td>
                                    <td>
                                        @if ($curso->status == 1)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-secondary">No activo</span>
                                        @endif
                                    </td>
                                    @can('admin.curso.edit')
                                        <td width="10px">
                                            <a href="{{ route('admin.curso.edit', $curso) }}"
                                                class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        </td>
                                    @endcan
                                    @can('admin.matricular.crear')
                                        <td width="10px">
                                            <a href="{{ route('admin.matricular.crear', $curso) }}"
                                                class="btn btn-success btn-sm"><i class="fas fa-user-graduate"></i></a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card-footer">
                {{ $cursos->links() }}
            </div>
        </div>
    @else
        <div class="card-body text-center">
            <strong>No se encontro registro para <span class="text-red">{{ $search }}</span></strong>
        </div>
    @endif


</div>
