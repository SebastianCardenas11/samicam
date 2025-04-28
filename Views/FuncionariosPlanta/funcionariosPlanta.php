<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-person-fill"></i> <?=$data['page_title']?></h1>
        </div>
        <div class="d-flex gap-2 mt-3">
            <!-- Botón para crear nuevo funcionario -->
            <?php if ($_SESSION['permisosMod']['w']) { ?>
                <button class="btn btn-warning" type="button" data-bs-toggle="modal" onclick="openModal();">
                    <i class="bi bi-plus-lg"></i>
                    Nuevo Funcionario</button>
            <?php } ?>
            
            <!-- Botones para Permisos y Viáticos -->
            <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
                <a href="<?= base_url(); ?>/funcionariospermisos">
                    <button class="btn btn-warning" type="button">
                        <i class="bi bi-door-open"></i> Permisos
                    </button>
                </a>
                <a href="<?= base_url(); ?>/funcionariosviaticos">
                    <button class="btn btn-warning" type="button">
                        <i class="bi bi-cash-coin"></i> Viáticos
                    </button>
                </a>
            <?php } ?>
        </div>

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?=base_url();?>/funcionarios"><?=$data['page_title']?></a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover cell-border" id="tableFuncionarios">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center">id</th> 
                                    <th class="text-center">Nombre completo</th>
                                    <th class="text-center">Identificacion</th> 
                                    <th class="text-center">Cargo</th> 
                                    <th class="text-center">Dependencia</th> 
                                    <th class="text-center">Celular</th> 
                                    <th class="text-center">Direccion</th> 
                                    <th class="text-center">Correo electronico</th> 
                                    <th class="text-center">Fecha de ingreso</th>
                                    <th class="text-center">Vacaciones</th>
                                    <th class="text-center">Hijos</th>
                                    <th class="text-center">Nombre de hijos</th>
                                    <th class="text-center">Sexo</th>
                                    <th class="text-center">Lugar de recidencia</th>
                                    <th class="text-center">Edad</th>
                                    <th class="text-center">Estado civil</th>
                                    <th class="text-center">Religion</th>
                                    <th class="text-center">Nivel escolar</th>
                                    <th class="text-center">Carrera</th>
                                    <th class="text-center">Especialidad</th>
                                    <th class="text-center">Maestria</th>
                                    <th class="text-center">Doctorado</th>
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
getModal('modalFuncionariosPlanta', $data);
footerAdmin($data);
?>
