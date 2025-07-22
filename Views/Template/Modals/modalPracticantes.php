<!-- Modal -->
<div class="modal fade" id="modalFormPracticante" tabindex="-1" aria-labelledby="modalFormPracticante" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Practicante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="tile-body">
                        <form id="formPracticante" name="formPracticante" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="idePracticante" name="idePracticante" value="">

                            <div class="row mb-4">
                                <div class="col-12">
                                    <p class="text-primary fw-bold">Los campos con asterisco (<span class="required text-danger">*</span>) son obligatorios.</p>
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 - Datos personales -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Datos Personales</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Nombre completo -->
                                            <div class="mb-3">
                                                <label for="txtNombrePracticante" class="form-label">Nombre completo <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control valid validText" id="txtNombrePracticante"
                                                    name="txtNombrePracticante" required maxlength="50">
                                            </div>

                                            <!-- Identificación -->
                                            <div class="mb-3">
                                                <label for="txtIdentificacionPracticante" class="form-label">Identificación <b class="required text-danger">*</b></label>
                                                <input type="number" class="form-control" id="txtIdentificacionPracticante"
                                                    name="txtIdentificacionPracticante">
                                            </div>

                                            <!-- ARL -->
                                            <div class="mb-3">
                                                <label for="txtArlPracticante" class="form-label">ARL <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtArlPracticante" name="txtArlPracticante">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Sura">Sura</option>
                                                    <option value="Positiva">Positiva</option>
                                                    <option value="Aseguradora_solidaria">Aseguradora solidaria</option>
                                                    <option value="Colpatria">Colpatria</option>
                                                    <option value="Sura">Sura</option>
                                                    <option value="Colmena">Colmena</option>
                                                    <option value="Bolívar">Bolívar</option>
                                                </select>
                                            </div>

                                            <!-- EPS -->
                                            <div class="mb-3">
                                                <label for="txtEpsPracticante" class="form-label">EPS <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtEpsPracticante" name="txtEpsPracticante">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Nueva EPS">Nueva EPS</option>
                                                    <option value="Asmet salud">Asmet salud</option>
                                                    <option value="Fomag">Fomag</option>
                                                    <option value="Cajacopi EPS">Cajacopi EPS</option>
                                                    <option value="eps_suramericana">Eps suramericana S.A</option>
                                                    <option value="Salud Total EPS">Salud Total EPS</option>
                                                    <option value="Coomeva Eps">Coomeva Eps</option>
                                                    <option value="Sanitas EPS">Sanitas EPS</option>
                                                    <option value="Coosalud EPS">Coosalud EPS</option>
                                                    <option value="Sura EPS">Sura EPS</option>
                                                    <option value="Aliansalud EPS">Aliansalud EPS</option>
                                                    <option value="Mutual SER EPS">Mutual SER EPS</option>
                                                    <option value="Salud Mía EPS">Salud Mía EPS</option>
                                                </select>
                                            </div>

                                            <!-- Edad -->
                                            <div class="mb-3">
                                                <label for="txtEdadPracticante" class="form-label">Edad <b class="required text-danger">*</b></label>
                                                <input type="number" class="form-control" id="txtEdadPracticante"
                                                    name="txtEdadPracticante" min="16" max="100">
                                            </div>

                                            <!-- Sexo -->
                                            <div class="mb-3">
                                                <label for="txtSexoPracticante" class="form-label">Sexo <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtSexoPracticante" name="txtSexoPracticante">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="masculino">Masculino</option>
                                                    <option value="femenino">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 2 - Información de contacto -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información de Contacto</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Correo -->
                                            <div class="mb-3">
                                                <label for="txtCorreoPracticante" class="form-label">Correo electrónico <b class="required text-danger">*</b></label>
                                                <input type="email" class="form-control" id="txtCorreoPracticante"
                                                    name="txtCorreoPracticante" required>
                                            </div>

                                            <!-- Teléfono -->
                                            <div class="mb-3">
                                                <label for="txtTelefonoPracticante" class="form-label">Teléfono <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control" id="txtTelefonoPracticante"
                                                    name="txtTelefonoPracticante">
                                            </div>

                                            <!-- Dirección -->
                                            <div class="mb-3">
                                                <label for="txtDireccionPracticante" class="form-label">Dirección <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control" id="txtDireccionPracticante"
                                                    name="txtDireccionPracticante">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 3 - Información laboral -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Laboral</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Dependencia -->
                                            <div class="mb-3">
                                                <label for="txtDependenciaPracticante" class="form-label">Dependencia <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtDependenciaPracticante" name="txtDependenciaPracticante">
                                                    <option value="">Selecciona una opción</option>
                                                    <?php foreach ($data['dependencias'] as $dep): ?>
                                                        <option value="<?= $dep['dependencia_pk'] ?>"><?= $dep['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Cargo a hacer -->
                                            <div class="mb-3">
                                                <label for="txtCargoHacerPracticante" class="form-label">Cargo a hacer <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control" id="txtCargoHacerPracticante"
                                                    name="txtCargoHacerPracticante">
                                            </div>

                                            <!-- Fecha de ingreso -->
                                            <div class="mb-3">
                                                <label for="txtFechaIngreso" class="form-label">Fecha de ingreso <b class="required text-danger">*</b></label>
                                                <input type="date" class="form-control" id="txtFechaIngreso"
                                                    name="txtFechaIngreso">
                                            </div>

                                            <!-- Fecha de salida -->
                                            <div class="mb-3">
                                                <label for="txtFechaSalida" class="form-label">Fecha de salida <b class="required text-danger">*</b></label>
                                                <input type="date" class="form-control" id="txtFechaSalida"
                                                    name="txtFechaSalida">
                                            </div>

                                            <!-- Tipo de contrato -->
                                            <div class="mb-3">
                                                <label for="txtContratoPracticante" class="form-label">Tipo de contrato <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtContratoPracticante" name="txtContratoPracticante">
                                                    <option value="">Selecciona una opción</option>
                                                    <?php foreach ($data['contratos'] as $cont): ?>
                                                        <option value="<?= $cont['id_contrato_practicante'] ?>"><?= $cont['nombre_contrato'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Estado -->
                                            <div class="mb-3">
                                                <label for="listStatus" class="form-label">Estado <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="listStatus" name="listStatus">
                                                    <option value="1">Activo</option>
                                                    <option value="2">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nueva fila para información académica -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Académica</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Formación académica -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="txtFormacionAcademica" class="form-label">Formación académica <b class="required text-danger">*</b></label>
                                                        <select class="form-select" id="txtFormacionAcademica" name="txtFormacionAcademica">
                                                            <option value="">Selecciona una opción</option>
                                                            <option value="Técnico">Técnico</option>
                                                            <option value="Tecnólogo">Tecnólogo</option>
                                                            <option value="Profesional">Profesional</option>
                                                           
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Programa de estudio -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="txtProgramaEstudio" class="form-label">Programa de estudio <b class="required text-danger">*</b></label>
                                                        <input type="text" class="form-control" id="txtProgramaEstudio"
                                                            name="txtProgramaEstudio" placeholder="Ej: Técnico en Sistemas">
                                                    </div>
                                                </div>

                                                <!-- Institución educativa -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="txtInstitucionEducativa" class="form-label">Institución educativa <b class="required text-danger">*</b></label>
                                                        <input type="text" class="form-control" id="txtInstitucionEducativa"
                                                            name="txtInstitucionEducativa" placeholder="Ej: SENA, Universidad, etc.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones con mejor espaciado -->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-3">
                                        <button class="btn btn-danger px-4 py-2" type="button" data-bs-dismiss="modal">
                                            <i class="bi bi-x-lg me-2"></i>Cerrar
                                        </button>
                                        <button class="btn btn-success px-4 py-2" type="submit" id="btnActionForm">
                                            <i class="bi bi-check-lg me-2"></i>Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver información del practicante -->
<div class="modal fade" id="modalViewPracticante" tabindex="-1" aria-labelledby="modalViewPracticante" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información del Practicante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Datos Personales</h6>
                        <p><strong>Nombre:</strong> <span id="viewNombre"></span></p>
                        <p><strong>Identificación:</strong> <span id="viewIdentificacion"></span></p>
                        <p><strong>ARL:</strong> <span id="viewArl"></span></p>
                        <p><strong>EPS:</strong> <span id="viewEps"></span></p>
                        <p><strong>Edad:</strong> <span id="viewEdad"></span></p>
                        <p><strong>Sexo:</strong> <span id="viewSexo"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Información de Contacto</h6>
                        <p><strong>Correo:</strong> <span id="viewCorreo"></span></p>
                        <p><strong>Teléfono:</strong> <span id="viewTelefono"></span></p>
                        <p><strong>Dirección:</strong> <span id="viewDireccion"></span></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Información Laboral</h6>
                        <p><strong>Dependencia:</strong> <span id="viewDependencia"></span></p>
                        <p><strong>Cargo a hacer:</strong> <span id="viewCargoHacer"></span></p>
                        <p><strong>Fecha de ingreso:</strong> <span id="viewFechaIngreso"></span></p>
                        <p><strong>Fecha de salida:</strong> <span id="viewFechaSalida"></span></p>
                        <p><strong>Días restantes:</strong> <span id="viewDiasRestantes"></span></p>
                        <p><strong>Tipo de contrato:</strong> <span id="viewTipoContrato"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Información Académica</h6>
                        <p><strong>Formación académica:</strong> <span id="viewFormacionAcademica"></span></p>
                        <p><strong>Programa de estudio:</strong> <span id="viewProgramaEstudio"></span></p>
                        <p><strong>Institución educativa:</strong> <span id="viewInstitucionEducativa"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> 