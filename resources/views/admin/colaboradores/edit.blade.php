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
                <div style="display: flex; justify-content: space-between;">
                    <!-- Utilizamos justify-content: space-between para que los elementos se distribuyan uniformemente -->
                    <h3 class="text-2xl font-bold">EDITAR COLABORADOR</h3>
                    <div style="margin-left: auto;">
                        <!-- Utilizamos margin-left: auto para colocar este div al extremo derecho -->
                        <div class="form-group text-right"> <!-- Alineación a la derecha -->
                            <div class="custom-control custom-checkbox d-inline-block"> <!-- Hacer el checkbox en línea -->
                                {!! Form::checkbox('activate_password', 'activate', false, [
                                    'class' => 'custom-control-input',
                                    'id' => 'activate_password',
                                ]) !!}
                                <label class="custom-control-label" for="activate_password">Activar contraseña</label>
                            </div>
                        </div>
                    </div>
                </div>



                <hr class="mt-2 mb-6">
                {!! Form::model($user, [
                    'route' => ['admin.colaboradores.update', $user], // Asegúrate de pasar el ID del usuario como parámetro
                    'autocomplete' => 'off',
                    'method' => 'PUT',
                ]) !!}
                @include('admin.colaboradores.partials.form')
                <div class="col-12">
                    {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('css')


@section('js')
@stop
