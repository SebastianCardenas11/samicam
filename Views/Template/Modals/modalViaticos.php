<div class="modal fade" id="modalViaticos" tabindex="-1" aria-labelledby="modalViaticosLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-dark">
            <form id="formViaticos" name="formViaticos" method="POST">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="modalViaticosLabel">Agregar Viático</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="listFuncionarios" class="form-label">Funcionario</label>
                        <select class="form-select" id="listFuncionarios" name="funci_fk" required>
                            <option value="">Seleccione un funcionario</option>
                            <?php foreach ($data['funcionarios_planta'] as $func): ?>
                                <option value="<?= $func['idefuncionario'] ?>">
                                    <?= $func['nombre_completo'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="txtDescripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="txtDescripcion" name="descripcion" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtMonto" class="form-label">Monto</label>
                        <input type="number" step="0.01" class="form-control" id="txtMonto" name="monto" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtFechaAprobacion" class="form-label">Fecha de Aprobación</label>
                        <input type="date" class="form-control" id="txtFechaAprobacion" name="fecha_aprobacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtFechaSalida" class="form-label">Fecha de Salida</label>
                        <input type="date" class="form-control" id="txtFechaSalida" name="fecha_salida" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtFechaRegreso" class="form-label">Fecha de Regreso</label>
                        <input type="date" class="form-control" id="txtFechaRegreso" name="fecha_regreso" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtUso" class="form-label">Uso</label>
                        <textarea class="form-control" id="txtUso" name="uso" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-floppy"></i> Guardar Viático
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Eliminamos el script interno ya que ahora está en functions_Viaticos.js -->