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

<!-- Incluir estilos específicos para tareas -->
<link href="<?= media() ?>/css/tareas.css" rel="stylesheet">

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
  
  // Inicializar cuando se hace clic en la pestaña
  document.getElementById('calendario-tab').addEventListener('click', function() {
    setTimeout(function() {
      initCalendar();
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
</script>

<?php footerAdmin($data); ?>