<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
        <h1 class="mb-0 me-4"><i class="bi bi-person-fill"></i> <?=$data['page_title']?></h1>
        <?php if ($_SESSION['permisosMod']['w']) { ?>
            <button class="btn btn-warning btn-sm mb-0 p-3" type="button" data-bs-toggle="modal" onclick="openModal();">
                <i class="bi bi-plus-lg"></i> Nuevo Funcionario Ops
            </button>
        <?php } ?>
    </div>
</div>
<ul class="app-breadcrumb breadcrumb">
<li class="breadcrumb-item"><i class="bi bi-house"></i></li>
<li class="breadcrumb-item"><a href="<?=base_url();?>/funcionariosOps"><?=$data['page_title']?></a></li>
</ul>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-estilo" id="tableFuncionarios">
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

<?php 
getModal('modalFuncionariosOps', $data);
footerAdmin($data);
?>