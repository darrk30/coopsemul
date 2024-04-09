@extends('adminlte::page')
@section('title', 'Coopsemul | Precios')

@section('content_header')
    <div class="mt-1">

    </div>
@stop

@section('content')
    <div class="container">
        @if (session('info'))
            <div id="alerta" class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ session('info') }}</strong>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @can('admin.precios.create')
                        <a href="{{ route('admin.precios.create') }}" class="btn btn-secondary btn-sm float-right">Nuevo
                            Precio</a>
                        @endcan
                        <h4>Lista de Precios</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th colspan="2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($precios as $precio)
                                        <tr>
                                            <td>{{ $precio->id }}</td>
                                            <td>{{ $precio->nombre }}</td>
                                            <td>S/ {{ number_format($precio->value, 2) }}</td>
                                            <td>
                                                @if ($precio->status == 1)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>

                                            {{-- <td width=10px>
                                                <a href="#" class="btn btn-primary btn-sm">Editar</a>
                                            </td> --}}
                                            @can('admin.precios.destroy')
                                            <td style="width: 10px;">
                                                <form id="eliminar-form-{{ $precio->id }}"
                                                    action="{{ route('admin.precios.destroy', $precio) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmarEliminar({{ $precio->id }})">Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination ">
                                <li class="page-item">
                                    <a class="page-link" href="{{ $precios->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Anterior</span>
                                    </a>
                                </li>
                                <li class="page-item disabled">
                                    <span class="page-link">Página {{ $precios->currentPage() }} de
                                        {{ $precios->lastPage() }}</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $precios->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Siguiente</span>
                                    </a>
                                </li>

                            </ul>
                        </nav>


                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este precio?')) {
                // Si el usuario confirma, enviar el formulario de eliminación
                document.getElementById('eliminar-form-' + id).submit();
            }
        }
    </script>
@stop
