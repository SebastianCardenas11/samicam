<!-- Modal -->
<div class="modal fade" id="modalViewEquipo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Información del Equipo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Tipo de Equipo:</strong></label>
              <p id="celTipo"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Número de Equipo:</strong></label>
              <p id="celNumero"></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Marca:</strong></label>
              <p id="celMarca"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Modelo:</strong></label>
              <p id="celModelo"></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Serial:</strong></label>
              <p id="celSerial"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Estado:</strong></label>
              <p id="celEstado"></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Disponibilidad:</strong></label>
              <p id="celDisponibilidad"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Dependencia:</strong></label>
              <p id="celDependencia"></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Oficina:</strong></label>
              <p id="celOficina"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Fecha de Registro:</strong></label>
              <p id="celFechaRegistro"></p>
            </div>
          </div>
        </div>
        
        <!-- Campos específicos para computadoras -->
        <div id="especsComputadora" style="display: none;">
          <hr>
          <h6><strong>Especificaciones Técnicas</strong></h6>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>RAM:</strong></label>
                <p id="celRam"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Procesador:</strong></label>
                <p id="celProcesador"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Disco Duro:</strong></label>
                <p id="celDiscoDuro"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Sistema Operativo:</strong></label>
                <p id="celSistemaOperativo"></p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Campos específicos para impresoras -->
        <div id="especsImpresora" style="display: none;">
          <hr>
          <h6><strong>Especificaciones</strong></h6>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label><strong>Consumible:</strong></label>
                <p id="celConsumible"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>