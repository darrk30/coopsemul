@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <div class="mt-1">

    </div>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="container py-8">
        <div class="card">
            <div class="card-body">
                <h3 class="text-2xl font-bold">CREAR NUEVO CURSO</h3>
                <hr class="mt-2 mb-6">
                {!! Form::open(['route' => 'admin.curso.store', 'autocomplete' => 'off', 'files' => true]) !!}
                @include('admin.curso.partials.form')
                {!! Form::submit('Crar Curso', ['class' => 'btn btn-primary mt-2']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{-- <div class="card container">
    <div class="card-body">
        {!! Form::open(['route' => 'admin.curso.store', 'autocomplete' => 'off', 'files' => true]) !!}
                            
            @include('admin.curso.partials.form')

            {!! Form::submit('Crear Curso', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div> --}}
@stop

@section('js')
    <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#nombre").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });
    </script>

    {{-- cambio de imagen automaticamente --}}
    <script>
        document.getElementById("file").addEventListener('change', cambiarImagen);

        function cambiarImagen(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById("imagen").setAttribute('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function buscarProfesor() {
            var searchQuery = document.getElementById('searchProfesor').value;
            // Realizar solicitud AJAX
            console.log(searchQuery);
            $.ajax({
                url: "{{ route('admin.curso.buscarProfesor') }}",
                type: 'GET',
                data: {
                    search: searchQuery
                },
                success: function(response) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    })

                    // Establecer el ID del usuario en el campo oculto
                    document.getElementById('user_id').value = response.user_id;

                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ha ocurrido un error. Por favor, inténtalo de nuevo.'
                    });
                    // Manejar errores si los hay
                }
            });
        }
    </script>

@endsection
