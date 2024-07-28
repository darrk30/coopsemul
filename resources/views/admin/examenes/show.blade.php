@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="container"></div>

@stop

@section('content')
    <div class="container card">
        <div class="card-header">
            @if ($rol === 'Estudiante')
                <p style="font-style: italic; color: gray;">Mis Resultados del examen</p>
            @else
                <p style="font-style: italic; color: gray;">Resultados de Estudiantes</p>
            @endif
            <h3>{{ $exam->titulo }}</h3>
        </div>

        <div class="card-body">
            @if ($rol === 'Estudiante')
                <div class="card text-center">
                    <div class="card-header text-white" style="background: #6200ff">
                        <h4>Puntaje Total Obtenido</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="display-4 text-success">{{ $userExamen->detalleExamen->puntaje }}</h1>
                    </div>
                    <div class="card-footer text-muted">
                        ¡Felicidades por completar el examen!
                    </div>
                </div>
                @include('admin.examenes.partials.estudiante', [
                    'userExamen' => $userExamen,
                    'exam' => $exam,
                ])
            @else
                @include('admin.examenes.partials.administrativo', ['userExamenes' => $userExamenes])
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.examenes.index') }}" class="btn btn-primary">Volver</a>
            <a href="{{ route('admin.questions.index', $exam) }}" class="btn btn-secondary ">Examen</a>
        </div>
    </div>
@stop


@section('css')
    <style>
        .card {
            height: 100%;
        }

        .card-img {
            width: 100%;
            /* Asegura que la imagen ocupe toda la altura disponible */
            object-fit: cover;
            /* Mantiene las proporciones de la imagen */
        }

        .bg-light {
            background-color: #f8f9fa;
            /* Fondo claro para contraste */
        }

        .rounded-circle {
            border-radius: 50%;
            /* Hace la imagen redonda */
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 1rem;
            /* Asegura un buen padding interno */
        }

        .card-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            /* Reduce el espacio inferior del título */
        }

        .card-text {
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            /* Reduce el espacio inferior del texto */
        }
    </style>


@stop

@section('js')

@stop
