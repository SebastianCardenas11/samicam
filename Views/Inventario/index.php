<?php 
require_once 'Views/Template/header_admin.php';
require_once 'Views/Template/nav_admin.php';
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-box-seam"></i> Inventario</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">Inventario</a></li>
    </ul>
  </div>
  <div class="container-fluid mt-3">
    <!-- Botones principales arriba -->
    <div class="mb-4 d-flex gap-3">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalIngreso">Ingresos</button>
      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalSalida">Salidas</button>
      <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalPrestamo">Préstamos</button>
    </div>

    <!-- Tabs principales -->
    <ul class="nav nav-tabs" id="tabInventario" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="graficos-tab" data-bs-toggle="tab" data-bs-target="#graficos" type="button" role="tab">Gráficos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="impresoras-tab" data-bs-toggle="tab" data-bs-target="#impresoras" type="button" role="tab">Impresoras</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="equipos-tab" data-bs-toggle="tab" data-bs-target="#equipos" type="button" role="tab">Equipos de Cómputo</button>
      </li>
    </ul>
    <div class="tab-content mt-3" id="tabInventarioContent">
      <!-- Tab de Gráficos -->
      <div class="tab-pane fade show active" id="graficos" role="tabpanel">
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="widget-small primary"><i class="icon bi bi-box-seam"></i>
              <div class="info">
                <h4>Total Inventario</h4>
                <p><b>58</b></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-small info"><i class="icon bi bi-arrow-down-circle"></i>
              <div class="info">
                <h4>Ingresos</h4>
                <p><b>20</b></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-small danger"><i class="icon bi bi-arrow-up-circle"></i>
              <div class="info">
                <h4>Salidas</h4>
                <p><b>10</b></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-small warning"><i class="icon bi bi-arrow-left-right"></i>
              <div class="info">
                <h4>Préstamos</h4>
                <p><b>5</b></p>
              </div>
            </div>
          </div>
        </div>
        <div class="graficos-container">
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="tile">
                <h3 class="tile-title">Inventario por Categoría</h3>
                <div class="tile-body">
                  <canvas id="graficoBarras" style="height: 250px;"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="tile">
                <h3 class="tile-title">Distribución General</h3>
                <div class="tile-body">
                  <canvas id="graficoPastel" style="height: 250px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-4">
              <div class="tile">
                <h3 class="tile-title">Histórico de Ingresos</h3>
                <div class="tile-body">
                  <canvas id="graficoHistoricoIngresos" style="height: 200px;"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="tile">
                <h3 class="tile-title">Histórico de Salidas</h3>
                <div class="tile-body">
                  <canvas id="graficoHistoricoSalidas" style="height: 200px;"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="tile">
                <h3 class="tile-title">Histórico de Préstamos</h3>
                <div class="tile-body">
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

  const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
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

  const ctxPastel = document.getElementById('graficoPastel').getContext('2d');
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