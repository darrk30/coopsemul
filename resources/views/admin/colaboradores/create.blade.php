@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="mt-1">

    </div>
@stop

@section('content')
    <div class="container">
        @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
    </div>
    <div class="container py-8">
        <div class="card">
            <div class="card-body">
                <h3 class="text-2xl font-bold">CREAR NUEVO COLABORADOR</h3>
                
                <hr class="mt-2 mb-6">
                {!! Form::open([
                    'route' => 'admin.colaboradores.store',
                    'method' => 'POST',                    
                ]) !!}
                @include('admin.colaboradores.partials.form')
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
@stop
