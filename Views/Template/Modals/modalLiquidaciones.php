<!-- Modal Liquidaciones -->
<div class="modal fade" id="modalLiquidaciones" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Liquidación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formLiquidacion" name="formLiquidacion" class="form-horizontal">
          <input type="hidden" id="idLiquidacion" name="idLiquidacion" value="">
          
          <div class="row">
            <!-- Información del Contrato -->
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="control-label">Contrato <span class="required">*</span></label>
                <select class="form-control" id="listContratoLiq" name="listContratoLiq" required>
                  <option value="">Seleccionar contrato...</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="control-label">Tipo de Liquidación <span class="required">*</span></label>
                <select class="form-control" id="listTipoLiquidacion" name="listTipoLiquidacion" required>
                  <option value="">Seleccionar tipo...</option>
                  <option value="Parcial">Parcial</option>
                  <option value="Total">Total</option>
                  <option value="Anticipada">Anticipada</option>
                  <option value="Por Mutuo Acuerdo">Por Mutuo Acuerdo</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="control-label">Fecha de Liquidación <span class="required">*</span></label>
                <input class="form-control" id="txtFechaLiquidacion" name="txtFechaLiquidacion" type="date" required>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="control-label">Valor a Liquidar <span class="required">*</span></label>
                <input class="form-control" id="txtValorLiquidar" name="txtValorLiquidar" type="number" step="0.01" placeholder="0.00" required>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="control-label">Estado <span class="required">*</span></label>
                <select class="form-control" id="listEstadoLiquidacion" name="listEstadoLiquidacion" required>
                  <option value="">Seleccionar estado...</option>
                  <option value="Pendiente">Pendiente</option>
                  <option value="En Proceso">En Proceso</option>
                  <option value="Completada">Completada</option>
                  <option value="Rechazada">Rechazada</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="control-label">Responsable <span class="required">*</span></label>
                <input class="form-control" id="txtResponsableLiq" name="txtResponsableLiq" type="text" placeholder="Nombre del responsable" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="control-label">Número de Acta</label>
                <input class="form-control" id="txtNumeroActa" name="txtNumeroActa" type="text" placeholder="Número de acta de liquidación">
              </div>
            </div>
          </div>
          
          <!-- Detalles Financieros -->
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-primary mb-3"><i class="fas fa-money-bill-wave me-2"></i>Detalles Financieros</h6>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label class="control-label">Valor Ejecutado</label>
                <input class="form-control" id="txtValorEjecutado" name="txtValorEjecutado" type="number" step="0.01" placeholder="0.00">
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label class="control-label">Saldo por Ejecutar</label>
                <input class="form-control" id="txtSaldoPorEjecutar" name="txtSaldoPorEjecutar" type="number" step="0.01" placeholder="0.00">
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label class="control-label">Multas/Sanciones</label>
                <input class="form-control" id="txtMultas" name="txtMultas" type="number" step="0.01" placeholder="0.00">
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label class="control-label">Descuentos</label>
                <input class="form-control" id="txtDescuentos" name="txtDescuentos" type="number" step="0.01" placeholder="0.00">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label class="control-label">Observaciones</label>
                <textarea class="form-control" id="txtObservacionesLiq" name="txtObservacionesLiq" rows="4" placeholder="Observaciones sobre la liquidación..."></textarea>
              </div>
            </div>
          </div>
          
          <!-- Documentos -->
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-primary mb-3"><i class="fas fa-file-alt me-2"></i>Documentos de Soporte</h6>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="control-label">Acta de Liquidación</label>
                <input class="form-control" id="fileActaLiquidacion" name="fileActaLiquidacion" type="file" accept=".pdf,.doc,.docx">
                <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX</small>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="control-label">Documentos Adicionales</label>
                <input class="form-control" id="fileDocumentosAdicionales" name="fileDocumentosAdicionales" type="file" multiple accept=".pdf,.doc,.docx,.jpg,.png">
                <small class="form-text text-muted">Múltiples archivos permitidos</small>
              </div>
            </div>
          </div>
          
          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit">
              <i class="fas fa-save"></i> Guardar
            </button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
              <i class="fas fa-times"></i> Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ver Detalles Liquidación -->
<div class="modal fade" id="modalVerLiquidacion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerView">
        <h5 class="modal-title">Detalles de Liquidación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="contentViewLiquidacion">
          <!-- Contenido se carga dinámicamente -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>