<x-app-layout>
    @section('title', '- Noticias')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="swiper-banner mt-10 rounded-xl">
            <div class="swiper-wrapper">
                <div class="swiper-slide " style="background-image: url({{asset('img/baners/noticiaNombramiento.jpg')}})"></div>
                {{-- <div class="swiper-slide" style="background-image: url({{ asset('img/home/baner_home.png') }})"></div> --}}
                <div class="swiper-slide" style="background-image: url({{asset('img/baners/Noticacomunicado.jpeg')}})"></div>
                <!-- Agrega más slides según sea necesario -->
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Navigation Buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3 py-6 flex flex-col md:flex-row">
            <!-- Contenido principal (3/5 del ancho) -->
            <div class="bg-white shadow-md rounded-lg p-6 md:flex-3 md:mr-4 mb-4 md:mb-0"
                style="width: 100%;  height: 100%;">
                <h1 class="text-3xl font-bold mb-2 text-amber-400">COMUNICADO - COOPSEMUL</h1>
                <div class="flex gap-2 justify-center">
                    @foreach ($noticias as $key => $noticia)
                        <button onclick="mostrarNoticia({{ $key + 1 }})"
                            class="px-4 py-2 bg-slate-400 text-white rounded-full hover:bg-blue-600 focus:outline-none focus:bg-blue-600 flex items-center justify-center {{ $key === 0 ? 'active' : '' }}">
                            <span>{{ $key + 1 }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="noticias-container">
                    @foreach ($noticias as $key => $noticia)
                        <div id="noticia{{ $key + 1 }}" class="noticia mt-4  {{ $key === 0 ? '' : 'hidden' }}">
                            <h2 class="text-2xl font-bold mb-2 text-sky-500">{{ $noticia->titulo }}</h2>
                            <p class="text-slate-500 text-justify">{!! $noticia->descripcion !!}</p>
                            <div class="fecha-publicacion">
                                <span class="fecha-label">Fecha de publicación</span>
                                <span class="fecha-label">{{ $noticia->fecha }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
            <!-- Barra lateral (2/5 del ancho) -->
            <div class="bg-white rounded-md p-4 shadow-md md:flex-2 md:ml-4 w-full md:w-2/5" style="height: 100%;">
                <h2 class="text-xl font-bold mb-2  text-amber-400">Documentos</h2>
                <div class="flex flex-col">
                    {{-- @foreach ($documentos as $key => $documento) --}}
                        <div class="bg-blue-200 p-2 rounded-md my-2">
                            <a href="{{asset('img/noticias/cronograma_actividades.png')}}" download
                                class="text-blue-600 hover:underline">Cronograma de Actividades</a>
                            {{-- <a href="{{asset('img/noticias/cronograma_actividades.png')}}" download
                                class="text-blue-600 hover:underline">{{ $documento->titulo }}</a> --}}
                        </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>




        <script>
            function mostrarNoticia(numNoticia) {
                // Oculta todas las noticias
                var noticias = document.getElementsByClassName('noticia');
                for (var i = 0; i < noticias.length; i++) {
                    noticias[i].classList.add('hidden');
                }

                // Muestra la noticia seleccionada
                var noticia = document.getElementById('noticia' + numNoticia);
                if (noticia) {
                    noticia.classList.remove('hidden');
                }
            }
        </script>

    </div>
</x-app-layout>
