@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="mt-1">

    </div>
@stop

@section('content')
    @if ($errors->any() && session('transaction_failed'))
        <div class="alert alert-danger alert-dismissible container">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container py-8">
        <div class="card">
            <div class="card-body">
                <h1 class="text-2xl font-bold">INSCRIBIR ALUMNO</h1>
                <hr class="mt-2 mb-6">


                {!! Form::open(['route' => 'admin.matricula.store', 'method' => 'post']) !!}

                <div class="form-group">
                    {!! Form::label('curso', 'Curso:') !!}
                    {!! Form::text('curso', $curso->nombre, ['class' => 'form-control', 'placeholder' => 'Curso', 'readonly']) !!}
                    {!! Form::hidden('id', $curso->id, ['class' => 'form-control', 'readonly']) !!}
                    @error('curso')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
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

                {{-- <div class="form-group">
                    {!! Form::label('dni', 'DNI:') !!}
                    {!! Form::text('dni', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el DNI del estudiante']) !!}
                    @error('dni')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}

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


                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Correo del estudiante']) !!}
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    {!! Form::label('password', 'Contraseña:') !!}
                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'placeholder' => 'Ingrese la contraseña del estudiante',
                    ]) !!}
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    {!! Form::label('status', 'Status:') !!}
                    {!! Form::select('status', ['1' => 'Inscrito', '0' => 'Retirado'], '1', ['class' => 'form-control']) !!}
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>


@stop

@section('css')
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        .border-green {
            border: 1px solid green !important;
        }
    </style>
@stop

@section('js')
@section('js')
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
                url: "{{ route('admin.matricular.buscarDNI') }}",
                type: 'GET',
                data: {
                    dni: dni,
                },
                success: function(response) {
                    if (response.success == true) {
                        $('#name').val(response.nombres);
                        if (response.apellidoPaterno) {
                            $('#apellidos').val(response.apellidoPaterno + ' ' + response.apellidoMaterno);
                            $('#email').val("");
                            $('#user_id').val("");
                            $('#password').prop('readonly', false);
                            $('#email').prop('readonly', false);
                        } else {
                            console.log(response.user_id);
                            $('#apellidos').val(response.apellidos);
                            $('#email').val(response.email);
                            $('#user_id').val(response.user_id);
                            $('#email').prop('readonly', true);
                            $('#password').prop('readonly', true);
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



@stop
