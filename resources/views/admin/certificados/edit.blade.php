@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')

@stop

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Crear Certificado</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::model($certificado, [
            'route' => isset($certificado) ? ['admin.certificados.update', $certificado] : 'admin.certificados.store',
            'method' => isset($certificado) ? 'PUT' : 'POST',
            'enctype' => 'multipart/form-data',
            'id' => 'form-certificado',
        ]) !!}
        @csrf

        <!-- DNI -->
        <div class="form-group">
            {!! Form::label('dni', 'DNI:') !!}
            <div class="input-group">
                <!-- Mostramos el DNI desde user->profile->DNI -->
                {!! Form::text('dni', optional($certificado->user->profile)->DNI, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el DNI del estudiante',
                    'id' => 'dni',
                    'readonly' => true, // Hacemos el campo solo lectura ya que es un dato relacionado
                ]) !!}
                <!-- El user_id se asigna al input oculto -->
                {!! Form::hidden('user_id', $certificado->user->id, ['id' => 'user_id']) !!}                
            </div>
            @error('dni')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Curso -->
        <div class="form-group">
            {!! Form::label('curso', 'Curso:') !!}
            {!! Form::text('curso', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Resolución -->
        <div class="form-group">
            {!! Form::label('resolucion', 'Resolución:') !!}
            {!! Form::text('resolucion', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Código -->
        <div class="form-group">
            {!! Form::label('codigo', 'Código:') !!}
            {!! Form::text('codigo', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Especialidad -->
        <div class="form-group">
            {!! Form::label('especialidad_id', 'Especialidad:') !!}
            {!! Form::select('especialidad_id', $especialidades->pluck('nombre', 'id'), null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione una especialidad',
                'required',
            ]) !!}
        </div>

        <!-- Archivo -->
        <div class="form-group">
            {!! Form::label('rutaArchivo', 'Archivo del Certificado:') !!}
            {!! Form::file('rutaArchivo', ['class' => 'form-control', 'accept' => '.pdf,.jpg,.png']) !!}
        </div>

        <!-- Tipo de Pago -->
        <div class="form-group">
            {!! Form::label('tipo_pago_id', 'Tipo de Pago:') !!}
            {!! Form::select('tipo_pago_id', $tiposPago->pluck('nombre', 'id'), null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione un tipo de pago',
                'required',
            ]) !!}
        </div>

        <!-- Promotor -->
        <div class="form-group">
            {!! Form::label('users_id_promotor', 'Promotor:') !!}
            {!! Form::select('users_id_promotor', $promotores->pluck('name', 'id'), null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione un promotor',
                'required',
            ]) !!}
        </div>

        <!-- Tipo de Inscripción -->
        <div class="form-group">
            {!! Form::label('tipo_inscripcion_id', 'Tipo de Inscripción:') !!}
            {!! Form::select('tipo_inscripcion_id', $tipoInscripciones->pluck('nombre', 'id'), null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione un tipo de inscripción',
                'required',
            ]) !!}
        </div>

        <!-- Empresa -->
        <div class="mb-3">
            <label for="empresas_id" class="form-label">Empresa</label>
            @if ($empresas->count() == 1)
                <!-- Si solo hay una empresa, mostramos un input con el nombre de la empresa -->
                <input type="text" class="form-control" value="{{ $empresas->first()->nombre }}" readonly>
                <input type="hidden" name="empresas_id" value="{{ old('empresas_id', $certificado->empresas_id ?? $empresas->first()->id) }}">
            @else
                <!-- Si hay varias empresas, mostramos el select normal -->
                <select name="empresas_id" id="empresas_id" class="form-control">
                    <option value="">Seleccione una empresa</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}"
                            {{ old('empresas_id', $certificado->empresas_id) == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
        

        <!-- Trabajador -->
        <div class="form-group">
            {!! Form::label('users_id_trabajador', 'Trabajador:') !!}
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
            {!! Form::hidden('users_id_trabajador', auth()->user()->id) !!}
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Certificado</button>
        <a href="{{ route('admin.certificados.index') }}" class="btn btn-secondary">Cancelar</a>

        {!! Form::close() !!}

    </div>
@stop

@section('css')

@stop

@section('js')

@stop
