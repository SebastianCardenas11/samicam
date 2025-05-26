<?php
headerAdmin($data);
?>
<link rel="stylesheet" href="<?= media(); ?>/css/error-custom.css">
<script>
document.querySelector('header').classList.add('header-v4');
</script>
<div class="container text-center">
    <main class="app-content">
        <div class="page-error tile">
            <?php if(isset($data['error_code'])): ?>
                <div class="error-code"><?= $data['error_code']; ?></div>
            <?php endif; ?>
            
            <?php if(isset($data['error_title'])): ?>
                <h1><?= $data['error_title']; ?></h1>
            <?php endif; ?>
            
            <?php if(isset($data['error_message'])): ?>
                <p><?= $data['error_message']; ?></p>
            <?php elseif(isset($data['page']['contenido'])): ?>
                <?= $data['page']['contenido']; ?>
            <?php else: ?>
                <p>Ha ocurrido un error inesperado.</p>
            <?php endif; ?>
            
            <p><a class="btn btn-dark" href="javascript:window.history.back();">Regresar</a></p>
        </div>
    </main>
</div>

<?php footerAdmin($data); ?>