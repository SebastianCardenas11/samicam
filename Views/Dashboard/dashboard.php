<?php headerAdmin($data); ?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1>
                <i class="bi bi-house-door"></i>
                </i> Inicio
            </h1>
            <p> Sistema Administrativo de Módulos de Información del Centro Administrativo</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        </ul>
    </div>
    <div class="row">

        <?php if (!empty($_SESSION['permisos'][2]['d'])) { ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="<?= base_url() ?>/usuarios" class="text-decoration-none">
                    <div class="card shadow-sm animate-card">
                        <div class="card-body text-center">
                            <i class="bi bi-people fs-1 text-primary mb-3"></i>
                            <h5 class="card-title mb-2">Usuarios</h5>

                            <p class="card-text fs-2"><b><?= $data['usuarios'] ?></b></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>


        <?php if (!empty($_SESSION['permisos'][2]['d'])) { ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="<?= base_url() ?>/usuarios" class="text-decoration-none">
                    <div class="card shadow-sm animate-card">
                        <div class="card-body text-center">
                            <i class="bi bi-people fs-1 text-primary mb-3"></i>
                            <h5 class="card-title mb-2">Roles</h5>

                            <p class="card-text fs-2"><b><?= $data['usuarios'] ?></b></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>



    </div>
</main>
<?php footerAdmin($data); ?>