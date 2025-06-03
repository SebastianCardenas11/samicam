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

/* Estilos para el modal de ver tarea */
.modal-xl {
    max-width: 90%;
}

.tarea-info {
    margin-bottom: 20px;
}

.tarea-info .label {
    font-weight: bold;
    color: #666;
    margin-bottom: 5px;
}

.tarea-info .value {
    font-size: 1.1em;
}

.usuarios-asignados {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
}

.usuario-badge {
    background-color: #e9ecef;
    border-radius: 20px;
    padding: 5px 15px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.usuario-badge i {
    color: #6c757d;
}

.estado-badge {
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: 500;
    display: inline-block;
}

.estado-completada { background-color: #d4edda; color: #155724; }
.estado-encurso { background-color: #fff3cd; color: #856404; }
.estado-sinempezar { background-color: #d1ecf1; color: #0c5460; }
.estado-vencida { background-color: #f8d7da; color: #721c24; }

.observaciones-container {
    max-height: 300px;
    overflow-y: auto;
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background-color: #f8f9fa;
}

.observacion-item {
    padding: 10px;
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 10px;
}

.observacion-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.observacion-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    color: #6c757d;
    font-size: 0.9em;
}

.observacion-texto {
    color: #212529;
}

.usuarios-lista {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.ver-mas-usuarios {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px 15px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 0.9em;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.ver-mas-usuarios:hover {
    background-color: #0056b3;
}

.contador-usuarios {
    background-color: rgba(255, 255, 255, 0.2);
    padding: 2px 8px;
    border-radius: 10px;
    margin-left: 5px;
    font-size: 0.85em;
}
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
                  <div class="col-md-12">
                    <div class="tile">
                      <h3 class="tile-title">Progreso de Tareas Completadas</h3>
                      <div class="chart-container">
                        <canvas id="tareasCompletadasChart"></canvas>
                      </div>
                    </div>
                  </div>
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Modal para ver tarea -->
<div class="modal fade" id="modalViewTarea" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Detalles de la Tarea</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="tarea-info">
              <div class="label">Descripción:</div>
              <div class="value" id="celDescripcion"></div>
            </div>
            <div class="tarea-info">
              <div class="label">Tipo:</div>
              <div class="value" id="celTipo"></div>
            </div>
            <div class="tarea-info">
              <div class="label">Dependencia:</div>
              <div class="value" id="celDependencia"></div>
            </div>
            <div class="tarea-info">
              <div class="label">Estado:</div>
              <div class="value">
                <span id="celEstado" class="estado-badge"></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="tarea-info">
              <div class="label">Fecha de Inicio:</div>
              <div class="value" id="celFechaInicio"></div>
            </div>
            <div class="tarea-info">
              <div class="label">Fecha de Fin:</div>
              <div class="value" id="celFechaFin"></div>
            </div>
            <div class="tarea-info">
              <div class="label">Tiempo Restante:</div>
              <div class="value" id="celTiempoRestante"></div>
            </div>
            <div class="tarea-info">
              <div class="label">Creado por:</div>
              <div class="value" id="celCreador"></div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <div class="tarea-info">
              <div class="label">Usuarios Asignados:</div>
              <div class="usuarios-asignados" id="celUsuariosAsignados"></div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <div class="tarea-info">
              <div class="label">Observaciones:</div>
              <div class="observaciones-container" id="celObservaciones"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para ver todos los usuarios asignados -->
<div class="modal fade" id="modalVerUsuarios" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Usuarios Asignados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="usuarios-lista" id="listaCompletaUsuarios"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

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
            },
            title: {
              display: true,
              text: 'Distribución Total de Tareas',
              padding: {
                bottom: 30
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
        return new Date(year, month - 1).toLocaleString('es', { month: 'long', year: '2-digit' });
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
            },
            x: {
              grid: {
                display: false
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

function fntViewTarea(idtarea) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getTarea/'+idtarea;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                document.getElementById("celDescripcion").innerHTML = objData.data.descripcion;
                document.getElementById("celTipo").innerHTML = objData.data.tipo;
                document.getElementById("celDependencia").innerHTML = objData.data.dependencia_nombre;
                
                // Aplicar estilo al estado
                let estado = objData.data.estado;
                let estadoElement = document.getElementById("celEstado");
                estadoElement.innerHTML = estado.charAt(0).toUpperCase() + estado.slice(1);
                estadoElement.className = 'estado-badge estado-' + estado.replace(' ', '');
                
                document.getElementById("celFechaInicio").innerHTML = objData.data.fecha_inicio_format;
                document.getElementById("celFechaFin").innerHTML = objData.data.fecha_fin_format;
                document.getElementById("celTiempoRestante").innerHTML = objData.data.tiempo_restante;
                document.getElementById("celCreador").innerHTML = objData.data.creador_nombre;

                // Mostrar usuarios asignados usando la nueva función
                mostrarUsuariosAsignados(objData.data.usuarios_asignados);

                // Cargar observaciones
                let observacionesContainer = document.getElementById("celObservaciones");
                observacionesContainer.innerHTML = '';
                
                let requestObs = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrlObs = base_url+'/Tareas/getObservaciones/'+idtarea;
                requestObs.open("GET",ajaxUrlObs,true);
                requestObs.send();
                requestObs.onreadystatechange = function(){
                    if(requestObs.readyState == 4 && requestObs.status == 200){
                        let objDataObs = JSON.parse(requestObs.responseText);
                        if(objDataObs.status) {
                            objDataObs.data.forEach(function(obs) {
                                let observacionDiv = document.createElement('div');
                                observacionDiv.className = 'observacion-item';
                                observacionDiv.innerHTML = `
                                    <div class="observacion-header">
                                        <span><i class="fas fa-user"></i> ${obs.usuario_nombre}</span>
                                        <span><i class="fas fa-calendar"></i> ${obs.fecha_format}</span>
                                    </div>
                                    <div class="observacion-texto">${obs.observacion}</div>
                                `;
                                observacionesContainer.appendChild(observacionDiv);
                            });
                        }
                    }
                }

                $('#modalViewTarea').modal('show');
            } else {
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function mostrarTodosLosUsuarios(usuarios) {
    let listaUsuarios = document.getElementById("listaCompletaUsuarios");
    listaUsuarios.innerHTML = '';
    
    usuarios.forEach(function(usuario) {
        let badge = document.createElement('div');
        badge.className = 'usuario-badge';
        badge.innerHTML = `<i class="fas fa-user"></i> ${usuario.nombres}`;
        listaUsuarios.appendChild(badge);
    });
    
    $('#modalVerUsuarios').modal('show');
}
</script>

<?php footerAdmin($data); ?>