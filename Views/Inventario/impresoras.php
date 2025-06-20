<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Impresoras</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImpresora">Agregar Impresora</button>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0" id="tablaImpresoras">
      <thead>
        <tr>
          <th>Marca</th><th>Modelo</th><th>Serial</th><th>Consumible</th><th>Estado</th><th>Disponibilidad</th><th>Sectorial</th><th>Oficina</th><th>Asignado</th><th>Cargo</th><th>Contacto</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($impresoras as $imp): ?>
        <tr>
            <td><?= $imp['marca'] ?></td>
            <td><?= $imp['modelo'] ?></td>
            <td><?= $imp['serial'] ?></td>
            <td><?= $imp['consumible'] ?></td>
            <td><?= $imp['estado'] ?></td>
            <td><?= $imp['disponibilidad'] ?></td>
            <td><?= $imp['id_dependencia'] ?></td>
            <td><?= $imp['oficina'] ?></td>
            <td><?= $imp['id_funcionario'] ?></td>
            <td><?= $imp['id_cargo'] ?></td>
            <td><?= $imp['id_contacto'] ?></td>
            <td>
                <!-- Botones de editar/eliminar -->
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php if (file_exists('Views/Inventario/modals/modal_impresora.php')) include 'Views/Inventario/modals/modal_impresora.php'; ?>
<script src="<?= base_url(); ?>/Assets/Js/inventario.js"></script> 