<div class="modal fade" id="modalPsi" tabindex="-1" aria-labelledby="modalPsiLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPsiLabel">Registro de Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formPsi" name="formPsi" autocomplete="off">
          <!-- Campos para Préstamos -->
          <input type="hidden" id="id_prestamos" name="id_prestamos" value="">
          <div class="row" data-field="prestamo">
            <!-- Primera fila -->
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Tipo de funcionario</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="tipo_funcionario" value="planta" id="tipo_planta" checked>
                  <label class="form-check-label" for="tipo_planta">Planta</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="tipo_funcionario" value="ops" id="tipo_ops">
                  <label class="form-check-label" for="tipo_ops">OPS</label>
                </div>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Fecha Préstamo</label>
                <input type="date" class="form-control" name="fecha_prestamo" required>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Fecha Devolución</label>
                <input type="date" class="form-control" name="fecha_devolucion">
              </div>
            </div>
            
            <!-- Segunda fila -->
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Funcionario Responsable</label>
                <select class="form-control" name="funcionario_responsable" id="funcionario_responsable" required>
                  <option value="">Seleccione un funcionario</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Dependencia</label>
                <input type="text" class="form-control" name="dependencia" id="dependencia" required readonly>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Cargo Funcionario</label>
                <input type="text" class="form-control" name="cargo_funcionario" id="cargo_funcionario" required readonly>
              </div>
            </div>
            
            <!-- Tercera fila -->
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Cantidad de Items</label>
                <input type="number" class="form-control" name="cantidad_items" id="cantidad_items" min="1" max="5" value="1" onchange="toggleInventarioTabPrestamo()">
                <small class="text-muted">Máximo 5 items por préstamo</small>
              </div>
            </div>
            
            <!-- Tab de Inventario para Préstamos -->
            <div class="col-12 mb-3" id="inventario_tab_prestamo">
              <div class="card">
                <div class="card-header">
                  <h6 class="mb-0">Seleccionar Equipos del Inventario</h6>
                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs" id="inventarioTabsPrestamo" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pc-torre-tab-prestamo" data-bs-toggle="tab" data-bs-target="#pc-torre-prestamo" type="button" role="tab">
                        <i class="fas fa-desktop"></i> PC Torre
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="todo-en-uno-tab-prestamo" data-bs-toggle="tab" data-bs-target="#todo-en-uno-prestamo" type="button" role="tab">
                        <i class="fas fa-tv"></i> PC Todo en Uno
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="portatiles-tab-prestamo" data-bs-toggle="tab" data-bs-target="#portatiles-prestamo" type="button" role="tab">
                        <i class="fas fa-laptop"></i> Portátiles
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="impresoras-tab-prestamo" data-bs-toggle="tab" data-bs-target="#impresoras-prestamo" type="button" role="tab">
                        <i class="fas fa-print"></i> Impresoras
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="escaneres-tab-prestamo" data-bs-toggle="tab" data-bs-target="#escaneres-prestamo" type="button" role="tab">
                        <i class="fas fa-barcode"></i> Escáneres
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="herramientas-tab-prestamo" data-bs-toggle="tab" data-bs-target="#herramientas-prestamo" type="button" role="tab">
                        <i class="fas fa-tools"></i> Herramientas
                      </button>
                    </li>
                  </ul>
                  <div class="tab-content mt-3" id="inventarioTabsContentPrestamo">
                    <div class="tab-pane fade show active" id="pc-torre-prestamo" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaPcTorrePrestamo">
                          <thead>
                            <tr>
                              <th>Número</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Serial</th>
                              <th>N° Activo</th>
                              <th>Estado</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="todo-en-uno-prestamo" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaTodoEnUnoPrestamo">
                          <thead>
                            <tr>
                              <th>Número</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Serial</th>
                              <th>N° Activo</th>
                              <th>Estado</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="portatiles-prestamo" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaPortatilesPrestamo">
                          <thead>
                            <tr>
                              <th>Número</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Serial</th>
                              <th>N° Activo</th>
                              <th>Estado</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="impresoras-prestamo" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaImpresorasPrestamo">
                          <thead>
                            <tr>
                              <th>Número</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Serial</th>
                              <th>N° Activo</th>
                              <th>Estado</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="escaneres-prestamo" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaEscaneresPrestamo">
                          <thead>
                            <tr>
                              <th>Número</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Serial</th>
                              <th>N° Activo</th>
                              <th>Estado</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="herramientas-prestamo" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaHerramientasPrestamo">
                          <thead>
                            <tr>
                              <th>Número</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Serial</th>
                              <th>N° Activo</th>
                              <th>Estado</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Contenedor dinámico para múltiples items -->
            <div id="items_container" class="col-12 mt-3">
              <!-- Los items se generarán dinámicamente aquí -->
            </div>
            
            <!-- Observaciones -->
            <div class="col-12">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Observaciones</label>
                <textarea class="form-control" name="observaciones" rows="3" placeholder="Ingrese observaciones adicionales..."></textarea>
              </div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success" form="formPsi" id="btnGuardarPsi">Guardar</button>
      </div>
    </div>
  </div>
</div>
