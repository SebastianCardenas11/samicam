<!-- Modal -->
<div class="modal fade" id="modalFormArchivo" tabindex="-1" aria-labelledby="modalFormArchivo" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                    <form id="formArchivo" name="formArchivo" enctype="multipart/form-data" method="POST">
                        <input type="hidden" id="idArchivo" name="idArchivo" value="">
                        <div class="modal-body">
                            <p class="text-primary">Los campos con asterisco (<span class="required text-danger">*</span>) son
                                obligatorios.
                            </p>
                            <hr>
                            <p class="text-primary">Datos del Archivo</p>
                        </div>
                        <div class="modal-body">
                            <label for="txtNombre">Nombre<span class="required text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtNombre"
                                name="txtNombre" required="">
                        </div>

                        <div class="modal-body">
                            <label for="txtDescripcion">Descripción</label>
                            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="3"></textarea>
                        </div>

                        <div class="modal-body">
                            <label for="fileArchivo">Archivo<span class="required text-danger">*</span></label>
                            <input type="file" class="form-control" id="fileArchivo" name="fileArchivo" required="">
                            <small class="text-muted">Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, JPEG, PNG, GIF</small>
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

<!-- Modal Ver Archivo -->
<div class="modal fade" id="modalViewArchivo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content text-dark">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Detalles del Archivo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="tile-body">
          <table class="table table-bordered align-middle mb-3">
           <tbody>
              <tr class="bg-light">
                <th scope="row" class="text-dark">ID:</th>
                <td id="celId" class="text-dark"></td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Nombre:</th>
                <td id="celNombre" class="text-dark"></td>
              </tr>
              <tr class="bg-light">
                <th scope="row" class="text-dark">Descripción:</th>
                <td id="celDescripcion" class="text-dark"></td>
              </tr>
              <tr>
                <th scope="row" class="text-dark">Tipo:</th>
                <td id="celTipo" class="text-dark"></td>
              </tr>
              <tr class="bg-light">
                <th scope="row" class="text-dark">Fecha:</th>
                <td id="celFecha" class="text-dark"></td>
              </tr>
            </tbody>
          </table>
          
          <div class="text-center mb-3" id="filePreview">
            <!-- Aquí se mostrará la vista previa del archivo -->
          </div>
        </div>

        <div class="modal-footer">
          <a id="btnDownload" href="#" class="btn btn-primary" download>
            <i class="bi bi-download"></i> Descargar
          </a>
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">
            <i class="bi bi-check2"></i> Listo
          </button>
        </div>
      </div>
    </div>
  </div>
</div>