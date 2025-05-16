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
                        <select class="form-select" id="txtAnio" name="anio" required>
                            <option value="<?php echo date('Y')-1; ?>"><?php echo date('Y')-1; ?></option>
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
                    <button type="submit" class="btn btn-primary">Guardar Presupuesto</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Cargar presupuesto actual al abrir el modal
    $('#modalPresupuestoViaticos').on('show.bs.modal', function () {
        const anio = document.getElementById('txtAnio').value;
        cargarPresupuestoActual(anio);
    });
    
    // Actualizar al cambiar el año
    document.getElementById('txtAnio').addEventListener('change', function() {
        cargarPresupuestoActual(this.value);
    });

    document.getElementById('formPresupuestoViaticos').addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Validar datos
        const anio = document.getElementById('txtAnio').value;
        const capitalTotal = document.getElementById('txtCapitalTotal').value;
        
        if (!anio || isNaN(anio) || parseInt(anio) <= 0) {
            Swal.fire('Error', 'El año no es válido', 'error');
            return;
        }
        
        if (!capitalTotal || isNaN(capitalTotal) || parseFloat(capitalTotal) <= 0) {
            Swal.fire('Error', 'El capital total debe ser mayor que cero', 'error');
            return;
        }
        
        // Crear FormData
        let formData = new FormData(this);
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Enviar datos
        fetch(base_url + '/FuncionariosViaticos/setPresupuestoAnual', {
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
                $('#modalPresupuestoViaticos').modal('hide');
                // Recargar datos
                const anioActual = document.getElementById('txtAnio').value;
                cargarCapitalDisponible(anioActual);
            } else {
                Swal.fire('Error', data.msg || 'Error desconocido', 'error');
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
        });
    });
});

function cargarPresupuestoActual(anio) {
    document.getElementById('txtCapitalTotal').value = '';
    
    if (!anio || isNaN(anio)) {
        console.error('Año inválido');
        return;
    }
    
    fetch(base_url + '/FuncionariosViaticos/getCapitalDisponible/' + anio)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data && data.capitalTotal !== undefined) {
                document.getElementById('txtCapitalTotal').value = data.capitalTotal;
            }
        })
        .catch(error => {
            console.error('Error al cargar presupuesto:', error);
        });
}
</script>