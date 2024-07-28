@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="container">
        @if (session('info'))
            <div id="alerta" class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ session('info') }}</strong>
            </div>
        @endif

        @if (session('error'))
            <div id="alerta" class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ session('error') }}</strong>
            </div>
        @endif

    </div>
@stop

@section('content')
    <div class="card container">
        @can('admin.examenes.create')
            <div class="card-header">
                <a href="{{ route('admin.examenes.create') }}" class="btn btn-primary btn-sm">Nuevo Examen</a>
            </div>
        @endcan
        <div class="card-body">
            <div class="row">
                @if ($examenes->count() > 0)
                    @foreach ($examenes as $examen)
                        <div class="col-12 col-sm-6 col-md-3 mb-4">
                            <div class="card shadow card-examen">
                                <div style="position: relative;">
                                    <img src="{{ isset($examen->image->url) ? Storage::disk('s3')->url($examen->image->url) : 'https://www.deperu.com/diccionario/imagenes/palabra-examen.jpg' }}"
                                        alt="Curso" class="fixed-size-img">
                                    <span class="badge badge-{{ $examen->status == 1 ? 'success' : 'warning' }} badge-lg"
                                        style="position: absolute; top: 5px; left: 5px; font-size: 1rem;">
                                        {{ $examen->status == 1 ? 'Publicado' : 'No Publicado' }}
                                    </span>
                                </div>

                                <div class="card-body">
                                    <div
                                        style="height: auto; display: flex; flex-direction: column; align-items: flex-start;">
                                        <h2 class="card-title text-lg font-semibold text-gray-800 mb-2">
                                            @if ($examen->status == 1 && $examen->questions->isEmpty())
                                                @if (auth()->user()->hasRole('Estudiante'))
                                                    <span
                                                        style="text-decoration: underline; color: #8a8a8a; cursor: pointer;">{{ $examen->titulo }}</span>
                                                    <i class="fas fa-exclamation-triangle ml-2"
                                                        style="color: #FF3D3D; text-shadow: 1px 1px 2px rgba(255, 65, 65, 0.5); cursor: pointer;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        onclick="mostrarMensaje(event)"></i>
                                                @else
                                                    <a
                                                        href="{{ route('admin.questions.index', $examen) }}">{{ $examen->titulo }}</a>
                                                    @if ($examen->questions->isEmpty())
                                                        <i class="fas fa-exclamation-triangle ml-2"
                                                            style="color: #FF3D3D; text-shadow: 1px 1px 2px rgba(255, 65, 65, 0.5); cursor: pointer;"
                                                            data-toggle="tooltip" data-placement="top"
                                                            onclick="mostrarMensaje(event)"></i>
                                                    @endif
                                                @endif
                                            @elseif ($examen->status == 1 && $examen->questions->isNotEmpty())
                                                <a
                                                    href="{{ route('admin.questions.index', $examen) }}">{{ $examen->titulo }}</a>
                                            @elseif ($examen->status == 0 && $examen->questions->isEmpty())
                                                @if (auth()->user()->hasRole(['Administrador', 'Profesor']))
                                                    <a
                                                        href="{{ route('admin.questions.index', $examen) }}">{{ $examen->titulo }}</a>
                                                    <i class="fas fa-exclamation-triangle ml-2"
                                                        style="color: #FF3D3D; text-shadow: 1px 1px 2px rgba(255, 65, 65, 0.5); cursor: pointer;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        onclick="mostrarMensaje(event)"></i>
                                                @else
                                                    <span
                                                        style="text-decoration: underline; color: #8a8a8a; cursor: pointer;">{{ $examen->titulo }}</span>
                                                    <i class="fas fa-exclamation-triangle ml-2"
                                                        style="color: #FF3D3D; text-shadow: 1px 1px 2px rgba(255, 65, 65, 0.5); cursor: pointer;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        onclick="mostrarMensaje(event)"></i>
                                                @endif
                                            @elseif ($examen->status == 0 && $examen->questions->isNotEmpty())
                                                <a
                                                    href="{{ route('admin.questions.index', $examen) }}">{{ $examen->titulo }}</a>
                                            @endif

                                        </h2>
                                        <span class="badge badge-secondary badge-lg">
                                            {{ $examen->tiempo }} Minutos
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer"
                                    style="font-style: italic; background-color: #f0f0f0; border-top: 1px solid #bebebe; padding: 10px; color:#757575;">
                                    <div>
                                        Fecha de publicación: {{ $examen->fecha }}
                                    </div>
                                    @can('admin.examenes.show')
                                        {{--  Verifica permisos para mostrar el botón de ver  --}}
                                        @if (auth()->user()->hasRole(['Administrador', 'Profesor']) ||
                                                (auth()->user()->hasRole('Estudiante') &&
                                                    $examen->userExamen->isNotEmpty() &&
                                                    $examen->userExamen->contains('exam_id', $examen->id) &&
                                                    $examen->userExamen->contains('user_id', auth()->user()->id)))
                                            @php $showButton = true; @endphp
                                        @else
                                            @php $showButton = false; @endphp
                                        @endif
                                    @else
                                        @php $showButton = false; @endphp
                                    @endcan

                                    @can('admin.examenes.edit')
                                        {{-- Verifica permisos para mostrar el botón de editar --}}
                                        @php $editButton = true; @endphp
                                    @else
                                        @php $editButton = false; @endphp
                                    @endcan

                                    @can('admin.examenes.destroy')
                                        {{-- Verifica permisos para mostrar el botón de eliminar --}}
                                        @php $destroyButton = true; @endphp
                                    @else
                                        @php $destroyButton = false; @endphp
                                    @endcan

                                    @if ($showButton || $editButton || $destroyButton)
                                        <div class="btn-group mt-2">
                                            @if ($showButton)
                                                <a href="{{ route('admin.examenes.show', $examen) }}"
                                                    class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                            @endif

                                            @if ($editButton)
                                                <a href="{{ route('admin.examenes.edit', $examen) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            @if ($destroyButton)
                                                <form action="{{ route('admin.examenes.destroy', $examen) }}"
                                                    method="POST" id="eliminar-form-{{ $examen->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger btn-custom"
                                                        onclick="confirmarEliminar({{ $examen->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <p class="mt-2 text-center font-weight-bold text-gray" style="font-style: italic;">AUN NO HAY
                            EXAMENES ELAVORADOS</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-footer">
            <ul class="pagination justify-content-center">
                @if ($examenes->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo; Anterior</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $examenes->previousPageUrl() }}">&laquo;
                            Anterior</a></li>
                @endif

                <li class="page-item active">
                    <span class="page-link">{{ $examenes->currentPage() }}</span>
                </li>

                @if ($examenes->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $examenes->nextPageUrl() }}">Siguiente &raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Siguiente &raquo;</span></li>
                @endif
            </ul>
        </div>



    </div>

