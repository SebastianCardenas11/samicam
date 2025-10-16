<div class="modal fade" id="modalPsiSalidas" tabindex="-1" aria-labelledby="modalPsiSalidasLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPsiSalidasLabel">Registro de Salida</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formPsiSalidas" name="formPsiSalidas" autocomplete="off">
          <input type="hidden" id="id_salida" name="id_salida" value="">
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Fecha</label>
                <input type="date" class="form-control" name="fecha_salida" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Ítem</label>
                <input type="text" class="form-control" name="item_salida" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Tipo Dispositivo</label>
                <select class="form-control" name="tipo_dispositivo_salida" id="tipo_dispositivo_salida" onchange="toggleInventarioTabSalidas()" required>
                  <option value="interno">Interno (desde inventario)</option>
                  <option value="externo">Externo</option>
                </select>
              </div>
            </div>
            
            <div class="col-12 mb-3" id="inventario_tab_salida" style="display: none;">
              <div class="card">
                <div class="card-header">
                  <h6 class="mb-0">Seleccionar Equipo del Inventario</h6>
                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs" id="inventarioTabsSalida" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pc-torre-tab-salida" data-bs-toggle="tab" data-bs-target="#pc-torre-salida" type="button" role="tab">
                        <i class="fas fa-desktop"></i> PC Torre
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="todo-en-uno-tab-salida" data-bs-toggle="tab" data-bs-target="#todo-en-uno-salida" type="button" role="tab">
                        <i class="fas fa-tv"></i> PC Todo en Uno
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="portatiles-tab-salida" data-bs-toggle="tab" data-bs-target="#portatiles-salida" type="button" role="tab">
                        <i class="fas fa-laptop"></i> Portátiles
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="impresoras-tab-salida" data-bs-toggle="tab" data-bs-target="#impresoras-salida" type="button" role="tab">
                        <i class="fas fa-print"></i> Impresoras
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="escaneres-tab-salida" data-bs-toggle="tab" data-bs-target="#escaneres-salida" type="button" role="tab">
                        <i class="fas fa-barcode"></i> Escáneres
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="herramientas-tab-salida" data-bs-toggle="tab" data-bs-target="#herramientas-salida" type="button" role="tab">
                        <i class="fas fa-tools"></i> Herramientas
                      </button>
                    </li>
                  </ul>
                  <div class="tab-content mt-3" id="inventarioTabsContentSalida">
                    <div class="tab-pane fade show active" id="pc-torre-salida" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaPcTorreSalida">
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
                    <div class="tab-pane fade" id="todo-en-uno-salida" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaTodoEnUnoSalida">
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
                    <div class="tab-pane fade" id="portatiles-salida" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaPortatilesSalida">
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
                    <div class="tab-pane fade" id="impresoras-salida" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaImpresorasSalida">
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
                    <div class="tab-pane fade" id="escaneres-salida" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaEscaneresSalida">
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
                    <div class="tab-pane fade" id="herramientas-salida" role="tabpanel">
                      <div class="table-responsive" style="max-height: 200px;">
                        <table class="table table-sm table-hover" id="tablaHerramientasSalida">
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
                <input type="text" class="form-control" name="descripcion_dispositivo_salida" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Marca</label>
                <input type="text" class="form-control" name="marca_salida" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Modelo</label>
                <input type="text" class="form-control" name="modelo_salida" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Número Activo</label>
                <input type="text" class="form-control" name="numero_activo_salida" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Serial</label>
                <input type="text" class="form-control" name="serial_salida" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Dependencia</label>
                <input type="text" class="form-control" name="dependencia_salida" required>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group mb-3">
                <label class="form-label fw-bold">Observaciones</label>
                <textarea class="form-control" name="observaciones_salida" rows="3"></textarea>
              </div>
            </div>
            
            <!-- Campos ocultos para equipo_id y equipo_tipo -->
            <input type="hidden" name="equipo_id_salida" id="equipo_id_salida" value="">
            <input type="hidden" name="equipo_tipo_salida" id="equipo_tipo_salida" value="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success" form="formPsiSalidas" id="btnGuardarPsiSalidas">Guardar</button>
      </div>
    </div>
  </div>
</div>
