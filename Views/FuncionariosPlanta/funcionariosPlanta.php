<?php
headerAdmin($data);
?>


<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <h1 class="mb-0 me-4">
                <i class="bi bi-person-fill"></i> <?= $data['page_title'] ?>
            </h1>
            
            <?php if ($_SESSION['permisosMod']['w']) { ?>
                <button class="btn btn-warning btn-sm px-3 py-2" type="button" onclick="openModal();">
                    <i class="bi bi-plus-lg fs-5 text-black"></i> Nuevo Funcionario Planta
                </button>
                
                <button class="btn btn-success btn-sm px-3 py-2" type="button" onclick="openModalImportar();">
                    <i class="bi bi-file-earmark-excel fs-5 text-black"></i> Importar Excel
                </button>

                
                <?php } ?>
                
                <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
                    <a href="<?= base_url(); ?>/funcionariospermisos" class="btn btn-warning btn-sm px-3 py-2">
                        <i class="bi bi-door-open-fill fs-5 text-black"></i> Permisos
                    </a>
                    <?php } ?>
                </div>
            </div>
            
            <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/funcionariosPlanta"><?= $data['page_title'] ?></a></li>
            </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableFuncionarios">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center">Foto</th>
                                    <th class="text-center">Nombre completo</th>
                                    <th class="text-center">Identificacion</th> 
                                    <th class="text-center">Cargo</th> 
                                    <th class="text-center">Dependencia</th> 
                                    <th class="text-center">Contrato</th> 
                                    <th class="text-center">Correo electronico</th> 
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th> 
                             </tr>
                            </thead>
                            <tbody class="table-group-divider text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php  getModal('modalFuncionariosPlanta', $data); ?>

<div class="modal fade" id="modalImportarExcel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Importar Funcionarios desde Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 text-center">
                    <a href="<?= base_url(); ?>/ImportarFuncionarios/generarPlantilla" class="btn btn-info">
                        <i class="bi bi-download"></i> Descargar Plantilla Excel
                    </a>
                </div>
                <form id="formImportarExcel" name="formImportarExcel">
                    <div class="form-group">
                        <label class="control-label">Archivo Excel</label>
                        <input class="form-control" type="file" name="archivo_excel" id="archivo_excel" accept=".xlsx,.xls">
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-success" type="submit"><i class="bi bi-upload"></i> Importar</button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data);?>

<script>
// Verificar permisos para mostrar botones de exportación
document.addEventListener("DOMContentLoaded", function() {
    <?php if ($_SESSION['permisosMod']['w']) { ?>
        // Si tiene permisos de escritura, mostrar botones de exportación
        const exportButtons = document.querySelectorAll('.dt-buttons');
        exportButtons.forEach(function(btn) {
            btn.style.display = 'block';
        });
    <?php } else { ?>
        // Si no tiene permisos, ocultar botones de exportación
        const exportButtons = document.querySelectorAll('.dt-buttons');
        exportButtons.forEach(function(btn) {
            btn.style.display = 'none';
        });
    <?php } ?>
});
</script>