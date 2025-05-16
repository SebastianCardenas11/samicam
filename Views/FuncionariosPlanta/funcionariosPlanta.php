<?php
headerAdmin($data);
?>
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-people"></i> <?= $data['page_title'] ?></h1>
        </div>
        <?php if ($_SESSION['permisosMod']['w']) { ?>
            <div>
                <button class="btn-usuarios-add" type="button" data-bs-toggle="modal" onclick="openModal();">
                    <i class="bi bi-plus-lg"></i>
                    Nuevo Usuario
                </button>
            </div>
        <?php } ?>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="usuarios-box">
                <div class="usuarios-box-body">
                    <div class="usuarios-table-responsive">
                        <table class="usuarios-table" id="tableUsuarios">
                            <thead>
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
                            <tbody>
                                <!-- contenido generado dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
getModal('modalUsuarios', $data);
footerAdmin($data);
?>