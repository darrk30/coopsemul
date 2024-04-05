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
    @livewire('admin.biblioteca.biblioteca-index')
@stop

@section('css')


@section('js')

@stop
