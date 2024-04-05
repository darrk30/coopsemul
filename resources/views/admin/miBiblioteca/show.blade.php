@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="mt-1">

    </div>
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Categoría: {{ $nombreCategoria }}</h3>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @foreach ($libros as $libro)
                    <div class="swiper-slide">
                        <div class="card" style="width: 12rem;">
                            <img src="{{ Storage::disk('s3')->url($libro->image->url) }}" class="card-img-top"
                                alt="Imagen del libro" style="height: auto;">
                            <hr style="padding: 0; margin: 0;">
                            <div class="mx-3 my-2">
                                <a href="{{ route('admin.libros.abrir-archivo', ['LibroId' => $libro->id]) }}"
                                    target="_blank">
                                    <h5 class="card-title">{{ $libro->titulo }}</h5>
                                </a>
                            </div>
                            <p class="card-text mx-2 text-right" style="font-size: small; color: grey;">
                                Publicado: {{ $libro->created_at->toDateString() }}</p>
                        </div>
                        <div class="swiper-slide">
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <style>
         .swiper-slide {
            width: auto !important;
            margin: 0 5px;
            /* Ajustamos el margen derecho */
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


        .card-title {
            color: #3f729b;
            /* Texto azul */
        }

        .card-text {
            color: #666666;
            /* Texto gris oscuro */
        }
    </style>
@stop

@section('js')

@stop
