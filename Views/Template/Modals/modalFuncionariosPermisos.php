<!-- Modal para ver funcionario -->
<div class="modal fade" id="modalViewFuncionario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>ID:</td>
                                    <td id="celIdeFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Nombre Completo:</td>
                                    <td id="celNombresFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Cargo:</td>
                                    <td id="celCargoFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Dependencia:</td>
                                    <td id="celDependenciaFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Permisos usados este mes:</td>
                                    <td id="celPermisosMes">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal"><i
                                class="bi bi-check2"></i>Listo</button>
                    </div>
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
                            
                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-success" type="submit">
                                    <i class="bi bi-floppy"></i> <span id="btnText">Guardar</span>
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
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title">Historial de Permisos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <h6 id="funcionarioHistorial"></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Motivo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="tableHistorialPermisos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnGenerarPDF">
                            <i class="bi bi-file-pdf"></i> Generar PDF
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>