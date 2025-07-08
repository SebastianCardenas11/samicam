<!-- Modal para ver funcionario -->
<div class="modal fade" id="modalViewFuncionario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-dark">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
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
                                <th scope="row" class="text-dark">Identificación:</th>
                                <td id="celIdentificacion" class="text-dark">0</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-dark">Cargo:</th>
                                <td id="celCargoFuncionario" class="text-dark">0</td>
                            </tr>
                            <tr class="bg-light">
                                <th scope="row" class="text-dark">Dependencia:</th>
                                <td id="celDependenciaFuncionario" class="text-dark">0</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-dark">Fecha de Ingreso:</th>
                                <td id="celFechaIngreso" class="text-dark">0</td>
                            </tr>
                            <tr class="bg-light">
                                <th scope="row" class="text-dark">Años de Servicio:</th>
                                <td id="celAnosServicio" class="text-dark">0</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-dark">Períodos Disponibles:</th>
                                <td id="celPeriodosDisponibles" class="text-dark">0</td>
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
                                <label for="txtFechaInicio" class="form-label">Fecha de Salida <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="txtFechaInicio" name="txtFechaInicio" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="txtFechaFin" class="form-label">Fecha de Ingreso <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="txtFechaFin" name="txtFechaFin" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="listTipoVacaciones" class="form-label">Tipo de Vacaciones <span class="text-danger">*</span></label>
                                <select class="form-control" id="listTipoVacaciones" name="listTipoVacaciones" required>
                                    <option value="Disfrutadas">Disfrutadas</option>
                                    <option value="Compensadas">Compensadas</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="txtValor" class="form-label">Valor</label>
                                <input type="number" class="form-control" id="txtValor" name="txtValor" min="0" step="0.01" placeholder="Valor de las vacaciones">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="fechaPago" class="form-label">Fecha y hora de entrega del dinero</label>
                                <input type="datetime-local" class="form-control" id="fechaPago" name="fechaPago">
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
        <div class="modal-content text-dark">
            <div class="modal-header header-primary">
                <h5 class="modal-title">Historial de Vacaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                    <h6 id="funcionarioHistorial"></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th class="text-dark">Fecha Inicio</th>
                                    <th class="text-dark">Fecha Fin</th>
                                    <th class="text-dark">Período</th>
                                    <th class="text-dark">Tipo</th>
                                    <th class="text-dark">Valor</th>
                                    <th class="text-dark">Estado</th>
                                    <th class="text-dark">Acciones</th>
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