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
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Tipo de funcionario</label><br>
                    <input type="radio" name="tipo_funcionario" value="planta" checked> Planta
                    <input type="radio" name="tipo_funcionario" value="ops" class="ms-2"> OPS
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Funcionario Responsable</label>
                    <select class="form-control" name="funcionario_responsable" id="funcionario_responsable" required>
                      <option value="">Seleccione un funcionario</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Dependencia</label>
                    <input type="text" class="form-control" name="dependencia" id="dependencia" required readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Cargo Funcionario</label>
                    <input type="text" class="form-control" name="cargo_funcionario" id="cargo_funcionario" required readonly>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Fecha Préstamo</label>
                    <input type="date" class="form-control" name="fecha_prestamo" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Fecha Devolución</label>
                    <input type="date" class="form-control" name="fecha_devolucion">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Cantidad de Items</label>
                    <input type="number" class="form-control" name="cantidad_items" id="cantidad_items" min="1" max="5" value="1" onchange="toggleInventarioTabPrestamo()">
                    <small class="text-muted">Máximo 5 items por préstamo</small>
                  </div>
                </div>
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
            <div id="items_container" class="col-12">
              <!-- Los items se generarán dinámicamente aquí -->
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <label>Observaciones</label>
                <textarea class="form-control" name="observaciones" rows="3"></textarea>
              </div>
            </div>
          </div>

          <!-- Campos para Salidas -->
          <input type="hidden" id="id_salida" name="id_salida" value="">
          <div class="row" data-field="salida" style="display: none;">
            <div class="col-md-6">
              <div class="form-group">
                <label>Fecha</label>
                <input type="date" class="form-control" name="fecha_salida" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Ítem</label>
                <input type="text" class="form-control" name="item_salida" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Tipo de Dispositivo</label>
                <select class="form-control" name="tipo_dispositivo_salida" id="tipo_dispositivo_salida" required onchange="toggleInventarioTab('salida')">
                  <option value="">Seleccione tipo</option>
                  <option value="interno">Interno</option>
                  <option value="externo">Externo</option>
                </select>
              </div>
            </div>
            
            <!-- Tab de Inventario para Salidas -->
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
              <div class="form-group">
                <label>Descripción Dispositivo</label>
                <input type="text" class="form-control" name="descripcion_dispositivo_salida" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Marca</label>
                <input type="text" class="form-control" name="marca_salida" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Modelo</label>
                <input type="text" class="form-control" name="modelo_salida" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Número Activo</label>
                <input type="text" class="form-control" name="numero_activo_salida" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Serial</label>
                <input type="text" class="form-control" name="serial_salida" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Dependencia</label>
                <input type="text" class="form-control" name="dependencia_salida" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Observaciones</label>
                <textarea class="form-control" name="observaciones_salida" rows="3"></textarea>
              </div>
            </div>
          </div>

          <!-- Campos para Ingresos -->
          <input type="hidden" id="id_ingreso" name="id_ingreso" value="">
          <div class="row" data-field="ingreso" style="display: none;">
            <div class="col-md-6">
              <div class="form-group">
                <label>Fecha</label>
                <input type="date" class="form-control" name="fecha_ingreso" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Ítem</label>
                <input type="text" class="form-control" name="item_ingreso" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Tipo de Dispositivo</label>
                <select class="form-control" name="tipo_dispositivo_ingreso" id="tipo_dispositivo_ingreso" required onchange="toggleInventarioTab('ingreso')">
                  <option value="">Seleccione tipo</option>
                  <option value="interno">Interno</option>
                  <option value="externo">Externo</option>
                </select>
              </div>
            </div>
            
            <!-- Tab de Inventario para Ingresos -->
            <div class="col-12 mb-3" id="inventario_tab_ingreso" style="display: none;">
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
              <div class="form-group">
                <label>Descripción Dispositivo</label>
                <input type="text" class="form-control" name="descripcion_dispositivo_ingreso" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Marca</label>
                <input type="text" class="form-control" name="marca_ingreso" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Modelo</label>
                <input type="text" class="form-control" name="modelo_ingreso" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Número Activo</label>
                <input type="text" class="form-control" name="numero_activo_ingreso" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Serial</label>
                <input type="text" class="form-control" name="serial_ingreso" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Dependencia</label>
                <input type="text" class="form-control" name="dependencia_ingreso" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Observaciones</label>
                <textarea class="form-control" name="observaciones_ingreso" rows="3"></textarea>
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
