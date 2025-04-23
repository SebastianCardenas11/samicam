<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-person-fill-gear"></i> <?=$data['page_title']?></h1>
        </div>

        <!-- Botones de Permisos de Salida y Viáticos -->
        <div class="d-flex gap-2 mt-3">
            <?php if ($_SESSION['permisosMod']['w']) { ?>
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
    </div>
</main>


<?php 
// getModal('modalUsuarios', $data);
footerAdmin($data);
?>