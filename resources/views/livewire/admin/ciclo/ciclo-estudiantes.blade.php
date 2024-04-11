<div class="container">
    <div class="card">
        <div class="card-body">
            <h1 class="text-xl font-weight-bold mb-4">ESTUDIANTES DEL CURSO</h1>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input wire:model.live.debounce.250ms="search" type="text" class="form-control rounded"
                                placeholder="Buscar Curso">
                        </div>
                    </div>
                </div>
            </div>


            @if ($estudiantes->count())
                <div class="container">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>DNI</th>
                                        <th>Email</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estudiantes as $estudiante)
                                        <tr>
                                            <td>
                                                <img src="{{ $estudiante->profile_photo_url }}"
                                                    alt="Imagen Predeterminada"
                                                    style="width: 50px; height: 50px; border-radius: 50%;">
                                            </td>
                                            <td>{{ $estudiante->name }}</td>
                                            <td>{{ $estudiante->profile->apellidos }}</td>
                                            <td>{{ $estudiante->profile->DNI }}</td>
                                            <td>{{ $estudiante->email }}</td>
                                            <td>

                                                @foreach ($estudiante->ciclos as $index)
 
                                                    @if (
                                                        $index->pivot->ciclo_id == $ciclo->id && $index->pivot->user_id == $estudiante->id && $index->pivot->status == 1)
                                                        <span class="badge badge-success">Inscrito</span>
                                                    @elseif(
                                                        $index->pivot->ciclo_id == $ciclo->id && $index->pivot->user_id == $estudiante->id && $index->pivot->status == 0)
                                                        <span class="badge badge-danger">Retirado</span>
                                                    @endif
                                                @endforeach

                                                {{-- @if ($estudiante->cursos->status == 1)
                                                    <span class="badge badge-success">Inscrito</span>
                                                @else
                                                    <span class="badge badge-danger">Retirado</span>
                                                @endif --}}
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.matricula.editar', ['user' => $estudiante, 'ciclo' => $ciclo]) }}"
                                                    class="btn btn-primary btn-sm">Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-footer">
                        {{ $estudiantes->links() }}
                    </div>
                </div>
            @else
                <div class="card-body text-center">
                    <strong>No se encontro registros <span class="text-red">{{ $search }}</span></strong>
                </div>
            @endif



        </div>
    </div>

</div>
