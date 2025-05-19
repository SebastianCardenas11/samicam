<div class="modal fade" id="modalViaticos" tabindex="-1" aria-labelledby="modalViaticosLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
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
    // Cargar funcionarios al abrir el modal
    $('#modalViaticos').on('show.bs.modal', function () {
        cargarFuncionariosValidos();
    });

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
                    if (data.status) {
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