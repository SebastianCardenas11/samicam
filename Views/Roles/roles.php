<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-toggles"></i> <?=$data['page_title']?></h1>
        </div>

        <div class="button-nuevo">
            <?php if ($_SESSION['permisosMod']['w']) {?>
            <button class="btn btn-info" type="button" data-bs-toggle="modal" onclick="openModal();">
                <i class="bi bi-plus-lg"></i>
                Nuevo Rol</button>
            <?php }?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive mt-2">
                        <table class="table table-estilo" id="tableRoles">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">Descripción</th>
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
<?php 
getModal('modalRoles', $data);
footerAdmin($data);?>