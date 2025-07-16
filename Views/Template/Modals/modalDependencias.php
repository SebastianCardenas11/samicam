<!-- Modal Formulario -->
<div class="modal fade" id="modalFormDependencias" tabindex="-1" aria-labelledby="modalFormDependencias" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva S.D.O</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                    <form id="formDependencias" name="formDependencias" enctype="multipart/form-data" method="POST">
                        <input type="hidden" id="idDependencia" name="idDependencia" value="">
                        <div class="modal-body">
                            <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                            <hr>
                            <label for="txtNombreDependencia">Nombre del S.D.O<span class="required">*</span></label>
                            <input type="text" class="form-control" id="txtNombreDependencia" name="txtNombreDependencia" required maxlength="255">
                        </div>
                        <div class="modal-footer">
                            <button id="btnActionForm" class="btn btn-success" type="submit"><i class="bi bi-floppy"></i> <span id="btnText">Guardar</span></button>
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver -->
<div class="modal fade" id="modalViewDependencias" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-dark">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del S.D.O</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                    <table class="table table-bordered align-middle mb-0">
                        <tbody>
                            <tr class="bg-light">
                                <th scope="row" class="text-dark">ID:</th>
                                <td id="celId" class="text-dark"></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-dark">Nombre:</th>
                                <td id="celNombre" class="text-dark"></td>
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