<?php

namespace App\Livewire\Admin\Ciclo;

use App\Models\Ciclo;
use App\Models\Curso;
use Livewire\Component;
use Livewire\WithPagination;

class CicloEstudiantes extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $ciclo, $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount(Ciclo $ciclo){
        $this->ciclo = $ciclo;
    }

    public function render()
    {
        $estudiantes = $this->ciclo->users()->where('name', 'LIKE', '%'. $this->search . '%')->latest('id')->paginate(5);
        return view('livewire.admin.ciclo.ciclo-estudiantes', compact('estudiantes'));
    }
}
