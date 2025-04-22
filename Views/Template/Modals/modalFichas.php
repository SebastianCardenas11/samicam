<!-- Modal -->
<div class="modal fade" id="modalFormFicha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Ficha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formFicha" name="formFicha" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideFicha" name="ideFicha" value="">
                            <div class="modal-body">
                                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son
                                    obligatorios.
                                </p>
                                <hr>
                                <p class="text-primary">Datos de la Ficha</p>
                            </div>

                            <div class="modal-body">
                                <label for="txtCodigoPrograma">Codigo del programa<span
                                        class="required">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtCodigoPrograma"
                                    onchange="fntViewInfoCodigoPrograma(this.value);" name="txtCodigoPrograma"
                                    required="" maxlength="10" onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtIdPrograma">ID PROGRAMA<span class="required">*</span></label>
                                <input type="text" class="form-control" id="txtIdPrograma" name="txtIdPrograma"
                                    required="">
                            </div>


                            <div class="modal-body">
                                <label for="txtFichaPrograma">Número de Ficha<span class="required">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtFichaPrograma"
                                    name="txtFichaPrograma" required="">
                            </div>

                            <div class="modal-body">
                                <label for="txtIdeInstructor">Identificación del Instructor<span
                                        class="required">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtIdeInstructor"
                                    onchange="fntViewInfoIdeInstructor(this.value);" name="txtIdeInstructor" required=""
                                    maxlength="10" onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtIdeUsuario">IDE USUARIO <span class="required">*</span></label>
                                <input type="text" class="form-control" id="txtIdeUsuario" name="txtIdeUsuario"
                                    required="">
                            </div>

                            <!-- <div class="modal-body">
                                <label for="txtNombreCompetencia">Nombre del COMPETENCIA <span
                                        class="required">*</span></label>
                                <input type="text" class="form-control" id="txtNombreCompetencia"
                                    name="txtNombreCompetencia" required="" disabled>
                            </div> -->

                            <BR></BR>
                            <div class="modal-footer">
                                <button id="btnActionForm" class="btn btn-success" type="submit"><i
                                        class="bi bi-floppy"></i><span id="btnText">Guardar</span></button>

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
<div class="modal fade" id="modalViewFicha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">ASIGNAR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">


                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Número de Ficha:</td>
                                    <td id="celIdeFicha">233104</td>
                                </tr>
                                <tr>
                                    <td>Programa:</td>
                                    <td id="celCodigoPrograma">233104</td>
                                </tr>

                                <tr>
                                    <td>Instructor Líder:</td>
                                    <td id="celNumeroFicha">Programación de Software</td>
                                </tr>

                                <tr>
                                    <td>Horas del Programa:</td>
                                    <td id="celIdeInstructor">Horas Competencia</td>
                                </tr>

                                <tr>
                                    <td>Nivel del Programa:</td>
                                    <td id="celEstadoFicha">2875079</td>
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