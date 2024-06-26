@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="container">
        <h1 class="text-4xl text-center font-semibold">{{ $ciclo->curso->nombre }}</h1>
        <div class="d-flex justify-content-start align-items-center">
            @can('admin.ciclos.agregarSemana')
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
            @if (isset($ciclo->link_Wspp))
                <a href="{{ $ciclo->link_Wspp }}" class="btn btn-success mb-3 mr-3" target="_blank">
                    <i class="fab fa-whatsapp mr-1"></i> Grupo de Cursos
                </a>
            @endif
            {{-- carta para las clases --}}
            @if ($ciclo->curso->status != 2)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Clases en linea</h3>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-link mr-2"></i>
                                    @if ($ciclo->curso->link && $ciclo->curso->link->url)
                                        <a href="{{ $ciclo->curso->link->url }}" target="_blank"
                                            class="text-decoration-none">Ir
                                            a la clase</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mt-3">
                @foreach ($semanas as $semana)
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-body" style="cursor: pointer">
                                <h3>
                                    <span>{{ $semana->nombre }}</span>
                                    <span class="float-right">
                                        {{-- boton para crear un recurso de la semana --}}
                                        @can('admin.ciclos.crear_recurso')
                                            <!-- Botón para crear un nuevo recurso -->
                                            <button type="button" class="btn btn-secondary btn-sm ml-2" data-toggle="modal"
                                                data-target="#modalAgregarRecurso" data-semana-id="{{ $semana->id }}"
                                                data-curso-nombre="{{ $ciclo->curso->nombre }}"
                                                data-ciclo-nombre="{{ $ciclo->nombre }}" data-toggle="tooltip"
                                                data-placement="top" title="Crear Recurso">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @endcan

                                        @can('admin.ciclos.eliminar_S_R')
                                            <!-- Botón para eliminar semana -->
                                            <form
                                                action="{{ route('admin.ciclos.eliminar_S_R', ['tipo' => 'semana', 'id' => $semana->id]) }}"
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
                                                    @can('admin.ciclos.eliminar_S_R')
                                                        {{-- boton para recurso de la semana --}}
                                                        <form
                                                            action="{{ route('admin.ciclos.eliminar_S_R', ['tipo' => 'recurso', 'id' => $recurso->id]) }}"
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
                                                    <h5 class="card-title">{{ $recurso->title }}<h5><br>
                                                            @if (isset($recurso->url))
                                                                <a href="{{ $recurso->url }}">{{ $recurso->url }}</a>
                                                            @endif
                                                            @if (isset($recurso->documento) &&
                                                                    in_array(strtolower(pathinfo($recurso->documento, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']))
                                                                <img src="{{ Storage::disk('s3')->url($recurso->documento) }}"
                                                                    alt="Imagen del recurso" class="img-fluid"
                                                                    width="150px" style="margin-bottom: 5px;"><br>
                                                            @endif


                                                            <div class="text-muted"
                                                                style="position: absolute; bottom: 5px; right: 5px;">
                                                                Fecha de Creacion:
                                                                {{ $recurso->created_at->format('d/m/Y') }}
                                                            </div>
                                                            @if (isset($recurso->documento))
                                                                @can('admin.ciclos.descargar-recurso')
                                                                    {{-- boton para descargar recurso --}}
                                                                    @if ($ciclo->curso->status != 2)
                                                                        <form
                                                                            action="{{ route('admin.ciclos.descargar-recurso', ['recursoId' => $recurso->id]) }}"
                                                                            method="POST"
                                                                            style="display: inline; margin-left: 10px;">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="btn btn-primary btn-sm mb-1"
                                                                                data-toggle="tooltip" data-placement="top"
                                                                                title="Descargar Recurso">
                                                                                {{ Str::limit($recurso->nombre, 20) }}
<i
                                                                                    class="fas fa-download ml-2"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                    {{-- Botón para ver el archivo directamente en el navegador --}}
                                                                    @if ($recurso->documento)
                                                                        <a href="{{ route('admin.ciclos.abrir-archivo', ['recursoId' => $recurso->id]) }}"
                                                                            target="_blank" class="btn btn-info btn-sm">
                                                                            Ver Archivo <i class="fas fa-eye"></i> 
                                                                        </a>
                                                                    @endif
                                                                @endcan
                                                            @endif
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
        </div>
    </section>



    @can('admin.ciclos.agregarSemana')
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
                    <form action="{{ route('admin.ciclos.agregarSemana') }}" method="POST">
                        @csrf
                        <!-- Campo oculto para el ID del ciclo -->
                        <input type="hidden" name="ciclo_id" value="{{ $ciclo->id }}">

                        <!-- Campo para el nombre de la semana -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre">Nombre de la semana</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripcion de la semana</label>
                                <input type="text" name="descripcion" class="form-control" required>
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


    @can('admin.ciclos.crear_recurso')
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
            var curso_nombre = button.data('curso-nombre');
            var ciclo_nombre = button.data('ciclo-nombre');
            $.ajax({
                url: "{{ route('admin.ciclos.formulario') }}",
                type: "GET",
                data: {
                    semana_id: semana_id,
                    curso_nombre: curso_nombre,
                    ciclo_nombre: ciclo_nombre,
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
