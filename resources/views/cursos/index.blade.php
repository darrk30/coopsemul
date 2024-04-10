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
            <div class="swiper-slide">
                <img class="swiper-slide-pc" src="{{ asset('img/home/catalogo.png') }}" alt="Banner para PC">
                <img class="swiper-slide-mobile" src="https://stsci-opo.org/STScI-01EVT7Y3Z5FY1FJ6TGH49V9SKR.jpg"
                    alt="Banner para móvil">
            </div>
        </div>
    </div>



    @livewire('catalogo-cursos')
</x-app-layout>
