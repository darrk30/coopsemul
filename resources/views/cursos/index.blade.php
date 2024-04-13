<x-app-layout>
    @section('title', '- Cursos')
    <style>
        .swiper-container {
            width: 100%;
            height: auto;
        }

        .swiper-slide img {
            width: 100%;
            height: auto;
        }

        .swiper-slide .swiper-slide-mobile {
            display: none;
        }

        @media screen and (max-width: 765px) {
            .swiper-slide-pc {
                display: none;
            }

            .swiper-slide-mobile {
                display: block;
                width: 100%;
                height: auto;
            }

            .swiper-slide .swiper-slide-mobile {
                display: block;
            }

            .swiper-slide .swiper-slide-pc {
                display: none;
            }
        }
    </style>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" >
                <img class="swiper-slide-pc" src="{{ asset('img/baners/catalogoCursos.png') }}" alt="Banner para PC" width="100%">
                <img class="swiper-slide-mobile" src="{{ asset('img/baners/catalogoCursos.png') }}"
                    alt="Banner para móvil">
            </div>
        </div>
    </div>



    @livewire('catalogo-cursos')
</x-app-layout>
