@extends('adminlte::page')
@section('title', 'Pagos | Coopsemul')

@section('content_header')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-7qc6yR8pJt+0ERytJ3SwXTOFlG5Fbrr5yljL9IydQ9npBM2KY+y8KA1RlmNJbcJg" crossorigin="anonymous">
    </script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

@stop

@section('content')
    <div class="card container">
        <div class="card-body">
            <h2 class="mb-4">Listado de pagos</h2>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoPagoModal">Nuevo Pago</button>
            <!-- Modal -->
            <div class="modal fade" id="nuevoPagoModal" tabindex="-1" aria-labelledby="nuevoPagoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="nuevoPagoModalLabel">Nuevo Pago</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="nuevoPagoForm" enctype="multipart/form-data" action="{{ route('admin.pagos.store') }}"
                                method="POST">
                                @csrf <!-- Protege tu formulario contra ataques CSRF -->
                                <input type="hidden" name="ciclo" value="{{ $ciclo }}">
                                <div class="mb-3">
                                    <label for="fechaPago" class="form-label">Fecha de Pago</label>
                                    <input type="date" class="form-control" id="fechaPago" name="fechaPago" required>
                                </div>
                                <div class="mb-3">
                                    <label for="monto" class="form-label">Monto</label>
                                    <input type="number" step="0.01" class="form-control" id="monto" name="monto"
                                        placeholder="Ingresa el monto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción del pago"
                                        required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="imagenPago" class="form-label">Cargar Imagen</label>
                                    <input type="file" class="form-control" id="file" name="file"
                                        accept="image/*">
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" form="nuevoPagoForm">Guardar Pago</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <!-- Formulario de búsqueda -->
            <form method="GET" action="{{ route('admin.pagos.index') }}">
                <div class="row g-2">
                    <!-- Campo de búsqueda por nombre -->
                    <div class="col-12 col-md-4">
                        <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                            value="{{ request('nombre') }}">
                    </div>

                    <!-- Campo de filtro por fecha de inicio -->
                    <div class="col-12 col-md-3">
                        <input type="date" name="fechaInicio" class="form-control" value="{{ request('fechaInicio') }}">
                    </div>

                    <!-- Campo de filtro por fecha de fin -->
                    <div class="col-12 col-md-3">
                        <input type="date" name="fechaFin" class="form-control" value="{{ request('fechaFin') }}">
                    </div>

                    <!-- Botones de búsqueda y limpiar -->
                    <div class="col-md-2 d-flex">
                        <!-- Botón de búsqueda -->
                        <button type="submit" class="btn btn-primary mr-2">Filtrar</button>

                        <!-- Botón de limpiar filtros -->
                        <a href="{{ route('admin.pagos.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form> --}}

            <!-- Contenedor de tabla responsiva -->
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha de Pago</th>
                            <th>Monto</th>
                            <th>Descripcion</th>
                            <th>Foto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                            <tr>
                                <td>{{ $pago->fecha_pago }}</td>
                                <td>{{ $pago->monto }}</td>
                                <td>{{ $pago->descripcion }}</td>
                                <td>
                                    <!-- Imagen pequeña, clicable -->

                                    @if ($pago->image)
                                        <img src="{{ isset($pago->image->url) ? Storage::disk('s3')->url($pago->image->url) : '' }}"
                                            alt="Curso" class="fixed-size-img" style="width: 50px; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#imageModal{{ $loop->index }}">
                                    @else
                                        <span class="badge bg-warning text-dark">No hay captura</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $loop->index }}">Editar</button>
                                </td>
                            </tr>

                            <!-- Modal de edición -->
                            <div class="modal fade" id="editModal{{ $loop->index }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $loop->index }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $loop->index }}">Editar Pago</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Mostrar la imagen actual -->


                                            <!-- Formulario para editar los datos -->
                                            <form action="{{ route('admin.pagos.update', $pago) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="fecha_pago{{ $loop->index }}" class="form-label">Fecha
                                                        de Pago</label>
                                                    <input type="date" class="form-control"
                                                        id="fecha_pago{{ $loop->index }}" name="fechapago"
                                                        value="{{ $pago->fecha_pago }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="monto{{ $loop->index }}"
                                                        class="form-label">Monto</label>
                                                    <input type="text" class="form-control"
                                                        id="monto{{ $loop->index }}" name="monto"
                                                        value="{{ $pago->monto }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion{{ $loop->index }}"
                                                        class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcion{{ $loop->index }}" name="descripcion">{{ $pago->descripcion }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="image{{ $loop->index }}" class="form-label">Subir nueva
                                                        foto (opcional)</label>
                                                    <input type="file" class="form-control"
                                                        id="image{{ $loop->index }}" name="file">
                                                </div>
                                                <div class="mb-3 text-center">
                                                    @if ($pago->image)
                                                        <img src="{{ isset($pago->image->url) ? Storage::disk('s3')->url($pago->image->url) : 'No hay captura de pantalla del pago' }}"
                                                            alt="Imagen Actual"
                                                            style="max-width: 100%; max-height: 200px;">
                                                    @else
                                                        <span class="badge bg-warning text-dark">No hay captura</span>
                                                    @endif

                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para mostrar la imagen en grande -->
                            <div class="modal fade" id="imageModal{{ $loop->index }}" tabindex="-1"
                                aria-labelledby="imageModalLabel{{ $loop->index }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel{{ $loop->index }}">Captura del
                                                pago
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            @if ($pago->image)
                                                <img src="{{ isset($pago->image->url) ? Storage::disk('s3')->url($pago->image->url) : 'No hay captura de pantalla del pago' }}"
                                                    alt="Imagen Actual" style="max-width: 100%; max-height: 500px;">
                                            @else
                                                <span class="badge bg-warning text-dark">No hay captura</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- Paginación -->
            {{-- <div class="d-flex justify-content-center mt-3">
                {{ $ciclos->appends(request()->query())->links() }}
            </div> --}}
        </div>
    </div>



@stop


@section('css')

@stop

@section('js')

@stop
