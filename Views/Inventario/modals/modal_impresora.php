<div class="modal fade" id="modalImpresora" tabindex="-1" aria-labelledby="modalImpresoraLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/Inventario/Impresoras/guardar">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalImpresoraLabel">Agregar Impresora</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="marca" class="form-control mb-2" placeholder="Marca" required>
          <input type="text" name="modelo" class="form-control mb-2" placeholder="Modelo" required>
          <input type="text" name="serial" class="form-control mb-2" placeholder="Serial" required>
          <input type="text" name="consumible" class="form-control mb-2" placeholder="Consumible" required>
          <select name="estado" class="form-control mb-2" required>
            <option value="">Estado</option>
            <option value="Bueno">Bueno</option>
            <option value="Regular">Regular</option>
            <option value="Dañado">Dañado</option>
            <option value="Baja">Baja</option>
          </select>
          <select name="disponibilidad" class="form-control mb-2" required>
            <option value="">Disponibilidad</option>
            <option value="Disponible">Disponible</option>
            <option value="En uso">En uso</option>
            <option value="Prestado">Prestado</option>
          </select>
          <input type="number" name="id_dependencia" class="form-control mb-2" placeholder="ID Dependencia" required>
          <input type="text" name="oficina" class="form-control mb-2" placeholder="Oficina" required>
          <input type="number" name="id_funcionario" class="form-control mb-2" placeholder="ID Funcionario" required>
          <input type="number" name="id_cargo" class="form-control mb-2" placeholder="ID Cargo" required>
          <input type="number" name="id_contacto" class="form-control mb-2" placeholder="ID Contacto" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div> 