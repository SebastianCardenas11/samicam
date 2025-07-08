<?php 
headerAdmin($data); 
?>

<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-cogs"></i> <?= $data['page_title'] ?></h1>
           
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/funcionariospermisos">Permisos</a></li>
            <li class="breadcrumb-item active"><?= $data['page_title'] ?></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="tile-title"><i class="fas fa-list"></i> Lista de Motivos</h3>
                    <div class="tile-title-btn">
                        <button class="btn btn-primary" onclick="openModal()">
                            <i class="fas fa-plus"></i> Nuevo Motivo
                        </button>
                    </div>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableMotivos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
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
</main>

<!-- Modal para motivos -->
<div class="modal fade" id="modalFormMotivo" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Motivo</h5>
            </div>
            <div class="modal-body">
                <form id="formMotivo" name="formMotivo">
                    <input type="hidden" id="idMotivo" name="id_motivo">
                    
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="txtNombre" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" id="txtDescripcion" name="descripcion" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Estado <span class="text-danger">*</span></label>
                        <select class="form-control" id="listStatus" name="status" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" onclick="$('#modalFormMotivo').modal('hide')">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnActionForm" onclick="fntSaveMotivo()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>