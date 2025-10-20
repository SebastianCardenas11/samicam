<!-- Modal -->
<div class="modal fade" id="modalViewEquipo" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f8f6f0; border-bottom: 1px solid #dee2e6;">
        <h5 class="modal-title text-dark" id="titleModal">Información del Equipo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 1.5rem; color: #000; opacity: 0.5;">&times;</button>
      </div>
      <div class="modal-body">
        <!-- Información Básica -->
        <div class="card mb-3">
          <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información Básica</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>Tipo:</strong> <span id="celTipo"></span></p>
                <p><strong>Número:</strong> <span id="celNumero"></span></p>
                <p><strong>Marca:</strong> <span id="celMarca"></span></p>
              </div>
              <div class="col-md-6">
                <p><strong>Modelo:</strong> <span id="celModelo"></span></p>
                <p><strong>Serial:</strong> <span id="celSerial"></span></p>
                <p><strong>Estado:</strong> <span id="celEstado"></span></p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Estado y Ubicación -->
        <div class="card mb-3">
          <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-map-marker-alt"></i> Estado y Ubicación</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>Disponibilidad:</strong> <span id="celDisponibilidad"></span></p>
                <p><strong>Dependencia:</strong> <span id="celDependencia"></span></p>
              </div>
              <div class="col-md-6">
                <p><strong>Oficina:</strong> <span id="celOficina"></span></p>
                <p><strong>Fecha Registro:</strong> <span id="celFechaRegistro"></span></p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Especificaciones Técnicas -->
        <div class="card mb-3" id="especsComputadora" style="display: none;">
          <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-microchip"></i> Especificaciones Técnicas</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>RAM:</strong> <span id="celRam"></span></p>
                <p><strong>Procesador:</strong> <span id="celProcesador"></span></p>
              </div>
              <div class="col-md-6">
                <p><strong>Disco Duro:</strong> <span id="celDiscoDuro"></span></p>
                <p><strong>Sistema Operativo:</strong> <span id="celSistemaOperativo"></span></p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Especificaciones Impresora -->
        <div class="card mb-3" id="especsImpresora" style="display: none;">
          <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-print"></i> Especificaciones</h6>
          </div>
          <div class="card-body">
            <p><strong>Consumible:</strong> <span id="celConsumible"></span></p>
          </div>
        </div>
        
        <!-- Especificaciones Escáner -->
        <div class="card mb-3" id="especsEscaner" style="display: none;">
          <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-scanner"></i> Especificaciones</h6>
          </div>
          <div class="card-body">
            <p><strong>Tipo:</strong> Escáner</p>
          </div>
        </div>
        
        <!-- Funcionario Actual -->
        <div class="card mb-3">
          <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-user"></i> Funcionario Asignado</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <p><strong>Funcionario Actual:</strong> <span id="celFuncionarioActual">Sin asignar</span></p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Historial de Funcionarios -->
        <div class="card mb-3">
          <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-history"></i> Historial de Funcionarios</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm table-striped">
                <thead>
                  <tr>
                    <th>Funcionario</th>
                    <th>Fecha Asignación</th>
                    <th>Fecha Desasignación</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody id="tbodyHistorialFuncionarios">
                  <tr>
                    <td colspan="4" class="text-center">Cargando historial...</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>