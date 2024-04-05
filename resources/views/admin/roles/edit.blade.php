@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Rol</h1>
@stop

@section('content')
@if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
    <div class="card">
        <div class="card-body">
            {!! Form::model($role, ['route' => ['admin.roles.update', $role], 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Nombre') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Nombre del Rol']) !!}
                @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>
            <b>Lista de Permisos</b>
            <div class="row mb-4 mt-3">
                @foreach ($permisos as $permiso)
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="permiso_{{ $permiso->id }}" name="permisos[]" value="{{ $permiso->id }}"
                                @if ($role->permissions->contains($permiso))
                                    checked
                                @endif
                            >
                            <label class="custom-control-label" for="permiso_{{ $permiso->id }}">{{ $permiso->description }}</label>
                        </div>
                    </div>
                @endforeach
            </div>           
            {!! Form::submit('Actualizar Rol', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop
