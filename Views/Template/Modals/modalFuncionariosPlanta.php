<!-- Modal -->
<div class="modal fade" id="modalFormFuncionario" tabindex="-1" aria-labelledby="modalFormUsuario" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formFuncionario" name=" formFuncionario" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideFuncionario" name=" ideFuncionario" value="">
                            <div class="modal-body">
                                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son
                                    obligatorios.
                                </p>
                                <hr>
                                <p class="text-primary">Datos del Usuario</p>
                            </div>
                            <div class="modal-body">
                                <label for="txtCorreoUsuario">Correos<span class=" required">*</span></label>
                                <input type="email" class="form-control " id="txtCorreoUsuario"
                                    name="txtCorreoUsuario" required="" >
                            </div>

                            <div class="modal-body">
                                <label for="txtNombresUsuario">Nombres<span class=" required">*</span></label>
                                <input type="text" class="form-control valid validText" id="txtNombresUsuario"
                                    name="txtNombresUsuario" required="" maxlength="30">
                            </div>

                            <div class="modal-body mb-3">
                                <label for="txtRolUsuario">Selecciona el Rol</label>
                                <select class="form-control selectpicker" id="txtRolUsuario" name="txtRolUsuario">
                                </select>
                            </div>

                            <div class="modal-body form-select-lg mb-3">
                                <label for="listStatus">Estado</label>
                                <select class="form-select" id="listStatus" name="listStatus">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-success" type="submit"><i
                                        class="bi bi-floppy"></i>
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
            <td>Estado:</td>
            <td id="celEstadoUsuario">0</td>
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
            <td>Nivel Escolar:</td>
            <td id="celNivelEscolarFuncionario">0</td>
        </tr>
        <tr>
            <td>Carrera:</td>
            <td id="celCarreraFuncionario">0</td>
        </tr>
        <tr>
            <td>Especialidad:</td>
            <td id="celEspecialidadFuncionario">0</td>
        </tr>
        <tr>
            <td>Maestría:</td>
            <td id="celMaestriaFuncionario">0</td>
        </tr>
        <tr>
            <td>Doctorado:</td>
            <td id="celDoctoradoFuncionario">0</td>
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