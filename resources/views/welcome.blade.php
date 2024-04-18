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







    {{-- <div class="container mx-auto text-gray-600 text-center mb-6 px-4">
        <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden mx-auto max-w-4xl">
            <div class="md:w-1/3">
                <img src="{{ asset('img/baners/GERENTE.jpg') }}" alt="Promotor General Percy Chingo Coronel"
                    class="object-cover w-full h-full">
            </div>
            <div class="w-full md:w-2/3 p-4">
                <h1 class="text-3xl font-bold text-gray-800">Promotor General Percy Chingo Coronel: Fundador de Coopsemul
                    "Los que más saben"</h1>
                <p class="mt-2 text-gray-600 text-justify text-xl">
                    Percy Chingo Coronel, reconocido como uno de los pilares en la fundación de Coopsemul "Los que más
                    saben", es una figura esencial en el campo de la educación profesional para docentes en la región.
                    Su trayectoria como educador y líder ha sido fundamental para el desarrollo y expansión de esta
                    institución educativa dedicada a la capacitación de profesores.
    
                    Desde sus inicios, Percy Chingo Coronel visionó a Coopsemul como un espacio innovador donde los
                    docentes podrían no solo prepararse para exámenes de nombramiento y ascenso, sino también
                    desarrollar habilidades pedagógicas que respondieran a las demandas del sistema educativo moderno.
                    Su enfoque siempre ha estado en crear un entorno de aprendizaje que promueva el desarrollo integral
                    del profesorado, equipándolos con herramientas pedagógicas y tecnológicas de vanguardia.
    
                    El Promotor General también ha sido clave en la formación de alianzas estratégicas con instituciones
                    educativas y organizaciones gubernamentales, lo que ha ampliado el alcance y el impacto de Coopsemul
                    "Los que más saben". Estas colaboraciones han permitido a la institución mantener su relevancia y
                    asegurar que su currículo esté siempre alineado con los cambios y las necesidades del sector
                    educativo.
                </p>
            </div>
        </div>
    </div> --}}





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
                    <h2 class="text-xl font-bold text-gray-800">Promotor General Percy Chingo Coronel</h2>
                    <p class="mt-2 text-gray-600 text-sm text-justify">
                        Percy Chingo Coronel es un destacado educador y líder fundador de Coopsemul "Los que más saben", una institución clave en la capacitación profesional de docentes. Desde el inicio, visionó este espacio como un centro de innovación pedagógica, preparando a los docentes para exámenes de nombramiento y ascenso, y fomentando el desarrollo de habilidades modernas. Su liderazgo ha sido crucial en la creación de alianzas estratégicas con otras instituciones y organismos gubernamentales, expandiendo el alcance y la influencia de Coopsemul en el sector educativo.
                    </p>
                </div>
            </div>
            <!-- Segunda tarjeta -->
            <div class="max-w-sm rounded overflow-hidden shadow-lg mx-auto">
                <img src="{{ asset('img/baners/promotor.png') }}" alt="Promotor General Percy Chingo Coronel"
                    class="w-full object-cover object-center">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-800">Director General de Proyectos Académicos</h2>
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





    <script>
        var swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

</x-app-layout>
