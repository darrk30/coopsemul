@extends('adminlte::page')
@section('title', 'Pagos | Coopsemul')

@section('content_header')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

@stop

@section('content')
    <div class="card container">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="h3 font-weight-bold text-muted">
                    Listado de Ciclos de
                    <span class="text-muted">{{ $docente->name }}</span>
                    @if ($docente->profile && $docente->profile->apellidos)
                        <span class="text-muted">{{ ' ' . $docente->profile->apellidos }}</span>
                    @endif
                </h2>
                <p class="text-muted" style="font-size: 1rem;">TODOS LOS CICLOS QUE HA DICTADO.</p>
                <hr class="my-3" style="border-top: 1px solid #89bbec; width: 50%; margin: 0 auto;">
            </div>
            

            <!-- Formulario de búsqueda -->
            <form method="GET" action="{{ route('admin.pagos.ciclos', $docente->id) }}">
                <div class="row g-2">
                    <!-- Campo de búsqueda por nombre -->
                    <div class="col-12 col-md-4">
                        <label for="fechaInicio" class="position-absolute text-muted" style="top: -10px; left: 10px; font-size: 0.9rem; background-color: white; padding: 0 5px;">Nombre</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                            value="{{ request('nombre') }}">
                    </div>

                    <!-- Campo de filtro por fecha de inicio -->
                    <div class="col-12 col-md-3 position-relative">
                        <label for="fechaInicio" class="position-absolute text-muted" style="top: -10px; left: 10px; font-size: 0.9rem; background-color: white; padding: 0 5px;">Inicio</label>
                        <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" value="{{ request('fechaInicio') }}">
                    </div>
                    

                    <!-- Campo de filtro por fecha de fin -->
                    <div class="col-12 col-md-3">
                        <label for="fechaInicio" class="position-absolute text-muted" style="top: -10px; left: 10px; font-size: 0.9rem; background-color: white; padding: 0 5px;">Fin</label>
                        <input type="date" name="fechaFin" class="form-control" value="{{ request('fechaFin') }}">
                    </div>

                    <!-- Botones de búsqueda y limpiar -->
                    <div class="col-md-2 d-flex">
                        <!-- Botón de búsqueda -->
                        <button type="submit" class="btn btn-primary mr-2">Filtrar</button>

                        <!-- Botón de limpiar filtros -->
                        <a href="{{ route('admin.pagos.ciclos', $docente->id) }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>

            <!-- Contenedor de tabla responsiva -->
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Ciclo</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ciclos as $ciclo)
                            <tr>
                                <td>{{ $ciclo->nombre }}</td>
                                <td>{{ $ciclo->fechaInicio }}</td>
                                <td>{{ $ciclo->fechaFin }}</td>
                                <td>
                                    <a href="{{route('admin.pagos.listadepagos', ['ciclo' => $ciclo->id])}}" class="btn btn-primary btn-sm">PAGOS</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $ciclos->appends(request()->query())->links() }}
            </div>
        </div>
    </div>



@stop


@section('css')

@stop

@section('js')

@stop
