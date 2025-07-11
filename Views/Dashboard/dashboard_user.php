<?php headerAdmin($data); ?>
<link rel="stylesheet" href="<?= media() ?>/css/dashboard-user.css">

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Bienvenido</p>
                            <h5 class="font-weight-bolder mb-0">
                                <?= $_SESSION['userData']['nombres'] ?>
                                <span class="text-success text-sm font-weight-bolder"><?= $_SESSION['userData']['nombrerol'] ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fa fa-user text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas del Usuario -->
<div class="row dashboard-user-stats">
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="card">
            <span class="mask bg-gradient-tasks opacity-10 border-radius-lg"></span>
            <div class="card-body p-3 position-relative">
                <div class="row">
                    <div class="col-8 text-start">
                        <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                            <i class="fas fa-tasks text-dark text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                        <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['estadisticas_usuario']['tareas_asignadas'] ?></h5>
                        <span class="text-white text-sm">Tareas Asignadas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="card">
            <span class="mask bg-gradient-completed opacity-10 border-radius-lg"></span>
            <div class="card-body p-3 position-relative">
                <div class="row">
                    <div class="col-8 text-start">
                        <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                            <i class="fas fa-check-circle text-dark text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                        <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['estadisticas_usuario']['tareas_completadas'] ?></h5>
                        <span class="text-white text-sm">Completadas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="card">
            <span class="mask bg-gradient-pending opacity-10 border-radius-lg"></span>
            <div class="card-body p-3 position-relative">
                <div class="row">
                    <div class="col-8 text-start">
                        <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                            <i class="fas fa-clock text-dark text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                        <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['estadisticas_usuario']['tareas_pendientes'] ?></h5>
                        <span class="text-white text-sm">Pendientes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="card">
            <span class="mask bg-gradient-overdue opacity-10 border-radius-lg"></span>
            <div class="card-body p-3 position-relative">
                <div class="row">
                    <div class="col-8 text-start">
                        <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                            <i class="fas fa-exclamation-triangle text-dark text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                        <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['estadisticas_usuario']['tareas_vencidas'] ?></h5>
                        <span class="text-white text-sm">Vencidas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficas del Usuario -->
<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="card chart-card z-index-2 h-100">
            <div class="card-header pb-0">
                <h6>Mis Tareas por Estado</h6>
                <p class="text-sm">
                    <i class="fa fa-chart-pie text-info"></i>
                    <span class="font-weight-bold">Distribución</span> de tus tareas
                </p>
            </div>
            <div class="card-body p-3">
                <div class="chart-container">
                    <canvas id="chart-doughnut-user" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card chart-card z-index-2 h-100">
            <div class="card-header pb-0">
                <h6>Tareas Completadas por Mes</h6>
                <p class="text-sm">
                    <i class="fa fa-chart-line text-success"></i>
                    <span class="font-weight-bold">Progreso</span> de tus tareas completadas
                </p>
            </div>
            <div class="card-body p-3">
                <div class="chart-container">
                    <canvas id="chart-line-user" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $esNtic = (strpos(strtolower($_SESSION['userData']['nombrerol'] ?? ''), 'ntic') !== false); ?>
<?php if($esNtic): ?>
<!-- Tareas pendientes para hoy -->
<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h6>Tareas Pendientes para Hoy</h6>
            </div>
            <div class="card-body p-3">
                <?php if(!empty($data['tareas_pendientes_hoy'])): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($data['tareas_pendientes_hoy'] as $tarea): ?>
                            <tr>
                                <td><?= htmlspecialchars($tarea['descripcion']) ?></td>
                                <td><?= htmlspecialchars($tarea['fecha_fin']) ?></td>
                                <td><?= htmlspecialchars($tarea['estado']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">No tienes tareas pendientes para hoy.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Histórico de tareas pendientes -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h6>Histórico de Tareas Pendientes</h6>
            </div>
            <div class="card-body p-3">
                <canvas id="chart-historico-tareas" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Renderizar gráfico de histórico de tareas pendientes
    const historico = <?= json_encode($data['historico_tareas_pendientes'] ?? []) ?>;
    const labels = historico.map(item => item.fecha);
    const datos = historico.map(item => parseInt(item.total));
    if(document.getElementById('chart-historico-tareas')) {
        new Chart(document.getElementById('chart-historico-tareas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendientes',
                    data: datos,
                    backgroundColor: '#ffc107',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }
});
</script>
<?php endif; ?>

<!-- Acceso rápido a tareas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Acceso Rápido</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <a href="<?= base_url() ?>/tareas" class="btn btn-outline-primary w-100 quick-access-btn">
                            <i class="fas fa-list me-2"></i>Ver Todas Mis Tareas
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <a href="<?= base_url() ?>/tareas?estado=pendiente" class="btn btn-outline-warning w-100 quick-access-btn">
                            <i class="fas fa-clock me-2"></i>Tareas Pendientes
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <a href="<?= base_url() ?>/tareas?estado=vencida" class="btn btn-outline-danger w-100 quick-access-btn">
                            <i class="fas fa-exclamation-triangle me-2"></i>Tareas Vencidas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.tareasEstadoData = <?= json_encode($data['tareas_por_estado']) ?>;
window.tareasMesData = <?= json_encode($data['tareas_por_mes']) ?>;
</script>

<?php footerAdmin($data); ?>