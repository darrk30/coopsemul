<div class="row">
    @if ($userExamenes->count() > 0)
        @foreach ($userExamenes as $userExamen)
            @php
                $tiempoEnSegundos = $userExamen->detalleExamen->tiempoConsumido;
                $minutos = intdiv($tiempoEnSegundos, 60);
                $segundos = $tiempoEnSegundos % 60;
                $tiempoEnMinutos = round($tiempoEnSegundos / 60, 2); // Convertir a minutos con dos decimales
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <img src="{{ $userExamen->user->profile_photo_url }}" alt="Imagen del Estudiante"
                                class="rounded-circle img-fluid" style="width: 80px; height: 80px;">
                        </div>
                        <div>
                            <h5 class="card-title mb-3 text-muted font-italic " style="font-size: 1.1rem">
                                {{ $userExamen->user->name }}
                                @if ($userExamen->user->profile && $userExamen->user->profile->apellidos)
                                    {{ ' ' . $userExamen->user->profile->apellidos }}
                                @endif
                            </h5>
                            <p class="card-text mb-1 text-muted font-italic">Puntaje:
                                {{ $userExamen->detalleExamen->puntaje }}</p>
                            <p class="card-text mb-1 text-muted font-italic">Correctas:
                                {{ $userExamen->detalleExamen->preguntasCorrectas }}</p>
                            <p class="card-text mb-1 text-muted font-italic">En Blanco:
                                {{ $userExamen->detalleExamen->preguntasEnBlanco }}</p>
                            <p class="card-text mb-1 text-muted font-italic">Incorrectas:
                                {{ $userExamen->detalleExamen->preguntasIncorrectas }}</p>
                            <p class="card-text mb-0 text-muted font-italic">Tiempo:
                                {{ $tiempoEnMinutos }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <p class="mt-2 text-center font-weight-bold text-gray" style="font-style: italic;">AUN NO HAY RESULTADOS DE
                LOS
                ESTUDIANTES</p>
        </div>
    @endif
</div>
