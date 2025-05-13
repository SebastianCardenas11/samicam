<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-person-fill"></i> <?=$data['page_title']?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?=base_url();?>/funcionarios"><?=$data['page_title']?></a></li>
        </ul>
        <div class="d-flex gap-2 mt-3">
        <!-- Botón para crear nuevo funcionario -->
        <?php if ($_SESSION['permisosMod']['w']) { ?>
            <button class="btn btn-warning" type="button" data-bs-toggle="modal" onclick="openModal();">
                <i class="bi bi-plus-lg"></i>
                Nuevo Funcionario</button>
        <?php } ?>
    </div>
        
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-estilo" id="tableFuncionarios">
                            <thead class="table-success">
                                <tr>
                                    <!-- <th class="text-center">id</th>  -->
                                    <th class="text-center">Nombre completo</th>
                                    <th class="text-center">Identificacion</th> 
                                    <th class="text-center">Cargo</th> 
                                    <th class="text-center">Dependencia</th>
                                    <th class="text-center">Permisos</th>
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
// getModal('modalFuncionariosPlanta', $data);
footerAdmin($data);
?>
