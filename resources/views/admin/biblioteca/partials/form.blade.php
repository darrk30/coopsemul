<div class="col-md-6">
    {!! Form::label('titulo', 'Título', ['class' => 'form-label']) !!}
    {!! Form::text('titulo', null, ['class' => 'form-control', 'required']) !!}
    @error('titulo')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-6">
    {!! Form::label('autor', 'Autor', ['class' => 'form-label']) !!}
    {!! Form::text('autor', null, ['class' => 'form-control', 'required']) !!}
    @error('autor')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-12">
    {!! Form::label('descripcion', 'Descripción', ['class' => 'form-label']) !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => 3, 'required']) !!}
    @error('descripcion')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-4">
    {!! Form::label('anio_publicacion', 'Año de Publicación', ['class' => 'form-label']) !!}
    {!! Form::number('anio_publicacion', null, ['class' => 'form-control', 'required']) !!}
    @error('anio_publicacion')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('category_id', 'Categoría') !!}
        {!! Form::select('category_id', $categorias, null, [
            'class' => 'form-control',
            'placeholder' => 'Seleccione una categoría',
        ]) !!}
        @error('category_id')
            <p class="text-danger">{{ $message }}</p>
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
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('image', 'Imagen del Libro') !!}
        <div class="container row">
            <div class="row">
                <div class="col-md-6">
                    <figure>
                        @isset($libro->image)
                            <img id="imagen" class="img-fluid" src="{{ Storage::disk('s3')->url($libro->image->url) }}"
                                alt="">
                        @else
                            <img id="imagen" class="img-fluid"
                                src="https://www.eclosio.ong/wp-content/uploads/2018/08/default.png" alt=""
                                width="350">
                        @endisset
                    </figure>
                </div>
                <div>
                    <div>
                        {!! Form::file('image', ['class' => 'form-control p-1', 'id' => 'image']) !!}
                    </div>
                </div>
            </div>
            @error('image')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="col-md-6">
    {!! Form::label('archivo', 'Archivo del Libro', ['class' => 'form-label']) !!}
    <div class="input-group">
        {!! Form::file('archivo', ['class' => 'form-control p-1']) !!}
    </div>
    @error('archivo')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>
