<div class="modal fade" id="modalViaticos" tabindex="-1" aria-labelledby="modalViaticosLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formViaticos" name="formViaticos" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViaticosLabel">Agregar Viático</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="listFuncionarios" class="form-label">Funcionario</label>
                        <select class="form-select" id="listFuncionarios" name="idFuncionario" required>
                            <option value="">Seleccione un funcionario</option>
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
                        <label for="txtFecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="txtFecha" name="fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtUso" class="form-label">Uso</label>
                        <textarea class="form-control" id="txtUso" name="uso" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Viático</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    cargarFuncionariosValidos();

    document.getElementById('formViaticos').addEventListener('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        fetch(base_url + '/FuncionariosViaticos/setViatico', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status){
                Swal.fire('Éxito', data.msg, 'success');
                $('#modalViaticos').modal('hide');
                this.reset();
                // Recargar datos
                const anioActual = new Date().getFullYear();
                cargarCapitalDisponible(anioActual);
                cargarHistoricoViaticos(anioActual);
                cargarDetalleViaticos(anioActual);
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        });
    });
});

function cargarFuncionariosValidos() {
    fetch(base_url + '/FuncionariosViaticos/getFuncionariosValidos')
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById('listFuncionarios');
            select.innerHTML = '<option value="">Seleccione un funcionario</option>';
            data.forEach(funcionario => {
                let option = document.createElement('option');
                option.value = funcionario.idFuncionario;
                option.textContent = funcionario.nombre;
                select.appendChild(option);
            });
        });
}
</script>
