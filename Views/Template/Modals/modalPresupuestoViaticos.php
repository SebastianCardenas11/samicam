<div class="modal fade" id="modalPresupuestoViaticos" tabindex="-1" aria-labelledby="modalPresupuestoViaticosLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formPresupuestoViaticos" name="formPresupuestoViaticos" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPresupuestoViaticosLabel">Agregar/Actualizar Presupuesto Anual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="txtAnio" class="form-label">Año</label>
                        <input type="number" class="form-control" id="txtAnio" name="anio" value="<?php echo date('Y'); ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="txtCapitalTotal" class="form-label">Capital Total</label>
                        <input type="number" step="0.01" class="form-control" id="txtCapitalTotal" name="capitalTotal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Presupuesto</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('formPresupuestoViaticos').addEventListener('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        fetch(base_url + '/FuncionariosViaticos/setPresupuestoAnual', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status){
                Swal.fire('Éxito', data.msg, 'success');
                $('#modalPresupuestoViaticos').modal('hide');
                this.reset();
                // Recargar datos
                const anioActual = new Date().getFullYear();
                cargarCapitalDisponible(anioActual);
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        });
    });
});
</script>
