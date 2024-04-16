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
                <div class="row">
                    @foreach ($libros as $libro)
                        <div class="col-12 col-md-6 col-lg-3 d-flex align-items-stretch">
                            <div class="card mb-4">
                                <img src="{{ Storage::disk('s3')->url($libro->image->url) }}" class="card-img-top"
                                    alt="Imagen del libro">
                                <div class="card-body">
                                    <a href="{{ route('admin.libros.abrir-archivo', ['LibroId' => $libro->id]) }}"
                                        target="_blank">
                                        <h5 class="card-title">{{ $libro->titulo }}</h5>
                                    </a>
                                    <p class="card-text text-muted text-right" style="font-size: small;">
                                        Publicado: {{ $libro->created_at->toDateString() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination ">
                        <li class="page-item">
                            <a class="page-link" href="{{ $libros->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Anterior</span>
                            </a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">Página {{ $libros->currentPage() }} de
                                {{ $libros->lastPage() }}</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $libros->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        </li>

                    </ul>
                </nav>                
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
