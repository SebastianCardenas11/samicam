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
                <div class="">
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
                                    <td>Identificación:</td>
                                    <td id="celIdentificacion">0</td>
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
                                    <td>Fecha de Ingreso:</td>
                                    <td id="celFechaIngreso">0</td>
                                </tr>
                                <tr>
                                    <td>Años de Servicio:</td>
                                    <td id="celAnosServicio">0</td>
                                </tr>
                                <tr>
                                    <td>Períodos Disponibles:</td>
                                    <td id="celPeriodosDisponibles">0</td>
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

<!-- Modal para registrar vacaciones -->
<div class="modal fade" id="modalFormVacaciones" tabindex="-1" aria-labelledby="modalFormVacaciones" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Registrar Vacaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="tile-body">
                        <form id="formVacaciones" name="formVacaciones" method="POST">
                            <input type="hidden" id="idFuncionario" name="idFuncionario" value="">
                            <input type="hidden" id="listPeriodo" name="listPeriodo" value="1">
                            
                            <div class="form-group mb-3">
                                <label for="txtNombreFuncionario" class="form-label">Funcionario</label>
                                <input type="text" class="form-control" id="txtNombreFuncionario" name="txtNombreFuncionario" readonly>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="txtFechaInicio" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="txtFechaInicio" name="txtFechaInicio" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="txtFechaFin" class="form-label">Fecha de Fin <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="txtFechaFin" name="txtFechaFin" required>
                            </div>
                            
                            <div class="alert alert-info" role="alert">
                                <p id="periodosInfo">Períodos disponibles: <span id="periodosDisponibles">0</span>/3</p>
                                <p class="mb-0">Las vacaciones quedarán en estado "Pendiente" hasta su aprobación.</p>
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

<!-- Modal para ver historial de vacaciones -->
<div class="modal fade" id="modalHistorialVacaciones" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title">Historial de Vacaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="tile-body">
                        <h6 id="funcionarioHistorial"></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Período</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tableHistorialVacaciones">
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