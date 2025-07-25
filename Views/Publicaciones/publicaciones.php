<?php 
    headerAdmin($data); 
    getModal('modalPublicaciones', $data);
?>
<link rel="stylesheet" href="<?= media() ?>/css/publicaciones.css">
<main class="app-content">
    <div class="app-title">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex align-items-center">
                <h1 class="me-3"><i class="bi bi-newspaper"></i> <?= $data['page_title'] ?></h1>
                <?php if($_SESSION['permisosMod']['w']){ ?>
                    <button class="btn btn-warning" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nueva Publicación</button>
                <?php } ?>
            </div>
        </div>
        <ul class="app-breadcrumb breadcrumb m-0">
            <li class="breadcrumb-item"><i class="bi bi-house fs-6"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/publicaciones"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="tile mb-4">
                <div class="tile-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tabla-tab" data-bs-toggle="tab" href="#tabla" role="tab" aria-controls="tabla" aria-selected="true"><i class="bi bi-table me-2"></i>Tabla</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="graficos-tab" data-bs-toggle="tab" href="#graficos" role="tab" aria-controls="graficos" aria-selected="false"><i class="bi bi-bar-chart-line-fill me-2"></i>Gráficos</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!-- Tab de Tabla -->
                        <div class="tab-pane fade show active" id="tabla" role="tabpanel" aria-labelledby="tabla-tab">
                            <div class="table-responsive mt-3">
                                <table class="table table-hover table-bordered" id="tablePublicaciones">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center">Fecha Recibido</th>
                                    <th class="text-center">Correo</th>
                                    <th class="text-center">Nombre Publicación</th>
                                    <th class="text-center">Asunto</th> 
                                    <th class="text-center">Dependencia</th> 
                                    <th class="text-center">Fecha Publicación</th> 
                                    <th class="text-center">Respuesta</th> 
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th> 
                             </tr>
                            </thead>
                            <tbody class="table-group-divider text-center">
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
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h3 class="tile-title mb-0">Tendencia de Publicaciones</h3>
                                                <div class="d-flex gap-2">
                                                    <input type="date" id="fechaInicio" class="form-control form-control-sm" style="width: 150px;">
                                                    <input type="date" id="fechaFin" class="form-control form-control-sm" style="width: 150px;">
                                                    <button type="button" id="btnFiltrar" class="btn btn-primary btn-sm">Filtrar</button>
                                                    <button type="button" id="btnLimpiar" class="btn btn-secondary btn-sm">Limpiar</button>
                                                </div>
                                            </div>
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
.d-flex.gap-2 > * {
    margin-right: 8px;
}
.d-flex.gap-2 > *:last-child {
    margin-right: 0;
}
#fechaInicio, #fechaFin {
    font-size: 0.875rem;
}
#btnFiltrar, #btnLimpiar {
    white-space: nowrap;
}
</style>

<?php footerAdmin($data); ?>

<script>
let chartTendencia = null;

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar cuando se hace clic en la pestaña de gráficos
    document.getElementById('graficos-tab').addEventListener('click', function() {
        setTimeout(function() {
            initCharts();
            setupDateFilters();
        }, 200);
    });
});

function setupDateFilters() {
    const btnFiltrar = document.getElementById('btnFiltrar');
    const btnLimpiar = document.getElementById('btnLimpiar');
    
    if (btnFiltrar) {
        btnFiltrar.addEventListener('click', function() {
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            
            if (fechaInicio && fechaFin) {
                if (fechaInicio > fechaFin) {
                    alert('La fecha de inicio no puede ser mayor que la fecha fin');
                    return;
                }
                cargarGraficoFiltrado(fechaInicio, fechaFin);
            } else {
                alert('Por favor seleccione ambas fechas');
            }
        });
    }
    
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function() {
            document.getElementById('fechaInicio').value = '';
            document.getElementById('fechaFin').value = '';
            cargarGraficoOriginal();
        });
    }
}

function initCharts() {
    const estadisticas = <?= json_encode($data['estadisticas']) ?>;
    actualizarTodosLosGraficos(estadisticas);
}

function crearGraficoTendencia(datos) {
    const colors = {
        primary: '#007bff'
    };
    
    const mesesLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    const datosPorMes = new Array(12).fill(0);
    datos.forEach(item => {
        datosPorMes[item.mes - 1] = parseInt(item.total);
    });

    if (chartTendencia) {
        chartTendencia.destroy();
    }

    chartTendencia = new Chart(document.getElementById('publicacionesPorMes'), {
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
}

function cargarGraficoFiltrado(fechaInicio, fechaFin) {
    fetch(`${base_url}/publicaciones/getPublicacionesPorFecha`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`
    })
    .then(response => response.json())
    .then(data => {
        actualizarTodosLosGraficos(data);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar los datos filtrados');
    });
}

function cargarGraficoOriginal() {
    const estadisticas = <?= json_encode($data['estadisticas']) ?>;
    actualizarTodosLosGraficos(estadisticas);
}

function actualizarTodosLosGraficos(estadisticas) {
    // Actualizar gráfico de tendencia
    crearGraficoTendencia(estadisticas.publicaciones_por_mes);
    
    // Actualizar gráfico de estado
    actualizarGraficoEstado(estadisticas.estado_publicaciones);
    
    // Actualizar gráfico de respuestas
    actualizarGraficoRespuestas(estadisticas.respuestas_envio);
    
    // Actualizar gráfico de dependencias
    actualizarGraficoDependencias(estadisticas.publicaciones_por_dependencia);
}

let chartEstado, chartRespuestas, chartDependencias;

function actualizarGraficoEstado(datos) {
    const colors = { success: '#28a745', danger: '#dc3545' };
    
    if (chartEstado) chartEstado.destroy();
    
    chartEstado = new Chart(document.getElementById('estadoPublicaciones'), {
        type: 'doughnut',
        data: {
            labels: ['Activas', 'Inactivas'],
            datasets: [{
                data: [
                    datos.find(e => e.status == 1)?.total || 0,
                    datos.find(e => e.status == 0)?.total || 0
                ],
                backgroundColor: [colors.success, colors.danger]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}

function actualizarGraficoRespuestas(datos) {
    const colors = { success: '#28a745', warning: '#ffc107' };
    
    if (chartRespuestas) chartRespuestas.destroy();
    
    chartRespuestas = new Chart(document.getElementById('respuestasEnvio'), {
        type: 'pie',
        data: {
            labels: ['Respondidas', 'Pendientes'],
            datasets: [{
                data: [
                    datos.find(e => e.respuesta_envio == 'Si')?.total || 0,
                    datos.find(e => e.respuesta_envio == 'No')?.total || 0
                ],
                backgroundColor: [colors.success, colors.warning]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}

function actualizarGraficoDependencias(datos) {
    const colors = { info: '#17a2b8' };
    
    if (chartDependencias) chartDependencias.destroy();
    
    chartDependencias = new Chart(document.getElementById('publicacionesPorDependencia'), {
        type: 'bar',
        data: {
            labels: datos.map(item => item.dependencia),
            datasets: [{
                label: 'Publicaciones',
                data: datos.map(item => parseInt(item.total)),
                backgroundColor: colors.info
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
}
</script>

<!-- DataTables Buttons -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>