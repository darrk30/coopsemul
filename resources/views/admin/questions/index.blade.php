@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')


    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

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

    <div class="container-form container">
        @if ($userExam)
            <div class="card text-center my-4">
                <div class="card-header text-white" style="background: #6200ff">
                    <h4 class="mb-0">Puntaje Total Obtenido</h4>
                </div>
                <div class="card-body">
                    <h1 class="display-4 text-success">{{ $userExam->detalleExamen->puntaje }}</h1>
                </div>
                <div class="card-footer text-muted">
                    ¡Felicidades por completar el examen!
                </div>
            </div>
            <div class="container-header" style="font-family: 'Montserrat', sans-serif;">
                <div class="question-container mx-auto mb-4 rounded-2xl shadow-md" style="border-top: 5px solid #6200ff;">
                    <h4 class="text-center text-2xl font-bold mb-2">{{ $exam->titulo }}</h4>
                </div>
            </div>

            @foreach ($userExam->resultado_examens as $item)
                @php
                    $puntajeObtenido = 0;
                    $selectedOptionId = $item->option->id ?? null;
                    if ($selectedOptionId) {
                        $selectedOption = $item->question->options->where('id', $selectedOptionId)->first();
                        if ($selectedOption && $selectedOption->correct_option == 1) {
                            $puntajeObtenido = $item->question->puntaje;
                        }
                    }
                @endphp
                <div class="card">
                    <div class="card-header">
                        <span class="score-badge text-white py-1 px-3 rounded-full text-sm" style="background: #8337ff;">
                            {{ floor($puntajeObtenido) }} puntos obtenidos
                        </span>
                        {!! $item->question->pregunta !!}
                    </div>
                    <div class="card-body">
                        <!-- Mostrar las opciones -->
                        @php
                            $selectedOptionId = $item->option->id ?? null;
                        @endphp
                        @foreach ($item->question->options as $option)
                            @php
                                $isSelected = $option->id == $selectedOptionId;
                                $isCorrect = $option->correct_option == 1;
                            @endphp
                            <p class="option-text {{ $isSelected ? ($isCorrect ? 'correct' : 'incorrect') : '' }}">
                                {{ $option->option }}
                            </p>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        @foreach ($item->question->options as $option)
                            @if ($option->correct_option == 1)
                                <p><strong>Opción Correcta:</strong> {{ $option->option }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <form action="{{ route('admin.detalleExamen.store') }}" method="POST" id="submit-form">
                @csrf
                @if (!$userExam)
                    <x-reloj :tiempo="$exam->tiempo"></x-reloj>
                @endif
                <div class="container-header" style="font-family: 'Montserrat', sans-serif;">
                    <div class="question-container mx-auto mb-4 rounded-2xl shadow-md"
                        style="border-top: 5px solid #6200ff;">
                        <h4 class="text-center text-2xl font-bold mb-2">{{ $exam->titulo }}</h4>
                    </div>
                </div>
                <input type="hidden" name="tiempoConsumido" id="tiempoConsumido">

                <div class="container-body">

                    @if ($questions->count() > 0)
                        <input type="hidden" name="examId" value="{{ $exam->id }}">
                        @foreach ($questions as $index => $question)
                            <div class="question-container p-4 border rounded-2xl shadow-md"
                                id="question-{{ $question->id }}">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="" style="margin-top: -10px">
                                        @can('admin.questions.destroy')
                                            <button type="button" class="iconbutton btn btn-sm btn-danger" title="Eliminar"
                                                onclick="confirmarEliminar({{ $question->id }})">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endcan
                                        <!-- Botón de editar -->
                                        @can('admin.questions.edit')
                                            <a href="{{ route('admin.questions.edit', $question) }}"
                                                class="iconbutton btn btn-sm btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                    </div>

                                    <span class="score-badge text-white py-1 px-3 rounded-full text-sm"
                                        style="background: #8337ff;">
                                        {{ floor($question->puntaje) }} puntos
                                    </span>
                                </div>
                                <p class="mb-4 text-lg font-semibold" style="margin-top: -15px">{!! $question->pregunta !!}</p>

                                <!-- Campo oculto para el ID de la pregunta usando el índice -->
                                <input type="hidden" name="questions[{{ $index }}][id]"
                                    value="{{ $question->id }}">

                                <div class="mt-4 space-y-4">
                                    @foreach ($question->options as $option)
                                        <div class="flex items-center justify-between p-1 border rounded bg-gray-50 hover:bg-gray-100 mb-2"
                                            onclick="document.getElementById('option-{{ $option->id }}').click();">
                                            <input type="radio" id="option-{{ $option->id }}"
                                                name="questions[{{ $index }}][selected_option]"
                                                value="{{ $option->id }}" class="mr-2">
                                            <label for="option-{{ $option->id }}" class="text-sm flex-1"
                                                style="margin-top: 3px;">
                                                {{ $option->option }}
                                            </label>

                                            @isset($option->image->url)
                                                <br>
                                                <img src="{{ Storage::disk('s3')->url($option->image->url) }}"
                                                    alt="Imagen de opción" class="fixed-size-img" width="150px">
                                            @endisset
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @can('admin.detalleExamen.store')
                            <div class="mb-4">
                                <button type="button" class="btn btn-purpure" onclick="enviarExamen()"
                                    id="finish-exam">FINALIZAR
                                    EXAMEN</button>
                            </div>
                        @endcan
                    @else
                        <div class="col-12">
                            <p class="mt-2 text-center font-weight-bold text-gray" style="font-style: italic;">AUN NO HAY
                                PREGUNTAS
                                PLANTEADAS</p>
                        </div>
                    @endif

                </div>
                @can('admin.questions.create')
                    <div class="card container">
                        <div class="card-body">
                            <a href="{{ route('admin.examenes.index') }}" class="btn btn-outline-secondary ">VOLVER</a>
                            <a href="{{ route('admin.questions.create', $exam->id) }}"
                                class="btn btn-outline-primary">AGREGAR
                                PREGUNTA</a>
                        </div>
                    </div>
                @endcan
            </form>
        @endif
    </div>
@stop

@section('css')
    <style>
        .option-text {
            border: 0.5px solid #9e9e9e;
            border-radius: 5px;
            padding: 5px;
            margin: 5px 0;
        }

        .option-text.correct {
            border: 2px solid #4CAF50;
            background-color: #e8f5e9;
        }

        .option-text.incorrect {
            border: 2px solid #F44336;
            background-color: #ffebee;
        }
    </style>


    <style>
        .btn-purpure {
            background-color: #8337ff;
            color: white;
            border: none;
        }

        .btn-purpure:hover {
            background-color: #5a21b6;
            color: white;
        }

        .question-container {
            position: relative;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            margin-bottom: 1rem;
            border: solid 1px #ddd;
        }

        .score-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #8b8b8b;
            padding: 0.5rem;
            font-size: small;
            border-bottom-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        input[type="radio"] {
            vertical-align: middle;
            margin-top: -2px;
            /* Ajusta según sea necesario */
        }

        label {
            vertical-align: middle;
        }

        .iconbutton {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            padding: 0;
            font-size: 14px;
            text-align: center;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @can('admin.questions.destroy')
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
                        $.ajax({
                            url: "{{ route('admin.questions.destroy', '') }}/" + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Eliminar el elemento de la interfaz
                                    Swal.fire(
                                        'Eliminado!',
                                        'La pregunta ha sido eliminada.',
                                        'success'
                                    );
                                    $('#question-' + id).remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'No se pudo eliminar la pregunta.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                console.error('Error al eliminar la pregunta:', xhr.responseText);
                                Swal.fire(
                                    'Error!',
                                    'Ocurrió un error al eliminar la pregunta.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>
    @endcan
    @can('admin.detalleExamen.store')
        @if (!$userExam)
            <script>
                let finish = false;
                function enviarExamen() {
                    Swal.fire({
                        title: 'Se finalizara el examen. ¿Desea continuar?',
                        text: "No podrás revertir esto después.",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, enviar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let finish = true;
                            // Si el usuario confirma, enviar el formulario de eliminación
                            document.getElementById('submit-form').submit();
                        }
                    });
                }
            </script>
        @endif
    @endcan
    @if (!$userExam)
        <script>
            const tiempoElement = document.querySelector('.tiempo');
            const toggleButton = document.getElementById('toggleButton');
            const alertaSound = document.getElementById('alertaSound');
            const tiempoConsumidoInput = document.getElementById('tiempoConsumido');
            document.querySelector('.tiempo-container').classList.add('show');
            const userRole = @json($userRole); // Usa la variable pasada desde el controlador

            if (userRole === 'Estudiante') {
                let tiempoInicial = parseInt(tiempoElement.textContent) * 60;
                let tiempoConsumido = 0; // Tiempo consumido en segundos

                function actualizarTiempo() {
                    if (tiempoInicial > 0) {
                        tiempoConsumido += 1;
                        tiempoInicial -= 1;
                        const minutos = Math.floor(tiempoInicial / 60);
                        const segundos = tiempoInicial % 60;
                        const minutosConsumidos = Math.floor(tiempoConsumido / 60);
                        const segundosConsumidos = tiempoConsumido % 60;
                        tiempoElement.textContent = `${minutos}:${segundos < 10 ? '0' : ''}${segundos}`;

                        // Actualiza el campo del formulario con el tiempo consumido en segundos
                        tiempoConsumidoInput.value = tiempoConsumido;

                        if (tiempoInicial <= 600) {
                            document.querySelector('.tiempo-container').classList.add('show');
                            toggleButton.classList.add('disabled');
                            toggleButton.disabled = true;

                            if (!alertaSound.played.length) {
                                alertaSound.play();
                            }
                        }
                    } else {
                        clearInterval(intervalo);
                        tiempoElement.textContent = '0:00';
                        // También actualiza el campo del formulario cuando el tiempo se agote
                        tiempoConsumidoInput.value = tiempoConsumido;

                        // Enviar el formulario automáticamente cuando el tiempo se acabe
                        document.getElementById('submit-form').submit();
                    }
                }

                const intervalo = setInterval(actualizarTiempo, 1000);

                function toggleTime() {
                    if (!toggleButton.classList.contains('disabled')) {
                        const tiempoContainer = document.querySelector('.tiempo-container');
                        tiempoContainer.classList.toggle('show');
                    }
                }
                if(finish === false){
                    // ALERTA DE ACTUALIZAR PAGINA O ABANDONO DE PAGINA
                    window.addEventListener('beforeunload', function(event) {
                        // Mostramos una alerta cuando el usuario intente salir                    
                        event.returnValue =
                            'Si sales de esta página, se perderá tu progreso del examen. ¿Estás seguro que deseas continuar?';
                    });                
                }

            } else {
                console.log('Usuario no autorizado para ver el temporizador.');
            }
        </script>
    @endif


@stop
