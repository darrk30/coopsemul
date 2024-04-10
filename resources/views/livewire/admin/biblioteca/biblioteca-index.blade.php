<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-slate-500 text-xl">Lista de Libros</h1>
        @can('admin.libros.create')
            <a class="btn btn-primary btn-sm" href="{{ route('admin.libros.create') }}">Nuevo Libro</a>
        @endcan
    </div>

    <div class="input-group mb-3">
        <input wire:model.live="search" type="text" class="form-control rounded" placeholder="Buscar Libro">
    </div>

    @if ($libros->count())
        <div class="container">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Año</th>
                                <th>Categoría</th>
                                <th>Status</th>
                                <th>Publicado</th>
                                <th colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($libros as $libro)
                                <tr>
                                    <td style="width: 50px;">
                                        @if ($libro->image)
                                            <button type="button" class="btn btn-primary btn-sm shadow-sm"
                                                data-toggle="modal" data-target="#imagenModal{{ $libro->id }}">
                                                <img src="{{ Storage::disk('s3')->url($libro->image->url) }}"
                                                    alt="Imagen del Recurso" style="max-width: 50px; max-height: 40px; border-radius: 50%; ">
                                            </button>
                                            <div class="modal fade" id="imagenModal{{ $libro->id }}" tabindex="-1" role="dialog" aria-labelledby="imagenModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imagenModalLabel">{{ $libro->titulo }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body d-flex justify-content-center align-items-center">
                                                            <img src="{{ Storage::disk('s3')->url($libro->image->url) }}" alt="Imagen del Recurso" style="max-width: 100%; height: auto;">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            @can('admin.libros.abrir-archivo')
                                                            <a href="{{ route('admin.libros.abrir-archivo', ['LibroId' => $libro->id]) }}" target="_blank" class="btn btn-info">
                                                                <i class="fas fa-eye"></i> Ver Archivo
                                                            </a>
                                                            @endcan
                                                            @can('admin.libros.descargar-libro')
                                                            <form action="{{ route('admin.libros.descargar-libro', ['LibroId' => $libro->id]) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Descargar Recurso">
                                                                    <i class="fas fa-download"></i> Descargar
                                                                </button>
                                                            </form>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <img src="ruta/a/imagen_predeterminada.jpg" alt="Imagen Predeterminada"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        @endif
                                    </td>
                                    <td>{{ $libro->titulo }}</td>
                                    <td>{{ $libro->descripcion }}</td>
                                    <td>{{ $libro->anio_publicacion }}</td>
                                    <td>{{ $libro->category->nombre }}</td>
                                    <td>
                                        @if ($libro->status == 1)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-secondary">No activo</span>
                                        @endif
                                    </td>
                                    <td>{{ $libro->created_at->format('Y-m-d') }}</td>
                                    <td width="10px">
                                        @can('admin.libros.edit')
                                        <a href="{{ route('admin.libros.edit', $libro) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $libros->links() }}
            </div>
        </div>
    @else
        <div class="card-body text-center">
            <strong>No se encontraron registros para <span class="text-red">{{ $search }}</span></strong>
        </div>
    @endif
</div>
