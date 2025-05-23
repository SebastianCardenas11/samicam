<?php headerAdmin($data); ?>
<div class="row">
    <?php if (!empty($_SESSION['permisos'][2]['d'])) { ?>
    <!-- Usuarios -->
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <a href="<?=base_url()?>/usuarios">
            <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-8 text-start">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                <i class="fas fa-users text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['usuarios'] ?></h5>
                            <span class="text-white text-sm">Usuarios</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>

    <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
    <!-- Funcionarios OPS -->
    <div class="col-lg-3 col-md-6 col-12 mb-3" >
        <a href="<?=base_url()?>/funcionariosOps">
            <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-8 text-start">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                <i class="fas fa-user-cog text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['funcionariosops'] ?></h5>
                            <span class="text-white text-sm">Funcionarios OPS</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>

    <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
    <!-- Funcionarios Planta -->
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <a href="<?=base_url()?>/funcionariosPlanta">
            <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-8 text-start">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                <i class="fas fa-user-tie text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['funcionariosplanta'] ?></h5>
                            <span class="text-white text-sm">Funcionarios Planta</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>

    <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
    <!-- Vacaciones Activas -->
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <a href="<?=base_url()?>/vacaciones">
            <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-8 text-start">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-2xl">
                                <i class="fas fa-calendar-week text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="text-white font-weight-bolder mb-0 mt-3"><?= $data['estadisticas']['vacacionesActivas'] ?></h5>
                            <span class="text-white text-sm">Vacaciones Activas</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>
</div>

<div class="row mt-4">
  <!-- Gráficas de funcionarios -->
  <div class="col-lg-6 mb-4">
    <div class="card z-index-2 h-100">
      <div class="card-body p-3">
        <div class="bg-dark border-radius-md py-3 pe-1 mb-3">
          <div class="chart">
            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
          </div>
        </div>
        <h6 class="ms-2 mt-4 mb-0 text-dark">Funcionarios por Cargo</h6>
        <p class="text-sm ms-2 text-dark">Distribución de funcionarios según su cargo</p>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-4">
    <div class="card z-index-2 h-100">
      <div class="card-header pb-0">
        <h6 class="text-dark">Permisos por Mes</h6>
        <p class="text-sm text-dark">
          <i class="fa fa-calendar text-success"></i>
          <span class="font-weight-bold">Registro de permisos</span> durante el año
        </p>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script para inicializar las gráficas -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para la gráfica de funcionarios por cargo
    const funcionariosPorCargo = <?= json_encode($data['funcionariosPorCargo']) ?>;
    const labelsCargos = funcionariosPorCargo.map(item => item.nombre_cargo);
    const valoresCargos = funcionariosPorCargo.map(item => parseInt(item.cantidad));
    
    // Datos para la gráfica de permisos por mes
    const permisosPorMes = <?= json_encode($data['permisosPorMes']) ?>;
    const labelsMeses = permisosPorMes.map(item => item.mes);
    const valoresPermisos = permisosPorMes.map(item => parseInt(item.total_permisos));
    
    // Inicializar gráfica de funcionarios por cargo
    const ctxBars = document.getElementById('chart-bars').getContext('2d');
    new Chart(ctxBars, {
        type: 'bar',
        data: {
            labels: labelsCargos,
            datasets: [{
                label: 'Funcionarios',
                tension: 0.4,
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false,
                backgroundColor: '#fff',
                data: valoresCargos,
                maxBarThickness: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 500,
                        beginAtZero: true,
                        padding: 15,
                        font: {
                            size: 14,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                        color: "#fff"
                    },
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false
                    },
                    ticks: {
                        display: true,
                        color: '#fff',
                        padding: 10,
                        font: {
                            size: 14,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
    
    // Inicializar gráfica de permisos por mes
    const ctxLine = document.getElementById('chart-line').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labelsMeses,
            datasets: [{
                label: 'Permisos',
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 0,
                borderColor: "#cb0c9f",
                backgroundColor: 'rgba(203, 12, 159, 0.2)',
                fill: true,
                data: valoresPermisos,
                maxBarThickness: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
});
</script>

<?php footerAdmin($data); ?>