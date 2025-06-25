<div class="modal fade" id="modalSalida" tabindex="-1" aria-labelledby="modalSalidaLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <form method="POST" action="#" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSalidaLabel"><i class="bi bi-box-arrow-up"></i> Registrar Salida</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="fechaSalida" class="form-label">Fecha de Salida</label>
            <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" required>
          </div>
          <div class="mb-3">
            <label for="tipoSalida" class="form-label">Tipo de Salida</label>
            <select class="form-select" id="tipoSalida" name="tipoSalida" required>
              <option value="">Seleccione</option>
              <option value="Baja">Baja</option>
              <option value="Transferencia">Transferencia</option>
              <option value="Préstamo">Préstamo</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="descripcionSalida" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcionSalida" name="descripcionSalida" rows="2" required></textarea>
          </div>
          <div class="mb-3">
            <label for="responsableSalida" class="form-label">Responsable</label>
            <input type="text" class="form-control" id="responsableSalida" name="responsableSalida" required>
          </div>
          <div class="mb-3">
            <label for="observacionesSalida" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observacionesSalida" name="observacionesSalida" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label for="itemSalida" class="form-label">Item</label>
            <input type="text" class="form-control" id="itemSalida" name="itemSalida" required>
          </div>
          <div class="mb-3">
            <label for="marcaSalida" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marcaSalida" name="marcaSalida" required>
          </div>
          <div class="mb-3">
            <label for="modeloSalida" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="modeloSalida" name="modeloSalida" required>
          </div>
          <div class="mb-3">
            <label for="numActivoSalida" class="form-label">N° Activo</label>
            <input type="text" class="form-control" id="numActivoSalida" name="numActivoSalida" required>
          </div>
          <div class="mb-3">
            <label for="serialSalida" class="form-label">Serial</label>
            <input type="text" class="form-control" id="serialSalida" name="serialSalida" required>
          </div>
          <div class="mb-3">
            <label for="dependenciaSalida" class="form-label">Dependencia</label>
            <input type="text" class="form-control" id="dependenciaSalida" name="dependenciaSalida" required>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<style>
#modalSalida .btn-close {
  filter: none !important;
  opacity: 1 !important;
  background: none !important;
  position: relative;
}
#modalSalida .btn-close svg, #modalSalida .btn-close::before {
  color: #111 !important;
  background: none !important;
}
#modalSalida .btn-close::after {
  content: "\00d7";
  font-size: 2rem;
  color: #111;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  line-height: 1;
}
</style> 