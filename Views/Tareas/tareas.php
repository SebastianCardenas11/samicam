<?php 
  headerAdmin($data); 
  getModal('modalTareas', $data);
  getModal('modalViewTarea', $data);
  getModal('modalObservacion', $data);
?>
<!-- Incluir FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/locales/es.js"></script>
<script src="<?= media() ?>/Js/fullcalendar-init.js"></script>

<!-- Incluir estilos específicos para tareas -->
<link href="<?= media() ?>/css/tareas.css" rel="stylesheet">

<!-- Elemento oculto para almacenar el ID del usuario actual -->
<input type="hidden" id="idUser" value="<?= $_SESSION['idUser'] ?>">
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fas fa-tasks"></i> <?= $data['page_title'] ?>
        <?php if($_SESSION['userData']['idrol'] == 1) { ?>
        <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nueva tarea</button>
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
              <a class="nav-link active" id="tabla-tab" data-toggle="tab" href="#tabla" role="tab" aria-controls="tabla" aria-selected="true">Tabla</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="calendario-tab" data-toggle="tab" href="#calendario" role="tab" aria-controls="calendario" aria-selected="false">Calendario</a>
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
<?php footerAdmin($data); ?>