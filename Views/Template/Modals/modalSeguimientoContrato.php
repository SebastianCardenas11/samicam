<!-- Modal -->
<div class="modal fade" id="modalFormSeguimientoContrato" tabindex="-1" aria-labelledby="modalFormSeguimientoContrato" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSeguimientoContrato" name="formSeguimientoContrato" class="form-horizontal">
                    <input type="hidden" id="id" name="id" value="">
                    <p class="text-danger">Todos los campos son obligatorios.</p>

                    <div class="row">
                      <div class="col-md-6">
                            <label for="numero_contrato">Número de Contrato</label>
                            <input type="text" class="form-control" id="numero_contrato" name="numero_contrato" required>
                            
                        </div>
                         <div class="col-md-6">
                            <label for="fecha_aprobacion_entidad">Fecha de Aprobación de la Entidad</label>
                            <input type="date" class="form-control" id="fecha_aprobacion_entidad" name="fecha_aprobacion_entidad" required>
                        </div>
                        <div class="col-md-12">
                            <label for="objeto_contrato">Objeto del Contrato</label>
                            <textarea id="objeto_contrato" class="form-control" name="objeto_contrato" rows="2" required></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_terminacion">Fecha de Terminación</label>
                            <input type="date" class="form-control" id="fecha_terminacion" name="fecha_terminacion" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="plazo">Plazo</label>
                            <input type="number" class="form-control" id="plazo" name="plazo" required>
                        </div>
                        <div class="col-md-2">
                            <label for="tipo_plazo">Tipo</label>
                            <select class="form-control" id="tipo_plazo" name="tipo_plazo" required>
                                <option value="dias">Días</option>
                                <option value="meses" selected>Meses</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="valor_total_contrato">Valor Total del Contrato</label>
                            <input type="number" class="form-control" id="valor_total_contrato" name="valor_total_contrato" step="0.01" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="dia_corte_informe">Día de Corte de Informe</label>
                            <input type="date" class="form-control" id="dia_corte_informe" name="dia_corte_informe" required>
                        </div>
                         <div class="col-md-6">
                            <label for="evidenciado_secop">Evidenciado en SECOP 2</label>
                            <input type="text" class="form-control" id="evidenciado_secop" name="evidenciado_secop">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="observaciones_ejecucion">Observaciones de Ejecución</label>
                            <textarea id="observaciones_ejecucion" class="form-control" name="observaciones_ejecucion" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_verificacion">Fecha de Verificación</label>
                            <input type="date" class="form-control" id="fecha_verificacion" name="fecha_verificacion">
                        </div>
                        <div class="col-md-6">
                            <label for="liquidacion">Liquidación</label>
                            <input type="number" class="form-control" id="liquidacion" name="liquidacion" step="0.01" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="estado">Estado</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="1">En ejecucion</option>
                                <option value="2">Finalizado</option>
                                <option value="3">Liquidado</option>
                            </select>
                        </div>
                       
                    </div>
                    <br><br>

                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-warning" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Contrato -->
<div class="modal fade" id="modalViewContrato" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Contrato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Fecha Aprobación Entidad:</strong>
            <span id="celFechaAprobacionEntidad"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Número de Contrato:</strong>
            <span id="celNumeroContrato"></span>
          </li>
          <li class="list-group-item">
            <strong>Objeto del Contrato:</strong>
            <p class="mb-0" id="celObjetoContrato"></p>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Fecha Inicio:</strong>
            <span id="celFechaInicio"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Fecha Fin:</strong>
            <span id="celFechaTerminacion"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Plazo:</strong>
            <span id="celPlazo"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Valor Total del Contrato:</strong>
            <span id="celValorTotalContrato"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Día de Corte Informe:</strong>
            <span id="celDiaCorteInforme"></span>
          </li>
          <li class="list-group-item">
            <strong>Observaciones Ejecución:</strong>
            <p class="mb-0" id="celObservacionesEjecucion"></p>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Evidenciado Secop:</strong>
            <span id="celEvidenciadoSecop"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Fecha Verificación:</strong>
            <span id="celFechaVerificacion"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Liquidación:</strong>
            <span id="celLiquidacion"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Estado:</strong>
            <span id="celEstado"></span>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Prórroga -->
