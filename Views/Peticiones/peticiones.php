<?php 
    headerAdmin($data); 
?>
<div id="contentAjax"></div> 
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-clipboard-list"></i> <?= $data['page_title'] ?></h1>
            <p>Gestión de Peticiones, Quejas, Reclamos y Sugerencias (PQRs)</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/peticiones"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>

    <!-- Dashboard de estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fas fa-clipboard-list fa-3x"></i>
                <div class="info">
                    <h4 id="totalPeticiones">0</h4>
                    <p><b>Total Peticiones</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-small info coloured-icon">
                <i class="icon fas fa-clock fa-3x"></i>
                <div class="info">
                    <h4 id="enProceso">0</h4>
                    <p><b>En Proceso</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fas fa-exclamation-triangle fa-3x"></i>
                <div class="info">
                    <h4 id="proximasVencer">0</h4>
                    <p><b>Próximas a Vencer</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-small danger coloured-icon">
                <i class="icon fas fa-times-circle fa-3x"></i>
                <div class="info">
                    <h4 id="vencidas">0</h4>
                    <p><b>Vencidas</b></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Semáforo de alertas -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="title"><i class="fas fa-traffic-light"></i> Semáforo de Peticiones</h3>
                    <p><small>Estado actual de las peticiones según días hábiles restantes</small></p>
                </div>
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-circle text-success"></i> Verde</h4>
                                <p>Más de 10 días hábiles disponibles</p>
                                <hr>
                                <p class="mb-0"><strong id="semaforoVerde">0</strong> peticiones</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-circle text-warning"></i> Amarillo</h4>
                                <p>Entre 6 y 10 días hábiles disponibles</p>
                                <hr>
                                <p class="mb-0"><strong id="semaforoAmarillo">0</strong> peticiones</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-circle text-danger"></i> Rojo</h4>
                                <p>5 días hábiles o menos disponibles</p>
                                <hr>
                                <p class="mb-0"><strong id="semaforoRojo">0</strong> peticiones</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de peticiones -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="title">Listado de Peticiones</h3>
                    <div class="btn-group">
                        <?php if($_SESSION['permisosMod']['w']){ ?>
                        <button class="btn btn-primary" type="button" onclick="openModal()">
                            <i class="fas fa-plus-circle"></i> Nueva Petición
                        </button>
                        <?php } ?>
                        <button class="btn btn-info" type="button" onclick="fntActualizarEstados()">
                            <i class="fas fa-sync-alt"></i> Actualizar Estados
                        </button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-download"></i> Reportes
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="fntGenerarReporte('vencidas')">Peticiones Vencidas</a>
                                <a class="dropdown-item" href="#" onclick="fntGenerarReporte('proximas_vencer')">Próximas a Vencer</a>
                                <a class="dropdown-item" href="#" onclick="fntGenerarReporte('respondidas')">Respondidas</a>
                                <a class="dropdown-item" href="#" onclick="fntGenerarReporte('por_dependencia')">Por Dependencia</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablePeticiones">
                            <thead>
                                <tr>
                                    <th>Radicado</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Peticionario</th>
                                    <th>Tipo</th>
                                    <th>Dependencia</th>
                                    <th>Estado</th>
                                    <th>Días Restantes</th>
                                    <th>Fecha Vencimiento</th>
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
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Petición</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPeticion" name="formPeticion" class="form-horizontal">
                    <input type="hidden" id="idPeticion" name="idPeticion" value="">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Número de Radicado <span class="required">*</span></label>
                                <input class="form-control" id="txtRadicado" name="txtRadicado" type="text" placeholder="Número de radicado" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Fecha de Ingreso <span class="required">*</span></label>
                                <input class="form-control" id="txtFechaIngreso" name="txtFechaIngreso" type="date" required="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Nombre del Peticionario <span class="required">*</span></label>
                        <input class="form-control" id="txtPeticionario" name="txtPeticionario" type="text" placeholder="Nombre completo del peticionario" required="">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Descripción de la Solicitud <span class="required">*</span></label>
                        <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" placeholder="Descripción detallada de la solicitud" required=""></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tipo de Petición <span class="required">*</span></label>
                                <select class="form-control" id="listTipoPeticion" name="listTipoPeticion" required="">
                                    <option value="">Seleccionar tipo</option>
                                    <?php 
                                    if(count($data['tipos_peticion']) > 0){
                                        foreach($data['tipos_peticion'] as $tipo){
                                            echo '<option value="'.$tipo['id_tipo'].'">'.$tipo['nombre'].' ('.$tipo['dias_habiles_plazo'].' días hábiles)</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Dependencia Responsable <span class="required">*</span></label>
                                <select class="form-control" id="listDependencia" name="listDependencia" required="">
                                    <option value="">Seleccionar dependencia</option>
                                    <?php 
                                    if(count($data['dependencias']) > 0){
                                        foreach($data['dependencias'] as $dependencia){
                                            echo '<option value="'.$dependencia['dependencia_pk'].'">'.$dependencia['nombre'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Observaciones</label>
                        <textarea class="form-control" id="txtObservaciones" name="txtObservaciones" rows="3" placeholder="Observaciones adicionales"></textarea>
                    </div>

                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit">
                            <i class="fas fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
                        </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">
                            <i class="fas fa-fw fa-lg fa-times-circle"></i>Cerrar
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
                        <select class="form-control" id="listAreaRemitida" name="listAreaRemitida" required="">
                            <option value="">Seleccionar área</option>
                            <?php 
                            if(count($data['dependencias']) > 0){
                                foreach($data['dependencias'] as $dependencia){
                                    echo '<option value="'.$dependencia['dependencia_pk'].'">'.$dependencia['nombre'].'</option>';
                                }
                            }
                            ?>
                        </select>
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