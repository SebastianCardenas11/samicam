<?php headerAdmin($data); ?>
<?php getModal('modalViaticos', $data); ?>
<?php getModal('modalPresupuestoViaticos', $data); ?>

<!-- Incluir CSS específico para viáticos -->
<link rel="stylesheet" href="<?= media(); ?>/css/viaticos.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.viaticos-cards-row {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 2rem;
}
.viaticos-card {
  flex: 1 1 220px;
  min-width: 220px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  padding: 1.2rem 1.5rem;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  transition: box-shadow 0.2s;
}
.viaticos-card .viaticos-card-content {
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
}
.viaticos-card .viaticos-card-title {
  font-size: 0.95rem;
  font-weight: 600;
  color: #888;
  text-transform: uppercase;
  margin-bottom: 0.2rem;
}
.viaticos-card .viaticos-card-value {
  font-size: 1.5rem;
  font-weight: 700;
  color: #222;
}
.viaticos-card .viaticos-card-icon {
  font-size: 2.1rem;
  opacity: 0.85;
}
.viaticos-card.blue { border-left: 5px solid #2563eb; }
.viaticos-card.blue .viaticos-card-icon { color: #2563eb; }
.viaticos-card.red { border-left: 5px solid #dc2626; }
.viaticos-card.red .viaticos-card-icon { color: #dc2626; }
.viaticos-card.green { border-left: 5px solid #16a34a; }
.viaticos-card.green .viaticos-card-icon { color: #16a34a; }
.viaticos-card.yellow { border-left: 5px solid #eab308; }
.viaticos-card.yellow .viaticos-card-icon { color: #eab308; }
@media (max-width: 900px) {
  .viaticos-cards-row { flex-direction: column; gap: 1.2rem; }
  .viaticos-card { min-width: 0; }
}
/* Estilos minimalistas para los gráficos */
.grafico-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  padding: 2rem 1.5rem 1.5rem 1.5rem;
  margin-bottom: 2rem;
  min-height: 340px;
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 2rem;
}
.grafico-card .grafico-leyenda {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  gap: 0.7rem;
}
.grafico-card .grafico-leyenda .leyenda-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1.1rem;
}
.grafico-card .grafico-leyenda .leyenda-color {
  width: 18px;
  height: 18px;
  border-radius: 4px;
  display: inline-block;
}
.grafico-card .grafico-valores {
  margin-top: 1.2rem;
  font-size: 1.2rem;
}
.grafico-card .grafico-valores strong {
  font-size: 1.3rem;
}
.grafico-donut-center {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  font-size: 1.3rem;
  font-weight: bold;
  color: #222;
}
.grafico-donut-container {
  position: relative;
  width: 180px;
  height: 180px;
  margin: 0 auto;
}
.grafico-barra-container {
  width: 100%;
  min-width: 220px;
  height: 220px;
}
@media (max-width: 900px) {
  .grafico-card { flex-direction: column; gap: 1.2rem; min-height: 0; }
  .grafico-donut-container { width: 140px; height: 140px; }
}
</style>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="col-12 mb-2">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <h1 class="fw-bold mb-0" style="font-size:2.8rem; line-height:1.1;"><i class="bi bi-cash-stack me-2"></i><?= $data['page_title'] ?></h1>
                    <div class="btn-group mt-2 mt-md-0" role="group">
                        <button class="btn btn-primary" onclick="openModalViatico();"><i class="bi bi-plus-lg"></i> Agregar Viático</button>
                        <button class="btn btn-success" onclick="openModalPresupuesto();"><i class="bi bi-cash-stack"></i> Presupuesto</button>
                        <button id="btnReporteAnual" class="btn btn-danger"><i class="bi bi-file-pdf"></i> Reporte Anual</button>
                    </div>
                </div>
                <ul class="app-breadcrumb breadcrumb mt-2">
                    <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/funcionariosviaticos"><?= $data['page_title'] ?></a></li>
                </ul>
            </div>
        </div>
        <!-- Tabs para Resumen y Gráficos -->
        <ul class="nav nav-tabs mb-3" id="viaticosTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab" aria-controls="resumen" aria-selected="true">
              <i class="bi bi-list-ul"></i> Resumen
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="graficos-tab" data-bs-toggle="tab" data-bs-target="#graficos" type="button" role="tab" aria-controls="graficos" aria-selected="false">
              <i class="bi bi-bar-chart-line"></i> Gráficos
            </button>
          </li>
        </ul>
        <div class="tab-content" id="viaticosTabContent">
          <div class="tab-pane fade show active" id="resumen" role="tabpanel" aria-labelledby="resumen-tab">
            <!-- Filtros de año y botón filtrar -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
              <label for="selectAnio" class="form-label mb-0 me-2">Año:</label>
              <select id="selectAnio" class="form-select form-select-sm me-2" style="width:auto;">
                <?php 
                  $currentYear = date('Y');
                  for($i = $currentYear; $i <= $currentYear+1; $i++) {
                    $selected = ($i == $currentYear) ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>$i</option>";
                  }
                ?>
              </select>
              <button id="btnFiltrar" class="btn btn-sm btn-primary">Filtrar</button>
            </div>
            <!-- Tarjetas resumen de viáticos -->
            <div class="viaticos-cards-row">
              <div class="viaticos-card blue">
                <div class="viaticos-card-content">
                  <span class="viaticos-card-title">Total de viáticos</span>
                  <span class="viaticos-card-value" id="cardTotalViaticos">$0</span>
                </div>
                <i class="fa-solid fa-sack-dollar viaticos-card-icon"></i>
              </div>
              <div class="viaticos-card red">
                <div class="viaticos-card-content">
                  <span class="viaticos-card-title">Viáticos usados</span>
                  <span class="viaticos-card-value" id="cardViaticosUsados">$0</span>
                </div>
                <i class="fa-solid fa-money-bill-trend-up viaticos-card-icon"></i>
              </div>
              <div class="viaticos-card green">
                <div class="viaticos-card-content">
                  <span class="viaticos-card-title">Viáticos disponibles</span>
                  <span class="viaticos-card-value" id="cardViaticosDisponibles">$0</span>
                </div>
                <i class="fa-solid fa-wallet viaticos-card-icon"></i>
              </div>
              <div class="viaticos-card yellow">
                <div class="viaticos-card-content">
                  <span class="viaticos-card-title">Viáticos entregados en el año</span>
                  <span class="viaticos-card-value" id="cardViaticosEntregados">0</span>
                </div>
                <i class="fa-solid fa-list-check viaticos-card-icon"></i>
              </div>
            </div>
            <div class="content-body">
                <section id="viaticos-historico" class="mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Histórico de Viáticos por Funcionario</h4>
                        </div>
                        <div class="card-body">
                            <table id="tableHistoricoViaticos" class="table table-bordered no-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Funcionario</th>
                                        <th>Total Viáticos Asignados</th>
                                        <th>Total Valor de Viáticos</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="viaticos-detalle" class="mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detalle de Viáticos Otorgados</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tableDetalleViaticos" class="table table-bordered no-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Funcionario</th>
                                            <th>Cargo</th>
                                            <th>Dependencia</th>
                                            <th>Motivo</th>
                                            <th>Lugar Comisión (Depto)</th>
                                            <th>Lugar Comisión (Ciudad)</th>
                                            <th>Finalidad</th>
                                            <th>Descripción</th>
                                            <th>Fecha Aprobación</th>
                                            <th>Fecha Salida</th>
                                            <th>Fecha Regreso</th>
                                            <th>N° Días</th>
                                            <th>Valor Día</th>
                                            <th>Valor Viático</th>
                                            <th>Tipo Transporte</th>
                                            <th>Valor Transporte</th>
                                            <th>Total Liquidado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div> <!-- /content-body dentro de tab resumen -->
          </div>
          <div class="tab-pane fade" id="graficos" role="tabpanel" aria-labelledby="graficos-tab">
            <div class="row mb-4 justify-content-center">
              <div class="col-md-6">
                <div class="card p-4">
                  <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <h4 class="mb-0"><i class="bi bi-pie-chart"></i> Capital Viáticos (Polar Area)</h4>
                    <div class="d-flex align-items-center gap-2">
                      <select id="selectAnioPolar" class="form-select form-select-sm me-1" style="width: auto;">
                        <?php 
                        $currentYear = date('Y');
                        for($i = $currentYear; $i <= $currentYear+1; $i++) {
                          $selected = ($i == $currentYear) ? 'selected' : '';
                          echo "<option value=\"$i\" $selected>$i</option>";
                        }
                        ?>
                      </select>
                      <button id="btnFiltrarPolar" class="btn btn-sm btn-primary">Filtrar</button>
                    </div>
                  </div>
                  <div style="min-height:200px;display:flex;align-items:center;justify-content:center;">
                    <canvas id="polarAreaCapital" width="200" height="120" class="grafico-pequeno"></canvas>
                  </div>
                  <div class="row mt-3 text-center">
                    <div class="col-4">
                      <span class="badge" style="background:#3b82f6">Total</span>
                    </div>
                    <div class="col-4">
                      <span class="badge" style="background:#22c55e">Disponible</span>
                    </div>
                    <div class="col-4">
                      <span class="badge" style="background:#ef4444">Usado</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card p-4">
                  <h4 class="mb-0"><i class="fa-solid fa-chart-bar"></i> Viáticos Entregados por Mes</h4>
                  <div style="min-height:200px;display:flex;align-items:center;justify-content:center;">
                    <canvas id="barViaticosMes" width="200" height="120" class="grafico-pequeno"></canvas>
                  </div>
                  <div class="card mt-4 p-3" id="cardMesesDestacados" style="box-shadow:none;background:transparent;">
                    <h6 class="mb-3"><i class="fa-solid fa-calendar"></i> Top 3 meses con mayor entrega de viáticos</h6>
                    <div class="table-responsive">
                      <table class="table table-bordered table-sm mb-0" style="font-size:0.95rem;">
                        <thead>
                          <tr>
                            <th>Mes</th>
                            <th>Valor Entregado</th>
                          </tr>
                        </thead>
                        <tbody id="tbodyMesesDestacados"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- NUEVOS GRÁFICOS -->
            <div class="row mb-4">
              <div class="col-md-6 mb-4">
                <div class="card p-3">
                  <h5 class="mb-3"><i class="fa-solid fa-chart-bar"></i> Top 10 Funcionarios con más Viáticos</h5>
                  <canvas id="barTopFuncionarios" width="180" height="120" class="grafico-pequeno"></canvas>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="card p-3">
                  <h5 class="mb-3"><i class="fa-solid fa-chart-line"></i> Evolución Capital Disponible/Entregado</h5>
                  <canvas id="lineCapitalMes" width="180" height="120" class="grafico-pequeno"></canvas>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="card p-3">
                  <h5 class="mb-3"><i class="fa-solid fa-location-dot"></i> Ciudades con Mayor Frecuencia de Viaje</h5>
                  <canvas id="barCiudadesFrecuentes" width="180" height="120" class="grafico-pequeno"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<script>
let polarChart;
function renderPolarAreaChart(total, disponible, usado) {
  const ctx = document.getElementById('polarAreaCapital').getContext('2d');
  if (polarChart) polarChart.destroy();
  polarChart = new Chart(ctx, {
    type: 'polarArea',
    data: {
      labels: ['Total', 'Disponible', 'Usado'],
      datasets: [{
        data: [total, disponible, usado],
        backgroundColor: [
          '#A7C7E7', // Total (azul pastel)
          '#A8E6CF', // Disponible (verde pastel)
          '#FFB3BA'  // Usado (rojo pastel)
        ],
        borderWidth: 1,
        borderColor: '#fff',
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        datalabels: {
          color: '#222',
          font: { weight: 'bold', size: 16 },
          formatter: function(value, ctx) {
            return value > 0 ? `$${value.toLocaleString('es-CO')}` : '';
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              let label = context.label || '';
              let value = context.parsed;
              return `${label}: $${value.toLocaleString('es-CO')}`;
            }
          }
        }
      },
      scales: {
        r: {
          pointLabels: {
            display: true,
            centerPointLabels: true,
            font: { size: 16, weight: 'bold' }
          },
          grid: { color: '#eee' },
          angleLines: { color: '#eee' },
          ticks: { display: false }
        }
      }
    },
    plugins: [ChartDataLabels]
  });
}

function cargarPolarAreaCapital(anio) {
  fetch(`${base_url}/FuncionariosViaticos/getCapitalDisponible/${anio}`)
    .then(res => res.json())
    .then(data => {
      let total = parseFloat(data.capitalTotal || 0);
      let disponible = parseFloat(data.capitalDisponible || 0);
      let usado = total - disponible;
      if (usado < 0) usado = 0;
      renderPolarAreaChart(total, disponible, usado);
    })
    .catch(() => {
      renderPolarAreaChart(0,0,0);
    });
}

document.addEventListener('DOMContentLoaded', function() {
  // Cargar gráfico inicial
  const anio = document.getElementById('selectAnioPolar').value;
  cargarPolarAreaCapital(anio);
  // Botón filtrar
  document.getElementById('btnFiltrarPolar').addEventListener('click', function() {
    const anio = document.getElementById('selectAnioPolar').value;
    cargarPolarAreaCapital(anio);
  });
});
</script>
<!-- Chart.js datalabels plugin -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<?php footerAdmin($data); ?>
<script src="<?= media(); ?>/Js/functions_Viaticos.js"></script>
</body>
</html>