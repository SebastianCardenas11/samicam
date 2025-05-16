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
                                    <th>Correo</th>
                                    <th>Nombres</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
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