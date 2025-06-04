            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Funcionarios</h3>
                    <div>
                        <?php if($_SESSION['permisosMod']['w']){ ?>
                        <button class="btn btn-primary mr-2" type="button" onclick="openModal();"><i class="bi bi-plus-circle-fill"></i> Nuevo</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url(); ?>/importarFuncionarios/generarPlantilla"><i class="bi bi-download"></i> Descargar Plantilla</a></li>
                                <li><a class="dropdown-item" href="#" onclick="openModalImportar();"><i class="bi bi-upload"></i> Importar Funcionarios</a></li>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

<!-- Modal Importar Funcionarios -->
<div class="modal fade" id="modalImportar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Importar Funcionarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formImportar" name="formImportar">
                    <div class="form-group">
                        <label for="archivo_excel">Seleccione el archivo Excel:</label>
                        <input type="file" class="form-control" id="archivo_excel" name="archivo_excel" accept=".xlsx,.xls">
                    </div>
                    <div class="alert alert-info mt-3">
                        <h6 class="alert-heading">Instrucciones:</h6>
                        <ol class="mb-0">
                            <li>Descargue la plantilla usando el botón "Descargar Plantilla"</li>
                            <li>Complete la información en la plantilla</li>
                            <li>No modifique los encabezados de las columnas</li>
                            <li>Asegúrese de que todos los campos estén completos</li>
                            <li>Guarde el archivo y súbalo usando este formulario</li>
                        </ol>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="importarFuncionarios();"><i class="bi bi-upload"></i> Importar</button>
            </div>
        </div>
    </div>
</div> 