<?php 
    headerAdmin($data); 
    getModal('modalPublicaciones', $data);
?>
<link rel="stylesheet" href="<?= media() ?>/css/publicaciones.css">
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="mb-4">
                    <div class="card-header pb-0">
                        <h6>Listado de Publicaciones</h6>
                        <?php if($_SESSION['permisosMod']['w']){ ?>
                        <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nueva Publicación</button>
                        <?php } ?>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="tablePublicaciones">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Recibido</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Asunto</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Pub.</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Respuesta</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Enlace</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</main>

<style>
.table td {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>

<?php footerAdmin($data); ?>