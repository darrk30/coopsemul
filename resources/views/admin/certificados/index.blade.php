@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')

@stop

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Lista de Certificados</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.certificados.create') }}" class="btn btn-primary mb-3">Crear Certificado</a>

        @if ($certificados->count() > 0)
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>DNI USUARIO</th>
                        <th>Curso</th>
                        <th>Resolución</th>
                        <th>Código</th>
                        <th>Empresa</th>
                        <th>Promotor</th>
                        <th>Trabajador</th>
                        <th>Certificado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificados as $certificado)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $certificado->user->profile->DNI }}</td>
                            <td>{{ $certificado->curso }}</td>
                            <td>{{ $certificado->resolucion }}</td>
                            <td>{{ $certificado->codigo }}</td>
                            <td>{{ $certificado->empresa->nombre ?? 'Sin empresa' }}</td>
                            <td>{{ $certificado->promotor->name ?? 'Sin promotor' }}</td>
                            <td>{{ $certificado->trabajador->name ?? 'Sin trabajador' }}</td>
                            <td>                                
                                <form action="{{ route('admin.certificado.descargar-recurso', ['recursoId' => $certificado->id]) }}"
                                    method="POST" style="display: inline; margin-left: 10px;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm mb-1" data-toggle="tooltip"
                                        data-placement="top" title="Descargar Recurso">
                                        DESCARGAR
                                        <i class="fas fa-download ml-2"></i>
                                    </button>
                                </form>
                            </td>

                            <td>
                                @can('admin.certificados.edit')
                                <a href="{{ route('admin.certificados.edit', ['certificado' => $certificado->id]) }}"
                                    class="btn btn-warning btn-sm mb-1"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Editar Certificado">
                                     Editar
                                     <i class="fas fa-edit ml-2"></i>
                                 </a>
                                @endcan                                                           
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{-- {{ $certificados->links() }} <!-- Paginación --> --}}
            </div>
        @else
            <p>No hay certificados disponibles.</p>
        @endif
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
