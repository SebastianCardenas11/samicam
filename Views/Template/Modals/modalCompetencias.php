<!-- Modal -->
<div class="modal fade" id="modalFormCompetencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Competencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formCompetencia" name="formCompetencia" enctype="multipart/form-data" method="POST">
                            <input type="hidden" id="ideCompetencia" name="ideCompetencia" value="">
                            <div class="modal-body">
                                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son
                                    obligatorios.
                                </p>
                                <hr>
                                <p class="text-primary">Datos de la Competencia</p>
                            </div>

                            <div class="modal-body">
                                <label for="txtCodigoCompetencia">Código de la Competencia<span
                                        class="required">*</span></label>
                                <input type="text" class="form-control valid validNumber" id="txtCodigoCompetencia"
                                    name="txtCodigoCompetencia" required="" maxlength="10"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtTipoCompetencia">Tipo de Competencia</label>
                                <select class="form-select selectpicker" data-style="btn-success"
                                    id="txtTipoCompetencia" name="txtTipoCompetencia" required>
                                    <option value="Técnica">Técnica</option>
                                    <option value="Transversal">Transversal</option>
                                </select>
                            </div>


                            <div class="modal-body">
                                <label for="txtNombreCompetencia">Nombre de la Competencia <span
                                        class="required">*</span></label>
                                <input type="text" class="form-control validText" id="txtNombreCompetencia"
                                    name="txtNombreCompetencia" required="">
                            </div>

                            <div class="modal-body">
                                <label for="txtHorasCompetencia">Horas de la COMPETENCIA <span
                                        class="required">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtHorasCompetencia"
                                    name="txtHorasCompetencia" required="" maxlength="10"
                                    onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtCodigoPrograma">NUMERO DE FICHA <span class="required">*</span></label>
                                <input type="text" class="form-control validNumber" id="txtCodigoPrograma"
                                    onchange="fntViewInfoCodigoPrograma(this.value);" name="txtCodigoPrograma"
                                    required="" maxlength="10" onkeypress="return controlTag(event);">
                            </div>

                            <div class="modal-body">
                                <label for="txtIdePrograma">ID de LA FICHA <span class="required">*</span></label>
                                <input type="text" class="form-control" id="txtIdePrograma" name="txtIdePrograma"
                                    required="">
                            </div>

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
<div class="modal fade" id="modalViewCompetencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos de la Competencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">


                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Codigo:</td>
                                    <td id="celCodigoCompetencia">233104</td>
                                </tr>

                                <tr>
                                    <td>Nombre:</td>
                                    <td id="celNombreCompetencia">Programación de Software</td>
                                </tr>

                                <tr>
                                    <td>Tipo:</td>
                                    <td id="celTipoPrograma">2875079</td>
                                </tr>

                                <tr>
                                    <td>Horas:</td>
                                    <td id="celHorasCompetencia">Horas Competencia</td>
                                </tr>

                                <tr>
                                    <td>Programa:</td>
                                    <td id="celNombrePrograma">2875079</td>
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