<div class="container">
    <div class="card">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @can('admin.curso.index')
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.curso.index') }}" class="{{ request()->routeIs('admin.curso.index') ? 'text-blue font-weight-bold' : 'text-gray' }}">Home</a>
                    </li>
                    @endcan
                    @can('admin.curso.edit')
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="{{ route('admin.curso.edit', $curso) }}" class="{{ request()->routeIs('admin.curso.edit') ? 'text-blue font-weight-bold' : 'text-gray' }}">Editar</a>
                    </li>
                    @endcan
                    @can('admin.curso.contenido')
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.curso.contenido', $curso) }}" class="{{ request()->routeIs('admin.curso.contenido') ? 'text-blue font-weight-bold' : 'text-gray' }}">Contenido</a>
                    </li>
                    @endcan                  
                </ol>
            </nav>
        </div>
    </div>
</div>
