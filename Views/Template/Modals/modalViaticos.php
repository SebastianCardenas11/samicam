<div class="modal fade" id="modalViaticos" tabindex="-1" aria-labelledby="modalViaticosLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" style="max-width: 900px;">
        <div class="modal-content text-dark">
            <form id="formViaticos" name="formViaticos" method="POST">
                <div class="modal-header headerRegister">
                    <h5 class="modal-title" id="modalViaticosLabel">Agregar Viático</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                  <div class="mb-3">
    <label for="listFuncionarios" class="form-label">Funcionario</label>
    <select class="form-select" id="listFuncionarios" name="funci_fk" required>
        <option value="">Seleccione un funcionario</option>
    </select>
</div>
<div class="mb-3">
    <label for="listCargo" class="form-label">Cargo</label>
    <input type="text" class="form-control" id="txtCargo" name="cargo" readonly required>
</div>
<div class="mb-3">
    <label for="txtDependencia" class="form-label">Dependencia</label>
    <input type="text" class="form-control" id="txtDependencia" name="dependencia" readonly required>
</div>
<div class="mb-3">
    <label for="txtMotivoGasto" class="form-label">Motivo del Gasto</label>
    <input type="text" class="form-control" id="txtMotivoGasto" name="motivo_gasto" required>
</div>
<div class="mb-3">
    <label for="selectDepartamento" class="form-label">Lugar Comisión (Departamento)</label>
    <select class="form-select" id="selectDepartamento" name="lugar_comision_departamento" required>
        <option value="">Seleccione un departamento</option>
    </select>
</div>
<div class="mb-3">
    <label for="selectCiudad" class="form-label">Lugar Comisión (Ciudad/Municipio)</label>
    <select class="form-select" id="selectCiudad" name="lugar_comision_ciudad" required>
        <option value="">Seleccione una ciudad o municipio</option>
    </select>
</div>
<div class="mb-3">
    <label for="txtFinalidadComision" class="form-label">Finalidad de la Comisión</label>
    <textarea class="form-control" id="txtFinalidadComision" name="finalidad_comision" rows="2" required></textarea>
</div>
<div class="mb-3">
    <label for="txtDescripcion" class="form-label">Descripción</label>
    <input type="text" class="form-control" id="txtDescripcion" name="descripcion" required>
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
    <label for="txtNDias" class="form-label">N° Días</label>
    <input type="number" class="form-control" id="txtNDias" name="n_dias" required>
</div>
<div class="mb-3">
    <label for="txtValorDia" class="form-label">Valor Día</label>
    <input type="number" step="0.01" class="form-control" id="txtValorDia" name="valor_dia" required>
</div>
<div class="mb-3">
    <label for="txtValorViatico" class="form-label">Valor Viático</label>
    <input type="number" step="0.01" class="form-control" id="txtValorViatico" name="valor_viatico" required>
</div>
<div class="mb-3">
    <label for="selectTipoTransporte" class="form-label">Tipo de Transporte</label>
    <select class="form-select" id="selectTipoTransporte" name="tipo_transporte" required>
        <option value="">Seleccione el tipo de transporte</option>
        <option value="Aéreo">Aéreo</option>
        <option value="Interno">Interno</option>
    </select>
</div>
<div class="mb-3">
    <label for="txtValorTransporte" class="form-label">Valor Transporte</label>
    <input type="number" step="0.01" class="form-control" id="txtValorTransporte" name="valor_transporte" required>
</div>
<div class="mb-3">
    <label for="txtTotalLiquidado" class="form-label">Total Liquidado</label>
    <input type="number" step="0.01" class="form-control" id="txtTotalLiquidado" name="total_liquidado" required>
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
