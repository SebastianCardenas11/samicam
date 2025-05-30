<div class="modal fade" id="modalFormObservacion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Observación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formObservacion" name="formObservacion" class="form-horizontal">
          <input type="hidden" id="idTareaObs" name="idTarea" value="">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="txtObservacionEdit">Observación</label>
              <textarea class="form-control" id="txtObservacionEdit" name="txtObservacion" rows="5" required></textarea>
            </div>
          </div>
          <div class="tile-footer">
            <button id="btnActionFormObs" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span>Actualizar</span></button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>