<?php
// Modal para importar datos desde Excel
?>
<div class="modal fade" id="modalImportarExcel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModalImportar">Importar datos desde Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="tile">
          <div class="tile-body">
            <form id="formImportarExcel" name="formImportarExcel" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label">Seleccione el archivo Excel (.xlsx, .xls)</label>
                <input class="form-control" id="archivo_excel" name="archivo_excel" type="file" accept=".xlsx, .xls" required>
              </div>
              <div class="form-group">
                <p>El archivo Excel debe tener las siguientes columnas en este orden:</p>
                <ol>
                  <li>Correo electrónico</li>
                  <li>Nombre completo</li>
                  <li>Identificación</li>
                  <li>ID Cargo</li>
                  <li>ID Dependencia</li>
                  <li>ID Contrato</li>
                  <li>Celular</li>
                  <li>Dirección</li>
                  <li>Fecha de ingreso</li>
                  <li>Número de hijos</li>
                  <li>Nombres de hijos</li>
                  <li>Sexo</li>
                  <li>Lugar de residencia</li>
                  <li>Edad</li>
                  <li>Estado civil</li>
                  <li>Religión</li>
                  <li>Formación académica</li>
                  <li>Nombre de formación</li>
                </ol>
                <p>La primera fila debe contener los encabezados.</p>
              </div>
              <div class="text-center">
                <button class="btn btn-success" type="submit"><i class="bi bi-upload"></i> Importar</button>
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>