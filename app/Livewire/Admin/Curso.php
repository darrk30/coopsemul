<?php

namespace App\Livewire\Admin;

use App\Models\Curso as ModelsCurso;
use Livewire\Component;
use Livewire\WithPagination;

class Curso extends Component
{
    use WithPagination;
    
    protected $paginationTheme = "bootstrap";
    
    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        //withCount es para contar los usuarios registrados en los cursos
        $cursos = ModelsCurso::withCount('users')
                        ->where('nombre', 'LIKE','%' . $this->search . '%')
                        ->latest('id')
                        ->paginate(10);       
        return view('livewire.admin.curso', compact('cursos'));
    }
}
