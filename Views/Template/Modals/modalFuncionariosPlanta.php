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

                            <!-- Nuevos campos adicionales -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Adicional</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="txtLugarExpedicion" class="form-label">Lugar de Expedición</label>
                                                <input type="text" class="form-control" id="txtLugarExpedicion" name="txtLugarExpedicion">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtLibretaMilitar" class="form-label">Libreta Militar</label>
                                                <select class="form-select" id="txtLibretaMilitar" name="txtLibretaMilitar">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Si">Sí</option>
                                                    <option value="No">No</option>
                                                    <option value="No Aplica">No Aplica</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtTipoNombramiento" class="form-label">Tipo de Nombramiento</label>
                                                <input type="text" class="form-control" id="txtTipoNombramiento" name="txtTipoNombramiento">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtNivel" class="form-label">Nivel</label>
                                                <input type="text" class="form-control" id="txtNivel" name="txtNivel">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtSalarioBasico" class="form-label">Salario Básico</label>
                                                <input type="number" step="0.01" class="form-control" id="txtSalarioBasico" name="txtSalarioBasico">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtEstudiosRealizados" class="form-label">Estudios Realizados</label>
                                                <input type="text" class="form-control" id="txtEstudiosRealizados" name="txtEstudiosRealizados">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtCodigo" class="form-label">Código</label>
                                                <input type="text" class="form-control" id="txtCodigo" name="txtCodigo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtGrado" class="form-label">Grado</label>
                                                <input type="text" class="form-control" id="txtGrado" name="txtGrado">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtCiudadResidencia" class="form-label">Ciudad de Residencia</label>
                                                <input type="text" class="form-control" id="txtCiudadResidencia" name="txtCiudadResidencia">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtFechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                                <input type="date" class="form-control" id="txtFechaNacimiento" name="txtFechaNacimiento">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtLugarNacimiento" class="form-label">Lugar de Nacimiento</label>
                                                <input type="text" class="form-control" id="txtLugarNacimiento" name="txtLugarNacimiento">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtRh" class="form-label">RH</label>
                                                <select class="form-select" id="txtRh" name="txtRh">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Laboral Adicional</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="txtActoAdministrativo" class="form-label">Acto Administrativo</label>
                                                <input type="text" class="form-control" id="txtActoAdministrativo" name="txtActoAdministrativo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtFechaActoNombramiento" class="form-label">Fecha Acto de Nombramiento</label>
                                                <input type="date" class="form-control" id="txtFechaActoNombramiento" name="txtFechaActoNombramiento">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtNoActaPosesion" class="form-label">No. Acta de Posesión</label>
                                                <input type="text" class="form-control" id="txtNoActaPosesion" name="txtNoActaPosesion">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtFechaActaPosesion" class="form-label">Fecha de Acta de Posesión</label>
                                                <input type="date" class="form-control" id="txtFechaActaPosesion" name="txtFechaActaPosesion">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtTiempoLaborado" class="form-label">Tiempo Laborado</label>
                                                <input type="text" class="form-control" id="txtTiempoLaborado" name="txtTiempoLaborado">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtTitulo" class="form-label">Título</label>
                                                <input type="text" class="form-control" id="txtTitulo" name="txtTitulo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtTarjetaProfesional" class="form-label">Tarjeta Profesional</label>
                                                <input type="text" class="form-control" id="txtTarjetaProfesional" name="txtTarjetaProfesional">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtOtrosEstudios" class="form-label">Otros Estudios y/o Especializaciones</label>
                                                <textarea class="form-control" id="txtOtrosEstudios" name="txtOtrosEstudios" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Financiera y Seguridad Social</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="txtCuentaNo" class="form-label">Cuenta No.</label>
                                                <input type="text" class="form-control" id="txtCuentaNo" name="txtCuentaNo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtBanco" class="form-label">Banco</label>
                                                <input type="text" class="form-control" id="txtBanco" name="txtBanco">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtEps" class="form-label">E.P.S</label>
                                                <select class="form-select" id="txtEps" name="txtEps">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Nueva EPS">Nueva EPS</option>
                                                    <option value="Cajacopi EPS">Cajacopi EPS</option>
                                                    <option value="Salud Total EPS">Salud Total EPS</option>
                                                    <option value="Sanitas EPS">Sanitas EPS</option>
                                                    <option value="Coosalud EPS">Coosalud EPS</option>
                                                    <option value="Sura EPS">Sura EPS</option>
                                                    <option value="Aliansalud EPS">Aliansalud EPS</option>
                                                    <option value="Mutual SER EPS">Mutual SER EPS</option>
                                                    <option value="Salud Mía EPS">Salud Mía EPS</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtAfp" class="form-label">A.F.P</label>
                                                <select class="form-select" id="txtAfp" name="txtAfp">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Porvenir">Porvenir</option>
                                                    <option value="Protección">Protección</option>
                                                    <option value="Colfondos">Colfondos</option>
                                                    <option value="Skandia">Skandia</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtAfc" class="form-label">A.F.C</label>
                                                <input type="text" class="form-control" id="txtAfc" name="txtAfc">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtArl" class="form-label">A.R.L</label>
                                                <select class="form-select" id="txtArl" name="txtArl">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Sura">Sura</option>
                                                    <option value="Positiva">Positiva</option>
                                                    <option value="Colpatria">Colpatria</option>
                                                    <option value="Colmena">Colmena</option>
                                                    <option value="Bolívar">Bolívar</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtSindicalizado" class="form-label">Sindicalizado</label>
                                                <select class="form-select" id="txtSindicalizado" name="txtSindicalizado">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Si">Sí</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtMadreCabezaHogar" class="form-label">Madre Cabeza de Hogar</label>
                                                <select class="form-select" id="txtMadreCabezaHogar" name="txtMadreCabezaHogar">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Si">Sí</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtPrepensionado" class="form-label">Prepensionado</label>
                                                <select class="form-select" id="txtPrepensionado" name="txtPrepensionado">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Si">Sí</option>
                                                    <option value="No">No</option>
                                                </select>
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
                        <div class="col-md-3">
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