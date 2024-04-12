<x-app-layout>
    @section('title', '- Nosotros')

    <!-- Banner con imagen -->
    <section class="py-32 text-center text-black bg-fixed bg-cover bg-center banner"
        style="background-image: url(https://solkem.com.ar/wp-content/uploads/solkem_BANNER_NOSOTROS-min.png)">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold mb-4 text-white">Bienvenidos a Nuestra Empresa</h1>
            <p class="text-lg text-white">Descubre más sobre nuestra historia y nuestros valores.</p>
        </div>
    </section>

    <!-- Sección de Historia de la Empresa -->
    <section class="bg-white py-20 flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">
            <!-- Contenido de la Historia de la Empresa -->
            <div class="md:w-1/2 text-center md:text-left md:pr-12">
                <h2 class="text-3xl font-bold mb-8">Nuestra Historia</h2>
                <p class="text-gray-700 leading-relaxed mx-auto max-w-2xl">Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Integer eget justo id turpis elementum ultricies nec at sem. Proin vitae nibh vel
                    odio varius rhoncus.</p>
            </div>
            <!-- Imagen de la Historia de la Empresa -->
            <div class="md:w-1/2">
                <img src="https://kinsta.com/es/wp-content/uploads/sites/8/2021/12/about-us-page-1024x512.png"
                    alt="Imagen de la Empresa" class="mx-auto rounded-lg mb-8 shadow-lg md:ml-12 img-history">
            </div>
        </div>
    </section>

    <!-- Contenedor principal con margen superior e inferior -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-8">

        <!-- Grid responsiva -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Sección de Visión -->
            <div class="border border-gray-300 p-8 vision">
                <section class="text-center">
                    <h2 class="text-2xl font-bold mb-4">Nuestra Visión</h2>
                    <p class="text-gray-700 text-justify">Ser una institución líder y referente en cuanto a capacitación
                        docente y ascenso de escala y nombramiento, reconocida por su excelencia académica, su enfoque
                        innovador en la enseñanza y el aprendizaje, y su capacidad para desarrollar docentes globales
                        críticos, éticos y comprometidos con el cambio positivo en sus comunidades y en el mundo.</p>
                </section>
            </div>

            <!-- Sección de Misión -->
            <div class="border border-gray-300 p-8 mission">
                <section class="text-center">
                    <h2 class="text-2xl font-bold mb-4">Nuestra Misión</h2>
                    <p class="text-gray-700 text-justify">Nuestra misión es proporcionar una educación integral,
                        innovadora y de alta calidad que empodere a los maestros para alcanzar su máximo potencial
                        académico, personal y social. Nos comprometemos a ofrecer un entorno de aprendizaje seguro,
                        inclusivo y estimulante que prepare a nuestros docentes para tener éxito en un mundo
                        globalizado, fomentando al mismo tiempo el respeto por la diversidad y la responsabilidad
                        social.</p>
                </section>
            </div>

            <!-- Sección de Valores -->
            <div class="border border-gray-300 p-8 values">
                <section class="text-left">
                    <h2 class="text-2xl font-bold mb-4">Nuestros Valores</h2>
                    <ul class="text-gray-700">
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 9a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm2-6a1 1 0 011 1v4a1 1 0 11-2 0V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Excelencia Académica: Compromiso con los más altos estándares de enseñanza y aprendizaje.
                        </li>
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 9a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm2-6a1 1 0 011 1v4a1 1 0 11-2 0V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Innovación: Búsqueda constante de métodos y prácticas educativas innovadoras que respondan a
                            las necesidades del siglo XXI.
                        </li>
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 9a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm2-6a1 1 0 011 1v4a1 1 0 11-2 0V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Integridad: Actuación con honestidad, transparencia y responsabilidad en todas nuestras
                            acciones.
                        </li>
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 9a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm2-6a1 1 0 011 1v4a1 1 0 11-2 0V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Sostenibilidad: Integración de prácticas sostenibles en nuestra operativa y currículo
                            educativo para contribuir a la protección del medio ambiente.
                        </li>
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 9a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm2-6a1 1 0 011 1v4a1 1 0 11-2 0V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Respeto: Fomento de un ambiente de respeto mutuo, inclusión y diversidad.
                        </li>
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 9a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm2-6a1 1 0 011 1v4a1 1 0 11-2 0V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Compromiso con la Comunidad: Promoción de la participación activa de los docentes en
                            proyectos sociales, fomentando el sentido de responsabilidad y compromiso con su entorno.
                        </li>

                        <!-- Añade más elementos de la lista aquí -->
                    </ul>
                </section>
            </div>

            <!-- Sección de Objetivos -->
            <div class="border border-gray-300 p-8 objectives">
                <section class="text-left">
                    <h2 class="text-2xl font-bold mb-4">Nuestros Objetivos</h2>
                    <ul class="text-gray-700">
                        <li class="flex items-center mb-2">
                            ■ Académicos:Mejorar continuamente la calidad y relevancia del currículo educativo para
                            cumplir y superar
                            los estándares académicos nacionales e internacionales.<br>
                            Incorporar tecnologías de información y comunicación en el proceso de enseñanza-aprendizaje
                            para enriquecer la experiencia educativa de los estudiantes.
                        </li>
                        <li class="flex items-center mb-2">
                            ■ Desarrollo Personal y Social:Fomentar el desarrollo integral de los estudiantes a través
                            de programas que promuevan el liderazgo, el trabajo en equipo, la empatía y la
                            autoeficacia.<br>
                            Implementar programas de orientación y apoyo psicológico que atiendan las necesidades
                            emocionales y sociales de los estudiantes.
                        </li>

                        <!-- Añade más elementos de la lista aquí -->
                    </ul>
                </section>
            </div>
        </div>
    </div>

    <section class="mt-24 bg-gray-700 py-12 contact">
        <h1 class="text-center text-white text-3xl">Contáctanos</h1>
        <div class="flex flex-wrap justify-center items-center gap-4 mt-10">
            <a href="https://wa.me/942407799?text=hola%20coopsemul%20quiero%20informacion%20!!"
                class="text-white text-lg hover:underline flex items-center">
                <img src="https://cdn.icon-icons.com/icons2/2992/PNG/512/whatsapp_logo_icon_187323.png" alt="WhatsApp"
                    class="w-6 h-6 mr-2">
                +51 942 407 799
                <a href="https://www.facebook.com/tuempresa" target="_blank"
                    class="text-white text-lg hover:underline flex items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/2021_Facebook_icon.svg/2048px-2021_Facebook_icon.svg.png"
                        alt="Facebook" class="w-6 h-6 mr-2">
                    Facebook
                </a>
                <a href="mailto:info@tuempresa.com" class="text-white text-lg hover:underline flex items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/281/281769.png" alt="Correo electrónico"
                        class="w-6 h-6 mr-2">
                    info@tuempresa.com
                </a>
                <a href="tel:+511234567890" class="text-white text-lg hover:underline flex items-center">
                    <img src="https://w7.pngwing.com/pngs/367/604/png-transparent-blue-icon-telephone-web-blue-phone-blue-web-blue-telephone-thumbnail.png"
                        alt="Teléfono" class="w-6 h-6 mr-2">
                    +51 1 234 567 890
                </a>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 swiper-container mySwiper">
        <h1 class="text-gray-600 text-center text-3xl mb-6">NUESTROS DOCENTES</h1>
        <div class="swiper-wrapper teachers">
            @foreach ($profesoresConPerfil as $profesor)
                <div class="swiper-slide">
                    <div class="max-w-sm rounded overflow-hidden shadow-lg">
                        @if ($profesor->profile && $profesor->profile_photo_path)
                            <img src="{{ optional($profesor)->profile_photo_path ? asset('storage/' . $profesor->profile_photo_path) : 'https://cdn-icons-png.flaticon.com/512/3135/3135768.png' }}"
                                alt="Foto de perfil"
                                class="object-cover h-64 w-full sm:h-full ">
                        @else
                            <!-- Imagen por defecto si no hay foto -->
                            <img class="mx-auto rounded-full h-32 w-32 mt-4" style="object-fit: cover;"
                                src="https://ui-avatars.com/api/?name={{ urlencode($profesor->name) }}&color=7F9CF5&background=EBF4FF"
                                alt="Imagen del profesor">
                        @endif
                        <div class="px-6 py-4">
                            <h2 class="font-bold text-xl mb-1">{{ $profesor->name }} {{ $profesor->last_name ?? '' }}
                            </h2>
                            <p class="text-gray-700 text-base text-justify">
                                {{ $profesor->profile->biografia ?? 'Este profesor no tiene un perfil configurado.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Add Pagination -->
    <div class="swiper-pagination" style="position: relative; margin-top: 10px"></div>
    <!-- Agrega botones de navegación -->
</x-app-layout>
