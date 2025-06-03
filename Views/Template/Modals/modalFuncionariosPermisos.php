<!-- Modal para ver funcionario -->
<div class="modal fade" id="modalViewFuncionario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-dark">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="tile-body">
                    <!-- Foto del funcionario -->
                    <div class="text-center mb-3">
                        <img id="celImagenFuncionario" src="<?= media(); ?>/images/funcionarios/user.png" alt="Foto funcionario" class="img-thumbnail rounded-circle" style="width:150px; height:150px;">
                    </div>
                    <table class="table table-bordered align-middle mb-0">
                        <tbody>
                            <tr class="bg-light">
                                <th scope="row" class="text-dark">ID:</th>
                                <td id="celIdeFuncionario" class="text-dark">0</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-dark">Nombre Completo:</th>
                                <td id="celNombresFuncionario" class="text-dark">0</td>
                            </tr>
                            <tr class="bg-light">
                                <th scope="row" class="text-dark">Cargo:</th>
                                <td id="celCargoFuncionario" class="text-dark">0</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-dark">Dependencia:</th>
                                <td id="celDependenciaFuncionario" class="text-dark">0</td>
                            </tr>
                            <tr class="bg-light">
                                <th scope="row" class="text-dark">Permisos usados este mes:</th>
                                <td id="celPermisosMes" class="text-dark">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        <i class="bi bi-check2"></i> Listo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear permiso -->
<div class="modal fade" id="modalFormPermiso" tabindex="-1" aria-labelledby="modalFormPermiso" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Permiso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formPermiso" name="formPermiso" method="POST">
                            <input type="hidden" id="idFuncionario" name="idFuncionario" value="">
                            
                            <div class="form-group mb-3">
                                <label for="txtNombreFuncionario" class="form-label">Funcionario</label>
                                <input type="text" class="form-control" id="txtNombreFuncionario" name="txtNombreFuncionario" readonly>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="txtFechaPermiso" class="form-label">Fecha del Permiso <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="txtFechaPermiso" name="txtFechaPermiso" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="listMotivoPermiso" class="form-label">Motivo <span class="text-danger">*</span></label>
                                <select class="form-select" id="listMotivoPermiso" name="listMotivoPermiso" required>
                                    <option value="">Seleccione un motivo</option>
                                </select>
                            </div>
                            
                            <div class="alert alert-info" role="alert">
                                <p id="permisosMesInfo">Permisos utilizados este mes: <span id="permisosUsados">0</span>/3</p>
                            </div>
                            
                            <div id="divPermisoEspecial" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="txtJustificacionEspecial" class="form-label">Justificación del Permiso Especial <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="txtJustificacionEspecial" name="txtJustificacionEspecial" rows="3" placeholder="Explique detalladamente el motivo del permiso especial"></textarea>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-success" type="submit">
                                    <i class="bi bi-floppy"></i> <span id="btnText">Guardar</span>
                                </button>
                                <button id="btnPermisoEspecial" class="btn btn-warning" type="button" style="display: none;">
                                    <i class="bi bi-exclamation-triangle"></i> Solicitar Permiso Especial
                                </button>
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg"></i> Cerrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver historial de permisos -->
<div class="modal fade" id="modalHistorialPermisos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content text-dark">
            <div class="modal-header header-primary">
                <h5 class="modal-title">Historial de Permisos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                    <h6 id="funcionarioHistorial"></h6>
                    <!-- Foto del funcionario -->
                    <div class="text-center mb-3">
                        <img id="imgFuncionarioHistorial" src="<?= media(); ?>/images/funcionarios/user.png" alt="Foto funcionario" class="img-thumbnail rounded-circle" style="width:100px; height:100px;">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th class="text-dark">Fecha</th>
                                    <th class="text-dark">Motivo</th>
                                    <th class="text-dark">Estado</th>
                                    <th class="text-dark">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableHistorialPermisos">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGenerarPDF">
                        <i class="bi bi-file-pdf"></i> Generar PDF Completo
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>