<?php 
require_once 'Views/Template/header_admin.php';
require_once 'Views/Template/nav_admin.php';
?>
<main class="app-content">
  <div class="app-title d-flex justify-content-between align-items-center">
    <div>
      <h1><i class="bi bi-box-seam"></i> Inventario</h1>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalIngreso">Ingresos</button>
      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalSalida">Salidas</button>
      <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalPrestamo">Préstamos</button>
    </div>
  </div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background: #ebebee; border-radius: 10px; padding: 8px 18px; margin-bottom: 10px;">
      <li class="breadcrumb-item"><i class="bi bi-house-door"></i></li>
      <li class="breadcrumb-item active" aria-current="page">Inventario</li>
    </ol>
  </nav>
  <div class="container-fluid mt-3">
    <!-- Tabs principales -->
    <ul class="nav nav-tabs custom-tabs" id="tabInventario" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="graficos-tab" data-bs-toggle="tab" data-bs-target="#graficos" type="button" role="tab">
          <i class="bi bi-bar-chart-line"></i> <b>Gráficos</b>
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="impresoras-tab" data-bs-toggle="tab" data-bs-target="#impresoras" type="button" role="tab">
          <i class="bi bi-printer"></i> Impresoras
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="equipos-tab" data-bs-toggle="tab" data-bs-target="#equipos" type="button" role="tab">
          <i class="bi bi-pc-display"></i> Equipos de Cómputo
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="herramientas-tab" data-bs-toggle="tab" data-bs-target="#herramientas" type="button" role="tab">
          <i class="bi bi-tools"></i> Herramientas
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="prestamos-tab" data-bs-toggle="tab" data-bs-target="#prestamos" type="button" role="tab">
          <i class="bi bi-clock-history"></i> Préstamos
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="salidas-tab" data-bs-toggle="tab" data-bs-target="#salidas" type="button" role="tab">
          <i class="bi bi-box-arrow-up"></i> Salidas
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="ingresos-tab" data-bs-toggle="tab" data-bs-target="#ingresos" type="button" role="tab">
          <i class="bi bi-box-arrow-in-down"></i> Ingresos
        </button>
      </li>
    </ul>
    <div class="tab-content mt-3" id="tabInventarioContent">
      <!-- Tab de Gráficos -->
      <div class="tab-pane fade show active" id="graficos" role="tabpanel">
        <div class="row mb-4">
          <div class="col-md-6 d-flex align-items-stretch">
            <div class="card mb-4 shadow-sm border-0 w-100" style="height: 400px;">
              <div class="card-body d-flex flex-column justify-content-between p-3" style="height: 100%;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="fw-bold text-primary mb-0">
                    <i class="bi bi-bar-chart-steps"></i> Inventario por Categoría
                  </h5>
                  <button class="btn btn-link text-secondary p-0" style="font-size:1.2rem;">
                    <i class="bi bi-gear"></i>
                  </button>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-grow-1" style="min-height: 320px;">
                  <canvas id="graficoBarrasCategoria" style="height: 320px; width: 100%"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch">
            <div class="card mb-4 shadow-sm border-0 w-100" style="height: 400px;">
              <div class="card-body d-flex flex-column justify-content-between p-3" style="height: 100%;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="fw-bold text-primary mb-0">
                    <i class="bi bi-pie-chart"></i> Distribución General
                  </h5>
                  <button class="btn btn-link text-secondary p-0" style="font-size:1.2rem;">
                    <i class="bi bi-gear"></i>
                  </button>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-grow-1" style="min-height: 320px;">
                  <canvas id="graficoDonaDistribucion" style="height: 320px; width: 100%"></canvas>
                </div>
                <div id="leyendaDistribucion" class="d-flex flex-wrap justify-content-center mt-2"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm border-0">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="fw-bold text-primary mb-0">
                    <i class="bi bi-graph-up"></i> Histórico de Ingresos
                  </h5>
                  <button class="btn btn-link text-secondary p-0" style="font-size:1.2rem;">
                    <i class="bi bi-gear"></i>
                  </button>
                </div>
                <div class="graficos-container">
                  <canvas id="graficoHistoricoIngresos" style="height: 200px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm border-0">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="fw-bold text-primary mb-0">
                    <i class="bi bi-graph-down"></i> Histórico de Salidas
                  </h5>
                  <button class="btn btn-link text-secondary p-0" style="font-size:1.2rem;">
                    <i class="bi bi-gear"></i>
                  </button>
                </div>
                <div class="graficos-container">
                  <canvas id="graficoHistoricoSalidas" style="height: 200px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm border-0">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="fw-bold text-primary mb-0">
                    <i class="bi bi-arrow-left-right"></i> Histórico de Préstamos
                  </h5>
                  <button class="btn btn-link text-secondary p-0" style="font-size:1.2rem;">
                    <i class="bi bi-gear"></i>
                  </button>
                </div>
                <div class="graficos-container">
                  <canvas id="graficoHistoricoPrestamos" style="height: 200px;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Submódulo Impresoras -->
      <div class="tab-pane fade" id="impresoras" role="tabpanel">
        <?php require_once 'Views/Inventario/impresoras.php'; ?>
        <?php require_once 'Views/Inventario/escaner.php'; ?>
        <?php require_once 'Views/Inventario/tintas_toner.php'; ?>
        <?php require_once 'Views/Inventario/papeleria.php'; ?>
      </div>
      <!-- Submódulo Equipos de Cómputo -->
      <div class="tab-pane fade" id="equipos" role="tabpanel">
        <?php require_once 'Views/Inventario/pc_torre.php'; ?>
        <?php require_once 'Views/Inventario/todo_en_uno.php'; ?>
        <?php require_once 'Views/Inventario/portatiles.php'; ?>
      </div>
      <!-- Submódulo Herramientas -->
      <div class="tab-pane fade" id="herramientas" role="tabpanel">
        <?php require_once 'Views/Inventario/herramientas.php'; ?>
      </div>
      <!-- Submódulo Préstamos -->
      <div class="tab-pane fade" id="prestamos" role="tabpanel">
        <?php require_once 'Views/Inventario/prestamos.php'; ?>
      </div>
      <!-- Submódulo Salidas -->
      <div class="tab-pane fade" id="salidas" role="tabpanel">
        <?php require_once 'Views/Inventario/salidas.php'; ?>
      </div>
      <!-- Submódulo Ingresos -->
      <div class="tab-pane fade" id="ingresos" role="tabpanel">
        <?php require_once 'Views/Inventario/ingresos.php'; ?>
      </div>
    </div>

    <!-- Modales para Ingresos, Salidas y Préstamos (placeholders) -->
    <?php //if (file_exists('Views/Inventario/modals/modal_ingreso.php')) require_once 'Views/Inventario/modals/modal_ingreso.php'; ?>
    <?php //if (file_exists('Views/Inventario/modals/modal_salida.php')) require_once 'Views/Inventario/modals/modal_salida.php'; ?>
    <?php //if (file_exists('Views/Inventario/modals/modal_prestamo.php')) require_once 'Views/Inventario/modals/modal_prestamo.php'; ?>
  </div>
