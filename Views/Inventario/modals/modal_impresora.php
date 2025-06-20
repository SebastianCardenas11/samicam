<div class="modal fade" id="modalImpresora" tabindex="-1" aria-labelledby="modalImpresoraLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/Inventario/Impresoras/guardar" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalImpresoraLabel"><i class="bi bi-printer"></i> Agregar Impresora</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-2 mb-2">
            <div class="col-6">
              <div class="form-floating">
                <input type="text" name="marca" class="form-control" id="inpMarca" placeholder="Marca" required>
                <label for="inpMarca"><i class="bi bi-award"></i> Marca</label>
              </div>
            </div>
            <div class="col-6">
              <div class="form-floating">
                <input type="text" name="modelo" class="form-control" id="inpModelo" placeholder="Modelo" required>
                <label for="inpModelo"><i class="bi bi-gear"></i> Modelo</label>
              </div>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <div class="col-6">
              <div class="form-floating">
                <input type="text" name="serial" class="form-control" id="inpSerial" placeholder="Serial" required>
                <label for="inpSerial"><i class="bi bi-hash"></i> Serial</label>
              </div>
            </div>
            <div class="col-6">
              <div class="form-floating">
                <input type="text" name="consumible" class="form-control" id="inpConsumible" placeholder="Consumible" required>
                <label for="inpConsumible"><i class="bi bi-droplet"></i> Consumible</label>
              </div>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <div class="col-6">
              <div class="form-floating">
                <select name="estado" class="form-select" id="selEstado" required>
                  <option value="" selected>Seleccione</option>
                  <option value="Bueno">Bueno</option>
                  <option value="Regular">Regular</option>
                  <option value="Dañado">Dañado</option>
                  <option value="Baja">Baja</option>
                </select>
                <label for="selEstado"><i class="bi bi-check2-circle"></i> Estado</label>
              </div>
            </div>
            <div class="col-6">
              <div class="form-floating">
                <select name="disponibilidad" class="form-select" id="selDisponibilidad" required>
                  <option value="" selected>Seleccione</option>
                  <option value="Disponible">Disponible</option>
                  <option value="En uso">En uso</option>
                  <option value="Prestado">Prestado</option>
                </select>
                <label for="selDisponibilidad"><i class="bi bi-box-arrow-in-right"></i> Disponibilidad</label>
              </div>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <div class="col-6">
              <div class="form-floating">
                <input type="number" name="id_dependencia" class="form-control" id="inpDependencia" placeholder="ID Dependencia" required>
                <label for="inpDependencia"><i class="bi bi-diagram-3"></i> ID Dependencia</label>
              </div>
            </div>
            <div class="col-6">
              <div class="form-floating">
                <input type="text" name="oficina" class="form-control" id="inpOficina" placeholder="Oficina" required>
                <label for="inpOficina"><i class="bi bi-building"></i> Oficina</label>
              </div>
            </div>
          </div>
          <div class="row g-2 mb-2">
            <div class="col-4">
              <div class="form-floating">
                <input type="number" name="id_funcionario" class="form-control" id="inpFuncionario" placeholder="ID Funcionario" required>
                <label for="inpFuncionario"><i class="bi bi-person"></i> Funcionario</label>
              </div>
            </div>
            <div class="col-4">
              <div class="form-floating">
                <input type="number" name="id_cargo" class="form-control" id="inpCargo" placeholder="ID Cargo" required>
                <label for="inpCargo"><i class="bi bi-person-badge"></i> Cargo</label>
              </div>
            </div>
            <div class="col-4">
              <div class="form-floating">
                <input type="number" name="id_contacto" class="form-control" id="inpContacto" placeholder="ID Contacto" required>
                <label for="inpContacto"><i class="bi bi-telephone"></i> Contacto</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success w-100"><i class="bi bi-save"></i> Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div> 