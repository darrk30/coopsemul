@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="mt-1">

    </div>
@stop

@section('content')
    @if (session('error'))
        <div class="alert alert-success">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    <div class="container py-8">
        <div class="card">
            <div class="card-body">
                <h1 class="text-2xl font-bold">EDITAR LIBRO</h1>
                <hr class="mt-2 mb-6">
                {!! Form::model($libro, [
                    'route' => ['admin.libros.update', $libro->id],
                    'autocomplete' => 'off',
                    'files' => true,
                    'method' => 'PUT',
                    'class' => 'row g-3',
                ]) !!}
                @include('admin.biblioteca.partials.form')
                <div class="col-12">
                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('css')


@section('js')
    <script>
        document.getElementById("image").addEventListener('change', cambiarImagen);

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
