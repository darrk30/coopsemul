@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <x-breadcrumb-curso :curso="$curso">
    </x-breadcrumb-curso>
@stop

@section('content')
    <div class="container mb-3">
        <div class="d-flex justify-content-start align-items-center">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAgregarContenido">
                <i class="fas fa-plus-circle mr-1"></i>
                <span class="tooltip-text">Agregar Contenido</span>
            </button>
        </div>
    </div>

    <div class="contenido container">
        @foreach ($curso->contenidos as $contenido)
            <div class="card contenido_card">
                <div class="card-body">
                    <strong>Contenido: </strong> <span
                        class="span_titulo_{{ $contenido->id }}">{{ $contenido->titulo }}</span>
                    <span class="float-right">
                        <button type="button" class="btn btn-secondary btn-sm ml-2" data-toggle="modal"
                            data-target="#modalAgregarLeccion" data-contenido-id="{{ $contenido->id }}"
                            data-toggle="tooltip" data-placement="top" title="Crear Leccion">
                            <i class="fas fa-plus"></i>
                        </button>

                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modalEditarContenido" data-contenido-id="{{ $contenido->id }}"
                            data-toggle="tooltip" data-placement="top" title="Editar Contenido">
                            <i class="fas fa-edit"></i>
                        </button>


                        <form action="{{ route('admin.contenidos.destroy', $contenido) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                onclick="confirmarEliminar(event)" title="Eliminar Contenido">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </span>
                </div>
                <div class="card-footer lession_card" id="lession_card_{{ $contenido->id }}" style="display: none;"> {{-- Agregamos un id único usando el id del contenido --}}
                    @foreach ($contenido->lesions as $lesion)
                        <div class="card lession_card">
                            <div class="card-body">
                                <strong>Leccion: </strong><span
                                    class="span_nombre_{{ $lesion->id }}">{{ $lesion->nombre }}</span>
                                <span class="float-right">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#modalEditarLeccion" data-leccion-id="{{ $lesion->id }}"
                                        data-toggle="tooltip" data-placement="top" title="Editar Leccion">
                                        <i class="fas fa-edit"></i>
                                    </button>


                                    <form action="{{ route('admin.lecciones.destroy', $lesion->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                            onclick="confirmarEliminar(event)" data-placement="top"
                                            title="Eliminar Lección">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAgregarContenido" tabindex="-1" aria-labelledby="modalAgregarContenidoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarContenidoLabel">Agregar Contenido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAgregarContenido">
                    @csrf
                    <!-- Campo oculto para el ID del curso -->
                    <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                    <!-- Campo para el nombre de la semana -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Titulo de Contenido</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <!-- Otros campos del formulario si es necesario -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agregar Contenido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Edición de Contenido -->
    <div class="modal fade" id="modalEditarContenido" tabindex="-1" aria-labelledby="modalEditarContenidoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Contenido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditarContenido">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="contenido_id_edit" name="contenido_id">
                        <div class="form-group">
                            <label for="titulo_contenido_edit">Nuevo Título del Contenido</label>
                            <input type="text" id="titulo_contenido_edit" name="titulo" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAgregarLeccion" tabindex="-1" aria-labelledby="modalAgregarLeccionLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Nueva Leccion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAgregarLeccion">
                    @csrf
                    <!-- Campo oculto para el ID del curso -->
                    <input type="hidden" name="contenido_id" id="contenido_id"
                        value="{{ $curso->contenidos->first()->id }}">

                    <!-- Campo para el nombre de la semana -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Leccion</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <!-- Otros campos del formulario si es necesario -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agregar Leccion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarLeccion" tabindex="-1" aria-labelledby="modalEditarLeccionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Leccion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditarLeccion">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="leccion_id_edit" name="leccion_id">
                        <div class="form-group">
                            <label for="nombre_leccion_edit">Nuevo Nombre de la Lección</label>
                            <input type="text" id="nombre_leccion_edit" name="nombre" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@section('js')
    <script>
        //agregar nuevo contenido
        $(document).ready(function() {
            $('#formAgregarContenido').submit(function(e) {
                e.preventDefault(); // Evita que el formulario se envíe normalmente

                // Envía los datos del formulario mediante AJAX
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.contenidos.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Actualiza la vista con el contenido recién agregado
                        var nuevoContenido =
                            '<div class="card contenido_card"><div class="card-body"><strong>Contenido: </strong> <span class="span_titulo_' +
                            response.id + '">' +
                            response.titulo +
                            '</span><span class="float-right">' +
                            '<button type="button" class="btn btn-secondary btn-sm ml-2" data-toggle="modal" ' +
                            'data-target="#modalAgregarLeccion" data-contenido-id="' + response
                            .id +
                            '" data-toggle="tooltip" data-placement="top" title="Crear Leccion">' +
                            '<i class="fas fa-plus"></i>' +
                            '</button>' +
                            '<button type="button" class="btn btn-primary btn-sm ml-1" data-toggle="modal" ' +
                            'data-target="#modalEditarContenido" data-contenido-id="' + response
                            .id +
                            '" data-toggle="tooltip" data-placement="top" title="Editar Contenido">' +
                            '<i class="fas fa-edit"></i>' +
                            '</button>' +
                            '<form action="{{ route('admin.contenidos.destroy', $contenido->id) }}" method="POST" ' +
                            'style="display: inline;">' +
                            '@csrf' +
                            '@method('DELETE')' +
                            '<button type="submit" class="btn btn-danger btn-sm ml-1" onclick="confirmarEliminar(event)" ' +
                            'data-toggle="tooltip" data-placement="top" title="Eliminar Contenido">' +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</form>' +
                            '</span>' +
                            '</div>' +
                            '<div class="card-footer lession_card" id="lession_card_' + response
                            .id + '"></div></div>';

                        $('.contenido').append(nuevoContenido);

                        // Limpia el formulario y cierra el modal
                        $('#formAgregarContenido')[0].reset();
                        $('#modalAgregarContenido').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        //agregar nueva leccion
        $(document).ready(function() {
            $('#formAgregarLeccion').submit(function(e) {
                e.preventDefault(); // Evita que el formulario se envíe normalmente

                // Envía los datos del formulario mediante AJAX
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.lecciones.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Actualiza la vista con la lección recién agregada
                        var nuevaLeccion =
                            '<div class="card"><div class="card-body"><strong>Leccion: </strong> <span class="span_nombre_' +
                            response.id + '">' +
                            response.nombre +
                            '</span><span class="float-right">' +
                            '<button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" ' +
                            'data-target="#modalEditarLeccion" data-contenido-id="' + response
                            .contenido_id +
                            '" data-toggle="tooltip" data-placement="top" title="Editar Leccion">' +
                            '<i class="fas fa-edit"></i>' +
                            '</button>' +
                            '<form action="{{ route('admin.lecciones.destroy', $lesion->id) }}" method="POST" ' +
                            'style="display: inline;">' +
                            '@csrf' +
                            '@method('DELETE')' +
                            '<button type="submit" class="btn btn-danger btn-sm" onclick="confirmarEliminar(event)" ' +
                            'data-toggle="tooltip" data-placement="top" title="Eliminar Leccion">' +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</form>' +
                            '</span>' +
                            '</div></div>';

                        $('#lession_card_' + response.contenido_id).append(nuevaLeccion);

                        // Limpia el formulario y cierra el modal
                        $('#formAgregarLeccion')[0].reset();
                        $('#modalAgregarLeccion').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        //Agrega el id del contenido en el modal de leccion
        $('#modalAgregarLeccion').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var contenidoId = button.data(
                'contenido-id'); // Extrae el valor del atributo data-contenido-id del botón
            $('#contenido_id').val(contenidoId); // Asigna el valor al input hidden
        });
    </script>

    <script>
        //actualizar contenido
        $(document).ready(function() {
            // Envía los datos del formulario de edición de contenido mediante AJAX
            $('#formEditarContenido').submit(function(e) {
                e.preventDefault(); // Evita que el formulario se envíe normalmente

                // Envía los datos del formulario mediante AJAX
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.contenidos.modificar') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Actualiza la vista con la lección recién agregada
                        var ContenidoActualizado = response.titulo;

                        $('.span_titulo_' + response.id).text(response.titulo);

                        // Limpia el formulario y cierra el modal
                        $('#formEditarContenido')[0].reset();
                        $('#modalEditarContenido').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // Agrega el ID del contenido en el modal de edición de contenido
            $('#modalEditarContenido').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que activó el modal
                var contenidoId = button.data('contenido-id'); // ID del contenido
                var tituloContenido = button.closest('.contenido_card').find('.card-body span:first').text()
                    .replace('Contenido: ', ''); // Título del contenido
                $('#contenido_id_edit').val(contenidoId); // Asigna el ID del contenido al campo oculto
                $('#titulo_contenido_edit').val(
                    tituloContenido); // Asigna el título del contenido al campo de entrada
            });
        });

        //actualizar contenido
        $(document).ready(function() {
            // Envía los datos del formulario de edición de contenido mediante AJAX
            $('#formEditarLeccion').submit(function(e) {
                e.preventDefault(); // Evita que el formulario se envíe normalmente

                // Envía los datos del formulario mediante AJAX
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.lecciones.modificar') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Actualiza la vista con la lección recién agregada
                        var LeccionActualizada = response.nombre;

                        $('.span_nombre_' + response.id).text(response.nombre);

                        // Limpia el formulario y cierra el modal
                        $('#formEditarLeccion')[0].reset();
                        $('#modalEditarLeccion').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // Agrega el ID del contenido en el modal de edición de contenido
            // Agrega el ID de la lección en el modal de edición de lección
            $('#modalEditarLeccion').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que activó el modal
                var leccionId = button.data('leccion-id'); // ID de la lección
                var nombreleccion = button.closest('.lession_card').find('.card-body span:first').text()
                    .replace('Leccion: ', ''); // Título de la lección
                $('#leccion_id_edit').val(leccionId); // Asigna el ID de la lección al campo oculto
                $('#nombre_leccion_edit').val(
                    nombreleccion); // Asigna el título de la lección al campo de entrada
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

<script>
    $(document).ready(function() {
        $('.card-body').click(function(event) {               
            if (!$(event.target).is('button')) {
                $(this).siblings('.card-footer').slideToggle();
            }
        });
    });
</script>
@stop
