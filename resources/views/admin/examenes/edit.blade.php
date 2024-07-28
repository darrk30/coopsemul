@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="container">
        @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
    </div>
@stop

@section('content')

    <div class="container py-8">
        <div class="card">
            <div class="card-body">
                <h3 class="text-2xl font-bold">Editar Examen: {{ $exam->titulo }}</h3>
                <hr class="mt-2 mb-6">

                {!! Form::model($exam, [
                    'route' => ['admin.examenes.update', $exam],
                    'autocomplete' => 'off',
                    'files' => true,
                    'method' => 'PUT',
                ]) !!}

                @include('admin.examenes.partials.form')

                {!! Form::submit('Actualizar Examen', ['class' => 'btn btn-primary mt-2']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop


@section('css')

@stop

@section('js')
    {{-- cambio de imagen automaticamente --}}
    <script>
        document.getElementById("file").addEventListener('change', cambiarImagen);

        function cambiarImagen(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById("imagen").setAttribute('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
    </script>
@stop
