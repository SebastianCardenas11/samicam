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

<script>
    // Cargar funcionarios al abrir el modal
    $('#modalViaticos').on('show.bs.modal', function () {
        cargarFuncionariosValidos();
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar fechas con la fecha actual
        const hoy = new Date();
        document.getElementById('txtFechaAprobacion').valueAsDate = hoy;
        document.getElementById('txtFechaSalida').valueAsDate = hoy;
        document.getElementById('txtFechaRegreso').valueAsDate = hoy;

        document.getElementById('formViaticos').addEventListener('submit', function (e) {
            e.preventDefault();
            
            // Validar que la fecha de salida no sea anterior a la fecha actual
            const fechaSalida = new Date(document.getElementById('txtFechaSalida').value);
            const fechaActual = new Date();
            fechaActual.setHours(0, 0, 0, 0); // Resetear horas para comparar solo fechas
            
            if (fechaSalida < fechaActual) {
                Swal.fire('Error', 'La fecha de salida no puede ser anterior a la fecha actual', 'error');
                return;
            }
            
            // Validar que la fecha de regreso sea posterior a la fecha de salida
            const fechaRegreso = new Date(document.getElementById('txtFechaRegreso').value);
            if (fechaRegreso < fechaSalida) {
                Swal.fire('Error', 'La fecha de regreso debe ser posterior a la fecha de salida', 'error');
                return;
            }
            
            guardarViatico(this);
        });
        
        // Validar fecha de salida al cambiar
        document.getElementById('txtFechaSalida').addEventListener('change', function() {
            const fechaSalida = new Date(this.value);
            const fechaActual = new Date();
            fechaActual.setHours(0, 0, 0, 0);
            
            if (fechaSalida < fechaActual) {
                Swal.fire('Error', 'La fecha de salida no puede ser anterior a la fecha actual', 'error');
                this.valueAsDate = fechaActual;
            }
            
            // Actualizar fecha de regreso mínima
            document.getElementById('txtFechaRegreso').min = this.value;
        });
    });

    function cargarFuncionariosValidos() {
        // Mostrar indicador de carga en el select
        let select = document.getElementById('listFuncionarios');
        select.innerHTML = '<option value="">Cargando funcionarios...</option>';
        select.disabled = true;

        fetch(base_url + '/FuncionariosViaticos/getFuncionariosValidos')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar funcionarios');
                }
                return response.json();
            })
            .then(data => {
                select.innerHTML = '<option value="">Seleccione un funcionario</option>';
                select.disabled = false;

                if (data && data.length > 0) {
                    data.forEach(funcionario => {
                        let option = document.createElement('option');
                        option.value = funcionario.idefuncionario;
                        option.textContent = funcionario.nombre_completo;
                        select.appendChild(option);
                    });
                } else {
                    select.innerHTML = '<option value="">No hay funcionarios disponibles</option>';
                }
            })
            .catch(error => {
                console.error('Error al cargar funcionarios:', error);
                select.innerHTML = '<option value="">Error al cargar funcionarios</option>';
                select.disabled = false;
            });
    }
</script>