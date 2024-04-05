<div>
    @foreach ($contenido->lesions as $item)
        <article class="card mt-3">
            <div class="card-body">
                @if ($leccion->id == $item->id)
                    <form wire:submit.prevent = "update">
                        <div class="" style="display: flex; justify-items: center">
                            <label>Nombre:</label>
                            <input wire:model="leccion.nombre" type="text" class="form-control w-100">
                        </div>
                        @error('leccion.nombre')
                            <span class="text-xs text-red">{{ $message }}</span>
                        @enderror
                        <div class="mt-4" style="display: flex; justify-content: end">
                            <button type="button" class="btn btn-danger text-sm mr-2"
                                wire:click = "cancel">Cancelar</button>
                            <button type="submit" class="btn btn-primary text-sm">Actualizar</button>
                        </div>
                    </form>
                @else
                    <div x-data="{ openLeccion: null }">
                        <header style="text-align: left;">
                            <h1 style="font-size: 1rem; margin: 0; cursor: pointer;"
                                @click="openLeccion !== '{{ $item->id }}' ? openLeccion = '{{ $item->id }}' : openLeccion = null">
                                <strong>Leccion:</strong> {{ $item->nombre }}
                            </h1>
                            <hr class="my-2">
                        </header>
                        <div class="mt-3" x-show="openLeccion === '{{ $item->id }}'">
                            <button class="btn btn-primary text-sm mr-2"
                                wire:click="edit({{ $item }})">Editar</button>
                            <button class="btn btn-danger text-sm"
                                wire:click="destroy({{ $item }})">Eliminar</button>
                        </div>
                    </div>
                @endif
            </div>
        </article>
    @endforeach
    <div x-data="{ open: false }">
        <template x-if="!open">
            <a x-on:click="open = true;" class="d-flex align-items-center" style="cursor: pointer;">
                <i class="far fa-plus-square text-danger mr-2" style="font-size: 1.5rem;"></i>
                Agregar nueva lección
            </a>
        </template>
        <article class="card mt-3" x-show.transition="open">
            <div class="card-body">
                <h1 class="font-weight-bold" style="font-size: 1.3rem">AGREGAR NUEVA LECCIÓN</h1>
                <div class="">
                    <div class="" style="display: flex; justify-items: center">
                        <label>Nombre:</label>
                        <input wire:model.live="nombre" type="text" class="form-control w-100">
                    </div>
                    @error('nombre')
                        <span class="text-xs text-red">{{ $message }}</span>
                    @enderror
                </div>
                <div style="display: flex; justify-content: end; margin-top: 7px;">
                    <button class="btn btn-danger" x-on:click="open = false">Cancelar</button>
                    <button class="btn btn-primary ml-2" x-on:click="open = false" wire:click="store">Agregar</button>
                </div>
            </div>
        </article>
    </div>
</div>
