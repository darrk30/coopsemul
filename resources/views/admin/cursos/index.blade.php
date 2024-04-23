@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="container">
        <h1 class="text-xl font-semibold text-gray-800">Mis Cursos</h1>
    </div>
@stop

@section('content')
    <section class="container">
        @if (Auth::user()->hasRole('Profesor') || Auth::user()->hasRole('Administrador'))

            <div class="row">
                @isset($MisCursos2)
                    @foreach ($MisCursos2 as $curso)
                        <div class="col-md-4 mb-4">
                            <div class="card curso-card shadow">
                                <img src="{{ Storage::disk('s3')->url($curso->image->url) }}" alt="Curso">
                                <div class="card-body">
                                    <div style="height: 4rem;">
                                        <h2 class="card-title text-lg font-semibold text-gray-800">
                                            @isset($curso->nombre)
                                                {{ $curso->nombre }}
                                            @endisset
                                        </h2>
                                    </div>
                                    @foreach ($curso->ciclo as $ciclo)
                                        <p class=" text-gray-600">Ciclo: {{ $ciclo->nombre }}</p>
                                        <p class=" text-gray-600">@isset($Ciclo->curso->user->name)Profesor: {{ $ciclo->user->name }}@endisset</p>
                                        <a href="{{ route('admin.ciclos.show', $ciclo) }}" class="btn btn-primary">Ir al
                                            Curso</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
                @forelse ($MisCursos as $curso)
                    @foreach ($curso->ciclo as $Ciclo)
                        <div class="col-md-4 mb-4">
                            <div class="card curso-card shadow">
                                <img src="{{ Storage::disk('s3')->url($Ciclo->curso->image->url) }}" alt="Curso">
                                <div class="card-body">
                                    <div style="height: 4rem;">
                                        <h2 class="card-title text-lg font-semibold text-gray-800">
                                            {{ $Ciclo->curso->nombre }}</h2>
                                    </div>
                                    <p class=" text-gray-600">Ciclo: {{ $Ciclo->nombre }}</p>
                                    <p class=" text-gray-600">@isset($Ciclo->curso->user->name)Profesor:
                                            {{ $Ciclo->curso->user->name }}
                                        @endisset
                                    </p>
                                    <a href="{{ route('admin.ciclos.show', $Ciclo) }}" class="btn btn-primary">Ir al
                                        Curso</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">No Tiene cursos asignados en este momento.</h4>
                        </div>
                    </div>
                @endforelse
            </div>
            @if(Auth::user()->hasRole('Administrador'))
            <nav aria-label="Page navigation example">
                <ul class="pagination ">
                    <li class="page-item">
                        <a class="page-link" href="{{ $MisCursos->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">Página {{ $MisCursos->currentPage() }} de
                            {{ $MisCursos->lastPage() }}</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $MisCursos->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </li>
        
                </ul>
            </nav>
            @endif
        @else
            <div class="row">
                @forelse ($MisCiclos as $ciclo)
                    <div class="col-md-4 mb-4">
                        <div class="card curso-card shadow">
                            <img src="{{ Storage::disk('s3')->url($ciclo->curso->image->url) }}" alt="Curso">
                            <div class="card-body">
                                <div style="height: 4rem;">
                                    <h2 class="card-title text-lg font-semibold text-gray-800">{{ $ciclo->curso->nombre }}
                                    </h2>
                                </div>
                                <p class=" text-gray-600">Ciclo: {{ $ciclo->nombre }}</p>
                                <p class=" text-gray-600">@isset($Ciclo->curso->user->name)Profesor:
                                        {{ $ciclo->curso->user->name }}
                                    @endisset
                                </p>
                                <a href="{{ route('admin.ciclos.show', $ciclo) }}" class="btn btn-primary">Ir al Curso</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">No Tiene cursos asignados en este momento.</h4>
                        </div>
                    </div>
                @endforelse
            </div>
        @endif
       
    </section>
    

    <style>
        .curso-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .curso-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .curso-card img {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .curso-card .card-body {
            padding: 1.25rem;
        }

        .curso-card .card-text {
            margin-top: 10px;
        }

        .curso-card .btn {
            font-size: 0.85rem;
        }
    </style>
@stop
