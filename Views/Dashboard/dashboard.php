<link rel="stylesheet" href="">
<?php
include '../../template/Header.php';
include '../../template/Nav.php';

?>

<!-- Contenido principal -->
<main class="app-content">
    <div class="app-title">
        <div class="title-left">
            <h1><i class="bi bi-house-door"></i> Inicio</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm h-100 animate-card">
                <div class="card-body d-flex flex-column align-items-center text-center">
                    <i class="bi bi-person-badge fs-1 text-primary mb-3"></i>
                    <h5 class="card-title mb-3">Funcionarios</h5>
                    <p class="card-text fs-2">
                        <?php
                        $sql = $conexion->query("SELECT COUNT(*) AS total_usuarios FROM usuarios");
                        $datos = $sql->fetch_object();
                        echo htmlspecialchars($datos->total_usuarios);
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm h-100 animate-card">
                <div class="card-body d-flex flex-column align-items-center text-center">
                    <i class="bi bi-inboxes fs-1 text-info mb-3"></i>
                    <h5 class="card-title mb-3">Inventario Equipos</h5>
                    <p class="card-text fs-2">
                        <?php
                        $sql = $conexion->query("SELECT COUNT(*) AS total_inventarioEquipos FROM inventario_pc");
                        $datos = $sql->fetch_object();
                        echo htmlspecialchars($datos->total_inventarioEquipos);
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm h-100 animate-card">
                <div class="card-body d-flex flex-column align-items-center text-center">
                    <i class="bi bi-clock-history fs-1 text-warning mb-3"></i>
                    <h5 class="card-title mb-3">Historial Equipos</h5>
                    <p class="card-text fs-2">
                        <?php
                        $sql = $conexion->query("SELECT COUNT(*) AS total_HistrorialEquipos FROM historial_equipo");
                        $datos = $sql->fetch_object();
                        echo htmlspecialchars($datos->total_HistrorialEquipos);
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../../template/Footer.php'; ?>