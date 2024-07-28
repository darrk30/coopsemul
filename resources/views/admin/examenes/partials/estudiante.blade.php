<div class="container2">    
    <div class="chart-container">
        <canvas id="resultsChart" width="400" height="200"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="timeChart" width="400" height="200"></canvas>
    </div>
</div>

@php
    $tiempoEnSegundos = $userExamen->detalleExamen->tiempoConsumido;
    $minutos = intdiv($tiempoEnSegundos, 60);
    $segundos = $tiempoEnSegundos % 60;
    $tiempoEnMinutos = round($tiempoEnSegundos / 60, 2); // Convertir a minutos con dos decimales
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de resultados del examen
        var ctxResults = document.getElementById('resultsChart').getContext('2d');
        var resultsChart = new Chart(ctxResults, {
            type: 'bar',
            data: {
                labels: ['Correctas', 'Incorrectas', 'En Blanco'],
                datasets: [{
                    label: 'Resultados del Examen',
                    data: [
                        {{ $userExamen->detalleExamen->preguntasCorrectas }},
                        {{ $userExamen->detalleExamen->preguntasIncorrectas }},
                        {{ $userExamen->detalleExamen->preguntasEnBlanco }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Esto hace que las barras sean horizontales
                scales: {
                    x: {
                        beginAtZero: true,
                        //max: {{ $exam->questions()->count() }}, // Establece el límite del gráfico
                        max:25,
                        
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });


        var ctxTime = document.getElementById('timeChart').getContext('2d');
        var timeChart = new Chart(ctxTime, {
            type: 'bar',
            data: {
                labels: ['Tiempo'],
                datasets: [{
                    label: 'Tiempo Consumido (min.seg)',
                    data: [
                        // {{ $userExamen->detalleExamen->tiempoConsumido }}
                        {{ $tiempoEnMinutos }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Esto hace que las barras sean horizontales
                scales: {
                    x: {
                        beginAtZero: true,
                        max: {{ $exam->tiempo }}, // Establece el límite del gráfico para el tiempo
                        ticks: {
                            stepSize: 10 // Define los incrementos de 10 en 10
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

       
    });
</script>

<style>
    .container2 {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .chart-container {
        flex: 1 1 100%;
        display: flex;
        justify-content: center;
        margin: 10px;
    }
    #resultsChart {
        max-width: 100%;
        height: auto;
    }
    #timeChart {
        max-width: 100%;
        height: auto;
    }
    @media (min-width: 768px) {
        .chart-container {
            flex: 1 1 45%;
        }
        #resultsChart {
            max-width: 400px;
        }
        #timeChart {
            max-width: 400px;
        }
    }
</style>