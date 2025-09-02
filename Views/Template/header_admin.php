<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="<?= media() ?>/images/favicon.png">
  <title><?= $data['page_tag']; ?></title>
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link id="pagestyle" href="<?= media() ?>/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
  <link rel="stylesheet" href="<?= media(); ?>/css/selectpicker/picker.css">
  <link rel="stylesheet" href="<?= media(); ?>/css/dashboard-custom.css">
  <link rel="stylesheet" href="<?= media(); ?>/css/permisos-diarios.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- jQuery primero -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  
  <!-- Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  
  <!-- DataTables y sus extensiones -->
  <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
  
  <!-- Chart.js para las gráficas -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
  
  <!-- Script para formato de hora en 12 horas -->
  <script src="<?= media() ?>/js/clock-format.js"></script>
  
  <!-- Loader Jelly -->
  <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/superballs.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <!-- Loader Global -->
  <div id="globalLoader" class="global-loader">
    <l-superballs size="40" speed="0.9" color="#004884"></l-superballs>
    <p class="loader-text" style="color: #004884;">Cargando sistema...</p>
  </div>
  
  <?php require_once "nav_admin.php"; ?>
  <div class="container-fluid py-4">

<?php
if (!function_exists('getModal')) {
    function getModal($nameModal, $data = "") {
        $fileModal = "Views/Template/Modals/" . $nameModal . ".php";
        if (file_exists($fileModal)) {
            require_once($fileModal);
        }
    }
}