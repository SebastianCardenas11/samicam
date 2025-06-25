<div class="modal fade" id="modalPapeleria" tabindex="-1" aria-labelledby="modalPapeleriaLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <form method="POST" action="#" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPapeleriaLabel"><i class="bi bi-journal"></i> Registrar Papelería</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3"><label for="itemPapeleria" class="form-label">Item</label><input type="text" class="form-control" id="itemPapeleria" name="itemPapeleria" required></div>
          <div class="mb-3"><label for="disponibilidadPapeleria" class="form-label">Disponibilidad</label><input type="number" class="form-control" id="disponibilidadPapeleria" name="disponibilidadPapeleria" min="0" required></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<style>
#modalPapeleria .btn-close { filter: none !important; opacity: 1 !important; background: none !important; position: relative; }
#modalPapeleria .btn-close svg, #modalPapeleria .btn-close::before { color: #111 !important; background: none !important; }
#modalPapeleria .btn-close::after { content: "\00d7"; font-size: 2rem; color: #111; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); line-height: 1; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var modalPapeleria = document.getElementById('modalPapeleria');
  if (modalPapeleria) {
    modalPapeleria.addEventListener('hidden.bs.modal', function () {
      modalPapeleria.querySelector('form').reset();
    });
  }
});
</script> 