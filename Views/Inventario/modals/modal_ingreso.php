<div class="modal fade" id="modalIngreso" tabindex="-1" aria-labelledby="modalIngresoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <form method="POST" action="#" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalIngresoLabel"><i class="bi bi-box-arrow-in-down"></i> Registrar Ingreso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="fechaIngreso" class="form-label">Fecha de Ingreso</label>
            <input type="date" class="form-control" id="fechaIngreso" name="fechaIngreso" required>
          </div>
          <div class="mb-3">
            <label for="tipoIngreso" class="form-label">Tipo de Ingreso</label>
            <select class="form-select" id="tipoIngreso" name="tipoIngreso" required>
              <option value="">Seleccione</option>
              <option value="Compra">Compra</option>
              <option value="Donación">Donación</option>
              <option value="Transferencia">Transferencia</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="descripcionIngreso" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcionIngreso" name="descripcionIngreso" rows="2" required></textarea>
          </div>
          <div class="mb-3">
            <label for="responsableIngreso" class="form-label">Responsable</label>
            <input type="text" class="form-control" id="responsableIngreso" name="responsableIngreso" required>
          </div>
          <div class="mb-3">
            <label for="observacionesIngreso" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observacionesIngreso" name="observacionesIngreso" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label for="itemIngreso" class="form-label">Item</label>
            <input type="text" class="form-control" id="itemIngreso" name="itemIngreso" required>
          </div>
          <div class="mb-3">
            <label for="marcaModeloIngreso" class="form-label">Marca/Modelo</label>
            <input type="text" class="form-control" id="marcaModeloIngreso" name="marcaModeloIngreso" required>
          </div>
          <div class="mb-3">
            <label for="numActivoIngreso" class="form-label">N° Activo</label>
            <input type="text" class="form-control" id="numActivoIngreso" name="numActivoIngreso" required>
          </div>
          <div class="mb-3">
            <label for="serialIngreso" class="form-label">Serial</label>
            <input type="text" class="form-control" id="serialIngreso" name="serialIngreso" required>
          </div>
          <div class="mb-3">
            <label for="dependenciaIngreso" class="form-label">Dependencia</label>
            <input type="text" class="form-control" id="dependenciaIngreso" name="dependenciaIngreso" required>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<style>
#modalIngreso .btn-close {
  filter: none !important;
  opacity: 1 !important;
  background: none !important;
  position: relative;
}
#modalIngreso .btn-close svg, #modalIngreso .btn-close::before {
  color: #111 !important;
  background: none !important;
}
#modalIngreso .btn-close::after {
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