@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <h1>Bienvenido a Coopsemul</h1>
     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
     {{-- <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}"> --}}
 
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
 
     <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stop

@section('content')
   
    <div class="swiper-banner">
        <div class="swiper-wrapper">
            <div class="swiper-slide "
                style="background-image: url('https://kinsta.com/es/wp-content/uploads/sites/8/2021/07/performance-testing-tools-1024x512.png')">
                <h1>ESTE ES EL TITULO</h1>
                <p>ESTE ES UN SUBTITULO</p>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Contactenos</a>
            </div>
            <div class="swiper-slide"
                style="background-image: url('https://kinsta.com/es/wp-content/uploads/sites/8/2021/07/performance-testing-tools-1024x512.png')">
                <h1>ESTE ES EL TITULO</h1>
                <p>ESTE ES UN SUBTITULO</p>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Contactenos</a>
            </div>
            <div class="swiper-slide"
                style="background-image: url('https://kinsta.com/es/wp-content/uploads/sites/8/2021/07/performance-testing-tools-1024x512.png')">
                <h1>ESTE ES EL TITULO</h1>
                <p>ESTE ES UN SUBTITULO</p>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Contactenos</a>
            </div>
            <!-- Agrega más slides según sea necesario -->
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation Buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
@stop

@section('css')
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