<div class="modal fade" id="modalProrrogaContrato" tabindex="-1" aria-labelledby="modalProrrogaContratoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formProrrogaContrato">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProrrogaContratoLabel">Prórroga de Contrato</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="prorroga_id_contrato" name="id_contrato">
          <div class="mb-3">
            <label for="prorroga_fecha_anterior" class="form-label">Fecha de terminación actual</label>
            <input type="date" class="form-control" id="prorroga_fecha_anterior" name="fecha_anterior" readonly>
          </div>
          <div class="mb-3">
            <label for="prorroga_nueva_fecha" class="form-label">Nueva fecha de terminación</label>
            <input type="date" class="form-control" id="prorroga_nueva_fecha" name="nueva_fecha" required>
            <div class="form-text text-primary" id="prorroga_dias_diferencia" style="font-weight:bold;"></div>
          </div>
          <div class="mb-3">
            <label for="prorroga_motivo" class="form-label">Motivo</label>
            <textarea class="form-control" id="prorroga_motivo" name="motivo" rows="2" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar Prórroga</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Historial de Prórrogas Individual -->
<div class="modal fade" id="modalHistorialProrrogas" tabindex="-1" aria-labelledby="modalHistorialProrrogasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHistorialProrrogasLabel"><i class="fas fa-history"></i> Historial de Prórrogas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-sm align-middle mb-0" id="tablaHistorialProrrogasIndividual">
            <thead class="table-light text-center">
              <tr>
                <th style="min-width:110px">Fecha anterior</th>
                <th style="min-width:110px">Nueva fecha</th>
                <th style="min-width:80px">Días</th>
                <th style="min-width:150px">Motivo</th>
                <th style="min-width:140px">Registrado</th>
              </tr>
            </thead>
            <tbody class="text-center align-middle">
              <!-- Aquí se cargará el historial por JS -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Adición -->
<div class="modal fade" id="modalAdicionContrato" tabindex="-1" aria-labelledby="modalAdicionContratoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formAdicionContrato">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAdicionContratoLabel">Adición de Contrato</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="adicion_id_contrato" name="id_contrato">
          <div class="mb-2">
            <label class="form-label">Valor Total del Contrato</label>
            <input type="text" class="form-control" id="adicion_valor_total_contrato" readonly>
          </div>
          <div class="mb-2">
            <label class="form-label">Máximo Permitido (50%)</label>
            <input type="text" class="form-control" id="adicion_valor_maximo" readonly>
          </div>
          <div class="mb-2">
            <label class="form-label">Adiciones Existentes</label>
            <input type="text" class="form-control" id="adicion_valor_usado" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Valor Disponible para Adiciones</strong></label>
            <input type="text" class="form-control bg-success text-white fw-bold" id="adicion_valor_disponible" readonly>
          </div>
          <div class="mb-3 text-center">
            <canvas id="graficoAdicionContrato" height="60"></canvas>
          </div>
          <div class="mb-3">
            <label for="adicion_valor" class="form-label">Valor de la Adición</label>
            <input type="number" class="form-control" id="adicion_valor" name="valor_adicion" step="0.01" min="0" required>
            <div class="form-text text-primary" id="adicion_validacion" style="font-weight:bold;"></div>
          </div>
          <div class="mb-3">
            <label for="adicion_motivo" class="form-label">Motivo</label>
            <textarea class="form-control" id="adicion_motivo" name="motivo" rows="2" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar Adición</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Historial de Adiciones Individual -->
<div class="modal fade" id="modalHistorialAdiciones" tabindex="-1" aria-labelledby="modalHistorialAdicionesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHistorialAdicionesLabel"><i class="fas fa-history"></i> Historial de Adiciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-sm align-middle mb-0" id="tablaHistorialAdicionesIndividual">
            <thead class="table-warning text-center">
              <tr>
                <th>Valor de la Adición</th>
                <th>Motivo</th>
                <th>Fecha de Adición</th>
              </tr>
            </thead>
            <tbody class="text-center align-middle">
              <!-- Aquí se cargará el historial por JS -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div> 