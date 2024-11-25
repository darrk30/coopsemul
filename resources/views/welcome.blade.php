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
        <div class="swiper-wrapper " id="simple-slider">
            <div class="swiper-slide">
                <img class="swiper-slide-pc" src="{{ asset('img/baners/PORTADA_1_PC.jpg') }}" alt="Capacitación docente">
                <img class="swiper-slide-mobile" src="{{ asset('img/baners/PORTADA_2_MOVIL.jpg') }}"
                    alt="Banner para móvil">
            </div>
            <div class="swiper-slide">
                <img class="swiper-slide-pc" src="{{ asset('img/baners/banerPc.jpg') }}" alt="Capacitación docente">
                <img class="swiper-slide-mobile" src="{{ asset('img/baners/banerMovil.jpg') }}" alt="Banner para móvil">
            </div>
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
                    <img class="rounded-xl h-full w-full object-cover" src="{{ asset('img/home/diplomados.png') }}"
                        alt="Diplomados" style="height: 200px;">
                </figure>
                <header class="mt-2">
                    <h2 class="text-center text-xl text-gray-700">Diplomados</h2>
                    <p class="text-sm text-gray-500 text-justify">Accede a una amplia gama de recursos educativos desde
                        la comodidad
                        de tu hogar. Explora, descubre y aprende en cualquier momento y lugar.</p>
                </header>
            </article>
            <!-- Aprende desde Casa -->
            <article class="service-card">
                <figure class="flex-grow">
                    <img class="rounded-xl h-full w-full object-cover"
                        src="{{ asset('img/home/aprendodesdecasa.jpg') }}" alt="Aprende desde Casa"
                        style="height: 200px;">
                </figure>
                <header class="mt-2">
                    <h2 class="text-center text-xl text-gray-700">Aprende desde Casa</h2>
                    <p class="text-sm text-gray-500 text-justify">Únete a nuestras clases interactivas y dinámicas
                        impartidas por
                        expertos en diversas áreas. Aprende a tu ritmo y según tu horario.</p>
                </header>
            </article>
            <!-- Capacitaciones Especializadas -->
            <article class="service-card">
                <figure class="flex-grow">
                    <img class="rounded-xl h-full w-full object-cover" src="{{ asset('img/home/capacitacion.jpg') }}"
                        alt="Capacitaciones Especializadas" style="height: 200px;">
                </figure>
                <header class="mt-2">
                    <h2 class="text-center text-xl text-gray-700">Capacitaciones Especializadas</h2>
                    <p class="text-sm text-gray-500 text-justify">Adquiere nuevas habilidades y conocimientos para
                        destacar en tu
                        carrera profesional con nuestros programas de capacitación especializados.</p>
                </header>
            </article>
            <!-- Conéctate y Colabora -->
            <article class="service-card">
                <figure class="flex-grow">
                    <img class="rounded-xl h-full w-full object-cover" src="{{ asset('img/home/grupoWspp.jpg') }}"
                        alt="Conéctate y Colabora" style="height: 200px;">
                </figure>
                <header class="mt-2">
                    <h2 class="text-center text-xl text-gray-700">Conéctate y Colabora</h2>
                    <p class="text-sm text-gray-500 text-justify">Únete a nuestro grupo de WhatsApp para interactuar con
                        otros
                        estudiantes, hacer preguntas y compartir recursos educativos. ¡Aprende en comunidad!</p>
                </header>
            </article>
        </div>
    </section>


    <section class="mt-24 bg-gray-700 py-12 mb-24">
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
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-x-6 gap-y-8">
            @foreach ($cursos as $curso)
                <article class="bg-white shadow-lg rounded overflow-hidden">
                    @if (isset($curso->image->url))
                        <img src="{{ Storage::disk('s3')->url($curso->image->url) }}" alt="Imagen del Curso"
                            class="w-full h-48 object-cover rounded-t-lg"> <!-- Adjusted line -->
                    @else
                        <img src="https://www.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600nw-1037719192.jpg"
                            alt="Imagen predeterminada del Curso" class="w-full h-48 object-cover rounded-t-lg">
                        <!-- Adjusted line -->
                    @endif

                    <div class="px-5 py-4">
                        <div class="mb-2 h-14">
                            <h1 class="text-base text-gray-700 mb-2 leading-6">
                                {{ Str::limit($curso->nombre, 50, '...') }}</h1>
                        </div>

                        <div class="mb-2">
                            @if (isset($curso->user->name) && isset($curso->user->profile->apellidos))
                                <p class="text-gray-500 text-sm">Prof: {{ $curso->user->name }}
                                    {{ $curso->user->profile->apellidos }}</p>
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
        <p class="text-center text-white mt-2">Compartimos material de mucho interés para ti. Ingresa de manera
            gratuita
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
        </div>
    </section>

    <div class="container mx-auto px-4 py-6 mt-24">
        <h1 class="text-center text-gray-700 text-3xl  mb-5">REPRESENTANTES</h1>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2  gap-x-6 gap-y-8">
            <!-- Primera tarjeta -->
            <div class="max-w-sm rounded overflow-hidden shadow-lg mx-auto">
                <img src="{{ asset('img/baners/GERENTE.jpg') }}" alt="Promotor General Percy Chingo Coronel"
                    class="w-full object-cover object-center">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-800 text-center">Promotor General</h2>
                    <p class="mt-2 text-gray-600 text-sm text-justify">
                        Percy Chingo Coronel es un destacado educador y líder fundador de Coopsemul "Los que más saben",
                        una institución clave en la capacitación profesional de docentes. Desde el inicio, visionó este
                        espacio como un centro de innovación pedagógica, preparando a los docentes para exámenes de
                        nombramiento y ascenso, y fomentando el desarrollo de habilidades modernas. Su liderazgo ha sido
                        crucial en la creación de alianzas estratégicas con otras instituciones y organismos
                        gubernamentales, expandiendo el alcance y la influencia de Coopsemul en el sector educativo.
                    </p>
                </div>
            </div>
            <!-- Segunda tarjeta -->
            <div class="max-w-sm rounded overflow-hidden shadow-lg mx-auto">
                <img src="{{ asset('img/baners/promotor.png') }}" alt="Promotor General Percy Chingo Coronel"
                    class="w-full object-cover object-center">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-800 text-center">Director General de Proyectos Académicos
                    </h2>
                    <p class="mt-2 text-gray-600 text-sm text-justify">
                        Ram J. Ruiz Molina es un reconocido docente en el área de Comunicación y experto en Comprensión
                        Lectora, con poco más de 24 años en la docencia preuniversitaria y una trayectoria reconocida a
                        nivel regional y nacional. Profesor Principal en el curso de Habilidad Verbal de las mejores
                        Academias Preuniversitarias del norte del país. Capacitador Docente de las más reconocidas e
                        importantes Empresas Educativas a Nivel de todo el Perú. Autor de diversas publicaciones como:
                        "Análisis y Compresión de Textos", "Ortografía Básica de la Lengua", "Comprensión Lectora:
                        Textos Discontinuos", "Comunicación: teoría y práctica", "Resúmenes de Lujo en la
                        Literatura Peruana"
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 mt-24 mb-24">
        <h1 class="text-center text-gray-700 text-3xl  mb-5">LOS MEJORES CAPACITADORES A NIVEL NACIONAL REUNIDOS PARA LOGRAR TU ASCENSO DE ESCALA</h1>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            <!-- Imagen 1 -->
            <img src="{{ asset('img/docentes/comunicacion.jpg') }}" alt="comunicacion" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 2 -->
            <img src="{{ asset('img/docentes/comunicacion2.jpg') }}" alt="comunicacion" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 3 -->
            <img src="{{ asset('img/docentes/cyt.jpg') }}" alt="ciencia y tecnología" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 4 -->
            <img src="{{ asset('img/docentes/ept.jpg') }}" alt="EPT" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 5 -->
            <img src="{{ asset('img/docentes/inicial.jpg') }}" alt="INICIAL" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 6 -->
            <img src="{{ asset('img/docentes/primaria.jpg') }}" alt="PRIMARIA" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 7 -->
            <img src="{{ asset('img/docentes/matematica.jpg') }}" alt="matematica" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 8 -->
            <img src="{{ asset('img/docentes/arteycultura.jpg') }}" alt="arte y cultura" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 8 -->
            <img src="{{ asset('img/docentes/cienciaytecnologia.jpg') }}" alt="ciencia y tecnologia" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
            <!-- Imagen 8 -->
            <img src="{{ asset('img/docentes/educacionfisica.jpg') }}" alt="eduacion fisica" class="cursor-pointer rounded transition-transform transform hover:scale-105 hover:shadow-lg"
                onclick="openModal(this.src)">
        </div>
    </div>



    <!-- Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden">
        <span class="absolute top-5 right-5 text-white text-3xl cursor-pointer" onclick="closeModal()">×</span>
        <img id="modalImage" src="" class="max-w-full max-h-full rounded">
    </div>

    <script>
        function openModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>
    {{-- <section class="mt-24 bg-gray-700 py-12 mb-24">
        <h1 class="text-center text-white text-3xl">Rumbo al Ascenso y Nombramiento Docente 2024-2025 (BLOQUE 1)</h1>       
        <div class="flex justify-center mt-5">
            <img src="{{ asset('img/home/horarioBloque1.jpg') }}" alt="Horario Bloque 1" width="700px">
        </div>

    </section> --}}


    <script>
        var swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

</x-app-layout>
