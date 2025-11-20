<form action="{{ route('activos.update' $activo) }}" method="PUT">
    @csrf
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control"></textarea>
    </div>
    <button class="btn btn-success mt-2">Guardar</button>
</form>