</main>

<style>
.widget-small {
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,.1);
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 8px;
    padding: 15px 10px;
}
.widget-small .icon {
    font-size: 2.2rem;
    margin-right: 15px;
}
.widget-small.primary .icon { color: #007bff; }
.widget-small.info .icon { color: #17a2b8; }
.widget-small.danger .icon { color: #dc3545; }
.widget-small.warning .icon { color: #ffc107; }
.widget-small .info h4 {
    font-size: 0.95rem;
    margin-bottom: 5px;
    font-weight: 600;
    color: #495057;
}
.widget-small .info p {
    font-size: 1.3rem;
    margin: 0;
    color: #222;
}
.graficos-container {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}
.tile {
    margin-bottom: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 1px rgba(0,0,0,.08);
    padding: 20px 15px 10px 15px;
}
.tile-title {
    font-size: 1.1rem;
    margin-bottom: 15px;
    font-weight: 600;
    color: #495057;
    text-align: center;
}
.tile-body {
    padding: 0;
    background: #f4f6fa;
    border-radius: 8px;
}
.custom-tabs .nav-link {
  color: #135087;
  font-weight: 500;
  background: transparent;
  border: none;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 1rem;
  padding: 0.7rem 1.5rem;
  transition: background 0.2s, color 0.2s;
}
.custom-tabs .nav-link.active {
  background: #fff;
  border: 1.5px solid #e0e0e0;
  border-bottom: none;
  color: #000;
  font-weight: bold;
  border-radius: 10px 10px 0 0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.custom-tabs .nav-link i {
  font-size: 1.1rem;
}
.card .fw-bold.text-primary {
  font-size: 1.1rem;
}
.card {
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  background: #fff;
}
.card-body {
  padding: 1.2rem 1.2rem 1rem 1.2rem !important;
}
.fw-semibold {
  font-weight: 600;
}
.btn-link {
  text-decoration: none;
}
#leyendaDistribucion {
  font-size: 0.98rem;
  gap: 18px;
}
#leyendaDistribucion span {
  display: flex;
  align-items: center;
  margin-right: 18px;
  margin-bottom: 4px;
}
#leyendaDistribucion i {
  width: 16px;
  height: 16px;
  display: inline-block;
  border-radius: 50%;
  margin-right: 6px;
}
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Chart.js datalabels plugin -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const labels = ['Impresoras', 'Escáner', 'Tintas/Tóner', 'Papelería', 'PC Torre', 'Todo en uno', 'Portátiles'];
  const dataValores = [12, 5, 8, 15, 7, 6, 9];
  const colores = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6610f2', '#20c997', '#fd7e14'];

  // Crear gradientes para las barras
  function getBarGradient(ctx, color) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, color + 'cc');
    gradient.addColorStop(1, color + '66');
    return gradient;
  }

  const ctxBarras = document.getElementById('graficoBarrasCategoria').getContext('2d');
  const barGradients = colores.map(color => getBarGradient(ctxBarras, color));

  new Chart(ctxBarras, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Cantidad',
        data: dataValores,
        backgroundColor: barGradients,
        borderColor: colores,
        borderWidth: 2,
        borderRadius: 12,
        hoverBackgroundColor: colores.map(c => c + 'ff'),
        barPercentage: 0.65,
        categoryPercentage: 0.55
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        title: { display: false },
        tooltip: {
          backgroundColor: '#343a40',
          titleColor: '#fff',
          bodyColor: '#fff',
          borderColor: '#007bff',
          borderWidth: 1
        },
        datalabels: {
          anchor: 'end',
          align: 'end',
          color: '#222',
          font: { weight: 'bold', size: 14 },
          formatter: function(value) { return value; }
        }
      },
      animation: {
        duration: 1200,
        easing: 'easeOutBounce'
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { color: '#495057', font: { weight: 'bold' } }
        },
        y: {
          beginAtZero: true,
          grid: { color: '#e9ecef' },
          ticks: { color: '#495057', font: { weight: 'bold' } }
        }
      }
    },
    plugins: [ChartDataLabels]
  });

  const ctxPastel = document.getElementById('graficoDonaDistribucion').getContext('2d');
  new Chart(ctxPastel, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: dataValores,
        backgroundColor: colores,
        borderColor: '#fff',
        borderWidth: 3,
        hoverOffset: 12
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: {
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            color: '#495057',
            font: { size: 15, weight: 'bold' },
            usePointStyle: true
          }
        },
        title: { display: false },
        tooltip: {
          backgroundColor: '#343a40',
          titleColor: '#fff',
          bodyColor: '#fff',
          borderColor: '#28a745',
          borderWidth: 1
        }
      },
      animation: {
        animateRotate: true,
        animateScale: true,
        duration: 1200,
        easing: 'easeOutCirc'
      }
    }
  });

  // Datos de ejemplo para históricos (puedes reemplazar por datos reales)
  const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
  const ingresosHistorico = [2, 3, 1, 4, 2, 5, 3, 2, 4, 3, 2, 1];
  const salidasHistorico = [1, 2, 2, 1, 3, 2, 1, 2, 1, 2, 3, 2];
  const prestamosHistorico = [0, 1, 0, 2, 1, 1, 2, 1, 0, 1, 1, 0];

  // Gráfico de Histórico de Ingresos
  new Chart(document.getElementById('graficoHistoricoIngresos').getContext('2d'), {
    type: 'line',
    data: {
      labels: meses,
      datasets: [{
        label: 'Ingresos',
        data: ingresosHistorico,
        borderColor: '#28a745',
        backgroundColor: 'rgba(40,167,69,0.1)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#28a745',
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Gráfico de Histórico de Salidas
  new Chart(document.getElementById('graficoHistoricoSalidas').getContext('2d'), {
    type: 'line',
    data: {
      labels: meses,
      datasets: [{
        label: 'Salidas',
        data: salidasHistorico,
        borderColor: '#dc3545',
        backgroundColor: 'rgba(220,53,69,0.1)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#dc3545',
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Gráfico de Histórico de Préstamos
  new Chart(document.getElementById('graficoHistoricoPrestamos').getContext('2d'), {
    type: 'line',
    data: {
      labels: meses,
      datasets: [{
        label: 'Préstamos',
        data: prestamosHistorico,
        borderColor: '#ffc107',
        backgroundColor: 'rgba(255,193,7,0.1)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#ffc107',
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
});
</script>
<?php require_once 'Views/Template/footer_admin.php'; ?> 