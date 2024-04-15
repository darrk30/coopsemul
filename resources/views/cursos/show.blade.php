<x-app-layout>
    @section('title', ' - ' . $curso->nombre)

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div
            class="lg:max-w-[1440px] md:max-w-[744px] max-w-[375px] mx-auto bg-white px-4 md:px-6 py-12 rounded-lg shadow-xl">
            <div class="md:flex justify-center items-center gap-8 relative">
                <div class="w-full md:w-1/2">
                    <div class="relative overflow-hidden rounded-lg shadow-lg">
                        <!-- Imagen del curso -->
                        <img src="{{ Storage::disk('s3')->url($curso->image->url) }}" alt="Imagen del Curso"
                            class="w-full h-auto md:h-full object-cover">

                        <!-- Categorías -->
                        <div
                            class="absolute top-0 right-0 mr-4 mt-4 bg-yellow-400 text-gray-800 px-3 py-1 font-bold rounded-full text-xs">
                            {{ $curso->category->nombre }}
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <!-- Contenido del curso -->
                    <h2 class="text-3xl font-semibold text-gray-600">{{ $curso->nombre }}</h2>
                    <ul class="mt-4 text-gray-600">
                        <li class="flex items-center mb-2"><i class="fas fa-wifi mr-2"></i><span>En Vivo</span></li>
                        @if (isset($curso->user->name))
                            <li class="flex items-center mb-2"><i class="fas fa-user-tie mr-2"></i><span>Profesor:
                                    {{ $curso->user->name }} {{ $curso->user->profile->apellidos }}</span></li>
                        @endif
                        <li class="flex items-center mb-2"><i class="fas fa-headset mr-2"></i><span>Comunicación directa
                                con el docente</span></li>
                        <li class="flex items-center mb-2"><i class="fas fa-comments mr-2"></i><span>Chat en vivo</span>
                        </li>
                        <li>
                            <div class="bg-sky-700 rounded-lg p-4">
                                <i class="far fa-clock mr-2 text-gray-100"></i>
                                <span class="text-gray-100 font-bold">HORARIO</span><br>
                                @if (isset($curso->horario))
                                    <span class="text-gray-100 font-bold">{{ $curso->horario }}</span>
                                @endif
                            </div>
                        </li>
                    </ul>
                    <p class="mt-4 text-lg text-gray-700">Inversión: S/. <span
                            class="text-gray-800 font-bold">{{ $curso->precio->value }}</span></p>
                </div>
            </div>
        </div>
    </div>


    <div class="mx-auto px-4 py-12 relative bg-gradient-to-r bg-slate-300"
        style="background-image: url(https://moxit.com.ar/wp-content/uploads/2021/10/istockphoto-1213778711-612x612-1.jpg); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
            <h1 class="text-3xl font-bold">¿EN QUÉ CONSISTE ESTE CURSO?</h1>
            <div class="text-justify mb-8 text-xl">
                <p class="text-justify">{{ $curso->descripcion }}</p>
            </div>
            <div class="text-center">
                <a href="https://wa.me/51967607828?text=Estoy%20interesado(a)%20en%20adquirir%20el%20curso%20{{ urlencode($curso->nombre) }},%20por%20favor%20env%C3%ADenme%20m%C3%A1s%20informaci%C3%B3n"
                    target="_blank"
                    class="inline-block px-6 py-3 rounded-lg bg-amber-300 text-slate-700 font-semibold hover:bg-cyan-400 transition duration-300 ease-in-out">ADQUIERA
                    EL CURSO AHORA
                </a>
            </div>
        </div>
    </div>

    <section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-4">
        <h2 class="text-3xl font-semibold mb-1 text-center text-gray-600">CONTENIDO DEL CURSO</h2>
        <div class="p-5">
            <div class="flex justify-center items-start my-2 w-full">
                <div class="w-full">
                    <ul class="flex flex-col w-full">
                        @foreach ($contenidos as $contenido)
                            <li class="bg-white my-2 shadow-lg w-full rounded-t-xl" x-data="accordion({{ $loop->iteration }})">
                                <h2 @click="handleClick()"
                                    class="flex justify-between items-center font-semibold p-3 cursor-pointer bg-sky-700 w-full rounded-t-xl text-white">
                                    <span>{{ $contenido->titulo }}</span>
                                    <svg :class="handleRotate()"
                                        class="fill-current text-white h-6 w-6 transform transition-transform duration-500"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                        </path>
                                    </svg>
                                </h2>
                                <div x-ref="tab" :style="handleToggle()"
                                    class="border-l-2 border-yellow-300 overflow-hidden max-h-0 duration-500 transition-all">
                                    <div class="p-4">
                                        <h2 class="font-bold mb-2">{{ $contenido->descripcion }}</h2>
                                        <hr>
                                        <ul>
                                            @foreach ($contenido->lesions as $key => $lesion)
                                                <li class="mb-2">{{ $key + 1 }}. {{ $lesion->nombre }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="mx-auto px-4 py-12 relative bg-gradient-to-r bg-slate-300">
        <h2 class="text-3xl font-semibold mb-5 text-center text-gray-700">DOCENTE A CARGO</h2>
        <div class="flex flex-col items-center justify-center">
            {{-- @foreach ($profesoresConPerfil as $profesor) --}}

            @foreach ($curso->users as $user)
                <div
                    class="relative flex flex-col sm:flex-row w-full max-w-[48rem] rounded-xl bg-white shadow-md overflow-hidden mb-6">
                    <div class="w-full sm:w-1/3 bg-gradient-to-r flex justify-center items-center">
                        <img src="{{ optional($user)->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://cdn-icons-png.flaticon.com/512/3135/3135768.png' }}"
                            alt="Foto de perfil"
                            class="object-cover h-64 w-full sm:h-full rounded-tl-xl sm:rounded-tl-none sm:rounded-l-xl">
                    </div>
                    <div class="p-6 w-full sm:w-2/3">
                        <h6 class="mb-2 flex items-center text-sm font-semibold text-gray-600 uppercase">
                            <i class="fas fa-chalkboard-teacher mr-2"></i> Profesor
                        </h6>

                        @if (isset($user->name))
                            <h4 class="mb-3 text-2xl font-semibold text-gray-800">

                                {{ $user->name . ' ' . $user->profile->apellidos }}
                            </h4>
                        @endif
                        @if (isset($user->profile->biografia))
                            <p class="mb-4 text-base text-gray-700">{{ $user->profile->biografia }}</p>
                        @endif
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <div class="mb-4 sm:mb-0">
                                <h6 class="mb-2 flex items-center text-sm font-semibold text-gray-600 uppercase">
                                    <i class="fas fa-graduation-cap mr-2"></i> Especialidad
                                </h6>
                                @if (isset($user->profile->especialidad))
                                    <p class="text-base text-gray-700">{{ $user->profile->especialidad }}</p>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-2 flex items-center text-sm font-semibold text-gray-600 uppercase">
                                    <i class="fas fa-envelope mr-2"></i> Contacto
                                </h6>
                                @if (isset($user->email))
                                    <p class="text-base text-gray-700">{{ $user->email }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div
                class="relative flex flex-col sm:flex-row w-full max-w-[48rem] rounded-xl bg-white shadow-md overflow-hidden">
                <div class="w-full sm:w-1/3 bg-gradient-to-r flex justify-center items-center">
                    <img src="{{ optional($curso->user)->profile_photo_path ? asset('storage/' . $curso->user->profile_photo_path) : 'https://cdn-icons-png.flaticon.com/512/3135/3135768.png' }}"
                        alt="Foto de perfil"
                        class="object-cover h-64 w-full sm:h-full rounded-tl-xl sm:rounded-tl-none sm:rounded-l-xl">
                </div>
                <div class="p-6 w-full sm:w-2/3">
                    <h6 class="mb-2 flex items-center text-sm font-semibold text-gray-600 uppercase">
                        <i class="fas fa-chalkboard-teacher mr-2"></i> Profesor
                    </h6>

                    @if (isset($curso->user->name))
                        <h4 class="mb-3 text-2xl font-semibold text-gray-800">

                            {{ $curso->user->name . ' ' . $curso->user->profile->apellidos }}
                        </h4>
                    @endif
                    @if (isset($curso->user->profile->biografia))
                        <p class="mb-4 text-base text-gray-700">{{ $curso->user->profile->biografia }}</p>
                    @endif
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="mb-4 sm:mb-0">
                            <h6 class="mb-2 flex items-center text-sm font-semibold text-gray-600 uppercase">
                                <i class="fas fa-graduation-cap mr-2"></i> Especialidad
                            </h6>
                            @if (isset($curso->user->profile->especialidad))
                                <p class="text-base text-gray-700">{{ $curso->user->profile->especialidad }}</p>
                            @endif
                        </div>
                        <div>
                            <h6 class="mb-2 flex items-center text-sm font-semibold text-gray-600 uppercase">
                                <i class="fas fa-envelope mr-2"></i> Contacto
                            </h6>
                            @if (isset($curso->user->email))
                                <p class="text-base text-gray-700">{{ $curso->user->email }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endforeach --}}
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('accordion', {
                tab: 0
            });

            Alpine.data('accordion', (idx) => ({
                init() {
                    this.idx = idx;
                },
                idx: -1,
                handleClick() {
                    this.$store.accordion.tab = this.$store.accordion.tab === this.idx ? 0 : this.idx;
                },
                handleRotate() {
                    return this.$store.accordion.tab === this.idx ? 'rotate-180' : '';
                },
                handleToggle() {
                    return this.$store.accordion.tab === this.idx ?
                        `max-height: ${this.$refs.tab.scrollHeight}px` : '';
                }
            }));
        })
    </script>
</x-app-layout>
