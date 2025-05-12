<!-- Modal -->
<div class="modal fade" id="modalFormFuncionario" tabindex="-1" aria-labelledby="modalFormUsuario" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Funcionario</h5>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formFuncionario" name="formFuncionario" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideFuncionario" name="ideFuncionario" value="">
                            <!-- Nombre completo -->
                            <div class="modal-body">
                                <label for="txtNombreFuncionario">Nombre completo <b
                                        class="required text-danger">*</b></label>
                                <input type="text" class="form-control valid validText" id="txtNombreFuncionario"
                                    name="txtNombreFuncionario" required maxlength="50">
                            </div>

                            <!-- Correo -->
                            <div class="modal-body">
                                <label for="txtCorreoFuncionario">Correo <b class="required text-danger">*</b></label>
                                <input type="email" class="form-control" id="txtCorreoFuncionario"
                                    name="txtCorreoFuncionario" required>
                            </div>

                            <div class="modal-body">
                                <label for="txtCargoFuncionario">Cargos <b class="required text-danger">*</b></label>
                                <select class="form-select" id="txtCargoFuncionario" name="txtCargoFuncionario">
                                    <option>Seleciona tu opcion</option>
                                    <?php foreach ($data['cargos'] as $car): ?>
                                        <option value="<?= $car['idecargos'] ?>"><?= $car['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="modal-body">
                                <label for="txtDependenciaFuncionario">Dependencia <b
                                        class="required text-danger">*</b></label>
                                <select class="form-select" id="txtDependenciaFuncionario"
                                    name="txtDependenciaFuncionario">
                                    <option>Seleciona tu opcion</option>
                                    <?php foreach ($data['dependencias'] as $dep): ?>
                                        <option value="<?= $dep['dependencia_pk'] ?>"><?= $dep['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="modal-body">
                                <label for="txtContrato">Tipo de Contrato <b class="required text-danger">*</b></label>
                                <select class="form-select" id="txtContrato" name="txtContrato">
                                    <option>Seleciona tu opcion</option>
                                    <?php foreach ($data['contrato'] as $cont): ?>
                                        <option value="<?= $cont['id_contrato'] ?>"><?= $cont['tipo_cont'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Identificación -->
                            <div class="modal-body">
                                <label for="txtIdentificacionFuncionario">Identificación <b
                                        class="required text-danger">*</b></label>
                                <input type="number" class="form-control" id="txtIdentificacionFuncionario"
                                    name="txtIdentificacionFuncionario">
                            </div>

                            <!-- Celular -->
                            <div class="modal-body">
                                <label for="txtCelularFuncionario">Celular <b class="required text-danger">*</b></label>
                                <input type="number" class="form-control" id="txtCelularFuncionario"
                                    name="txtCelularFuncionario">
                            </div>

                            <!-- Dirección -->
                            <div class="modal-body">
                                <label for="txtDireccionFuncionario">Dirección <b
                                        class="required text-danger">*</b></label>
                                <input type="text" class="form-control" id="txtDireccionFuncionario"
                                    name="txtDireccionFuncionario">
                            </div>

                            <!-- Fecha de ingreso -->
                            <div class="modal-body">
                                <label for="txtFechaIngresoFuncionario">Fecha de ingreso <b
                                        class="required text-danger">*</b></label>
                                <input type="date" class="form-control" id="txtFechaIngresoFuncionario"
                                    name="txtFechaIngresoFuncionario">
                            </div>

                            <!-- <div class="modal-body user-select-none pe-none">
                                <label for="txtVacacionesFuncionario" class="pe-none" >Fecha Vacaciones</label>
                                <input type="text" class="form-control" id="txtVacacionesFuncionario"
                                    name="txtVacacionesFuncionario">
                            </div> -->

                            <!-- Número de hijos -->
                            <div class="modal-body">
                                <label for="txtHijosFuncionario">Cantidad de hijos <b
                                        class="required text-danger">*</b></label>
                                <input type="number" class="form-control" id="txtHijosFuncionario"
                                    name="txtHijosFuncionario">
                            </div>

                            <!-- Nombres de los hijos -->
                            <div class="modal-body d-none">
                                <label for="txtNombresHijosFuncionario">Nombres de los hijos <b
                                        class="required text-danger">*</b></label>
                                <input type="text" class="form-control" id="txtNombresHijosFuncionario"
                                    name="txtNombresHijosFuncionario">
                            </div>

                            <div class="modal-body">
                                <label for="txtSexoFuncionario">Sexo <b class="required text-danger">*</b></label>
                                <select class="form-select" id="txtSexoFuncionario" name="txtSexoFuncionario">
                                    <option>Seleciona tu opcion</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                </select>
                            </div>

                            <!-- Lugar de residencia -->
                            <div class="modal-body">
                                <label for="txtLugarResidenciaFuncionario">Lugar de residencia <b
                                        class="required text-danger">*</b></label>
                                <input type="text" class="form-control" id="txtLugarResidenciaFuncionario"
                                    name="txtLugarResidenciaFuncionario">
                            </div>

                            <!-- Edad -->
                            <div class="modal-body">
                                <label for="txtEdadFuncionario">Edad <b class="required text-danger">*</b></label>
                                <input type="number" class="form-control" id="txtEdadFuncionario"
                                    name="txtEdadFuncionario">
                            </div>

                            <!-- Estado civil -->
                            <div class="modal-body">
                                <label for="txtEstadoCivilFuncionario">Estado civil <b
                                        class="required text-danger">*</b></label>
                                <select class="form-select" id="txtEstadoCivilFuncionario"
                                    name="txtEstadoCivilFuncionario">
                                    <option>Seleciona tu opcion</option>
                                    <option value="soltero">Soltero</option>
                                    <option value="casado">Casado</option>
                                    <option value="divorciado">Divorciado</option>
                                    <option value="viudo">Viudo</option>
                                    <option value="union_libre">Unión libre</option>
                                </select>
                            </div>

                            <!-- Religión -->
                            <div class="modal-body">
                                <label for="txtReligionFuncionario">Religión <b
                                        class="required text-danger">*</b></label>
                                <input type="text" class="form-control" id="txtReligionFuncionario"
                                    name="txtReligionFuncionario">
                            </div>

                            <!-- Nivel escolar -->
                            <div class="modal-body">
                                <label for="txtFormacionFuncionario">Formacion academica <b
                                        class="required text-danger">*</b></label>
                                <select class="form-select" id="txtFormacionFuncionario" name="txtFormacionFuncionario">
                                    <option>Seleciona tu opcion</option>
                                    <option value="bachiller">Bachiller</option>
                                    <option value="tecnico">Técnico</option>
                                    <option value="tecnologo">Técnologo</option>
                                    <option value="ingieneria">Ingieneria</option>
                                    <option value="licenciatura">Licenciatura</option>
                                    <option value="maestria">Maestría</option>
                                    <option value="doctorado">Doctorado</option>
                                </select>
                            </div>

                            <!-- Nombre del titulo -->
                            <div class="modal-body ">
                                <label for="txtNombreFormacion">Nombre de la formacion <b
                                        class="required text-danger">*</b></label>
                                <input type="text" class="form-control" id="txtNombreFormacion"
                                    name="txtNombreFormacion">
                            </div>

                            <div class="modal-body form-select-lg mb-3">
                                <label for="listStatus">Estado</label>
                                <select class="form-select" id="listStatus" name="listStatus">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnActionForm" class="btn btn-success" type="submit"><i class="bi bi-floppy"></i>
                    <span id="btnText">Guardar</span></button>

                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i
                        class="bi bi-x-lg"></i>Cerrar</button>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
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
                                    <td>Correo:</td>
                                    <td id="celCorreoFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Nombre Completo:</td>
                                    <td id="celNombresFuncionario">0</td>
                                </tr>

                                <tr>
                                    <td>Identificación:</td>
                                    <td id="celIdentificacionFuncionario">0</td>
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
                                    <td>Contrato:</td>
                                    <td id="celContrato">0</td>
                                </tr>
                                <tr>
                                    <td>Celular:</td>
                                    <td id="celCelularFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Dirección:</td>
                                    <td id="celDireccionFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Ingreso:</td>
                                    <td id="celFechaIngresoFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Vacaciones:</td>
                                    <td id="celVacacionesFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Hijos:</td>
                                    <td id="celHijosFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Nombres de Hijos:</td>
                                    <td id="celNombresHijosFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Sexo:</td>
                                    <td id="celSexoFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Lugar de Residencia:</td>
                                    <td id="celLugarResidenciaFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Edad:</td>
                                    <td id="celEdadFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Estado Civil:</td>
                                    <td id="celEstadoCivilFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Religión:</td>
                                    <td id="celReligionFuncionario">0</td>
                                </tr>
                                <tr>
                                    <td>Formacion academica:</td>
                                    <td id="celFormacionAcademica">0</td>
                                </tr>
                                <tr>
                                    <td>Nombre de la formacion:</td>
                                    <td id="celNombreFormacion">0</td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td id="celEstadoFuncionario">0</td>
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


<script>
    let txtHijosFuncionario = document.getElementById('txtHijosFuncionario');
    let divNombresHijosFuncionario = document.querySelector('.modal-body.d-none');

    txtHijosFuncionario.addEventListener('input', function () {
        if (txtHijosFuncionario.value > 0) {
            divNombresHijosFuncionario.classList.remove('d-none');
        } else {
            divNombresHijosFuncionario.classList.add('d-none');
        }
    });

</script>
