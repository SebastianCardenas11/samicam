<div class="modal fade" id="modalPsiIngresos" tabindex="-1" aria-labelledby="modalPsiIngresosLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPsiIngresosLabel">Registro de Ingreso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formPsiIngresos" name="formPsiIngresos" autocomplete="off">
          <input type="hidden" id="id_ingreso" name="id_ingreso" value="">
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Fecha</label>
                <input type="date" class="form-control" name="fecha" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Ítem</label>
                <input type="text" class="form-control" name="item" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Tipo Dispositivo</label>
                <select class="form-control" name="tipo_dispositivo" id="tipo_dispositivo_ingreso" onchange="toggleInventarioTabIngresos()" required>
                  <option value="interno">Interno (desde inventario)</option>
                  <option value="externo">Externo</option>
                </select>
              </div>
            </div>
            
            <div class="col-12 mb-3" id="inventario_tab_ingreso" style="display: block;">
              <div class="card">
                <div class="card-header">
                  <h6 class="mb-0">Seleccionar Equipo del Inventario</h6>
                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs" id="inventarioTabsIngreso" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pc-torre-tab-ingreso" data-bs-toggle="tab" data-bs-target="#pc-torre-ingreso" type="button" role="tab">
                        <i class="fas fa-desktop"></i> PC Torre
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="todo-en-uno-tab-ingreso" data-bs-toggle="tab" data-bs-target="#todo-en-uno-ingreso" type="button" role="tab">
                        <i class="fas fa-tv"></i> PC Todo en Uno
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="portatiles-tab-ingreso" data-bs-toggle="tab" data-bs-target="#portatiles-ingreso" type="button" role="tab">
                        <i class="fas fa-laptop"></i> Portátiles
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="impresoras-tab-ingreso" data-bs-toggle="tab" data-bs-target="#impresoras-ingreso" type="button" role="tab">
                        <i class="fas fa-print"></i> Impresoras
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="escaneres-tab-ingreso" data-bs-toggle="tab" data-bs-target="#escaneres-ingreso" type="button" role="tab">
                        <i class="fas fa-barcode"></i> Escáneres
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="herramientas-tab-ingreso" data-bs-toggle="tab" data-bs-target="#herramientas-ingreso" type="button" role="tab">
                        <i class="fas fa-tools"></i> Herramientas
                      </button>
                    </li>
                  </ul>
                  <div class="tab-content mt-3" id="inventarioTabsContentIngreso">
                    <div class="tab-pane fade show active" id="pc-torre-ingreso" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaPcTorreIngreso">
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
                    <div class="tab-pane fade" id="todo-en-uno-ingreso" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaTodoEnUnoIngreso">
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
                    <div class="tab-pane fade" id="portatiles-ingreso" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaPortatilesIngreso">
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
                    <div class="tab-pane fade" id="impresoras-ingreso" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaImpresorasIngreso">
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
                    <div class="tab-pane fade" id="escaneres-ingreso" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaEscaneresIngreso">
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
                    <div class="tab-pane fade" id="herramientas-ingreso" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaHerramientasIngreso">
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
            
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Descripción Dispositivo</label>
                <input type="text" class="form-control" name="descripcion_dispositivo" required readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Marca</label>
                <input type="text" class="form-control" name="marca" required readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Modelo</label>
                <input type="text" class="form-control" name="modelo" required readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Número Activo</label>
                <input type="text" class="form-control" name="numero_activo" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Serial</label>
                <input type="text" class="form-control" name="serial" required readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Dependencia</label>
                <input type="text" class="form-control" name="dependencia" required>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Observaciones</label>
                <textarea class="form-control" name="observaciones" rows="3"></textarea>
              </div>
            </div>
            
            <!-- Campos ocultos para equipo_id y equipo_tipo -->
            <input type="hidden" name="equipo_id" id="equipo_id_ingreso" value="">
            <input type="hidden" name="equipo_tipo" id="equipo_tipo_ingreso" value="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success" form="formPsiIngresos" id="btnGuardarPsiIngresos">Guardar</button>
      </div>
    </div>
  </div>
</div>
