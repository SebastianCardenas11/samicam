<!-- Modal para Peticiones -->
<div class="modal fade" id="modalFormPeticion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Petición</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPeticion" name="formPeticion">
                    <input type="hidden" id="idPeticion" name="idPeticion" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtNumeroRadicado" class="form-label">Número de Radicado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtNumeroRadicado" name="txtNumeroRadicado" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtFechaIngreso" class="form-label">Fecha de Ingreso <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="txtFechaIngreso" name="txtFechaIngreso" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtNombrePeticionario" class="form-label">Nombre del Peticionario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtNombrePeticionario" name="txtNombrePeticionario" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="listTipoPeticion" class="form-label">Tipo de Petición <span class="text-danger">*</span></label>
                                <select class="form-control" id="listTipoPeticion" name="listTipoPeticion" required>
                                    <option value="">Seleccionar...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="listDependencia" class="form-label">Dependencia Responsable <span class="text-danger">*</span></label>
                                <select class="form-control" id="listDependencia" name="listDependencia" required>
                                    <option value="">Seleccionar...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtDescripcionSolicitud" class="form-label">Descripción de la Solicitud <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="txtDescripcionSolicitud" name="txtDescripcionSolicitud" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtObservaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="txtObservaciones" name="txtObservaciones" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
                        </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                            <i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Responder Petición -->
<div class="modal fade" id="modalResponderPeticion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Responder Petición</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formResponderPeticion" name="formResponderPeticion" enctype="multipart/form-data">
                    <input type="hidden" id="idPeticionResponder" name="idPeticionResponder" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtComentarioRespuesta" class="form-label">Comentario de Respuesta <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="txtComentarioRespuesta" name="txtComentarioRespuesta" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fileArchivoRespuesta" class="form-label">Archivo de Respuesta (Opcional)</label>
                                <input type="file" class="form-control" id="fileArchivoRespuesta" name="fileArchivoRespuesta" accept=".pdf,.doc,.docx">
                                <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 5MB</small>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Responder
                        </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                            <i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Remitir Petición -->
<div class="modal fade" id="modalRemitirPeticion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Remitir Petición</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRemitirPeticion" name="formRemitirPeticion">
                    <input type="hidden" id="idPeticionRemitir" name="idPeticionRemitir" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="listAreaRemitida" class="form-label">Área a Remitir <span class="text-danger">*</span></label>
                                <select class="form-control" id="listAreaRemitida" name="listAreaRemitida" required>
                                    <option value="">Seleccionar...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtMotivoRemision" class="form-label">Motivo de Remisión <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="txtMotivoRemision" name="txtMotivoRemision" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-warning" type="submit">
                            <i class="fa fa-fw fa-lg fa-share"></i>Remitir
                        </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                            <i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalles -->
<div class="modal fade" id="modalVerPeticion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Petición</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contentAjax">
                <!-- Contenido cargado dinámicamente -->
            </div>
        </div>
    </div>
</div>