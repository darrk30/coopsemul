@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="container">
        <h1 class="text-4xl text-center font-semibold">{{ $curso->nombre }}</h1>
        <div class="d-flex justify-content-start align-items-center">
            @can('admin.cursos.store')
                {{-- boton para crear una seccion de semana --}}
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAgregarSemana">
                    <span class="tooltip-text">Agregar Semana</span>
                    <i class="fas fa-plus-circle mr-1"></i>
                </button>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <section>
        <div class="container">
            <a href="Wsp.com" class="btn btn-success mb-3 mr-3" target="_blank">
                <i class="fab fa-whatsapp mr-1"></i> Grupo de Cursos
            </a>
            {{-- carta para las clases --}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Clases en linea</h3>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-link mr-2"></i>
                                {{-- <a href="{{ $curso->link->url }}" target="_blank" class="text-decoration-none">Ir a la
                                    clase</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                @foreach ($semanas as $semana)                    
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h3>
                                    <span>{{ $semana->nombre }}</span>
                                    <span class="float-right">
                                        {{-- boton para crear un recurso de la semana --}}
                                        @can('admin.cursos.crear_recurso')
                                            <!-- Botón para crear un nuevo recurso -->
                                            <button type="button" class="btn btn-secondary btn-sm ml-2" data-toggle="modal"
                                                data-target="#modalAgregarRecurso" data-semana-id="{{ $semana->id }}"
                                                data-toggle="tooltip" data-placement="top" title="Crear Recurso">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @endcan

                                        @can('admin.cursos.eliminar_S_R')
                                            <!-- Botón para eliminar semana -->
                                            <form
                                                action="{{ route('admin.cursos.eliminar_S_R', ['tipo' => 'semana', 'id' => $semana->id]) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="confirmarEliminar(event)" data-toggle="tooltip"
                                                    data-placement="top" title="Eliminar Semana">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </span>
                                </h3>
                                <p>{{ $semana->descripcion }}</p>
                            </div>
                            <div class="card-footer" style="display: none;">
                                <div class="row">
                                    @foreach ($semana->recursos as $recurso)
                                        <div class="col-md-12">                                        
                                            <div class="card mb-3">
                                                <div class="card-body" style="position: relative;">
                                                    @can('admin.cursos.eliminar_S_R')
                                                        {{-- boton para recurso de la semana --}}
                                                        <form
                                                            action="{{ route('admin.cursos.eliminar_S_R', ['tipo' => 'recurso', 'id' => $recurso->id]) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="confirmarEliminar(event)" data-toggle="tooltip"
                                                                data-placement="top" title="Eliminar Recurso"
                                                                style="position: absolute; top: 5px; right: 5px;">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    <h5 class="card-title">{{ $recurso->title }}</h5>
                                                    @if (Str::startsWith($recurso->documento, 'public/documentos'))
                                                        @php
                                                            // Obtener la extensión del archivo
                                                            $extension = pathinfo(
                                                                $recurso->documento,
                                                                PATHINFO_EXTENSION,
                                                            );
                                                            // Lista de extensiones de imagen válidas
                                                            $extensionesImagen = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                                                        @endphp
                                                        @if (in_array(strtolower($extension), $extensionesImagen))
                                                            {{-- El archivo es una imagen --}}
                                                            <img src="{{ Storage::url($recurso->documento) }}"
                                                                alt="Imagen" class="img-fluid" width="150px">
                                                        @endif
                                                    @endif
                                                    <div class="text-muted"
                                                        style="position: absolute; bottom: 5px; right: 5px;">
                                                        Fecha de Creacion: {{ $recurso->created_at->format('d/m/Y') }}
                                                    </div>
                                                    @can('admin.cursos.descargar_recurso')
                                                        {{-- boton para descargar recurso --}}
                                                        <form
                                                            action="{{ route('admin.cursos.descargar_recurso', ['recursoId' => $recurso->id]) }}"
                                                            method="POST" style="display: inline; margin-left: 10px;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary btn-sm "
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Descargar Recurso">
                                                                {{ $recurso->nombre }}<i class="fas fa-download ml-2"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


    </section>



    @can('admin.cursos.store')
        {{-- modal para crear seccion de semana --}}
        <div class="modal fade" id="modalAgregarSemana" tabindex="-1" aria-labelledby="modalAgregarSemanaLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarSemanaLabel">Agregar Semana</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.cursos.store') }}" method="POST">
                        @csrf
                        <!-- Campo oculto para el ID del curso -->
                        <input type="hidden" name="curso_id" value="{{ $curso->id }}">

                        <!-- Campo para el nombre de la semana -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre">Nombre de la semana</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripcion de la semana</label>
                                <input type="text" name="descripcion" class="form-control">
                            </div>
                            <!-- Otros campos del formulario si es necesario -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Agregar Semana</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan


    @can('admin.cursos.crear_recurso')
        <!-- Modal para crear un nuevo recurso -->
        <div class="modal fade" id="modalAgregarRecurso" tabindex="-1" aria-labelledby="modalAgregarRecursoLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Nuevo Recurso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalBodyAgregarRecurso">
                        <!-- Aquí se cargará el contenido del formulario -->
                    </div>
                </div>
            </div>
        </div>
    @endcan






@stop

@section('js')
    <script>
        // Función para cargar el formulario dentro del modal cuando se abre
        $('#modalAgregarRecurso').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            var semana_id = button.data('semana-id'); 
            $.ajax({
                url: "{{ route('admin.cursos.formulario') }}",
                type: "GET",
                data: {
                    semana_id: semana_id 
                },
                success: function(response) {
                    $('#modalBodyAgregarRecurso').html(
                        response); 
                },
                error: function(xhr) {
                    console.error('Error al cargar el formulario:', xhr.responseText);
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.card-body').click(function(event) {               
                if (!$(event.target).is('button')) {
                    $(this).siblings('.card-footer').slideToggle();
                }
            });
        });
    </script>


    <script>
        // funcion para confirmar la eliminacion
        function confirmarEliminar(event) {           
            event.preventDefault();
            if (confirm('¿Estás seguro de que deseas eliminar este elemento?')) {
                // Si el usuario confirma, enviar el formulario
                event.target.closest('form').submit();
            }
        }
    </script>









@stop
