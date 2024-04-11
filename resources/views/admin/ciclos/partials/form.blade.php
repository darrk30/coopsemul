<div class="form-group">
    {!! Form::label('nombre', 'Nombre del Ciclo') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre del Ciclo']) !!}
    @error('nombre')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    {!! Form::label('fechaInicio', 'Fecha de Inicio') !!}
    {!! Form::date('fechaInicio', null, ['class' => 'form-control']) !!}
    @error('fechaInicio')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    {!! Form::label('fechaFin', 'Fecha de Fin') !!}
    {!! Form::date('fechaFin', null, ['class' => 'form-control']) !!}
    @error('fechaFin')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    {!! Form::label('status', 'Status') !!}
    {!! Form::select('status', [1 => 'Activo', 0 => 'Inactivo'], null, ['class' => 'form-control']) !!}
    @error('status')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    {!! Form::label('curso_id', 'Curso') !!}
    {!! Form::select('curso_id', $cursos, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un curso']) !!}
    @error('curso_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

