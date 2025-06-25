<div class="modal fade" id="modalImpresora" tabindex="-1" aria-labelledby="modalImpresoraLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <form method="POST" id="formImpresora" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalImpresoraLabel"><i class="bi bi-printer"></i> Registrar Impresora</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3"><label for="numImpresora" class="form-label">Número de impresora</label><input type="text" class="form-control" id="numImpresora" name="numImpresora" required></div>
          <div class="mb-3"><label for="marcaImpresora" class="form-label">Marca</label><input type="text" class="form-control" id="marcaImpresora" name="marca" required></div>
          <div class="mb-3"><label for="modeloImpresora" class="form-label">Modelo</label><input type="text" class="form-control" id="modeloImpresora" name="modelo" required></div>
          <div class="mb-3"><label for="serialImpresora" class="form-label">Serial</label><input type="text" class="form-control" id="serialImpresora" name="serial" required></div>
          <div class="mb-3"><label for="consumibleImpresora" class="form-label">Consumible</label><input type="text" class="form-control" id="consumibleImpresora" name="consumible"></div>
          <div class="mb-3"><label for="estadoImpresora" class="form-label">Estado</label><select class="form-select" id="estadoImpresora" name="estado" required><option value="">Seleccione</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Dañado">Dañado</option><option value="Baja">Baja</option></select></div>
          <div class="mb-3"><label for="disponibilidadImpresora" class="form-label">Disponibilidad</label><select class="form-select" id="disponibilidadImpresora" name="disponibilidad" required><option value="">Seleccione</option><option value="Asignado">Asignado</option><option value="No asignado">No asignado</option></select></div>
          <div class="mb-3">
            <label for="funcionarioImpresora" class="form-label">Funcionario Asignado</label>
            <select class="form-select" id="funcionarioImpresora" name="id_funcionario">
              <option value="">Seleccione un funcionario</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="cargoImpresora" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="cargoImpresora" name="id_cargo" readonly>
          </div>
          <div class="mb-3">
            <label for="sectorialImpresora" class="form-label">Sectorial</label>
            <input type="text" class="form-control" id="sectorialImpresora" name="id_dependencia" readonly>
          </div>
          <div class="mb-3"><label for="oficinaImpresora" class="form-label">Oficina</label><input type="text" class="form-control" id="oficinaImpresora" name="oficina"></div>
          <div class="mb-3">
            <label for="contactoImpresora" class="form-label">Contacto</label>
            <input type="text" class="form-control" id="contactoImpresora" name="id_contacto" readonly>
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
#modalImpresora .btn-close { filter: none !important; opacity: 1 !important; background: none !important; position: relative; }
#modalImpresora .btn-close svg, #modalImpresora .btn-close::before { color: #111 !important; background: none !important; }
#modalImpresora .btn-close::after { content: "\00d7"; font-size: 2rem; color: #111; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); line-height: 1; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var modalImpresora = document.getElementById('modalImpresora');
  if (modalImpresora) {
    modalImpresora.addEventListener('hidden.bs.modal', function () {
      modalImpresora.querySelector('form').reset();
      document.getElementById('cargoImpresora').value = '';
      document.getElementById('sectorialImpresora').value = '';
      document.getElementById('contactoImpresora').value = '';
    });
  }
  
  // Manejar envío del formulario
  const formImpresora = document.getElementById('formImpresora');
  if (formImpresora) {
    formImpresora.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Prevenir múltiples envíos
      const submitBtn = this.querySelector('button[type="submit"]');
      if (submitBtn.disabled) return;
      submitBtn.disabled = true;
      submitBtn.textContent = 'Guardando...';
      
      const formData = new FormData(formImpresora);
      
      fetch(base_url + '/Inventario/Impresoras/setImpresora', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status) {
          const modal = bootstrap.Modal.getInstance(modalImpresora);
          if (modal) modal.hide();
          formImpresora.reset();
          location.reload();
        } else {
          if (typeof Swal !== 'undefined') {
            Swal.fire('Error', data.msg, 'error');
          } else {
            alert('Error: ' + data.msg);
          }
        }
      })
      .catch(error => {
        if (typeof Swal !== 'undefined') {
          Swal.fire('Error', 'Error de conexión', 'error');
        } else {
          alert('Error de conexión');
        }
      })
      .finally(() => {
        // Rehabilitar botón
        submitBtn.disabled = false;
        submitBtn.textContent = 'Guardar';
      });
    });
  }
  
  // Cargar funcionarios planta y autocompletar cargo, sectorial y contacto
  fetch(base_url + '/FuncionariosPlanta/getFuncionarios')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('funcionarioImpresora');
      data.forEach(f => {
        const option = document.createElement('option');
        option.value = f.idefuncionario;
        option.textContent = f.nombre_completo + ' (' + f.nm_identificacion + ')';
        option.dataset.cargo = f.cargo;
        option.dataset.dependencia = f.dependencia_fk;
        option.dataset.dependenciaNombre = f.dependencia;
        option.dataset.contacto = f.celular || f.correo_elc || '';
        select.appendChild(option);
      });
    })
    .catch(err => console.log('Error cargando funcionarios:', err));
    
  document.getElementById('funcionarioImpresora').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    document.getElementById('cargoImpresora').value = selected.dataset.cargo || '';
    document.getElementById('sectorialImpresora').value = selected.dataset.dependencia || '';
    document.getElementById('contactoImpresora').value = selected.dataset.contacto || '';
  });
});
</script> 