@stop


@section('css')
    <style>
        .card-examen {
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .card-examen:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }


        .fixed-size-img {
            width: 100%;
            height: 200px;
            /* Puedes ajustar la altura según tus necesidades */
            object-fit: cover;
            /* Esto asegurará que la imagen se recorte para llenar el espacio, manteniendo su proporción */
        }

        .btn-custom {
            border-radius: 0 0.2rem 0.2rem 0;
        }
    </style>

@stop

@section('js')
    @can('admin.examenes.destroy')
        <!-- Incluir SweetAlert desde CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script>
            function confirmarEliminar(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto después.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, enviar el formulario de eliminación
                        document.getElementById('eliminar-form-' + id).submit();
                    }
                });
            }
        </script>
    @endcan
    <script>
        function mostrarMensaje(event) {
            // Mostrar un popover o mensaje como una "nube" alrededor del ícono
            var icon = event.target;
            var popover = new bootstrap.Popover(icon, {
                content: 'Faltan preguntas',
                placement: 'top',
                trigger: 'focus',

            });

            // Mostrar el popover
            popover.show();

            // Ocultar el popover después de 3 segundos (opcional)
            setTimeout(function() {
                popover.hide();
            }, 3000); // 3000 milisegundos = 3 segundos
        }
    </script>


@stop
