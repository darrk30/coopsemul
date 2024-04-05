<?php

namespace App\Livewire\Admin\Curso;

use App\Models\Curso;
use Livewire\Component;
use Livewire\WithPagination;

class CursosEstudiantes extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $curso, $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount(Curso $curso){
        $this->curso = $curso;
    }

    public function render()
    {
        $estudiantes = $this->curso->users()->where('name', 'LIKE', '%'. $this->search . '%')->latest('id')->paginate(5);
        return view('livewire.admin.curso.cursos-estudiantes', compact('estudiantes'));
    }
}
