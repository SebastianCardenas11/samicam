<div class="modal fade" id="modalFormPublicaciones" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Nueva Publicación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPublicacion" name="formPublicacion" class="form-horizontal">
          <input type="hidden" id="idPublicacion" name="idPublicacion" value="">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtFechaRecibido" class="form-control-label">Fecha de Recibido</label>
                <input type="date" class="form-control" id="txtFechaRecibido" name="txtFechaRecibido" required="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtCorreoRecibido" class="form-control-label">Correo Recibido</label>
                <input type="email" class="form-control" id="txtCorreoRecibido" name="txtCorreoRecibido" required="">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtAsunto" class="form-control-label">Asunto</label>
            <input type="text" class="form-control" id="txtAsunto" name="txtAsunto" required="">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="txtFechaPublicacion" class="form-control-label">Fecha de Publicación</label>
                <input type="date" class="form-control" id="txtFechaPublicacion" name="txtFechaPublicacion">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtRespuestaEnvio" class="form-control-label">Respuesta de Envío</label>
            <textarea class="form-control" id="txtRespuestaEnvio" name="txtRespuestaEnvio" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="txtEnlacePublicacion" class="form-control-label">Enlace de Publicación</label>
            <input type="text" class="form-control" id="txtEnlacePublicacion" name="txtEnlacePublicacion">
          </div>
          <div class="form-group">
            <label for="listStatus" class="form-control-label">Estado</label>
            <select class="form-control" id="listStatus" name="listStatus" required="">
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="btnActionForm"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Ver Publicación -->
<div class="modal fade" id="modalViewPublicacion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Datos de la Publicación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
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
              <td>Fecha de Recibido:</td>
              <td id="celFechaRecibido"></td>
            </tr>
            <tr>
              <td>Correo Recibido:</td>
              <td id="celCorreoRecibido"></td>
            </tr>
            <tr>
              <td>Asunto:</td>
              <td id="celAsunto"></td>
            </tr>
            <tr>
              <td>Fecha de Publicación:</td>
              <td id="celFechaPublicacion"></td>
            </tr>
            <tr>
              <td>Respuesta de Envío:</td>
              <td id="celRespuestaEnvio"></td>
            </tr>
            <tr>
              <td>Enlace de Publicación:</td>
              <td id="celEnlacePublicacion"></td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>