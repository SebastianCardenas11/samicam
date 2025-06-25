<div class="modal fade" id="modalEscaner" tabindex="-1" aria-labelledby="modalEscanerLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <form method="POST" action="#" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEscanerLabel"><i class="bi bi-upc-scan"></i> Registrar Escáner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3"><label for="numEscaner" class="form-label">Número de escáner</label><input type="text" class="form-control" id="numEscaner" name="numEscaner" required></div>
          <div class="mb-3"><label for="marcaEscaner" class="form-label">Marca</label><input type="text" class="form-control" id="marcaEscaner" name="marcaEscaner" required></div>
          <div class="mb-3"><label for="modeloEscaner" class="form-label">Modelo</label><input type="text" class="form-control" id="modeloEscaner" name="modeloEscaner" required></div>
          <div class="mb-3"><label for="serialEscaner" class="form-label">Serial</label><input type="text" class="form-control" id="serialEscaner" name="serialEscaner" required></div>
          <div class="mb-3"><label for="estadoEscaner" class="form-label">Estado</label><select class="form-select" id="estadoEscaner" name="estadoEscaner" required><option value="">Seleccione</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Dañado">Dañado</option><option value="Baja">Baja</option></select></div>
          <div class="mb-3"><label for="disponibilidadEscaner" class="form-label">Disponibilidad</label><select class="form-select" id="disponibilidadEscaner" name="disponibilidadEscaner" required><option value="">Seleccione</option><option value="Asignado">Asignado</option><option value="No asignado">No asignado</option></select></div>
          <div class="mb-3">
            <label for="funcionarioEscaner" class="form-label">Funcionario Asignado</label>
            <select class="form-select" id="funcionarioEscaner" name="funcionarioEscaner">
              <option value="">Seleccione un funcionario</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="cargoEscaner" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="cargoEscaner" name="cargoEscaner" readonly>
          </div>
          <div class="mb-3">
            <label for="sectorialEscaner" class="form-label">Sectorial</label>
            <input type="text" class="form-control" id="sectorialEscaner" name="sectorialEscaner" readonly>
          </div>
          <div class="mb-3"><label for="oficinaEscaner" class="form-label">Oficina</label><input type="text" class="form-control" id="oficinaEscaner" name="oficinaEscaner"></div>
          <div class="mb-3">
            <label for="contactoEscaner" class="form-label">Contacto</label>
            <input type="text" class="form-control" id="contactoEscaner" name="contactoEscaner" readonly>
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
#modalEscaner .btn-close { filter: none !important; opacity: 1 !important; background: none !important; position: relative; }
#modalEscaner .btn-close svg, #modalEscaner .btn-close::before { color: #111 !important; background: none !important; }
#modalEscaner .btn-close::after { content: "\00d7"; font-size: 2rem; color: #111; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); line-height: 1; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var modalEscaner = document.getElementById('modalEscaner');
  if (modalEscaner) {
    modalEscaner.addEventListener('hidden.bs.modal', function () {
      modalEscaner.querySelector('form').reset();
      document.getElementById('cargoEscaner').value = '';
      document.getElementById('sectorialEscaner').value = '';
      document.getElementById('contactoEscaner').value = '';
    });
  }
  // Cargar funcionarios planta y autocompletar cargo, sectorial y contacto
  fetch(base_url + '/FuncionariosPlanta/getFuncionarios')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('funcionarioEscaner');
      data.forEach(f => {
        const option = document.createElement('option');
        option.value = f.idefuncionario;
        option.textContent = f.nombre_completo + ' (' + f.nm_identificacion + ')';
        option.dataset.cargo = f.cargo;
        option.dataset.dependencia = f.dependencia;
        option.dataset.contacto = f.celular || f.correo_elc || '';
        select.appendChild(option);
      });
    });
  document.getElementById('funcionarioEscaner').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    document.getElementById('cargoEscaner').value = selected.dataset.cargo || '';
    document.getElementById('sectorialEscaner').value = selected.dataset.dependencia || '';
    document.getElementById('contactoEscaner').value = selected.dataset.contacto || '';
  });
});
</script> 