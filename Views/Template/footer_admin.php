<footer class="footer pt-3">
  <div class="container-fluid">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="copyright text-center text-sm text-muted text-lg-start">
          © <script>document.write(new Date().getFullYear())</script>
          <a href="<?php echo WEB_EMPRESA?>" class="font-weight-bold" target="_blank"><?php echo NOMBRE_EMPESA?></a>
        </div>
      </div>
      <div class="col-lg-6">
        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
          <li class="nav-item">
            <a href="#" class="nav-link text-muted" target="_blank">Samicam</a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>/documentacion" class="nav-link text-muted" target="_blank">Documentacion</a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>/manualusuario" class="nav-link text-muted" target="_blank">Manual de usuario</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link pe-0 text-muted" target="_blank">Licencia</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>
</div>
</main>

<!-- VARIABLES -->
<script>
  const base_url = "<?=base_url();?>";
</script>

<!-- Los scripts básicos ya están en el header -->

<!-- COMPLEMENTOS -->
<script src="<?=media();?>/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?=media();?>/js/plugins/smooth-scrollbar.min.js"></script>
<script src="<?=media();?>/js/selectpicker/picker.js"></script>
<script src="<?=media();?>/js/soft-ui-dashboard.min.js?v=1.1.0"></script>

<!-- OTROS PLUGINS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<!-- FUNCIONES PROPIAS -->
<script type="text/javascript" src="<?=media();?>/js/functions_admin.js"></script>
<script type="text/javascript" src="<?=media();?>/js/functions_audit_helper.js"></script>
<script type="text/javascript" src="<?=media();?>/js/loader-manager.js"></script>

<?php if(isset($data['page_name']) && $data['page_name'] == "tareas"){ ?>
<!-- FullCalendar para el módulo de tareas -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/es.js"></script>
<?php } ?>

<?php if(isset($data['page_name']) && $data['page_name'] == "dependencias"){ ?>
<script type="text/javascript" src="<?=media();?>/js/functions_dependencias.js"></script>
<?php } ?>

<!-- DATATABLES INICIALIZACIÓN -->
<script>
  $('#sampleTable').DataTable();
</script>

<script src="<?= media(); ?>/js/main.js"></script>
<script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>

</body>
</html>