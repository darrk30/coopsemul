<?php

namespace App\Livewire\Admin\Biblioteca;

use App\Models\Libro;
use Livewire\Component;
use Livewire\WithPagination;

class BibliotecaIndex extends Component
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
        // Obtener todos los libros con sus categorías
        $libros = Libro::with('category')
            ->where('titulo', 'LIKE', '%' . $this->search . '%')
            ->latest('id')
            ->paginate(10);
    
        return view('livewire.admin.biblioteca.biblioteca-index', [
            'libros' => $libros
        ]);
    }
    
}
