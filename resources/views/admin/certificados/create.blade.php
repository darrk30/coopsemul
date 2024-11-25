@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')

@stop

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Crear Certificado</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Checkbox para habilitar los campos -->
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="editFieldsCheck">
            <label class="form-check-label" for="editFieldsCheck">Habilitar edición de Nombre y Apellidos</label>
        </div>
        <form action="{{ route('admin.certificados.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                {!! Form::label('dni', 'DNI:') !!}
                <div class="input-group">
                    {!! Form::text('dni', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Ingrese el DNI del estudiante',
                        'id' => 'dni',
                    ]) !!}
                    {!! Form::hidden('user_id', null, ['id' => 'user_id']) !!}
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="searchDNI">Buscar</button>
                    </div>
                </div>
                @error('dni')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('name', 'Nombre:') !!}
                {!! Form::text('name', null, [
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
                {!! Form::text('apellidos', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese los Apellidos del estudiante',
                    'readonly',
                ]) !!}
                @error('apellidos')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="curso" class="form-label">Curso</label>
                <input type="text" name="curso" id="curso" class="form-control" value="{{ old('curso') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="resolucion" class="form-label">Resolución</label>
                <input type="text" name="resolucion" id="resolucion" class="form-control" value="{{ old('resolucion') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="especialidad_id" class="form-label">Especialidad</label>
                <select name="especialidad_id" id="especialidad_id" class="form-control" required>
                    <option value="">Seleccione una especialidad</option>
                    @foreach ($especialidades as $especialidad)
                        <option value="{{ $especialidad->id }}"
                            {{ old('especialidad_id') == $especialidad->id ? 'selected' : '' }}>
                            {{ $especialidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="rutaArchivo" class="form-label">Archivo del Certificado</label>
                <input type="file" name="rutaArchivo" id="rutaArchivo" class="form-control" accept=".pdf,.jpg,.png"
                    required>
            </div>

            <div class="mb-3">
                <label for="tipo_pago_id" class="form-label">Tipo de Pago</label>
                <select name="tipo_pago_id" id="tipo_pago_id" class="form-control">
                    <option value="">Seleccione un tipo de pago</option>
                    @if ($tiposPago->isNotEmpty())
                        @foreach ($tiposPago as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('tipo_pago_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    @else
                        <option value="" disabled>Sin datos disponibles</option>
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label for="users_id_promotor" class="form-label">Promotor</label>
                <select name="users_id_promotor" id="users_id_promotor" class="form-control">
                    <option value="">Seleccione un promotor</option>
                    @if ($promotores->isNotEmpty())
                        @foreach ($promotores as $promotor)
                            <option value="{{ $promotor->id }}"
                                {{ old('users_id_promotor') == $promotor->id ? 'selected' : '' }}>
                                {{ $promotor->name }}
                            </option>
                        @endforeach
                    @else
                        <option value="" disabled>Sin datos disponibles</option>
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label for="tipo_inscripcion_id" class="form-label">Tipo de Inscripción</label>
                <select name="tipo_inscripcion_id" id="tipo_inscripcion_id" class="form-control">
                    <option value="">Seleccione un tipo de inscripción</option>
                    @if ($tipoInscripciones->isNotEmpty())
                        @foreach ($tipoInscripciones as $tipoInscripcion)
                            <option value="{{ $tipoInscripcion->id }}"
                                {{ old('tipo_inscripcion_id') == $tipoInscripcion->id ? 'selected' : '' }}>
                                {{ $tipoInscripcion->nombre }}
                            </option>
                        @endforeach
                    @else
                        <option value="" disabled>Sin datos disponibles</option>
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label for="empresas_id" class="form-label">Empresa</label>
                <select name="empresas_id" id="empresas_id" class="form-control">
                    <option value="">Seleccione una empresa</option>
                    @if ($empresas->isNotEmpty())
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id }}"
                                {{ old('empresas_id') == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->nombre }}
                            </option>
                        @endforeach
                    @else
                        <option value="" disabled>Sin datos disponibles</option>
                    @endif
                </select>
            </div>


            <div class="mb-3">
                <label for="users_id_trabajador" class="form-label">Trabajador</label>
                <!-- Mostrar el nombre del usuario autenticado de forma estática -->
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>

                <!-- Campo oculto con el ID del usuario autenticado -->
                <input type="hidden" name="users_id_trabajador" value="{{ auth()->user()->id }}">
            </div>



            <button type="submit" class="btn btn-primary">Guardar Certificado</button>
            <a href="{{ route('admin.certificados.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@stop

@section('css')

@stop

@section('js')

    <script>
        // Función para habilitar los campos cuando el checkbox está marcado
        document.getElementById('editFieldsCheck').addEventListener('change', function() {
            const nameField = document.getElementById('name');
            const apellidosField = document.getElementById('apellidos');

            if (this.checked) {
                nameField.removeAttribute('readonly');
                apellidosField.removeAttribute('readonly');
            } else {
                nameField.setAttribute('readonly', 'readonly');
                apellidosField.setAttribute('readonly', 'readonly');
            }
        });
    </script>
    <script>
        var dniFound = false;

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('searchDNI').addEventListener('click', function(event) {
                // Obtener el valor del DNI
                var dni = document.getElementById('dni').value;

                // Verificar que el DNI tiene exactamente 8 dígitos y no contiene letras
                if (/^\d{8}$/.test(dni)) {
                    // Si la longitud es 8 y no contiene letras, llamar a la función consultaDNI()
                    consultaDNI();
                } else {
                    // Si no cumple con los requisitos, mostrar un mensaje de error
                    alert('Ingrese un DNI válido de 8 dígitos numéricos.');
                }
            });

            // Manejar el envío del formulario
            document.getElementById('form-inscripcion').addEventListener('submit', function(event) {
                // Si no se encontró el DNI, prevenir el envío del formulario
                if (!dniFound) {
                    event.preventDefault();
                    alert(
                        'No se ha encontrado un DNI válido. Por favor, busque un DNI válido antes de enviar el formulario.'
                    );
                }
            });
        });

        function consultaDNI() {
            var dni = document.getElementById('dni').value;
            // Realizar la consulta AJAX
            $.ajax({
                url: "{{ route('admin.certificados.buscarDNI') }}",
                type: 'GET',
                data: {
                    dni: dni,
                },
                success: function(response) {
                    if (response.success == true) {
                        $('#name').val(response.nombres);
                        if (response.apellidoPaterno) {
                            $('#apellidos').val(response.apellidoPaterno + ' ' + response.apellidoMaterno);
                            $('#user_id').val("");
                        } else {
                            console.log(response.user_id);
                            $('#apellidos').val(response.apellidos);
                            $('#user_id').val(response.user_id);
                        }

                        $('#dni').removeClass('border-red').addClass('border-green');
                        dniFound = true; // Establecer la bandera en true                       
                    } else {
                        $('#name').val('');
                        $('#apellidos').val('');
                        $('#dni').removeClass('border-green').addClass('border-red');
                        dniFound = false; // Establecer la bandera en false
                    }
                },
                error: function(xhr, status, error) {
                    // Manejar el error aquí
                    var errorMessage = "No se encontro resultado para el DNI";
                    $('#dni').removeClass('border-green').addClass('border-red');
                    dniFound = false; // Establecer la bandera en false en caso de error
                }
            });
        }
    </script>
@stop
