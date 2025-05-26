<div class="modal fade" id="modalPresupuestoViaticos" tabindex="-1" aria-labelledby="modalPresupuestoViaticosLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-dark">
            <form id="formPresupuestoViaticos" name="formPresupuestoViaticos" method="POST">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="modalPresupuestoViaticosLabel">Agregar/Actualizar Presupuesto Anual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="txtAnio" class="form-label">Año</label>
                        <select class="form-select" id="txtAnio" name="anio" required>
                            <option value="<?php echo date('Y'); ?>" selected><?php echo date('Y'); ?></option>
                            <option value="<?php echo date('Y')+1; ?>"><?php echo date('Y')+1; ?></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="txtCapitalTotal" class="form-label">Capital Total</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="txtCapitalTotal" name="capitalTotal" required>
                    </div>
                    <div class="alert alert-info">
                        <p><strong>Nota:</strong> Al actualizar el presupuesto, se mantendrá el registro de los viáticos ya asignados.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-floppy"></i> Guardar Presupuesto
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