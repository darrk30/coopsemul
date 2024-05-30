<x-app-layout>
    @section('title', '- Docentes')
    <section class="relative bg-gray-700 py-28 mb-5 bg-cover bg-center" style="background-image: url('https://cdn1-admin.ojowo.com/posts/detail/enhance-online-education.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <h1 class="relative text-center text-white text-3xl z-10 font-semibold">NUESTROS DOCENTES INSCRITOS</h1>
    </section>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2 mt-5">
            @foreach ($users as $user)
                <div class="relative group overflow-hidden h-36 w-36 cursor-default">
                    <img class="h-full w-full object-cover" src="{{ $user->profile_photo_url }}"
                        alt="{{ $user->name }}" />
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p class="text-white text-center">{{ $user->name }}<br>{{ $user->profile->apellidos }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
