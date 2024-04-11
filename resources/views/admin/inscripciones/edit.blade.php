@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="mt-1">

    </div>
@stop

@section('content')
    <div class="container">
        @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
    </div>
    <div class="container py-8">
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <!-- Utilizamos justify-content: space-between para que los elementos se distribuyan uniformemente -->
                    <h3 class="text-2xl font-bold">EDITAR ALUMNO</h3>
                    <div style="margin-left: auto;">
                        <!-- Utilizamos margin-left: auto para colocar este div al extremo derecho -->
                        <div class="form-group text-right"> <!-- Alineación a la derecha -->
                            <div class="custom-control custom-checkbox d-inline-block"> <!-- Hacer el checkbox en línea -->
                                {!! Form::checkbox('activate_password', 'activate', false, [
                                    'class' => 'custom-control-input',
                                    'id' => 'activate_password',
                                ]) !!}
                                <label class="custom-control-label" for="activate_password">Activar contraseña</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block">
                                {!! Form::checkbox('activate_curso', 'activate', false, [
                                    'class' => 'custom-control-input',
                                    'id' => 'activate_curso',
                                ]) !!}
                                <label class="custom-control-label" id="label_cambio" for="activate_curso">Cambiar
                                    Curso</label>
                            </div>


                            {{-- <div class="custom-control custom-checkbox d-inline-block"> <!-- Hacer el checkbox en línea -->
                                {!! Form::checkbox('activate_curso', 'activate', false, [
                                    'class' => 'custom-control-input',
                                    'id' => 'activate_curso',
                                ]) !!}
                                <label class="custom-control-label" for="activate_curso">Activar Curso</label>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <hr class="mt-2 mb-6">
                {!! Form::model($user, [
                    'route' => ['admin.matricula.update', $user], // Asegúrate de pasar el ID del usuario como parámetro
                    'autocomplete' => 'off',
                    'method' => 'PUT',
                ]) !!}
                @if ($errors->any() && session('transaction_failed'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    {!! Form::label('curso', 'Curso:') !!}
                    {!! Form::text('curso', $ciclo->curso->nombre, [
                        'class' => 'form-control',
                        'placeholder' => 'Curso',
                        'readonly',
                        'id' => 'curso',
                    ]) !!}
                    {!! Form::hidden('id', $ciclo->id, ['class' => 'form-control', 'id' => 'codigo']) !!}
                    @error('curso')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group" id="select_curso" style="display: none;">
                    {!! Form::label('curso_id', 'Curso:') !!}
                    {!! Form::select('curso_id', $cursos, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un curso']) !!}
                    @error('curso_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <script>
                    document.getElementById('activate_curso').addEventListener('change', function() {
                        var checkbox = this;
                        var cursoInput = document.getElementById('curso');
                        var cicloIdInput = document.getElementById('codigo');
                        var selectCurso = document.getElementById('select_curso');
                        var labelCurso = document.querySelector('label[for="curso"]');
                        var labelCambio = document.getElementById('label_cambio');
                
                        if (checkbox.checked) {
                            cursoInput.style.display = 'none';
                            cursoInput.value = ''; // Limpiar el campo de texto
                            cicloIdInput.style.display = 'none';
                            cicloIdInput.value = ''; // Limpiar el campo oculto
                            labelCurso.style.display = 'none'; // Ocultar el label del campo de texto
                
                            // Mostrar el campo de selección
                            selectCurso.style.display = 'block';
                
                            // Limpiar el contenido del campo de selección
                            selectCurso.value = '';
                
                            // Cambiar el texto y estilo del label del checkbox
                            labelCambio.textContent = 'Cancelar Cambio';
                            labelCambio.style.color = 'red';
                        } else {
                            // Mostrar el campo de texto y el input hidden
                            cursoInput.style.display = 'block';
                            cursoInput.value = '{{ $ciclo->curso->nombre }}';
                            cicloIdInput.style.display = 'block';
                            cicloIdInput.value = '{{ $ciclo->id }}';
                            labelCurso.style.display = 'block'; // Mostrar el label del campo de texto
                
                            // Ocultar el campo de selección
                            selectCurso.style.display = 'none';
                
                            // Limpiar el contenido del campo de selección
                            selectCurso.value = '';
                
                            // Cambiar el texto y estilo del label del checkbox
                            labelCambio.textContent = 'Cambiar Curso';
                            labelCambio.style.color = 'black';
                        }
                    });
                </script>
                





                {{-- <script>
                    document.getElementById('activate_curso').addEventListener('change', function() {
                        var checkbox = this;
                        var cursoInput = document.getElementById('curso');
                        // var codigoInput = document.getElementById('codigo');
                        var labelCambio = document.getElementById('label_cambio');
                
                        if (checkbox.checked) {
                            // Limpiar el contenido y cambiar el ID del input de texto
                            cursoInput.value = '';
                            cursoInput.removeAttribute('readonly');
                            cursoInput.setAttribute('id', 'codigo');
                            cursoInput.setAttribute('name', 'codigo');
                            cursoInput.setAttribute('codigo', 'codigo');
                            cursoInput.setAttribute('value', "");
                            // Cambiar el placeholder del input de texto
                            cursoInput.setAttribute('placeholder', 'Ingrese el código del curso a cambiar');
                
                            // Cambiar el texto y estilo del label del checkbox
                            labelCambio.textContent = 'Cancelar Cambio';
                            labelCambio.style.color = 'red';
                
                            // Limpiar el contenido del input oculto
                            // codigoInput.value = '';
                        } else {
                            // Actualizar la página
                            location.reload();
                        }
                    });
                </script> --}}
                {{-- <div class="form-group">
                    {!! Form::label('curso', 'Curso:') !!}
                    {!! Form::text('curso', $curso->nombre, ['class' => 'form-control', 'placeholder' => 'Curso', 'readonly']) !!}
                    {!! Form::hidden('id', $curso->id, ['class' => 'form-control']) !!}
                    @error('curso')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="form-group">
                    {!! Form::label('dni', 'DNI:') !!}
                    <div class="input-group">
                        {!! Form::text('dni', $user->profile->DNI ?? null, [
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese el DNI del estudiante',
                            'id' => 'dni',
                            'readonly',
                        ]) !!}
                        {!! Form::hidden('user_id', $user->id, ['class' => 'form-control', 'id' => 'user_id']) !!}
                    </div>

                    @error('dni')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    {!! Form::label('name', 'Nombre:') !!}
                    {!! Form::text('name', $user->name ?? null, [
                        'class' => 'form-control',
                        'placeholder' => 'Ingrese los Nombres del estudiante',
                        'readonly',
                    ]) !!}
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    {!! Form::label('apellidos', 'Apellidos:') !!}
                    {!! Form::text('apellidos', $user->profile->apellidos ?? null, [
                        'class' => 'form-control',
                        'placeholder' => 'Ingrese los Apellidos del estudiante',
                        'readonly',
                    ]) !!}
                    @error('apellidos')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email('email', $user->email ?? null, [
                        'class' => 'form-control',
                        'placeholder' => 'Ingrese el Correo del estudiante',
                    ]) !!}
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <div class="col-md-12" id="password_field"
                    style="{{ old('activate_password') ? 'display:block;' : 'display:none;' }}">
                    <div class="form-group">
                        {!! Form::label('password', 'Contraseña', ['class' => 'form-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'current-password']) !!}
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const activatePasswordCheckbox = document.getElementById('activate_password');
                        const passwordField = document.getElementById('password_field');

                        activatePasswordCheckbox.addEventListener('change', function() {
                            passwordField.style.display = this.checked ? 'block' : 'none';
                        });
                    });
                </script>



                <div class="form-group">
                    {!! Form::label('status', 'Status:') !!}
                    {!! Form::select(
                        'status',
                        ['1' => 'Inscrito', '0' => 'Retirado'],
                        $user->ciclos()->where('ciclo_id', $ciclo->id)->first()->pivot->status ?? null,
                        ['class' => 'form-control'],
                    ) !!}

                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('css')


@section('js')
@stop
