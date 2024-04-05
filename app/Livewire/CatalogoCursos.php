<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Curso;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

class CatalogoCursos extends Component
{
    use WithPagination;

    //protected $paginationTheme = "bootstrap";
    public $search;
    public $categoria_id;
    public $level_id;
    
    public function updatingSearch(){
        $this->resetPage();
    }
    // public function boot()
    // {
    //     Paginator::useTailwind();
    // }
    
    public function render()
    {
        $categorias = Category::all();

        $levels = Level::all();

        $cursos = Curso::latest('id')->where(function ($query) {
            $query->where('nombre', 'LIKE', '%' . $this->search . '%');
        })        
        ->when($this->categoria_id, function ($query) {
            $query->where('category_id', $this->categoria_id);
        })
        ->when($this->level_id, function ($query) {
            $query->where('level_id', $this->level_id);
        })->where('status', 1)->paginate(5);
        return view('livewire.catalogo-cursos', compact('categorias', 'cursos', 'levels'));
    }
    
}
