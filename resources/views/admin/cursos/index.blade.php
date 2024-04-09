@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="container">
        <h1 class="text-xl font-semibold text-gray-800">Mis Cursos</h1>
    </div>
@stop

@section('content')
    <section class="container">
        <div class="row">
            @forelse ($MisCursos as $curso)
                <div class="col-md-4 mb-4">
                    <div class="card curso-card shadow">
                        <img src="{{ Storage::disk('s3')->url($curso->image->url) }}" alt="Curso">
                        <div class="card-body">
                            <div style="height: 5rem;">
                                <h2 class="card-title text-lg font-semibold text-gray-800">{{ $curso->nombre }}</h2>
                            </div>
                            
                            <p class=" text-gray-600">Profesor: {{ $curso->user->name }}</p>
                            <a href="{{ route('admin.cursos.show', $curso) }}"
                                class="btn btn-primary">Ir al Curso</a>
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
