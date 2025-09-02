<?php 
    headerAdmin($data); 
?>
<div id="contentAjax"></div> 
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-clipboard-list"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/peticiones"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>



    <!-- Tarjetas minimalistas -->
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary" id="totalPeticiones">0</h5>
                    <p class="card-text">Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-info" id="enProceso">0</h5>
                    <p class="card-text">En Proceso</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-warning" id="proximasVencer">0</h5>
                    <p class="card-text">Próximas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-danger" id="vencidas">0</h5>
                    <p class="card-text">Vencidas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de peticiones -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <?php if($_SESSION['permisosMod']['w']){ ?>
                    <button class="btn btn-warning" type="button" onclick="openModal()">
                        <i class="fas fa-plus"></i> Nueva Peticion
                    </button>
                    <?php } ?>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablePeticiones">
                            <div class="mb-2">
                                <button class="btn btn-success btn-sm" onclick="exportExcel()">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                            </div>
                            <thead>
                                <tr>
                                    <th>Radicado</th>
                                    <th>Peticionario</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal para Nueva/Editar Petición -->
<div class="modal fade" id="modalFormPeticion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Nueva Petición</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formPeticion" name="formPeticion">
                    <input type="hidden" id="idPeticion" name="idPeticion" value="">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label>Fecha de ingreso <span class="text-danger">*</span></label>
                            <input class="form-control mb-3" id="txtFechaIngreso" name="txtFechaIngreso" type="date" required>
                        </div>
                        <div class="col-md-6">
                            <label>Nombre del peticionario <span class="text-danger">*</span></label>
                            <input class="form-control mb-3" id="txtPeticionario" name="txtPeticionario" type="text" required>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label>Solicitud / Descripción <span class="text-danger">*</span></label>
                            <textarea class="form-control mb-3" id="txtDescripcion" name="txtDescripcion" rows="4" required></textarea>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label>Áreas responsables <span class="text-danger">*</span></label>
                            <input class="form-control mb-3" id="txtAreasResponsables" name="txtAreasResponsables" type="text" placeholder="Escriba las áreas responsables" required>
                        </div>
                        <div class="col-md-6">
                            <label>Fecha de remisión al área</label>
                            <input class="form-control mb-3" id="txtFechaRemision" name="txtFechaRemision" type="date">
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label>Tipo de petición <span class="text-danger">*</span></label>
                            <select class="form-control mb-3" id="listTipoPeticion" name="listTipoPeticion" required>
                                <option value="">Seleccionar</option>
                                <?php 
                                if(count($data['tipos_peticion']) > 0){
                                    foreach($data['tipos_peticion'] as $tipo){
                                        echo '<option value="'.$tipo['id_tipo'].'" data-dias="'.$tipo['dias_habiles_plazo'].'">'.$tipo['nombre'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Días a vencer</label>
                            <input class="form-control mb-3" id="txtDiasVencer" name="txtDiasVencer" type="number" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Fecha vencimiento total</label>
                            <input class="form-control mb-3" id="txtVencimientoTotal" name="txtVencimientoTotal" type="date" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label>Consecutivo / Tipo de envío</label>
                            <input class="form-control mb-3" id="txtConsecutivo" name="txtConsecutivo" type="text">
                        </div>
                        <div class="col-md-6">
                            <label>Observaciones</label>
                            <textarea class="form-control mb-3" id="txtObservaciones" name="txtObservaciones" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="btnActionForm" class="btn btn-success" type="submit">
                            <span id="btnText">Guardar</span>
                        </button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Petición -->
<div class="modal fade" id="modalViewPeticion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title">Información de la Petición</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="divInfoPeticion"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formResponder" name="formResponder" enctype="multipart/form-data">
                    <input type="hidden" id="idPeticionResponder" name="idPeticion" value="">
                    
                    <div class="form-group">
                        <label class="control-label">Respuesta <span class="required">*</span></label>
                        <textarea class="form-control" id="txtRespuesta" name="txtRespuesta" rows="5" placeholder="Escriba la respuesta a la petición" required=""></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Archivo de Respuesta (Opcional)</label>
                        <input class="form-control" id="fileRespuesta" name="fileRespuesta" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX, JPG, PNG</small>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-reply"></i> Responder Petición
                        </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRemitir" name="formRemitir">
                    <input type="hidden" id="idPeticionRemitir" name="idPeticion" value="">
                    
                    <div class="form-group">
                        <label class="control-label">Área a Remitir <span class="required">*</span></label>
                        <input class="form-control" id="txtAreaRemitida" name="txtAreaRemitida" type="text" placeholder="Escriba el nombre del área" required="">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Motivo de Remisión <span class="required">*</span></label>
                        <textarea class="form-control" id="txtMotivoRemision" name="txtMotivoRemision" rows="3" placeholder="Explique el motivo de la remisión" required=""></textarea>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-warning" type="submit">
                            <i class="fas fa-share"></i> Remitir Petición
                        </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Desistir Petición -->
<div class="modal fade" id="modalDesistirPeticion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Desistir Petición</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDesistir" name="formDesistir">
                    <input type="hidden" id="idPeticionDesistir" name="idPeticion" value="">
                    
                    <div class="alert alert-warning">
                        <strong>¡Atención!</strong> Esta acción marcará la petición como desistida. ¿Está seguro de continuar?
                    </div>

                    <div class="form-group">
                        <label class="control-label">Observaciones <span class="required">*</span></label>
                        <textarea class="form-control" id="txtObservacionesDesistir" name="txtObservaciones" rows="3" placeholder="Explique el motivo del desistimiento" required=""></textarea>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fas fa-times"></i> Desistir Petición
                        </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-primary" type="button" data-dismiss="modal">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php footerAdmin($data); ?>