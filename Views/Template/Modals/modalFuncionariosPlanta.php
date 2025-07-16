<style>
    .disable {
    background-color: #e3e3e7 !important;
}

</style>
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
                            <input type="hidden" id="txtNombresHijosFuncionario" name="txtNombresHijosFuncionario" value="">
                            <input type="hidden" id="txtEdadesHijosFuncionario" name="txtEdadesHijosFuncionario" value="">
                            <input type="hidden" id="txtLugarExpedicion" name="txtLugarExpedicion" value="">
                            <input type="hidden" id="txtLugarNacimiento" name="txtLugarNacimiento" value="">

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

                                            
                                            <div class="mb-3">
                                                <label for="txtFechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                                <input type="date" class="form-control" id="txtFechaNacimiento" name="txtFechaNacimiento">
                                            </div>
                                            <!-- Edad -->
                                            <div class="mb-3">
                                                <label for="txtEdadFuncionario" class="form-label">Edad <b class="required text-danger">*</b></label>
                                                <input type="number" class="form-control" id="txtEdadFuncionario"
                                                    name="txtEdadFuncionario" min="18" max="100">
                                                <small class="form-text text-muted">Se calcula automáticamente si ingresa fecha de nacimiento</small>
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
                                                    <option value="">Selecciona una opción</option>
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
                                                    <option value="Profesional">Profesional</option>
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

                            <!-- Nuevos campos adicionales -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Adicional</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Lugar de Expedición -->
                                            <div class="mb-3">
                                                <label for="txtDepartamentoExpedicion" class="form-label">Departamento de Expedición</label>
                                                <select class="form-select" id="txtDepartamentoExpedicion" name="txtDepartamentoExpedicion">
                                                    <option value="">Selecciona un departamento</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtCiudadExpedicion" class="form-label">Ciudad de Expedición</label>
                                                <select class="form-select" id="txtCiudadExpedicion" name="txtCiudadExpedicion" disabled>
                                                    <option value="">Selecciona una ciudad</option>
                                                </select>
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
                                                <select class="form-select" id="txtTipoNombramiento" name="txtTipoNombramiento">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="supernumerario">Supernumerario</option>
                                                    <option value="libre_nombramiento">Libre Nombramiento</option>
                                                    <option value="remocion">Remoción</option>
                                                    <option value="carrera_administrativa">Carrera Administrativa</option>
                                                    <option value="provisionalidad">Provisionalidad</option>
                                                    <option value="periodo_fijo">Periodo Fijo</option>
                                                    <option value="periodo_de_prueba">Periodo de prueba</option>
                                                </select>
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
                                                <label for="txtCodigo" class="form-label">Código</label>
                                                <input type="text" class="form-control" id="txtCodigo" name="txtCodigo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtGrado" class="form-label">Grado</label>
                                                <input type="text" class="form-control" id="txtGrado" name="txtGrado">
                                            </div>

                                            
                                            
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const fechaNacimiento = document.getElementById('txtFechaNacimiento');
                                                    const edad = document.getElementById('txtEdadFuncionario');
                                                    const fechaIngreso = document.getElementById('txtFechaIngresoFuncionario');
                                                    const tiempoLaborado = document.getElementById('txtTiempoLaborado');
                                                    
                                                    fechaNacimiento.addEventListener('change', function() {
                                                        if (this.value) {
                                                            const hoy = new Date();
                                                            const nacimiento = new Date(this.value);
                                                            let edadCalculada = hoy.getFullYear() - nacimiento.getFullYear();
                                                            const mes = hoy.getMonth() - nacimiento.getMonth();
                                                            
                                                            if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                                                                edadCalculada--;
                                                            }
                                                            
                                                            edad.value = edadCalculada;
                                                            edad.readOnly = true;
                                                            edad.classList.add('disable');
                                                        } else {
                                                            edad.readOnly = false;
                                                            edad.classList.remove('disable');
                                                        }
                                                    });
                                                    
                                                    // Permitir edición manual si no hay fecha de nacimiento
                                                    edad.addEventListener('focus', function() {
                                                        if (!fechaNacimiento.value) {
                                                            this.readOnly = false;
                                                            this.classList.remove('disable');
                                                        }
                                                    });
                                                    
                                                    fechaIngreso.addEventListener('change', function() {
                                                        if (this.value) {
                                                            const hoy = new Date();
                                                            const ingreso = new Date(this.value);
                                                            let anios = hoy.getFullYear() - ingreso.getFullYear();
                                                            let meses = hoy.getMonth() - ingreso.getMonth();
                                                            let dias = hoy.getDate() - ingreso.getDate();
                                                            
                                                            if (dias < 0) {
                                                                meses--;
                                                                const ultimoMes = new Date(hoy.getFullYear(), hoy.getMonth(), 0);
                                                                dias += ultimoMes.getDate();
                                                            }
                                                            
                                                            if (meses < 0) {
                                                                anios--;
                                                                meses += 12;
                                                            }
                                                            
                                                            let tiempoCalculado = '';
                                                            if (anios > 0) {
                                                                tiempoCalculado += anios + ' año' + (anios > 1 ? 's' : '');
                                                            }
                                                            if (meses > 0) {
                                                                if (tiempoCalculado) tiempoCalculado += ', ';
                                                                tiempoCalculado += meses + ' mes' + (meses > 1 ? 'es' : '');
                                                            }
                                                            if (dias > 0 && anios === 0 && meses === 0) {
                                                                if (tiempoCalculado) tiempoCalculado += ', ';
                                                                tiempoCalculado += dias + ' día' + (dias > 1 ? 's' : '');
                                                            }
                                                            
                                                            if (!tiempoCalculado) {
                                                                tiempoCalculado = 'Menos de 1 día';
                                                            }
                                                            
                                                            tiempoLaborado.value = tiempoCalculado;
                                                        } else {
                                                            tiempoLaborado.value = '';
                                                        }
                                                    });
                                                });
                                            </script>
                                            <!-- Lugar de Nacimiento -->
                                            <div class="mb-3">
                                                <label for="txtDepartamentoNacimiento" class="form-label">Departamento de Nacimiento</label>
                                                <select class="form-select" id="txtDepartamentoNacimiento" name="txtDepartamentoNacimiento">
                                                    <option value="">Selecciona un departamento</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtCiudadNacimiento" class="form-label">Ciudad de Nacimiento</label>
                                                <select class="form-select" id="txtCiudadNacimiento" name="txtCiudadNacimiento" disabled>
                                                    <option value="">Selecciona una ciudad</option>
                                                </select>
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
                                                <label for="txtTiempoLaborado" class="form-label ">Tiempo Laborado</label>
                                                <input type="text" class="form-control disable" id="txtTiempoLaborado" name="txtTiempoLaborado" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtTitulo" class="form-label">Título</label>
                                                <input type="text" class="form-control" id="txtTitulo" name="txtTitulo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtTarjetaProfesional" class="form-label">Tarjeta Profesional</label>
                                                <select class="form-select" id="txtTarjetaProfesional" name="txtTarjetaProfesional">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="Si">Sí</option>
                                                    <option value="No">No</option>
                                                    <option value="No Aplica">No Aplica</option>
                                                </select>
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
                                                <select class="form-select" id="txtBanco" name="txtBanco">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="BANCOLOMBIA">BANCOLOMBIA</option>
                                                    <option value="BANCO DE BOGOTA">BANCO DE BOGOTÁ</option>
                                                    <option value="DAVIVIENDA">DAVIVIENDA</option>
                                                    <option value="BBVA COLOMBIA">BBVA COLOMBIA</option>
                                                    <option value="BANCO POPULAR">BANCO POPULAR</option>
                                                    <option value="BANCO CAJA SOCIAL">BANCO CAJA SOCIAL</option>
                                                    <option value="BANCO AV VILLAS">BANCO AV VILLAS</option>
                                                    <option value="BANCO OCCIDENTE">BANCO OCCIDENTE</option>
                                                    <option value="BANCO AGRARIO">BANCO AGRARIO</option>
                                                    <option value="CITIBANK">CITIBANK</option>
                                                    <option value="BANCO GNB SUDAMERIS">BANCO GNB SUDAMERIS</option>
                                                    <option value="BANCO FALABELLA">BANCO FALABELLA</option>
                                                    <option value="BANCO PICHINCHA">BANCO PICHINCHA</option>
                                                    <option value="BANCO COOPERATIVO COOPCENTRAL">BANCO COOPERATIVO COOPCENTRAL</option>
                                                    <option value="BANCO SANTANDER">BANCO SANTANDER</option>
                                                    <option value="BANCO MUNDO MUJER">BANCO MUNDO MUJER</option>
                                                    <option value="BANCO FINANDINA">BANCO FINANDINA</option>
                                                    <option value="BANCO SERFINANZA">BANCO SERFINANZA</option>
                                                    <option value="BANCAMIA">BANCAMÍA</option>
                                                    <option value="NEQUI">NEQUI</option>
                                                    <option value="DAVIPLATA">DAVIPLATA</option>
                                                    <option value="BANCO CREDIFINANCIERA">BANCO CREDIFINANCIERA</option>
                                                    <option value="BANCO W">BANCO W</option>
                                                    <option value="LULO BANK">LULO BANK</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtEps" class="form-label">E.P.S</label>
                                                <select class="form-select" id="txtEps" name="txtEps">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="NUEVA EPS">NUEVA EPS</option>
                                                    <option value="SURA">SURA</option>
                                                    <option value="SANITAS">SANITAS</option>
                                                    <option value="SALUD TOTAL">SALUD TOTAL</option>
                                                    <option value="COMPENSAR">COMPENSAR</option>
                                                    <option value="FAMISANAR">FAMISANAR</option>
                                                    <option value="COOMEVA">COOMEVA</option>
                                                    <option value="MEDIMAS">MEDIMAS</option>
                                                    <option value="ALIANSALUD">ALIANSALUD</option>
                                                    <option value="COOSALUD">COOSALUD</option>
                                                    <option value="ASMETSALUD">ASMETSALUD</option>
                                                    <option value="MUTUAL SER">MUTUAL SER</option>
                                                    <option value="CAJACOPI">CAJACOPI</option>
                                                    <option value="CAPRESOCA">CAPRESOCA</option>
                                                    <option value="COMFENALCO VALLE">COMFENALCO VALLE</option>
                                                    <option value="ECOOPSOS">ECOOPSOS</option>
                                                    <option value="EMSSANAR">EMSSANAR</option>
                                                    <option value="GOLDEN GROUP">GOLDEN GROUP</option>
                                                    <option value="PIJAOS SALUD">PIJAOS SALUD</option>
                                                    <option value="SAVIA SALUD">SAVIA SALUD</option>
                                                    <option value="DUSAKAWI">DUSAKAWI</option>
                                                    <option value="ANAS WAYUU">ANAS WAYUU</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtAfp" class="form-label">A.F.P</label>
                                                <select class="form-select" id="txtAfp" name="txtAfp">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="PORVENIR">PORVENIR</option>
                                                    <option value="PROTECCION">PROTECCIÓN</option>
                                                    <option value="COLFONDOS">COLFONDOS</option>
                                                    <option value="OLD MUTUAL">OLD MUTUAL</option>
                                                    <option value="COLPENSIONES">COLPENSIONES</option>
                                                    <option value="FONDO NACIONAL DE AHORRO">FONDO NACIONAL DE AHORRO</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtAfc" class="form-label">A.F.C</label>
                                                <select class="form-select" id="txtAfc" name="txtAfc">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="PORVENIR">PORVENIR</option>
                                                    <option value="PROTECCION">PROTECCIÓN</option>
                                                    <option value="COLFONDOS">COLFONDOS</option>
                                                    <option value="COLPENCIONES">COLPENCIONES</option>
                                                    <option value="FONDO NACIONAL DE AHORRO">FONDO NACIONAL DE AHORRO</option>
                                                    <option value="SKANDIA">SKANDIA</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtArl" class="form-label">A.R.L</label>
                                                <select class="form-select" id="txtArl" name="txtArl">
                                                    <option value="POSITIVA" selected>POSITIVA</option>
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
                                                <label for="txtHijosFuncionario" class="form-label">Cantidad de hijos</label>
                                                <input type="number" class="form-control" id="txtHijosFuncionario"
       name="txtHijosFuncionario" min="0" max="9" step="1" value="0"
       oninput="if(this.value.length > 1) this.value = this.value.slice(0,1);">
                                            </div>

                                            <!-- Contenedor dinámico para hijos -->
                                            <div id="hijosContainer" style="display: none;"></div>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const cantidadHijosInput = document.getElementById("txtHijosFuncionario");
                                                    const hijosContainer = document.getElementById("hijosContainer");
                                                    const form = document.getElementById("formFuncionario");

                                                    function generarCamposHijos() {
                                                        const cantidad = parseInt(cantidadHijosInput.value) || 0;
                                                        hijosContainer.innerHTML = '';
                                                        
                                                        if (cantidad > 0) {
                                                            hijosContainer.style.display = "block";
                                                            const inputNombres = document.getElementById('txtNombresHijosFuncionario');
                                                            const inputEdades = document.getElementById('txtEdadesHijosFuncionario');
                                                            const nombresExistentes = inputNombres && inputNombres.value ? inputNombres.value.split(', ') : [];
                                                            // Separar edades concatenadas: 1011 = [10, 11]
                                                            let edadesExistentes = [];
                                                            if (inputEdades && inputEdades.value) {
                                                                const edadesStr = inputEdades.value;
                                                                for (let i = 0; i < edadesStr.length; i += 2) {
                                                                    edadesExistentes.push(parseInt(edadesStr.substr(i, 2)));
                                                                }
                                                            }
                                                            
                                                            for (let i = 1; i <= cantidad; i++) {
                                                                const hijoDiv = document.createElement('div');
                                                                hijoDiv.className = 'row mb-2';
                                                                hijoDiv.innerHTML = `
                                                                    <div class="col-md-8">
                                                                        <label class="form-label">Nombre hijo ${i}</label>
                                                                        <input type="text" class="form-control hijo-nombre" placeholder="Nombre completo" value="${nombresExistentes[i-1] || ''}">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Edad</label>
                                                                        <input type="number" class="form-control hijo-edad" min="0" max="50" value="${edadesExistentes[i-1] || ''}">
                                                                    </div>
                                                                `;
                                                                hijosContainer.appendChild(hijoDiv);
                                                            }
                                                        } else {
                                                            hijosContainer.style.display = "none";
                                                        }
                                                    }
                                                    
                                                    // Cargar datos al abrir modal para editar
                                                    document.getElementById('modalFormFuncionario').addEventListener('shown.bs.modal', function() {
                                                        setTimeout(() => {
                                                            const cantidad = parseInt(cantidadHijosInput.value) || 0;
                                                            if (cantidad > 0) {
                                                                cantidadHijosInput.dispatchEvent(new Event('input'));
                                                            }
                                                        }, 2500);
                                                    });

                                                    cantidadHijosInput.addEventListener("input", generarCamposHijos);
                                                    


                                                    form.addEventListener('submit', function() {
                                                        const nombres = Array.from(document.querySelectorAll('.hijo-nombre')).map(input => input.value).filter(v => v);
                                                        const edades = Array.from(document.querySelectorAll('.hijo-edad')).map(input => input.value).filter(v => v);
                                                        
                                                        let inputNombres = document.getElementById('txtNombresHijosFuncionario');
                                                        if (!inputNombres) {
                                                            inputNombres = document.createElement('input');
                                                            inputNombres.type = 'hidden';
                                                            inputNombres.id = 'txtNombresHijosFuncionario';
                                                            inputNombres.name = 'txtNombresHijosFuncionario';
                                                            form.appendChild(inputNombres);
                                                        }
                                                        inputNombres.value = nombres.join(', ');
                                                        
                                                        let inputEdades = document.getElementById('txtEdadesHijosFuncionario');
                                                        if (!inputEdades) {
                                                            inputEdades = document.createElement('input');
                                                            inputEdades.type = 'hidden';
                                                            inputEdades.id = 'txtEdadesHijosFuncionario';
                                                            inputEdades.name = 'txtEdadesHijosFuncionario';
                                                            form.appendChild(inputEdades);
                                                        }
                                                        // Concatenar edades sin comas: 10, 11 = 1011
                                                        inputEdades.value = edades.map(edad => edad.toString().padStart(2, '0')).join('');
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
                    <!-- Información Básica -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header" style="background-color: #ccc;">
                                    <h5 class="mb-0">Información Básica</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p><strong>ID:</strong> <span id="celIdeFuncionario">-</span></p>
                                            <p><strong>Estado:</strong> <span id="celEstadoFuncionario">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Nombre Completo:</strong> <span id="celNombresFuncionario">-</span></p>
                                            <p><strong>Identificación:</strong> <span id="celIdentificacionFuncionario">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Correo:</strong> <span id="celCorreoFuncionario">-</span></p>
                                            <p><strong>Celular:</strong> <span id="celCelularFuncionario">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Dirección:</strong> <span id="celDireccionFuncionario">-</span></p>
                                            <p><strong>Lugar de Residencia:</strong> <span id="celLugarResidenciaFuncionario">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Personal -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header" style="background-color: #ccc;">
                                    <h5 class="mb-0">Información Personal</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Edad:</strong> <span id="celEdadFuncionario">-</span></p>
                                            <p><strong>Sexo:</strong> <span id="celSexoFuncionario">-</span></p>
                                            <p><strong>Estado Civil:</strong> <span id="celEstadoCivilFuncionario">-</span></p>
                                            <p><strong>Religión:</strong> <span id="celReligionFuncionario">-</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Fecha de Nacimiento:</strong> <span id="celFechaNacimiento">-</span></p>
                                            <p><strong>Lugar de Nacimiento:</strong> <span id="celLugarNacimiento">-</span></p>
                                            <p><strong>RH:</strong> <span id="celRh">-</span></p>
                                            <p><strong>Lugar de Expedición:</strong> <span id="celLugarExpedicion">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header" style="background-color: #ccc;">
                                    <h5 class="mb-0">Información Familiar</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Cantidad de Hijos:</strong> <span id="celHijosFuncionario">-</span></p>
                                            <p><strong>Nombres de Hijos:</strong> <span id="celNombresHijosFuncionario">-</span></p>
                                            <p><strong>Edades de Hijos:</strong> <span id="celEdadesHijosFuncionario">-</span></p>
                                            <p><strong>Libreta Militar:</strong> <span id="celLibretaMilitar">-</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Madre Cabeza de Hogar:</strong> <span id="celMadreCabezaHogar">-</span></p>
                                            <p><strong>Sindicalizado:</strong> <span id="celSindicalizado">-</span></p>
                                            <p><strong>Prepensionado:</strong> <span id="celPrepensionado">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header" style="background-color: #ccc;">
                                    <h5 class="mb-0">Información Laboral</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Cargo:</strong> <span id="celCargoFuncionario">-</span></p>
                                            <p><strong>Dependencia:</strong> <span id="celDependenciaFuncionario">-</span></p>
                                            <p><strong>Tipo de Contrato:</strong> <span id="celContrato">-</span></p>
                                            <p><strong>Fecha de Ingreso:</strong> <span id="celFechaIngresoFuncionario">-</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Tiempo Laborado:</strong> <span id="celTiempoLaborado">-</span></p>
                                            <p><strong>Nivel:</strong> <span id="celNivel">-</span></p>
                                            <p><strong>Grado:</strong> <span id="celGrado">-</span></p>
                                            <p><strong>Código:</strong> <span id="celCodigo">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header" style="background-color: #ccc;">
                                    <h5 class="mb-0">Información Administrativa</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Tipo de Nombramiento:</strong> <span id="celTipoNombramiento">-</span></p>
                                            <p><strong>Acto Administrativo:</strong> <span id="celActoAdministrativo">-</span></p>
                                            <p><strong>Fecha Acto Nombramiento:</strong> <span id="celFechaActoNombramiento">-</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>No. Acta de Posesión:</strong> <span id="celNoActaPosesion">-</span></p>
                                            <p><strong>Fecha Acta Posesión:</strong> <span id="celFechaActaPosesion">-</span></p>
                                            <p><strong>Salario Básico:</strong> <span id="celSalarioBasico">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Académica -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header" style="background-color: #ccc;">
                                    <h5 class="mb-0">Información Académica</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Formación Académica:</strong> <span id="celFormacionAcademica">-</span></p>
                                            <p><strong>Nombre de la Formación:</strong> <span id="celNombreFormacion">-</span></p>
                                            <p><strong>Título:</strong> <span id="celTitulo">-</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Tarjeta Profesional:</strong> <span id="celTarjetaProfesional">-</span></p>
                                            <p><strong>Otros Estudios:</strong> <span id="celOtrosEstudios">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header" style="background-color: #ccc;">
                                    <h5 class="mb-0">Información Financiera</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Cuenta No.:</strong> <span id="celCuentaNo">-</span></p>
                                            <p><strong>Banco:</strong> <span id="celBanco">-</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Salario Básico:</strong> <span id="celSalarioBasico2">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Seguridad Social -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header" style="background-color: #ccc;">
                                    <h5 class="mb-0">Seguridad Social</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p><strong>EPS:</strong> <span id="celEps">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>AFP:</strong> <span id="celAfp">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>AFC:</strong> <span id="celAfc">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>ARL:</strong> <span id="celArl">-</span></p>
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

<!-- Scripts para departamentos y ciudades -->
<script src="Assets/Js/colombia-api.js"></script>
<script src="Assets/Js/funcionarios-colombia.js"></script>
<script>
</script>