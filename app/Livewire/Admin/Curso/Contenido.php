<?php

namespace App\Livewire\Admin\Curso;

use App\Models\ContenidoCurso;
use App\Models\Curso;
use Livewire\Component;

class Contenido extends Component
{
    public $curso, $contenido, $titulo;



    public function mount($curso)
    {
        $this->curso = $curso;
        $this->contenido = new ContenidoCurso();
    }

    protected $rules = [
        'contenido.titulo' => 'required',
    ];


    public function render()
    {
        return view('livewire.admin.curso.contenido');
    }

    public function store(){
        $this->validate([
            'titulo' => 'required',
        ]);
        ContenidoCurso::create([
            'titulo' => $this->titulo,
            'descripcion' => "Contenido del curso",
            'curso_id' => $this->curso->id,
        ]);

        $this->reset('titulo');
        $this->curso = Curso::find($this->curso->id);
    }

    public function edit(ContenidoCurso $contenido)
    {
        $this->contenido = $contenido;
    }

    public function update(){
        $this->validate();
        $this->contenido->save();
        $this->contenido = new ContenidoCurso();
        $this->curso = Curso::find($this->curso->id);
    }

    public function destroy(ContenidoCurso $contenido){
        $contenido->delete();
        $this->curso = Curso::find($this->curso->id);
    }

}
