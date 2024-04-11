@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="mt-1">

    </div>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="container py-8">
        <div class="card">
            <div class="card-body">
                <h3 class="text-2xl font-bold">CREAR NUEVO CICLO</h3>
                <hr class="mt-2 mb-6">
                {!! Form::open(['route' => 'admin.ciclos.store', 'autocomplete' => 'off', 'files' => true]) !!}
                @include('admin.ciclos.partials.form')
                {!! Form::submit('Crar Ciclo', ['class' => 'btn btn-primary mt-2']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

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

@endsection
