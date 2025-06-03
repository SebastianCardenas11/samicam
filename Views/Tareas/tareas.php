<?php 
  headerAdmin($data); 
  getModal('modalTareas', $data);
  getModal('modalViewTarea', $data);
  getModal('modalObservaciones', $data);
  getModal('modalUsuarios', $data);
?>
<!-- Incluir FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/locales/es.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Incluir estilos específicos para tareas -->
<link href="<?= media() ?>/css/tareas.css" rel="stylesheet">

<style>
.chart-container {
    position: relative;
    height: 300px;
    margin: 15px 0;
}

.tile {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.tile-title {
    color: #333;
    font-size: 1.2rem;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

.graficos-container {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.stats-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
}

.stat-card {
    flex: 1;
    min-width: 200px;
    padding: 15px;
    border-radius: 8px;
    color: white;
    text-align: center;
}

.stat-card h3 {
    margin: 0;
    font-size: 2rem;
}

.stat-card p {
    margin: 5px 0 0;
    opacity: 0.9;
}

.completadas-card { background: linear-gradient(135deg, #28a745, #20c997); }
.encurso-card { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.sinempezar-card { background: linear-gradient(135deg, #17a2b8, #0dcaf0); }
.vencidas-card { background: linear-gradient(135deg, #dc3545, #f86c6b); }
</style>

<!-- Elemento oculto para almacenar el ID del usuario actual -->
<input type="hidden" id="idUser" value="<?= $_SESSION['idUser'] ?>">
<main class="app-content">
  <div class="app-title">
    <div >
      <h1><i class="fas fa-tasks"></i> <?= $data['page_title'] ?>
        <?php if($_SESSION['userData']['idrol'] == 1) { ?>
        <button class="btn btn-warning ms-5" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nueva tarea</button>
        <?php } ?>
      </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/tareas"><?= $data['page_title'] ?></a></li>
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
              <a class="nav-link" id="calendario-tab" data-bs-toggle="tab" href="#calendario" role="tab" aria-controls="calendario" aria-selected="false">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="graficos-tab" data-bs-toggle="tab" href="#graficos" role="tab" aria-controls="graficos" aria-selected="false">Gráficos</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabla" role="tabpanel" aria-labelledby="tabla-tab">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableTareas">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Asignado a</th>
                      <th>Tipo</th>
                      <th>Descripción</th>
                      <th>Dependencia</th>
                      <th>Estado</th>
                      <th>Fecha inicio</th>
                      <th>Fecha fin</th>
                      <th>Tiempo restante</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="calendario" role="tabpanel" aria-labelledby="calendario-tab">
              <div id="calendar" style="height: 650px;"></div>
            </div>
            <div class="tab-pane fade" id="graficos" role="tabpanel" aria-labelledby="graficos-tab">
              <div class="graficos-container">
                <!-- Tarjetas de estadísticas -->
                <div class="stats-container">
                  <div class="stat-card completadas-card">
                    <h3 id="completadas-count">0</h3>
                    <p>Tareas Completadas</p>
                  </div>
                  <div class="stat-card encurso-card">
                    <h3 id="encurso-count">0</h3>
                    <p>En Curso</p>
                  </div>
                  <div class="stat-card sinempezar-card">
                    <h3 id="sinempezar-count">0</h3>
                    <p>Sin Empezar</p>
                  </div>
                  <div class="stat-card vencidas-card">
                    <h3 id="vencidas-count">0</h3>
                    <p>Vencidas</p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="tile">
                      <h3 class="tile-title">Estado de Tareas</h3>
                      <div class="chart-container">
                        <canvas id="estadoTareasChart"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="tile">
                      <h3 class="tile-title">Tareas por Tipo</h3>
                      <div class="chart-container">
                        <canvas id="tipoTareasChart"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tile">
                      <h3 class="tile-title">Tareas Completadas por Mes</h3>
                      <div class="chart-container">
                        <canvas id="tareasCompletadasChart"></canvas>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Variable global para el calendario
  window.calendarInstance = null;
  
  // Inicializar cuando se hace clic en la pestaña del calendario
  document.getElementById('calendario-tab').addEventListener('click', function() {
    setTimeout(function() {
      initCalendar();
    }, 200);
  });

  // Inicializar cuando se hace clic en la pestaña de gráficos
  document.getElementById('graficos-tab').addEventListener('click', function() {
    setTimeout(function() {
      initCharts();
    }, 200);
  });
});

function initCalendar() {
  const calendarEl = document.getElementById('calendar');
  
  if (!calendarEl) {
    console.error('No se encontró el elemento calendar');
    return;
  }
  
  // Limpiar el contenedor antes de inicializar
  calendarEl.innerHTML = '';
  
  try {
    // Crear nueva instancia
    window.calendarInstance = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      height: 'auto',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      events: {
        url: base_url+'/Tareas/getTareasCalendario',
        method: 'GET',
        failure: function() {
          Swal.fire("Error", "No se pudieron cargar las tareas en el calendario", "error");
        }
      },
      eventClick: function(info) {
        let idTarea = info.event.id;
        fntViewTarea(idTarea);
      },
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      eventDidMount: function(info) {
        // Personalizar el título del evento para mostrar la descripción
        const descripcion = info.event.extendedProps.descripcion || info.event.title;
        info.el.querySelector('.fc-event-title').innerText = descripcion;
      }
    });
    
    window.calendarInstance.render();
  } catch (error) {
    console.error("Error al inicializar el calendario:", error);
    calendarEl.innerHTML = '<div class="alert alert-danger">Error al inicializar el calendario: ' + error.message + '</div>';
  }
}

// Función para actualizar eventos del calendario
function refreshCalendar() {
  if (window.calendarInstance) {
    window.calendarInstance.refetchEvents();
  }
}

// Función para inicializar los gráficos
async function initCharts() {
  try {
    // Obtener datos para los gráficos
    const response = await fetch(base_url + '/Tareas/getEstadisticasTareas');
    const data = await response.json();

    if(data.success) {
      // Actualizar contadores en las tarjetas
      document.getElementById('completadas-count').textContent = data.estadoTareas.completadas;
      document.getElementById('encurso-count').textContent = data.estadoTareas.enCurso;
      document.getElementById('sinempezar-count').textContent = data.estadoTareas.sinEmpezar;
      document.getElementById('vencidas-count').textContent = data.estadoTareas.vencidas;

      // Gráfico de Estado de Tareas
      const ctxEstado = document.getElementById('estadoTareasChart').getContext('2d');
      new Chart(ctxEstado, {
        type: 'doughnut',
        data: {
          labels: ['Completadas', 'En Curso', 'Sin Empezar', 'Vencidas'],
          datasets: [{
            data: [
              data.estadoTareas.completadas,
              data.estadoTareas.enCurso,
              data.estadoTareas.sinEmpezar,
              data.estadoTareas.vencidas
            ],
            backgroundColor: [
              '#28a745',
              '#ffc107',
              '#17a2b8',
              '#dc3545'
            ]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                padding: 20,
                usePointStyle: true
              }
            }
          }
        }
      });

      // Gráfico de Tareas por Tipo
      const ctxTipo = document.getElementById('tipoTareasChart').getContext('2d');
      new Chart(ctxTipo, {
        type: 'bar',
        data: {
          labels: data.tiposTarea.map(tipo => tipo.nombre),
          datasets: [{
            label: 'Cantidad de Tareas',
            data: data.tiposTarea.map(tipo => tipo.cantidad),
            backgroundColor: '#007bff',
            borderRadius: 6
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

      // Formatear los datos para el gráfico de línea
      const meses = data.tareasCompletadas.map(item => {
        const [year, month] = item.mes.split('-');
        return new Date(year, month - 1).toLocaleString('es', { month: 'short', year: '2-digit' });
      }).reverse();

      const cantidades = data.tareasCompletadas.map(item => item.cantidad).reverse();

      // Gráfico de Tareas Completadas por Mes
      const ctxCompletadas = document.getElementById('tareasCompletadasChart').getContext('2d');
      new Chart(ctxCompletadas, {
        type: 'line',
        data: {
          labels: meses,
          datasets: [{
            label: 'Tareas Completadas',
            data: cantidades,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4,
            fill: true,
            pointStyle: 'circle',
            pointRadius: 6,
            pointHoverRadius: 8
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
  } catch (error) {
    console.error("Error al cargar los gráficos:", error);
    Swal.fire("Error", "No se pudieron cargar los gráficos", "error");
  }
}
</script>

<?php footerAdmin($data); ?>