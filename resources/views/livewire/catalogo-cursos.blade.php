<div>
    <h1 class="text-center text-3xl mt-10 text-gray-700 mb-6">Últimos Cursos</h1>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex flex-wrap mb-4">
            <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                <input wire:model.live.debounce.250ms="search" type="text" class="form-input rounded w-full" placeholder="Buscar Curso">
            </div>
            <div class="w-full md:w-1/3 px-2">
                <select wire:model.live="categoria_id" class="form-select w-full rounded">
                    <option value="">Seleccionar categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3 px-2">
                <select wire:model.live="level_id" class="form-select w-full rounded">
                    <option value="">Seleccionar Nivel</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <section class="mt-5 mb-5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @foreach ($cursos as $curso)
                    <div class="mb-8">
                        <article class="bg-white rounded-lg overflow-hidden flex flex-col sm:flex-row">
                            <div class="w-full sm:w-1/3">
                                <img src="{{ Storage::disk('s3')->url($curso->image->url) }}" alt="Imagen del Curso"
                                    class="lg:block md:hidden block rounded-lg shadow-lg w-full h-auto">
                            </div>
                            <div class="w-full sm:w-2/3 p-4">
                                <h1 class="text-xl text-gray-800 font-semibold mb-2">{{ $curso->nombre }}</h1>
                                <p class="text-gray-500 text-sm mb-2">{{ $curso->descripcion }}</p>
                                <p class="text-gray-500 text-sm mb-2">Profesor: {{ $curso->user->name }}</p>
                                <p class="text-gray-500 text-sm mb-2">Fecha de publicación:
                                    {{ $curso->created_at->format('d/m/Y') }}</p>
                                <p class="text-gray-500 text-lg mb-2 font-bold">S/ {{ $curso->precio->value }}</p>
                                <a href="{{ route('curso.show', $curso) }}"
                                    class="inline-block mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Más
                                    Información</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="card-footer pb-4">
            <nav class="flex justify-between items-center" aria-label="Pagination">
                <div class="text-sm text-gray-500">
                    Página {{ $cursos->currentPage() }} de {{ $cursos->lastPage() }}
                </div>

                <ul class="flex justify-end space-x-2">
                    {{-- Anterior --}}
                    @if ($cursos->onFirstPage())
                        <li
                            class="relative inline-flex items-center px-2 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-400">
                            <span>&laquo; Anterior</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $cursos->previousPageUrl() }}"
                                class="relative inline-flex items-center px-2 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <span>&laquo; Anterior</span>
                            </a>
                        </li>
                    @endif

                    {{-- Siguiente --}}
                    @if ($cursos->hasMorePages())
                        <li>
                            <a href="{{ $cursos->nextPageUrl() }}"
                                class="relative inline-flex items-center px-2 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <span>Siguiente &raquo;</span>
                            </a>
                        </li>
                    @else
                        <li
                            class="relative inline-flex items-center px-2 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-400">
                            <span>Siguiente &raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
