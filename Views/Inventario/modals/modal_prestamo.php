<div class="modal fade" id="modalPrestamo" tabindex="-1" aria-labelledby="modalPrestamoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <form method="POST" action="#" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPrestamoLabel"><i class="bi bi-arrow-left-right"></i> Registrar Préstamo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="dependenciaPrestamo" class="form-label">Dependencia</label>
            <input type="text" class="form-control" id="dependenciaPrestamo" name="dependenciaPrestamo" readonly required>
          </div>
          <div class="mb-3">
            <label for="funcionarioPrestamo" class="form-label">Funcionario Responsable</label>
            <select class="form-select" id="funcionarioPrestamo" name="funcionarioPrestamo" required>
              <option value="">Seleccione un funcionario</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="cargoPrestamo" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="cargoPrestamo" name="cargoPrestamo" readonly required>
          </div>
          <div class="mb-3">
            <label for="fechaPrestamo" class="form-label">Fecha Préstamo</label>
            <input type="date" class="form-control" id="fechaPrestamo" name="fechaPrestamo" required>
          </div>
          <div class="mb-3 d-flex align-items-center gap-2">
            <div style="flex:1">
              <label for="fechaDevolucion" class="form-label">Fecha Devolución</label>
              <input type="date" class="form-control" id="fechaDevolucion" name="fechaDevolucion">
            </div>
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" id="indefinidaDevolucion">
              <label class="form-check-label" for="indefinidaDevolucion">Indefinida</label>
            </div>
          </div>
          <div class="mb-3">
            <label for="itemPrestamo" class="form-label">Item</label>
            <input type="text" class="form-control" id="itemPrestamo" name="itemPrestamo" required>
          </div>
          <div class="mb-3">
            <label for="dispositivoPrestamo" class="form-label">Dispositivo</label>
            <input type="text" class="form-control" id="dispositivoPrestamo" name="dispositivoPrestamo" required>
          </div>
          <div class="mb-3">
            <label for="modeloPrestamo" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="modeloPrestamo" name="modeloPrestamo" required>
          </div>
          <div class="mb-3">
            <label for="activoPrestamo" class="form-label">Activo</label>
            <input type="text" class="form-control" id="activoPrestamo" name="activoPrestamo" required>
          </div>
          <div class="mb-3">
            <label for="serialPrestamo" class="form-label">Serial</label>
            <input type="text" class="form-control" id="serialPrestamo" name="serialPrestamo" required>
          </div>
          <div class="mb-3">
            <label for="estadoPrestamo" class="form-label">Estado</label>
            <select class="form-select" id="estadoPrestamo" name="estadoPrestamo" required>
              <option value="">Seleccione</option>
              <option value="En Progreso">En Progreso</option>
              <option value="Finalizado">Finalizado</option>
              <option value="Liquidado">Liquidado</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="macPrestamo" class="form-label">MAC</label>
            <input type="text" class="form-control" id="macPrestamo" name="macPrestamo">
          </div>
          <div class="mb-3">
            <label for="observacionesPrestamo" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observacionesPrestamo" name="observacionesPrestamo" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<style>
#modalPrestamo .btn-close {
  filter: none !important;
  opacity: 1 !important;
  background: none !important;
  position: relative;
}
#modalPrestamo .btn-close svg, #modalPrestamo .btn-close::before {
  color: #111 !important;
  background: none !important;
}
#modalPrestamo .btn-close::after {
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
<script>
// Cargar funcionarios planta y autocompletar cargo y dependencia
let funcionariosPlanta = [];
document.addEventListener('DOMContentLoaded', function() {
  fetch(base_url + '/FuncionariosPlanta/getFuncionarios')
    .then(res => res.json())
    .then(data => {
      funcionariosPlanta = data;
      const select = document.getElementById('funcionarioPrestamo');
      data.forEach(f => {
        const option = document.createElement('option');
        option.value = f.idefuncionario;
        option.textContent = f.nombre_completo + ' (' + f.nm_identificacion + ')';
        option.dataset.cargo = f.cargo;
        option.dataset.dependencia = f.dependencia;
        select.appendChild(option);
      });
    });
  document.getElementById('funcionarioPrestamo').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    document.getElementById('cargoPrestamo').value = selected.dataset.cargo || '';
    document.getElementById('dependenciaPrestamo').value = selected.dataset.dependencia || '';
  });
  const chkIndefinida = document.getElementById('indefinidaDevolucion');
  const inputFecha = document.getElementById('fechaDevolucion');
  chkIndefinida.addEventListener('change', function() {
    if (this.checked) {
      inputFecha.value = '';
      inputFecha.disabled = true;
    } else {
      inputFecha.disabled = false;
    }
  });
});
// Limpiar formulario al cerrar el modal (Bootstrap 5, sin jQuery)
var modal = document.getElementById('modalPrestamo');
if (modal) {
  modal.addEventListener('hidden.bs.modal', function () {
    modal.querySelector('form').reset();
    document.getElementById('cargoPrestamo').value = '';
    document.getElementById('dependenciaPrestamo').value = '';
    document.getElementById('fechaDevolucion').disabled = false;
  });
}
</script> 