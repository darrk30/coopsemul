@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
<div class="container">
    @if (session('info'))
        <div id="alerta" class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    
</div>

@stop

@section('content')

    @livewire('admin.curso')
@stop

@section('js')
    <script>
        // Cerrar la alerta cuando se hace clic en el botón de cerrar
        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('alerta').style.display = 'none';
        });

        // Desaparecer la alerta después de 5 segundos
        setTimeout(function() {
            document.getElementById('alerta').style.display = 'none';
        }, 3000);
    </script>
@endsection
