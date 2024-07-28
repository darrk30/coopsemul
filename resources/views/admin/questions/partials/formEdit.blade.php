<div class="card-header d-flex justify-content-between align-items-center">
    <div class="text-center">
        <h4 class="mt-2">NUEVA PREGUNTA</h4>        
    </div>
    <div class="ml-auto d-flex align-items-center">
        <div class="form-outline" style="width: 4rem;">
            <input min="1" type="number" id="puntos" name="puntaje" class="form-control" required>
        </div>
        <span class="ml-2">puntos</span>
    </div>
</div>
<div class="card-body">
    <div class="form-group">
        <textarea id="editor" name="pregunta" class="form-control form-control-lg" placeholder="Ingrese la pregunta" required></textarea>
    </div>
    <div class="form-group" id="alternatives-container">
        <!-- Alternativas se agregan dinámicamente aquí -->
    </div>
    <button class="btn btn-outline-primary" id="add-option" type="button">Agregar Opción</button>
    <br>
</div>