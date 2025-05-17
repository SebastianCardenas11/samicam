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
                        <select class="form-select" id="listFuncionarios" name="funci_fk" required>
                            <option value="">Seleccione un funcionario</option>
                            <option value="9">Carlos Lopez (Libre Nombramiento)</option>
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
    // Inicializar fecha con la fecha actual
    document.getElementById('txtFecha').valueAsDate = new Date();
    
    document.getElementById('formViaticos').addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Validar que se haya seleccionado un funcionario
        const funcionarioId = document.getElementById('listFuncionarios').value;
        if (!funcionarioId) {
            Swal.fire('Error', 'Debe seleccionar un funcionario', 'error');
            return;
        }
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        let formData = new FormData(this);
        fetch(base_url + '/FuncionariosViaticos/setViatico', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            Swal.close();
            if(data.status){
                Swal.fire('Éxito', data.msg, 'success');
                $('#modalViaticos').modal('hide');
                this.reset();
                document.getElementById('txtFecha').valueAsDate = new Date();
                // Recargar datos
                const anioActual = new Date().getFullYear();
                cargarCapitalDisponible(anioActual);
                cargarHistoricoViaticos(anioActual);
                cargarDetalleViaticos(anioActual);
            } else {
                Swal.fire('Error', data.msg || 'Error al asignar viático', 'error');
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
        });
    });
});
</script>