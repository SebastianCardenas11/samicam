<div class="modal fade" id="modalPsi" tabindex="-1" aria-labelledby="modalPsiLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPsiLabel">Registro de Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formPsi" name="formPsi" autocomplete="off">
          <input type="hidden" id="id_prestamos" name="id_prestamos" value="">
          <div class="row">
            <div class="col-md-6 mb-2">
              <label>Tipo de funcionario:</label><br>
              <input type="radio" name="tipo_funcionario" value="planta" checked> Planta
              <input type="radio" name="tipo_funcionario" value="ops" class="ms-2"> OPS
            </div>
            <div class="col-md-6 mb-2">
              <label>Funcionario Responsable</label>
              <select class="form-control" name="funcionario_responsable" id="funcionario_responsable" required>
                <option value="">Seleccione un funcionario</option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <label>Dependencia</label>
              <input type="text" class="form-control" name="dependencia" id="dependencia" required readonly>
            </div>
            <div class="col-md-6 mb-2">
              <label>Cargo Funcionario</label>
              <input type="text" class="form-control" name="cargo_funcionario" id="cargo_funcionario" required readonly>
            </div>
            <div class="col-md-6 mb-2">
              <label>Fecha Préstamo</label>
              <input type="date" class="form-control" name="fecha_prestamo" required>
            </div>
            <div class="col-md-6 mb-2">
              <label>Fecha Devolución</label>
              <input type="date" class="form-control" name="fecha_devolucion">
            </div>
            <div class="col-md-6 mb-2">
              <label>Item</label>
              <input type="text" class="form-control" name="item" required>
            </div>
            <div class="col-md-6 mb-2">
              <label>Dispositivo</label>
              <input type="text" class="form-control" name="dispositivo" required>
            </div>
            <div class="col-md-6 mb-2">
              <label>Marca/Modelo</label>
              <input type="text" class="form-control" name="marca_modelo" required>
            </div>
            <div class="col-md-6 mb-2">
              <label>Activo</label>
              <input type="text" class="form-control" name="activo" required>
            </div>
            <div class="col-md-6 mb-2">
              <label>Serial</label>
              <input type="text" class="form-control" name="serial" required>
            </div>
            <div class="col-md-6 mb-2">
              <label>Estado</label>
              <input type="text" class="form-control" name="estado" required>
            </div>
            <div class="col-md-6 mb-2">
              <label>MAC</label>
              <input type="text" class="form-control" name="mac">
            </div>
            <div class="col-md-12 mb-2">
              <label>Observaciones</label>
              <textarea class="form-control" name="observaciones"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btnGuardarPsi">Guardar</button>
      </div>
    </div>
  </div>
</div>
