<x-app-layout>
    @section('title', '')
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
                <img class="swiper-slide-pc" src="{{ asset('img/baners/PORTADA_1_PC.jpg') }}" alt="Capacitación docente">
                <img class="swiper-slide-mobile" src="{{ asset('img/baners/PORTADA_2_MOVIL.jpg') }}"
                    alt="Banner para móvil">
            </div>          
            <div class="swiper-slide">
                <img class="swiper-slide-pc" src="{{ asset('img/baners/baner_03.png') }}" alt="Capacitación docente">
                {{-- <img class="swiper-slide-mobile" src="{{ asset('img/baners/PORTADA_2_MOVIL.jpg') }}"
                    alt="Banner para móvil"> --}}
            </div>

            <!-- Agrega más slides según sea necesario -->
        </div>
        <!-- Controles de navegación -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <section class="mt-24">
        <h1 class="text-gray-600 text-center text-3xl mb-6">NUESTROS SERVICIOS</h1>
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8">
            <!-- Diplomados -->
            <article class="service-card">
                <figure class="flex-grow">
                    <img class="rounded-xl h-full w-full object-cover" src="{{ asset('img/baners/DIPLOMADOS.jpg') }}"
                        alt="Diplomados">
                </figure>
                <header class="mt-2">
                    <h2 class="text-center text-xl text-gray-700">Diplomados</h2>
                    <p class="text-sm text-gray-500">Accede a una amplia gama de recursos educativos desde la comodidad
                        de tu hogar. Explora, descubre y aprende en cualquier momento y lugar.</p>
                </header>
            </article>
            <!-- Aprende desde Casa -->
            <article class="service-card">
                <figure class="flex-grow">
                    <img class="rounded-xl h-full w-full object-cover" src="{{ asset('img/home/clases_online.png') }}"
                        alt="Aprende desde Casa">
                </figure>
                <header class="mt-2">
                    <h2 class="text-center text-xl text-gray-700">Aprende desde Casa</h2>
                    <p class="text-sm text-gray-500">Únete a nuestras clases interactivas y dinámicas impartidas por
                        expertos en diversas áreas. Aprende a tu ritmo y según tu horario.</p>
                </header>
            </article>
            <!-- Capacitaciones Especializadas -->
            <article class="service-card">
                <figure class="flex-grow">
                    <img class="rounded-xl h-full w-full object-cover" src="{{ asset('img/home/capacitaciones.png') }}"
                        alt="Capacitaciones Especializadas">
                </figure>
                <header class="mt-2">
                    <h2 class="text-center text-xl text-gray-700">Capacitaciones Especializadas</h2>
                    <p class="text-sm text-gray-500">Adquiere nuevas habilidades y conocimientos para destacar en tu
                        carrera profesional con nuestros programas de capacitación especializados.</p>
                </header>
            </article>
            <!-- Conéctate y Colabora -->
            <article class="service-card">
                <figure class="flex-grow">
                    <img class="rounded-xl h-full w-full object-cover" src="{{ asset('img/home/grupo_wspp.png') }}"
                        alt="Conéctate y Colabora">
                </figure>
                <header class="mt-2">
                    <h2 class="text-center text-xl text-gray-700">Conéctate y Colabora</h2>
                    <p class="text-sm text-gray-500">Únete a nuestro grupo de WhatsApp para interactuar con otros
                        estudiantes, hacer preguntas y compartir recursos educativos. ¡Aprende en comunidad!</p>
                </header>
            </article>
        </div>
    </section>


    <section class="mt-24 bg-gray-700 py-12">
        <h1 class="text-center text-white text-3xl">¿ESTÁS BUSCANDO TU ESTABILIDAD LABORAL Y UNA MEJOR REMUNERACIÓN
            MENSUAL?</h1>
        <p class="text-center text-white mt-2">Dirígete a nuestro catálogo de cursos</p>
        <div class="flex justify-center mt-5">
            <a href="{{ route('curso.index') }}"
                class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nuestro
                Catálogo</a>
        </div>

    </section>


    <section class="mt-24 mb-5">
        <h1 class="text-center text-3xl text-gray-700 mb-6">NUESTROS CURSOS</h1>
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8">
            @foreach ($cursos as $curso)
                <article class="bg-white shadow-white rounded overflow-hidden">
                    @if (isset($curso->image->url))
                        <img src="{{ Storage::disk('s3')->url($curso->image->url) }}" alt="Imagen del Curso"
                            class="lg:block md:hidden block rounded-lg shadow-lg" style="width: 400px; height: 300px;">
                    @else
                        <!-- Aquí puedes poner una imagen predeterminada o dejarlo en blanco según prefieras -->
                        <img src="https://www.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600nw-1037719192.jpg" alt="Imagen predeterminada del Curso"
                            class="lg:block md:hidden block rounded-lg shadow-lg" style="width: 400px; height: 300px;">
                    @endif

                    <div class="px-5 py-4">
                        <div class="mb-2 h-14">
                            <h1 class="text-base text-gray-700 mb-2 leading-6">
                                {{ Str::limit($curso->nombre, 50, '...') }}</h1>
                        </div>

                        <div class="mb-2">
                            @if (isset($curso->user->name))
                            <p class="text-gray-500 text-sm">Prof: {{ $curso->user->name }} {{ $curso->user->profile->apellidos }}</p>
                            @endif
                        </div>
                        <div class="mb-2">
                            <p class="text-gray-500 text-sm">Fecha de Publicación:
                                {{ $curso->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="mb-2">
                            <strong class="text-gray-700 text-base">Precio: S/ {{ $curso->precio->value }}</strong>
                        </div>
                        <div>
                            <a href="{{ route('curso.show', $curso) }}"
                                class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                Más Información
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>


    <section class="mt-24 mb-24 bg-gray-700 py-12">
        <h1 class="text-center text-white text-3xl">Únete a nuestros grupos gratuitos</h1>
        <p class="text-center text-white mt-2">Compartimos material de mucho interés para ti. Ingresa de manera gratuita
            dándole click al enlace de abajo o desde aquí.</p>
        <div class="flex justify-center mt-5 space-x-4">
            <!-- Botón de Facebook -->
            <a href="#"
                class="bg-white flex items-center justify-center rounded-full h-12 w-12 hover:bg-gray-200">
                <img src="https://w7.pngwing.com/pngs/561/460/png-transparent-fb-facebook-facebook-logo-social-media-icon.png"
                    alt="Facebook" class="rounded-full" loading="lazy">
            </a>
            <!-- Botón de WhatsApp -->
            <a href="#"
                class="bg-white flex items-center justify-center rounded-full h-12 w-12 hover:bg-gray-200">
                <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" alt="WhatsApp" class="rounded-full"
                    loading="lazy">
            </a>
            <!-- Botón de Instagram -->
            <a href="#"
                class="bg-white flex items-center justify-center rounded-full h-12 w-12 hover:bg-gray-200">
                <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="Instagram" class="rounded-full"
                    loading="lazy">
            </a>
        </div>
    </section>




    <script>
        var swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>


</x-app-layout>
