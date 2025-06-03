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

<div class="modal fade" id="modalImportarExcel" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"><i class="bi bi-file-earmark-excel me-2"></i>Importar Funcionarios desde Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <div class="border-start border-4 border-dark ps-3 mb-4">
                    <h6 class="fw-bold mb-3">Información Importante</h6>
                    <p class="text-muted mb-2">Antes de importar funcionarios, tenga en cuenta lo siguiente:</p>
                    <ul class="text-muted mb-2 ps-3">
                        <li class="mb-2">No se pueden importar funcionarios con identificaciones o correos electrónicos que ya existan en el sistema.</li>
                        <li class="mb-2">Los IDs de cargo, dependencia y contrato deben existir previamente en el sistema.</li>
                        <li class="mb-2">Todos los campos son obligatorios excepto "Nombres de Hijos".</li>
                        <li class="mb-2">El formato de fecha debe ser YYYY-MM-DD (ejemplo: 2024-03-14).</li>
                        <li class="mb-2">El campo "Sexo" debe ser: masculino o femenino.</li>
                        <li class="mb-2">Los campos numéricos (Identificación, Edad) deben contener solo números.</li>
                        <li class="mb-2">En el campo "Número de Hijos" coloque 0 si no tiene hijos.</li>
                    </ul>
                </div>

                <div class="text-center mb-4">
                    <p class="text-muted mb-3">Se recomienda descargar y utilizar la plantilla proporcionada para evitar errores en la importación.</p>
                    <a href="<?= base_url(); ?>/ImportarFuncionarios/generarPlantilla" class="btn btn-success">
                        <i class="bi bi-download me-2"></i>Descargar Plantilla Excel
                    </a>
                </div>

                <form id="formImportarExcel" name="formImportarExcel">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Seleccione el archivo Excel</label>
                        <input class="form-control" type="file" name="archivo_excel" id="archivo_excel" accept=".xlsx,.xls">
                        <div class="form-text">Solo se aceptan archivos Excel (.xlsx, .xls)</div>
                    </div>

                    <div class="border-start border-4 border-warning bg-light p-3 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Importante:</strong> 
                                <span class="text-muted">Si intenta importar funcionarios con datos duplicados (identificación o correo), el sistema le mostrará un mensaje indicando las filas específicas donde se encontraron los duplicados.</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i>Cerrar
                        </button>
                        <button class="btn btn-success" type="submit">
                            <i class="bi bi-upload me-2"></i>Importar
                        </button>
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