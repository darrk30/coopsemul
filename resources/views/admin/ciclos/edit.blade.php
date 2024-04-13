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
                <h3 class="text-2xl font-bold">EDITAR CICLO</h3>
                <hr class="mt-2 mb-6">
                {!! Form::model($ciclo, ['route' => ['admin.ciclos.update', $ciclo->id], 'method' => 'put', 'autocomplete' => 'off', 'files' => true]) !!}
                @include('admin.ciclos.partials.form')
                {!! Form::submit('Actualizar Ciclo', ['class' => 'btn btn-primary mt-2']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    

@stop

@section('js')

@endsection
