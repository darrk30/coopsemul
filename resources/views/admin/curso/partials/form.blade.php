<div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('codigo', 'codigo') !!}
                {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el codigo del curso']) !!}
                @error('codigo')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('nombre', 'Nombre del Curso') !!}
                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del curso']) !!}
                @error('nombre')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('profesor', 'DNI del Profesor') !!}
                <div class="input-group">
                    <input type="text" id="searchProfesor" name="searchProfesor" class="form-control" placeholder="Ingrese el DNI del profesor" value="<?php echo isset($curso->user) && isset($curso->user->profile) ? $curso->user->profile->DNI : ''; ?>">

                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="buscarProfesor()">Buscar</button>
                    </div>
                </div>

                {!! Form::hidden('user_id', null, ['class' => 'form-control', 'id' => 'user_id']) !!}



                @error('user_id')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {!! Form::label('descripcion', 'Descripción del Curso') !!}
            {!! Form::textarea('descripcion', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese la descripción',
                'rows' => 2,
                'cols' => 50,
            ]) !!}
            @error('descripcion')
                <samp class="text-danger">{{ $message }}</samp>
            @enderror
        </div>
    </div>



    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('duracion', 'Duración en Semanas') !!}
                {!! Form::number('duracion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la duración en horas']) !!}
                @error('duracion')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('certificado', 'Certificación') !!}
                {!! Form::select('certificado', ['1' => 'Sí', '0' => 'No'], null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione una opción',
                ]) !!}
                @error('certificado')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('category_id', 'Categoría') !!}
                {!! Form::select('category_id', $categorias, null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione una categoría',
                ]) !!}
                @error('category_id')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('precio_id', 'Precio') !!}
                {!! Form::select('precio_id', $precios, null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione un precio',
                ]) !!}
                @error('precio_id')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('level_id', 'Nivel') !!}
                {!! Form::select('level_id', $niveles, null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione un nivel',
                ]) !!}
                @error('level_id')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('status', 'Estado') !!}
                {!! Form::select('status', ['1' => 'Activo', '0' => 'No activo'], null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione una opción',
                ]) !!}
                @error('status')
                    <samp class="text-danger">{{ $message }}</samp>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('url', 'Link de la Clase') !!}
            {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Link de la Clase']) !!}
            @error('url')
                <samp class="text-danger">{{ $message }}</samp>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {!! Form::label('slug', 'Slug del Curso') !!}
            {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la descripción', 'readonly']) !!}
            @error('slug')
                <samp class="text-danger">{{ $message }}</samp>
            @enderror
        </div>
    </div>

    <div class="container row">
        {!! Form::label('file', 'Imagen del Curso') !!}
        <div class="row">
            <div class="col-md-6">
                <figure>
                    @isset($curso->image)
                        <img id="imagen" class="img-fluid" src="{{ Storage::url($curso->image->url) }}" alt="">
                    @else
                        <img id="imagen" class="img-fluid"
                            src="https://www.eclosio.ong/wp-content/uploads/2018/08/default.png" alt="">
                    @endisset
                </figure>

            </div>
            <div class="col-md-6">
                <div>
                    {!! Form::file('file', ['class' => 'form-control', 'id' => 'file']) !!}
                </div>
            </div>
        </div>
        @error('file')
            <samp class="text-danger">{{ $message }}</samp>
        @enderror
    </div>

</div>
