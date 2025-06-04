<?php headerAdmin($data); ?>

<!-- Incluir estilos específicos para ajustes -->
<link href="<?= media() ?>/css/ajustes.css" rel="stylesheet">

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-cog"></i> Ajustes de Perfil</h1>
            <p>Actualiza tu información personal.</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="tile">
                <div class="tile-body">
                    <form id="formAjustesPerfil" enctype="multipart/form-data">
                        <div class="mb-3 text-center">
                            <img id="imgPreview" src="<?= !empty($data['usuario']['imgperfil']) ? base_url().'/uploads/perfiles/'.$data['usuario']['imgperfil'] : media().'/images/user.png' ?>" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;" alt="Foto de perfil">
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto de perfil</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $data['usuario']['nombres'] ?>" required>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php footerAdmin($data); ?> 