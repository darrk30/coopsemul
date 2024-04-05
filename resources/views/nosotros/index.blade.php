<x-app-layout>

    <!-- Banner con imagen -->
    <section class="py-32 text-center text-black bg-fixed bg-cover bg-center"
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
                    alt="Imagen de la Empresa" class="mx-auto rounded-lg mb-8 shadow-lg md:ml-12" style="width: 400px;">
            </div>
        </div>
    </section>



    <!-- Contenedor principal con margen superior e inferior -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-8">

        <!-- Grid responsiva -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Sección de Visión -->
            <div class="border border-gray-300 p-8">
                <section class="text-center">
                    <h2 class="text-2xl font-bold mb-4">Nuestra Visión</h2>
                    <p class="text-gray-700 text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Integer eget justo id turpis elementum ultricies nec at sem.</p>
                </section>
            </div>

            <!-- Sección de Misión -->
            <div class="border border-gray-300 p-8">
                <section class="text-center">
                    <h2 class="text-2xl font-bold mb-4">Nuestra Misión</h2>
                    <p class="text-gray-700 text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Integer eget justo id turpis elementum ultricies nec at sem.</p>
                </section>
            </div>

            <!-- Sección de Valores -->
            <div class="border border-gray-300 p-8">
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
                            Calidad
                        </li>
                        <!-- Añade más elementos de la lista aquí -->
                    </ul>
                </section>
            </div>

            <!-- Sección de Objetivos -->
            <div class="border border-gray-300 p-8">
                <section class="text-left">
                    <h2 class="text-2xl font-bold mb-4">Nuestros Objetivos</h2>
                    <ul class="text-gray-700">
                        <li class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 9a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm2-6a1 1 0 011 1v4a1 1 0 11-2 0V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Satisfacción del Cliente
                        </li>
                        <!-- Añade más elementos de la lista aquí -->
                    </ul>
                </section>
            </div>
        </div>
    </div>

    <section class="mt-24 bg-gray-700 py-12">
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



    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 swiper-container mySwiper" style="margin-bottom:3rem">
        <h1 class="text-gray-600 text-center text-3xl mb-6">NUESTROS DOCENTES</h1>
        <div class="swiper-wrapper">
            @foreach ($profesoresConPerfil as $profesor)
                <div class="swiper-slide">
                    <div class="max-w-sm rounded overflow-hidden shadow-lg">
                        @if ($profesor->profile)
                            <img class="mx-auto" style="width: 200px"
                                src="{{ Storage::url($profesor->profile->image->url ?? '') }}"
                                alt="Imagen del profesor">
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">{{ $profesor->name }}</div>
                                <p class="text-gray-700 text-base">
                                    {{ $profesor->profile->descripcion }}
                                </p>
                            </div>
                        @else
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">{{ $profesor->name }}</div>
                                <p class="text-gray-700 text-base">
                                    Este profesor no tiene un perfil configurado.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach




        </div>
    </div>

    <!-- Add Pagination -->
    <div class="swiper-pagination" style="position: relative; margin-top: 10px"></div>
    <!-- Agrega botones de navegación -->
    </div>

</x-app-layout>
