<div class="form-group">
    <label for="titulo">Título:</label>
    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $exam->titulo ?? '') }}" required>
</div>

<div class="form-group">
    <label for="tiempo">Tiempo (Entero):</label>
    <input type="number" class="form-control" id="tiempo" name="tiempo" value="{{ old('tiempo', $exam->tiempo ?? '') }}" required>
</div>

<div class="form-group">
    <label for="fecha">Fecha:</label>
    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha', $exam->fecha ?? '') }}" required>
</div>

<div class="form-group">
    <label for="estado">Estado:</label>
    <select class="form-control" id="estado" name="estado" required>
        <option value="{{ old('status', $exam->status ?? '') }}" >Seleccione el estado</option>
        <option value="0" {{ isset($exam) && $exam->status == 0 ? 'selected' : '' }}>NO PUBLICADO</option>
        @isset($exam)
            <option value="1" {{ $exam->status == 1 ? 'selected' : '' }}>PUBLICADO</option>
        @endisset
    </select>
</div>

<div class="form-group">
    <label for="file">Subir Nueva Imagen:</label>
    <input type="file" class="form-control" id="file" name="file" accept="image/*">
</div>

<div class="col-md-6">
    <figure>
        @if (isset($exam) && $exam->image)
            <img id="imagen" class="img-fluid" src="{{ Storage::disk('s3')->url($exam->image->url) }}" alt="Imagen del examen" width="300px">
        @else
            <img id="imagen" class="img-fluid" src="https://www.eclosio.ong/wp-content/uploads/2018/08/default.png" alt="Imagen por defecto" width="300px">
        @endif
    </figure>
</div>
