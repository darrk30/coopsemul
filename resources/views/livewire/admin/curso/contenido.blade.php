<div class="container">
    <div class="card">
        <div class="card-body">
            <h1 class="text-xl font-weight-bold mb-4">CONTENIDO DEL CURSO</h1>
            <hr class="mt-2 mb-6">
            <?php foreach ($curso->contenidos as $item): ?>
            <article class="card mb-6">
                <div class="card-body" style="background: rgb(241, 241, 241)">
                    @if ($contenido->id == $item->id)
                        <form wire:submit.prevent="update">
                            <input wire:model.live="contenido.titulo" type="text" class="form-control w-100"
                                placeholder="Ingrese el título del contenido">
                            @error('contenido.titulo')
                                <span class="text-xs text-red">{{ $message }}</span>
                            @enderror
                        </form>
                    @else
                    <div x-data="{ open: false }">
                        <header style="display: flex; justify-content: space-between; align-items: center">
                            <span style="cursor: pointer" @click="open = !open"><strong>Contenido:</strong> <?php echo $item->titulo; ?></span>
                            <div>
                                <i class="fas fa-edit" style="cursor: pointer; color: rgb(56, 56, 255);" wire:click="edit({{ $item }})"></i>
                                <i class="fas fa-eraser" style="cursor: pointer; color: rgb(255, 64, 64);" wire:click="destroy({{ $item }})"></i>
                            </div>
                        </header>
                        <div x-show="open">
                            @livewire('admin.curso.lecciones', ['contenido' => $item], key($item->id))
                        </div>
                    </div>
                    
                    @endif
                </div>
            </article>
            <?php endforeach; ?>

            <div x-data="{ open: false }">
                <template x-if="!open">
                    <a x-on:click="open = true;" class="d-flex align-items-center" style="cursor: pointer;">
                        <i class="far fa-plus-square text-danger mr-2" style="font-size: 1.5rem;"></i>
                        Agregar nueva sección
                    </a>
                </template>
                <article class="card mt-3" x-show.transition="open">
                    <div class="card-body" style="background: rgb(228, 228, 228)">
                        <h1 class="font-weight-bold" style="font-size: 1.3rem">AGREGAR NUEVA SECCIÓN</h1>
                        <div class="">
                            <input wire:model.live="titulo" type="text" class="form-control w-100"
                                placeholder="Escriba el nombre de la sección">
                            @error('titulo')
                                <span class="text-xs text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div style="display: flex; justify-content: end; margin-top: 7px;">
                            <button class="btn btn-danger" x-on:click="open = false">Cancelar</button>
                            <button class="btn btn-primary ml-2" wire:click="store">Agregar</button>
                        </div>
                    </div>
                </article>
            </div>




        </div>
    </div>
</div>
