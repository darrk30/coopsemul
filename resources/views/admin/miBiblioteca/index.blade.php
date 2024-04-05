@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="mt-1">

    </div>

@stop

@section('content')

    <div class="container">

        @foreach ($categorias as $categoria)
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>{{ $categoria->nombre }}</h4>
                    <a href="{{ route('admin.miBiblioteca.show', $categoria) }}" class="btn btn-warning ml-auto btn-sm">Ver
                        Más</a>
                </div>
                <div class="card-body">
                    <div class="container-slider" id="beneficios">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper mx-5">
                                @foreach ($libros->where('category_id', $categoria->id) as $libro)
                                    <div class="swiper-slide">
                                        <div class="card" style="width: 12rem;">
                                            <img src="{{ Storage::disk('s3')->url($libro->image->url) }}"
                                                class="card-img-top" alt="Imagen del libro"
                                                style="height: auto; max-width: 100%;">
                                            <hr style="padding: 0; margin: 0;">
                                            <div class="m-2">
                                                <a href="{{ route('admin.libros.abrir-archivo', ['LibroId' => $libro->id]) }}"
                                                    target="_blank">
                                                    <h5 class="card-title">{{ $libro->titulo }}</h5>
                                                </a>
                                            </div>
                                            <p class="card-text mx-2 text-right" style="font-size: small; color: grey;">
                                                Publicado: {{ $libro->created_at->toDateString() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <style>
        .container-slider {
            position: relative;
            overflow: hidden;
        }

        .swiper-slide {
            width: auto !important;
            margin: 0 5px;
            /* Ajustamos el margen derecho */
        }

        .swiper-button-prev,
        .swiper-button-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
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

        .card-header {
            background-color: #3f729b;
            /* Fondo azul */
            color: #fff;
            /* Texto blanco */
        }

        .card-body {
            background-color: #fff;
            /* Fondo blanco */
            border-radius: 10px;
            /* Bordes redondeados */
            background-color: #f2f2f2;
        }

        .swiper-button-prev,
        .swiper-button-next {
            background-color: #3f729b;
            /* Fondo azul */
            color: #fff;
            /* Texto blanco */
        }

        .swiper-button-prev:hover,
        .swiper-button-next:hover {
            background-color: #255580;
            /* Cambia el color al pasar el mouse */
        }

        .card-title {
            color: #3f729b;
            /* Texto azul */
        }

        .card-text {
            color: #666666;
            /* Texto gris oscuro */
        }

        .swiper-slide {
            background-color: #f9f9f9;
            /* Fondo gris claro */
            border-radius: 10px;
            /* Bordes redondeados */
            margin: 0 5px;
            /* Ajustamos el margen derecho */
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        var swipers = document.querySelectorAll('.mySwiper');
        swipers.forEach(function(swiper) {
            new Swiper(swiper, {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                slidesPerView: 1,
                spaceBetween: 10,

                breakpoints: {
                    620: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    680: {
                        slidesPerView: 2,
                        spaceBetween: 40,
                    },
                    920: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                    1240: {
                        slidesPerView: 4,
                        spaceBetween: 50,
                    },
                }
            });
        });
    </script>
@stop
