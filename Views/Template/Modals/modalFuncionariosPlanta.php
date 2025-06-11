<!-- Modal -->
<div class="modal fade" id="modalFormFuncionario" tabindex="-1" aria-labelledby="modalFormUsuario" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="tile-body">
                        <form id="formFuncionario" name="formFuncionario" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideFuncionario" name="ideFuncionario" value="">

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
                                                <label for="txtNombreFuncionario" class="form-label">Nombre completo <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control valid validText" id="txtNombreFuncionario"
                                                    name="txtNombreFuncionario" required maxlength="50">
                                            </div>

                                            <!-- Foto -->
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Foto</label>
                                                <div class="prevPhoto">
                                                    <span class="delPhoto notBlock">X</span>
                                                    <label for="foto"></label>
                                                    <div>
                                                        <img id="img_funcionario" src="<?= media(); ?>/images/funcionarios/user.png">
                                                    </div>
                                                </div>
                                                <div class="upimg">
                                                    <input type="file" class="form-control" id="foto" name="foto"
                                                        accept="image/jpeg,image/png">
                                                </div>
                                                <div id="form_alert"></div>
                                                <input type="hidden" id="foto_actual" name="foto_actual" value="">
                                                <input type="hidden" id="foto_remove" name="foto_remove" value="0">
                                            </div>

                                            <!-- Identificación -->
                                            <div class="mb-3">
                                                <label for="txtIdentificacionFuncionario" class="form-label">Identificación <b class="required text-danger">*</b></label>
                                                <input type="number" class="form-control" id="txtIdentificacionFuncionario"
                                                    name="txtIdentificacionFuncionario">
                                            </div>

                                            <!-- Edad -->
                                            <div class="mb-3">
                                                <label for="txtEdadFuncionario" class="form-label">Edad <b class="required text-danger">*</b></label>
                                                <input type="number" class="form-control" id="txtEdadFuncionario"
                                                    name="txtEdadFuncionario">
                                            </div>

                                            <!-- Sexo -->
                                            <div class="mb-3">
                                                <label for="txtSexoFuncionario" class="form-label">Sexo <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtSexoFuncionario" name="txtSexoFuncionario">
                                                    <option>Selecciona una opción</option>
                                                    <option value="masculino">Masculino</option>
                                                    <option value="femenino">Femenino</option>
                                                </select>
                                            </div>

                                            <!-- Estado civil -->
                                            <div class="mb-3">
                                                <label for="txtEstadoCivilFuncionario" class="form-label">Estado civil <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtEstadoCivilFuncionario"
                                                    name="txtEstadoCivilFuncionario">
                                                    <option>Selecciona una opción</option>
                                                    <option value="soltero">Soltero</option>
                                                    <option value="casado">Casado</option>
                                                    <option value="divorciado">Divorciado</option>
                                                    <option value="viudo">Viudo</option>
                                                    <option value="union libre">Unión libre</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 2 - Información de contacto y laboral -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información de Contacto y Laboral</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Correo -->
                                            <div class="mb-3">
                                                <label for="txtCorreoFuncionario" class="form-label">Correo <b class="required text-danger">*</b></label>
                                                <input type="email" class="form-control" id="txtCorreoFuncionario"
                                                    name="txtCorreoFuncionario" required>
                                            </div>

                                            <!-- Celular -->
                                            <div class="mb-3">
                                                <label for="txtCelularFuncionario" class="form-label">Celular <b class="required text-danger">*</b></label>
                                                <input type="number" class="form-control" id="txtCelularFuncionario"
                                                    name="txtCelularFuncionario">
                                            </div>

                                            <!-- Dirección -->
                                            <div class="mb-3">
                                                <label for="txtDireccionFuncionario" class="form-label">Dirección <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control" id="txtDireccionFuncionario"
                                                    name="txtDireccionFuncionario">
                                            </div>

                                            <!-- Lugar de residencia -->
                                            <div class="mb-3">
                                                <label for="txtLugarResidenciaFuncionario" class="form-label">Lugar de residencia <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control" id="txtLugarResidenciaFuncionario"
                                                    name="txtLugarResidenciaFuncionario">
                                            </div>

                                            <!-- Religión -->
                                            <div class="mb-3">
                                                <label for="txtReligionFuncionario" class="form-label">Religión <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtReligionFuncionario" name="txtReligionFuncionario" required>
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="catolico">Católico</option>
                                                    <option value="cristiano">Cristiano</option>
                                                    <option value="ateo">Ateo</option>
                                                    <option value="no_creyente">No creyente</option>
                                                    <option value="otro">Otro</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 3 - Información laboral y académica -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Laboral y Académica</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Cargo -->
                                            <div class="mb-3">
                                                <label for="txtCargoFuncionario" class="form-label">Cargo <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtCargoFuncionario" name="txtCargoFuncionario">
                                                    <option>Selecciona una opción</option>
                                                    <?php foreach ($data['cargos'] as $car): ?>
                                                        <option value="<?= $car['idecargos'] ?>"><?= $car['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Dependencia -->
                                            <div class="mb-3">
                                                <label for="txtDependenciaFuncionario" class="form-label">Dependencia <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtDependenciaFuncionario" name="txtDependenciaFuncionario">
                                                    <option>Selecciona una opción</option>
                                                    <?php foreach ($data['dependencias'] as $dep): ?>
                                                        <option value="<?= $dep['dependencia_pk'] ?>"><?= $dep['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Tipo de Contrato -->
                                            <div class="mb-3">
                                                <label for="txtContrato" class="form-label">Tipo de Contrato <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtContrato" name="txtContrato">
                                                    <option>Selecciona una opción</option>
                                                    <?php foreach ($data['contrato'] as $cont): ?>
                                                        <option value="<?= $cont['id_contrato'] ?>"><?= $cont['tipo_cont'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Fecha de ingreso -->
                                            <div class="mb-3">
                                                <label for="txtFechaIngresoFuncionario" class="form-label">Fecha de ingreso <b class="required text-danger">*</b></label>
                                                <input type="date" class="form-control" id="txtFechaIngresoFuncionario"
                                                    name="txtFechaIngresoFuncionario">
                                            </div>

                                            <!-- Formación académica -->
                                            <div class="mb-3">
                                                <label for="txtFormacionFuncionario" class="form-label">Formación académica <b class="required text-danger">*</b></label>
                                                <select class="form-select" id="txtFormacionFuncionario" name="txtFormacionFuncionario">
                                                    <option>Selecciona una opción</option>
                                                    <option value="bachiller">Bachiller</option>
                                                    <option value="tecnico">Técnico</option>
                                                    <option value="tecnologo">Tecnólogo</option>
                                                    <option value="ingieneria">Ingeniería</option>
                                                    <option value="licenciatura">Licenciatura</option>
                                                    <option value="maestria">Maestría</option>
                                                    <option value="doctorado">Doctorado</option>
                                                </select>
                                            </div>

                                            <!-- Nombre del título -->
                                            <div class="mb-3">
                                                <label for="txtNombreFormacion" class="form-label">Nombre de la formación <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control" id="txtNombreFormacion"
                                                    name="txtNombreFormacion">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Familiar</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Cantidad de hijos -->
                                            <div class="mb-3">
                                                <label for="txtHijosFuncionario" class="form-label">Cantidad de hijos <b class="required text-danger">*</b></label>
                                                <input type="number" class="form-control" id="txtHijosFuncionario"
                                                    name="txtHijosFuncionario" min="0">
                                            </div>

                                            <!-- Campo oculto inicialmente -->
                                            <div class="mb-3" id="nombresHijosContainer" style="display: none;">
                                                <label for="txtNombresHijosFuncionario" class="form-label">Nombres de los hijos <b class="required text-danger">*</b></label>
                                                <input type="text" class="form-control" id="txtNombresHijosFuncionario"
                                                    name="txtNombresHijosFuncionario">
                                            </div>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const cantidadHijosInput = document.getElementById("txtHijosFuncionario");
                                                    const nombresHijosContainer = document.getElementById("nombresHijosContainer");

                                                    cantidadHijosInput.addEventListener("input", () => {
                                                        const cantidad = parseInt(cantidadHijosInput.value);
                                                        if (cantidad > 0) {
                                                            nombresHijosContainer.style.display = "block";
                                                        } else {
                                                            nombresHijosContainer.style.display = "none";
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Estado</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="listStatus" class="form-label">Estado del funcionario</label>
                                                <select class="form-select" id="listStatus" name="listStatus">
                                                    <option value="1">Activo</option>
                                                    <option value="2">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button id="btnActionForm" class="btn btn-success" type="submit"><i class="bi bi-floppy"></i>
                                        <span id="btnText">Guardar</span></button>

                                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i
                                            class="bi bi-x-lg"></i>Cerrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalViewFuncionario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid py-3">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <!-- Foto del funcionario -->
                            <div class="mb-4">
                                <img id="celImagenFuncionario" src="<?= media(); ?>/images/funcionarios/user.png"
                                    alt="Foto funcionario" class="img-thumbnail rounded-circle"
                                    style="width:220px; height:220px;">
                            </div>
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Información Básica</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>ID:</strong> <span id="celIdeFuncionario">0</span></p>
                                    <p><strong>Nombre:</strong> <span id="celNombresFuncionario">0</span></p>
                                    <p><strong>Identificación:</strong> <span id="celIdentificacionFuncionario">0</span></p>
                                    <p><strong>Estado:</strong> <span id="celEstadoFuncionario">0</span></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Información Personal</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Edad:</strong> <span id="celEdadFuncionario">0</span></p>
                                                    <p><strong>Sexo:</strong> <span id="celSexoFuncionario">0</span></p>
                                                    <p><strong>Estado Civil:</strong> <span id="celEstadoCivilFuncionario">0</span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Religión:</strong> <span id="celReligionFuncionario">0</span></p>
                                                    <p><strong>Hijos:</strong> <span id="celHijosFuncionario">0</span></p>
                                                    <p><strong>Nombres de Hijos:</strong> <span id="celNombresHijosFuncionario">0</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Información de Contacto</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Correo:</strong> <span id="celCorreoFuncionario">0</span></p>
                                                    <p><strong>Celular:</strong> <span id="celCelularFuncionario">0</span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Dirección:</strong> <span id="celDireccionFuncionario">0</span></p>
                                                    <p><strong>Lugar de Residencia:</strong> <span id="celLugarResidenciaFuncionario">0</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Información Laboral y Académica</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p><strong>Cargo:</strong> <span id="celCargoFuncionario">0</span></p>
                                                    <p><strong>Dependencia:</strong> <span id="celDependenciaFuncionario">0</span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>Contrato:</strong> <span id="celContrato">0</span></p>
                                                    <p><strong>Fecha de Ingreso:</strong> <span id="celFechaIngresoFuncionario">0</span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>Formación académica:</strong> <span id="celFormacionAcademica">0</span></p>
                                                    <p><strong>Nombre de la formación:</strong> <span id="celNombreFormacion">0</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        <i class="bi bi-check2"></i> Listo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>