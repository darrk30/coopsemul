<?php

namespace App\Livewire\Admin\Colaboradores;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ColaboradoresIndex extends Component
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
        $colaboradores = User::select('users.*')
            ->leftJoin('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
            ->leftJoin('roles as R', 'mhr.role_id', '=', 'R.id')
            ->whereNotIn('users.id', function ($query) {
                $query->select('model_id')
                    ->from('model_has_roles')
                    ->where('model_type', 'App\Models\User')
                    ->where('role_id', function ($query) {
                        $query->select('id')
                            ->from('roles')
                            ->where('name', 'Estudiante');
                    });
            })
            ->where('mhr.model_type', 'App\Models\User')
            ->where(function ($query) {
                $query->where('users.name', 'LIKE', '%' . $this->search . '%')
                    ->orWhereHas('profile', function ($query) {
                        $query->where('apellidos', 'LIKE', '%' . $this->search . '%');
                    })
                    ->orWhereHas('profile', function ($query) {
                        $query->where('DNI', 'LIKE', '%' . $this->search . '%');
                    });
            })
            ->latest('users.id')
            ->paginate(10);





        return view('livewire.admin.colaboradores.colaboradores-index', compact('colaboradores'));
    }
}
