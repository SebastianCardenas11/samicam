<?php 
    headerAdmin($data); 
    getModal('modalPublicaciones', $data);
?>
<link rel="stylesheet" href="<?= media() ?>/css/publicaciones.css">
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-newspaper"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/publicaciones"></a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile mb-4">
                <div class="tile-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tabla-tab" data-bs-toggle="tab" href="#tabla" role="tab" aria-controls="tabla" aria-selected="true">Tabla</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="graficos-tab" data-bs-toggle="tab" href="#graficos" role="tab" aria-controls="graficos" aria-selected="false">Gráficos</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!-- Tab de Tabla -->
                        <div class="tab-pane fade show active" id="tabla" role="tabpanel" aria-labelledby="tabla-tab">
                            <div class="mb-3">
                                <?php if($_SESSION['permisosMod']['w']){ ?>
                                <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nueva Publicación</button>
                                <?php } ?>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tablePublicaciones">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha Recibido</th>
                                            <th>Correo</th>
                                            <th>Asunto</th>
                                            <th>Dependencia</th>
                                            <th>Fecha Publicación</th>
                                            <th>Respuesta</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Tab de Gráficos -->
                        <div class="tab-pane fade" id="graficos" role="tabpanel" aria-labelledby="graficos-tab">
                            <!-- Dashboard de Estadísticas -->
                            <div class="row mb-4">
                                <!-- Total de Publicaciones -->
                                <div class="col-md-3">
                                    <div class="widget-small primary"><i class="icon bi bi-newspaper"></i>
                                        <div class="info">
                                            <h4>Total Publicaciones</h4>
                                            <p><b><?= $data['estadisticas']['total_publicaciones'] ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Publicaciones Recientes -->
                                <div class="col-md-3">
                                    <div class="widget-small info"><i class="icon bi bi-clock-history"></i>
                                        <div class="info">
                                            <h4>Últimos 7 días</h4>
                                            <p><b><?= $data['estadisticas']['publicaciones_recientes'] ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Publicaciones Pendientes -->
                                <div class="col-md-3">
                                    <div class="widget-small warning"><i class="icon bi bi-hourglass-split"></i>
                                        <div class="info">
                                            <h4>Pendientes</h4>
                                            <p><b><?= $data['estadisticas']['publicaciones_pendientes'] ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tasa de Respuesta -->
                                <div class="col-md-3">
                                    <div class="widget-small success"><i class="icon bi bi-check-circle"></i>
                                        <div class="info">
                                            <h4>Tasa de Respuesta</h4>
                                            <p><b><?= number_format(($data['estadisticas']['total_publicaciones'] - $data['estadisticas']['publicaciones_pendientes']) / max(1, $data['estadisticas']['total_publicaciones']) * 100, 1) ?>%</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="graficos-container">
                                <div class="row">
                                    <!-- Gráfica de Publicaciones por Mes -->
                                    <div class="col-md-8">
                                        <div class="tile">
                                            <h3 class="tile-title">Tendencia de Publicaciones</h3>
                                            <div class="tile-body">
                                                <canvas id="publicacionesPorMes" style="height: 250px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Gráfica de Estado de Publicaciones -->
                                    <div class="col-md-4">
                                        <div class="tile">
                                            <h3 class="tile-title">Estado de Publicaciones</h3>
                                            <div class="tile-body">
                                                <canvas id="estadoPublicaciones" style="height: 250px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Gráfica de Respuestas de Envío -->
                                    <div class="col-md-4">
                                        <div class="tile">
                                            <h3 class="tile-title">Respuestas de Envío</h3>
                                            <div class="tile-body">
                                                <canvas id="respuestasEnvio" style="height: 200px;"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gráfica de Publicaciones por Dependencia -->
                                    <div class="col-md-8">
                                        <div class="tile">
                                            <h3 class="tile-title">Publicaciones por Dependencia</h3>
                                            <div class="tile-body">
                                                <canvas id="publicacionesPorDependencia" style="height: 200px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.widget-small {
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,.1);
}
.widget-small .info h4 {
    font-size: 0.9rem;
    margin-bottom: 5px;
}
.tile {
    margin-bottom: 20px;
}
.tile-title {
    font-size: 1.1rem;
    margin-bottom: 15px;
}
.table td {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.graficos-container {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}
</style>

<?php footerAdmin($data); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar cuando se hace clic en la pestaña de gráficos
    document.getElementById('graficos-tab').addEventListener('click', function() {
        setTimeout(function() {
            initCharts();
        }, 200);
    });
});

function initCharts() {
    // Datos para las gráficas
    const estadisticas = <?= json_encode($data['estadisticas']) ?>;
    
    // Configuración de colores
    const colors = {
        primary: '#007bff',
        success: '#28a745',
        warning: '#ffc107',
        danger: '#dc3545',
        info: '#17a2b8'
    };

    // Gráfica de Publicaciones por Mes
    const mesesLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    const datosPorMes = new Array(12).fill(0);
    estadisticas.publicaciones_por_mes.forEach(item => {
        datosPorMes[item.mes - 1] = parseInt(item.total);
    });

    new Chart(document.getElementById('publicacionesPorMes'), {
        type: 'line',
        data: {
            labels: mesesLabels,
            datasets: [{
                label: 'Publicaciones',
                data: datosPorMes,
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfica de Estado de Publicaciones
    new Chart(document.getElementById('estadoPublicaciones'), {
        type: 'doughnut',
        data: {
            labels: ['Activas', 'Inactivas'],
            datasets: [{
                data: [
                    estadisticas.estado_publicaciones.find(e => e.status == 1)?.total || 0,
                    estadisticas.estado_publicaciones.find(e => e.status == 0)?.total || 0
                ],
                backgroundColor: [colors.success, colors.danger]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfica de Respuestas de Envío
    new Chart(document.getElementById('respuestasEnvio'), {
        type: 'pie',
        data: {
            labels: ['Respondidas', 'Pendientes'],
            datasets: [{
                data: [
                    estadisticas.respuestas_envio.find(e => e.respuesta_envio == 'Si')?.total || 0,
                    estadisticas.respuestas_envio.find(e => e.respuesta_envio == 'No')?.total || 0
                ],
                backgroundColor: [colors.success, colors.warning]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfica de Publicaciones por Dependencia
    const dependenciasData = estadisticas.publicaciones_por_dependencia;
    new Chart(document.getElementById('publicacionesPorDependencia'), {
        type: 'bar',
        data: {
            labels: dependenciasData.map(item => item.dependencia),
            datasets: [{
                label: 'Publicaciones',
                data: dependenciasData.map(item => parseInt(item.total)),
                backgroundColor: colors.info
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}
</script>