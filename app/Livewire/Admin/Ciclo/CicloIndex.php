<?php

namespace App\Livewire\Admin\Ciclo;

use App\Models\Ciclo;
use Livewire\Component;
use Livewire\WithPagination;

class CicloIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        //withCount es para contar los usuarios registrados en los cursos
        $ciclos = Ciclo::withCount('users')
            ->where('nombre', 'LIKE', '%' . $this->search . '%')
            ->latest('id')
            ->paginate(10);
        return view('livewire.admin.ciclo.ciclo-index', compact('ciclos'));
    }
}
