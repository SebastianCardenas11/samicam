<?php
headerAdmin($data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-person-fill-gear"></i> <?=$data['page_title']?></h1>
        </div>
        <!-- <div class="d-grid gap-2 d-md-block">
            <?php if ($_SESSION['permisosMod']['w']) {?>
            <button class="btn btn-warning" type="button" data-bs-toggle="modal" onclick="openModal();">
                <i class="bi bi-plus-lg"></i>
                Nuevo Usuario</button>
            <?php }?>
        </div> -->


       
    </div>
  
</main>
<?php 
// getModal('modalUsuarios', $data);
footerAdmin($data);
?>