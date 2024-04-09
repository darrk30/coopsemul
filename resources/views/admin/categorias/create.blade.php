@extends('adminlte::page')
@section('title', 'Coopsemul | Crear Precio')

@section('content_header')
    <div class="mt-1">
        
    </div>
@stop

@section('content')
    <div class="card container">
        <div class="card-header">
            <h3>Crear Categoria</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Crear</button>
            </form>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
