@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}"> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stop

@section('content')
<div class="swiper-banner d-none d-md-block">
    <div class="swiper-wrapper">
        <div class="swiper-slide" style="background-image: url('{{ asset('img/baners/bienvenidos.png') }}');"></div>            
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Navigation Buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
<img src="{{ asset('img/baners/baner_bienvenida_movil.png') }}" alt="" class="d-block d-md-none" style="width: 100%;">

    <section class="mt-24 bg-gray-700 py-12 mb-24">
        <div class="flex justify-center mt-5">
            <div class="card curso-card shadow" style="width: 18rem; margin: 0; background-color: #faee95;">
                <div class="card-body">
                    <h5 class="card-title mb-3"><strong>CRONOGRAMAA DE ACTIVIDADES</strong> </h5>                    
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cronogramaModal">
                        VER
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="cronogramaModal" tabindex="-1" role="dialog" aria-labelledby="cronogramaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cronogramaModalLabel">Cronograma de Actividades</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('img/baners/cronograma_actividades.png') }}" alt="Cronograma de Actividades"
                        class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@stop


@section('css')

<style>
    .curso-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .curso-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .curso-card .card-body {
        padding: 1.25rem;
    }

    .curso-card .card-text {
        margin-top: 10px;
    }

</style>
    <style>
        .swiper-banner {
            max-width: 100%;
            overflow-x: hidden;
        }

        .swiper-banner {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
            position: relative;
        }

        .swiper-banner .swiper-slide {
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            text-align: center;
        }

        .swiper-banner .swiper-slide h1 {
            font-size: 32px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 10px;
        }

        .swiper-banner .swiper-slide p {
            font-size: 18px;
            color: #fff;
            margin-bottom: 20px;
        }

        .swiper-banner .swiper-slide button {
            background-color: #3490dc;
            color: #fff;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .swiper-button-prev,
        .swiper-button-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            /* background: rgba(0, 0, 0, 0.5); */
            color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 10;
        }

        .swiper-button-prev {
            left: 10px;
        }

        .swiper-button-next {
            right: 10px;
        }
    </style>
@stop

@section('js')
    <script>
        var swiper = new Swiper('.swiper-banner', {
            loop: true,
            autoplay: {
                delay: 5000, // Cambia el valor según sea necesario (en milisegundos)
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
@stop
