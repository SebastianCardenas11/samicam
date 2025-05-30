<div class="modal fade" id="modalViewTarea" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la Tarea</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>ID:</td>
              <td id="celId"></td>
            </tr>
            <tr>
              <td>Creado por:</td>
              <td id="celCreador"></td>
            </tr>
            <tr>
              <td>Asignado a:</td>
              <td id="celAsignado"></td>
            </tr>
            <tr>
              <td>Tipo:</td>
              <td id="celTipo"></td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescripcion"></td>
            </tr>
            <tr>
              <td>Dependencia:</td>
              <td id="celDependencia"></td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado"></td>
            </tr>
            <tr>
              <td>Observación:</td>
              <td id="celObservacion"></td>
            </tr>
            <tr>
              <td>Fecha de inicio:</td>
              <td id="celFechaInicio"></td>
            </tr>
            <tr>
              <td>Fecha de fin:</td>
              <td id="celFechaFin"></td>
            </tr>
            <tr>
              <td>Tiempo restante:</td>
              <td id="celTiempoRestante"></td>
            </tr>
            <tr>
              <td>Fecha de creación:</td>
              <td id="celFechaCreacion"></td>
            </tr>
          </tbody>
        </table>
        <div class="text-center" id="divEditarObservacion">
          <button class="btn btn-primary" type="button" onclick="openModalObservacion();"><i class="fas fa-edit"></i> Editar observación</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>