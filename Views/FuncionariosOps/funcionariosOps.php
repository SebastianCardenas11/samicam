<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-tie"></i> <?= $data['page_title'] ?>
                <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn btn-warning ms-3" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nuevo Funcionario OPS</button>
                <?php } ?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/funcionariosOps"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableFuncionariosOps">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center">Número Contrato</th>
                                    <th class="text-center">Nombre Contratista</th>
                                    <th class="text-center">Identificación</th>
                                    <th class="text-center">Objeto</th>
                                    <th class="text-center">Valor Contrato</th>
                                    <th class="text-center">Fecha Inicio</th>
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

<?php getModal('modalFuncionariosOps', $data); ?>
<?php getModal('modalFuncionariosOpsVer', $data); ?>

<?php footerAdmin($data); ?>