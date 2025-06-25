<div class="modal fade" id="modalTintasToner" tabindex="-1" aria-labelledby="modalTintasTonerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="#" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTintasTonerLabel"><i class="bi bi-droplet"></i> Registrar Tinta/Tóner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3"><label for="itemTintaToner" class="form-label">Item</label><input type="text" class="form-control" id="itemTintaToner" name="itemTintaToner" required></div>
          <div class="mb-3"><label for="disponiblesTintaToner" class="form-label">Disponibles</label><input type="number" class="form-control" id="disponiblesTintaToner" name="disponiblesTintaToner" min="0" required></div>
          <div class="mb-3"><label for="impresoraTintaToner" class="form-label">Impresora</label><input type="text" class="form-control" id="impresoraTintaToner" name="impresoraTintaToner"></div>
          <div class="mb-3"><label for="modelosCompatiblesTintaToner" class="form-label">Modelos Compatibles</label><input type="text" class="form-control" id="modelosCompatiblesTintaToner" name="modelosCompatiblesTintaToner"></div>
          <div class="mb-3"><label for="fechaActualizacionTintaToner" class="form-label">Fecha Última Actualización</label><input type="date" class="form-control" id="fechaActualizacionTintaToner" name="fechaActualizacionTintaToner"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<style>
#modalTintasToner .btn-close { filter: none !important; opacity: 1 !important; background: none !important; position: relative; }
#modalTintasToner .btn-close svg, #modalTintasToner .btn-close::before { color: #111 !important; background: none !important; }
#modalTintasToner .btn-close::after { content: "\00d7"; font-size: 2rem; color: #111; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); line-height: 1; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var modalTintasToner = document.getElementById('modalTintasToner');
  if (modalTintasToner) {
    modalTintasToner.addEventListener('hidden.bs.modal', function () {
      modalTintasToner.querySelector('form').reset();
    });
  }
});
</script> 