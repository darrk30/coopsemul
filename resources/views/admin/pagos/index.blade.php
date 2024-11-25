@extends('adminlte::page')
@section('title', 'Pagos | Coopsemul')

@section('content_header')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

@stop

@section('content')
    {{-- <div class="card container">
        <div class="card-body">
            <h2 class="mb-4">Listado de Ciclos</h2>

            <!-- Formulario de búsqueda -->
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
                                    <a href="#" class="btn btn-primary btn-sm">IR AL CICLO</a>
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
    </div> --}}
    <section class="w-100 p-2 container">
        <div class="row d-flex justify-content-center">
            <!-- Tarjeta del Docente -->
            @foreach ($docentes as $docente)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('admin.pagos.ciclos', ['docente' => $docente->id]) }}" class="card h-100 border-0 shadow text-decoration-none text-dark bg-light"
                        style="transition: transform 0.2s;">
                        <div class="card-body d-flex align-items-center">
                            <div class="mr-2">
                                <img src="{{ $docente->profile_photo_url }}" alt="Imagen del Docente"
                                    class="rounded-circle img-fluid" style="width: 70px; height: 70px;">
                            </div>
                            <div>
                                <h5 class="card-title mb-1 text-muted font-italic" style="font-size: 1rem">
                                    {{ $docente->name }}
                                    @if ($docente->profile && $docente->profile->apellidos)
                                        {{ ' ' . $docente->profile->apellidos }}
                                    @endif
                                </h5>
                                @if ($docente->profile && $docente->profile->DNI)
                                    <p class="card-text mb-1 text-muted font-italic"><strong>DNI:</strong>
                                        {{ $docente->profile->DNI }}</p>
                                @else
                                    <p class="card-text mb-1 text-muted font-italic"><strong>DNI:</strong> No disponible</p>
                                @endif
                                <p class="card-text mb-1 text-muted font-italic">{{ $docente->email }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>


@stop


@section('css')
    <style>
        .custom-card {
            background-color: #f8f9fa;
            /* Cambia el color de fondo aquí */
            transition: transform 0.2s, background-color 0.2s;
            /* Transición suave para el fondo */
        }

        .custom-card:hover {
            background-color: #e2e6ea;
            /* Cambia el color al pasar el mouse */
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(78, 78, 78, 0.2);
        }

        .card:hover {
            transform: scale(1.05);
            /* Aumenta ligeramente el tamaño */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            /* Añade sombra al pasar el mouse */
        }
    </style>
@stop

@section('js')

@stop
