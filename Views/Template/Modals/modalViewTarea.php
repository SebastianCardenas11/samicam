<div class="modal fade" id="modalViewTarea" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title text-white" id="titleModal">Datos de la Tarea</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <td class="fw-bold">ID:</td>
              <td id="celId"></td>
            </tr>
            <tr>
              <td class="fw-bold">Creado por:</td>
              <td id="celCreador"></td>
            </tr>
            <tr>
              <td class="fw-bold">Asignado a:</td>
              <td id="celAsignado"></td>
            </tr>
            <tr>
              <td class="fw-bold">Tipo:</td>
              <td id="celTipo"></td>
            </tr>
            <tr>
              <td class="fw-bold">Descripción:</td>
              <td id="celDescripcion"></td>
            </tr>
            <tr>
              <td class="fw-bold">Dependencia:</td>
              <td id="celDependencia"></td>
            </tr>
            <tr>
              <td class="fw-bold">Estado:</td>
              <td id="celEstado"></td>
            </tr>
            <tr>
              <td class="fw-bold">Observaciones:</td>
              <td id="celObservacion"></td>
            </tr>
            <tr>
              <td class="fw-bold">Fecha de inicio:</td>
              <td id="celFechaInicio"></td>
            </tr>
            <tr>
              <td class="fw-bold">Fecha de fin:</td>
              <td id="celFechaFin"></td>
            </tr>
            <tr>
              <td class="fw-bold">Tiempo restante:</td>
              <td id="celTiempoRestante"></td>
            </tr>
            <tr>
              <td class="fw-bold">Fecha completada:</td>
              <td id="celFechaCompletada"></td>
            </tr>
          </tbody>
        </table>
        <div class="text-center mt-3" id="divAgregarObservacion">
          <button class="btn btn-primary" type="button" onclick="openModalObservaciones(document.querySelector('#celId').innerText);"><i class="fas fa-comment-plus"></i> Agregar observación</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
.header-primary {
  background-color: #6c757d;
  color: white;
}
.fw-bold {
  font-weight: 600;
}
</style>