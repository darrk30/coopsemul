<?php

namespace App\Livewire\Admin\Curso;

use App\Models\ContenidoCurso;
use App\Models\Lesion;
use Livewire\Component;

class Lecciones extends Component
{
    public $contenido, $leccion, $nombre;



    public function mount(ContenidoCurso $contenido)
    {
        $this->contenido = $contenido;
        $this->leccion = new Lesion();
    }

    protected $rules = [
        'leccion.nombre' => 'required',
    ];
    public function render()
    {
        return view('livewire.admin.curso.lecciones');
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
        ]);
        Lesion::create([
            'nombre' => $this->nombre,
            'contenido_curso_id' => $this->contenido->id,
        ]);
        $this->reset(['nombre']);
        $this->contenido = ContenidoCurso::find($this->contenido->id);
    }

    public function edit(Lesion $leccion)
    {
        $this->resetValidation();
        $this->leccion = $leccion;
    }

    public function update()
    {
        $this->validate();
        $this->leccion->save();
        $this->leccion = new Lesion();
        $this->contenido = ContenidoCurso::find($this->contenido->id);
    }

    public function cancel()
    {
        $this->leccion = new Lesion();
    }

    public function destroy(Lesion $leccion){
        $leccion->delete();
        $this->contenido = ContenidoCurso::find($this->contenido->id);
    }
}
