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
    @php $totalPermisos = count($permisos); @endphp
    @php $permisosPorColumna = ceil($totalPermisos / 4); @endphp

    @foreach ($permisos as $permiso)
    <div class="col-md-3">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="permiso_{{ $permiso->id }}" name="permisos[]"
                value="{{ $permiso->id }}">
            <label class="custom-control-label"
                for="permiso_{{ $permiso->id }}">{{ $permiso->descripcion }}</label>
        </div>
    </div>
@endforeach
    
</div>
