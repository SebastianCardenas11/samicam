<?php
headerAdmin($data);
?>
<div class="modal fade" id="modalFormFuncionariosOps" tabindex="-1" aria-labelledby="modalFormFuncionariosOps" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Funcionario OPS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="tile-body">
                        <form id="formFuncionariosOps" name="formFuncionariosOps" class="form-horizontal">
                            <input type="hidden" id="idFuncionario" name="idFuncionario" value="">

                            <div class="row mb-4">
                                <div class="col-12">
                                    <p class="text-primary fw-bold">Los campos con asterisco (<span class="required text-danger">*</span>) son obligatorios.</p>
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 - Información del Contrato -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información del Contrato</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="anio" class="form-label">Año <span class="required text-danger">*</span></label>
                                                <input type="number" class="form-control" id="anio" name="anio" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nit" class="form-label">NIT <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nit" name="nit" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nombre_entidad" class="form-label">Nombre Entidad <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nombre_entidad" name="nombre_entidad" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="numero_contrato" class="form-label">Número de Contrato <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="numero_contrato" name="numero_contrato" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha_firma_contrato" class="form-label">Fecha Firma Contrato <span class="required text-danger">*</span></label>
                                                <input type="date" class="form-control" id="fecha_firma_contrato" name="fecha_firma_contrato" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 2 - Información del Proceso -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información del Proceso</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="numero_proceso" class="form-label">Número de Proceso <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="numero_proceso" name="numero_proceso" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="forma_contratacion" class="form-label">Forma de Contratación <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="forma_contratacion" name="forma_contratacion" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="codigo_banco_proyecto" class="form-label">Código Banco Proyecto</label>
                                                <input type="text" class="form-control" id="codigo_banco_proyecto" name="codigo_banco_proyecto">
                                            </div>
                                            <div class="mb-3">
                                                <label for="linea_estrategia" class="form-label">Línea Estrategia</label>
                                                <input type="text" class="form-control" id="linea_estrategia" name="linea_estrategia">
                                            </div>
                                            <div class="mb-3">
                                                <label for="fuente_recurso" class="form-label">Fuente Recurso</label>
                                                <input type="text" class="form-control" id="fuente_recurso" name="fuente_recurso">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 3 - Información del Contratista -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información del Contratista</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="nombre_contratista" class="form-label">Nombre Contratista <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nombre_contratista" name="nombre_contratista" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="identificacion_contratista" class="form-label">Identificación <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="identificacion_contratista" name="identificacion_contratista" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sexo" class="form-label">Sexo <span class="required text-danger">*</span></label>
                                                <select class="form-select" id="sexo" name="sexo" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edad" class="form-label">Edad <span class="required text-danger">*</span></label>
                                                <input type="number" class="form-control" id="edad" name="edad" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <!-- Columna 4 - Información de Contacto -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información de Contacto</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="direccion_domicilio" class="form-label">Dirección <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="direccion_domicilio" name="direccion_domicilio" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="telefono_contacto" class="form-label">Teléfono <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="correo_electronico" class="form-label">Correo Electrónico <span class="required text-danger">*</span></label>
                                                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 5 - Información Bancaria -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Bancaria</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="entidad_bancaria" class="form-label">Entidad Bancaria <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="entidad_bancaria" name="entidad_bancaria" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tipo_cuenta" class="form-label">Tipo de Cuenta <span class="required text-danger">*</span></label>
                                                <select class="form-select" id="tipo_cuenta" name="tipo_cuenta" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="Ahorros">Ahorros</option>
                                                    <option value="Corriente">Corriente</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="numero_cuenta_bancaria" class="form-label">Número de Cuenta <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="numero_cuenta_bancaria" name="numero_cuenta_bancaria" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 6 - Información Presupuestal -->
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Presupuestal</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="numero_disp_presupuestal" class="form-label">Número Disponibilidad Presupuestal</label>
                                                <input type="text" class="form-control" id="numero_disp_presupuestal" name="numero_disp_presupuestal">
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha_disp_presupuestal" class="form-label">Fecha Disponibilidad Presupuestal</label>
                                                <input type="date" class="form-control" id="fecha_disp_presupuestal" name="fecha_disp_presupuestal">
                                            </div>
                                            <div class="mb-3">
                                                <label for="valor_disp_presupuestal" class="form-label">Valor Disponibilidad Presupuestal</label>
                                                <input type="number" step="0.01" class="form-control" id="valor_disp_presupuestal" name="valor_disp_presupuestal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <!-- Columna 7 - Detalles del Contrato -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Detalles del Contrato</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="objeto" class="form-label">Objeto del Contrato <span class="required text-danger">*</span></label>
                                                <textarea class="form-control" id="objeto" name="objeto" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha_inicio" class="form-label">Fecha de Inicio <span class="required text-danger">*</span></label>
                                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="plazo_contrato" class="form-label">Plazo del Contrato <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="plazo_contrato" name="plazo_contrato" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="valor_contrato" class="form-label">Valor del Contrato <span class="required text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control" id="valor_contrato" name="valor_contrato" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="clase_contrato" class="form-label">Clase de Contrato <span class="required text-danger">*</span></label>
                                                <input type="text" class="form-control" id="clase_contrato" name="clase_contrato" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna 8 - Información del Interventor -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información del Interventor</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="asignado_interventor" class="form-label">Asignado Interventor</label>
                                                <input type="text" class="form-control" id="asignado_interventor" name="asignado_interventor">
                                            </div>
                                            <div class="mb-3">
                                                <label for="unidad_ejecucion" class="form-label">Unidad de Ejecución</label>
                                                <input type="text" class="form-control" id="unidad_ejecucion" name="unidad_ejecucion">
                                            </div>
                                            <div class="mb-3">
                                                <label for="nombre_interventor" class="form-label">Nombre del Interventor</label>
                                                <input type="text" class="form-control" id="nombre_interventor" name="nombre_interventor">
                                            </div>
                                            <div class="mb-3">
                                                <label for="identificacion_interventor" class="form-label">Identificación del Interventor</label>
                                                <input type="text" class="form-control" id="identificacion_interventor" name="identificacion_interventor">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tipo_vinculacion_interventor" class="form-label">Tipo de Vinculación del Interventor</label>
                                                <input type="text" class="form-control" id="tipo_vinculacion_interventor" name="tipo_vinculacion_interventor">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <!-- Columna 9 - Información Adicional -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Información Adicional</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="fecha_aprobacion_garantia" class="form-label">Fecha Aprobación Garantía</label>
                                                    <input type="date" class="form-control" id="fecha_aprobacion_garantia" name="fecha_aprobacion_garantia">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="anticipo_contrato" class="form-label">Anticipo del Contrato</label>
                                                    <input type="number" step="0.01" class="form-control" id="anticipo_contrato" name="anticipo_contrato">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="valor_pagado_anticipo" class="form-label">Valor Pagado Anticipo</label>
                                                    <input type="number" step="0.01" class="form-control" id="valor_pagado_anticipo" name="valor_pagado_anticipo">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="fecha_pago_anticipo" class="form-label">Fecha Pago Anticipo</label>
                                                    <input type="date" class="form-control" id="fecha_pago_anticipo" name="fecha_pago_anticipo">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 mb-3">
                                                    <label for="numero_adiciones" class="form-label">Número de Adiciones</label>
                                                    <input type="number" class="form-control" id="numero_adiciones" name="numero_adiciones">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="valor_total_adiciones" class="form-label">Valor Total Adiciones</label>
                                                    <input type="number" step="0.01" class="form-control" id="valor_total_adiciones" name="valor_total_adiciones">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="numero_prorrogas" class="form-label">Número de Prórrogas</label>
                                                    <input type="number" class="form-control" id="numero_prorrogas" name="numero_prorrogas">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="tiempo_prorrogas" class="form-label">Tiempo Prórrogas</label>
                                                    <input type="text" class="form-control" id="tiempo_prorrogas" name="tiempo_prorrogas">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="numero_suspensiones" class="form-label">Número Suspensiones</label>
                                                    <input type="number" class="form-control" id="numero_suspensiones" name="numero_suspensiones">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="tiempo_suspensiones" class="form-label">Tiempo Suspensiones</label>
                                                    <input type="text" class="form-control" id="tiempo_suspensiones" name="tiempo_suspensiones">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="valor_total_pagos" class="form-label">Valor Total Pagos</label>
                                                    <input type="number" step="0.01" class="form-control" id="valor_total_pagos" name="valor_total_pagos">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="fecha_terminacion" class="form-label">Fecha Terminación</label>
                                                    <input type="date" class="form-control" id="fecha_terminacion" name="fecha_terminacion">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="fecha_acta_liquidacion" class="form-label">Fecha Acta Liquidación</label>
                                                    <input type="date" class="form-control" id="fecha_acta_liquidacion" name="fecha_acta_liquidacion">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="estado_contrato" class="form-label">Estado del Contrato</label>
                                                    <select class="form-select" id="estado_contrato" name="estado_contrato">
                                                        <option value="">Seleccione</option>
                                                        <option value="En ejecución">En ejecución</option>
                                                        <option value="Terminado">Terminado</option>
                                                        <option value="Liquidado">Liquidado</option>
                                                        <option value="Suspendido">Suspendido</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="observaciones" class="form-label">Observaciones</label>
                                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input" id="proviene_recurso_reactivacion" name="proviene_recurso_reactivacion">
                                                <label class="form-check-label" for="proviene_recurso_reactivacion">¿Proviene de recurso de reactivación?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button id="btnActionForm" class="btn btn-primary" type="submit">
                                        <i class="fa fa-fw fa-lg fa-check-circle"></i>
                                        <span id="btnText">Guardar</span>
                                    </button>
                                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                                        <i class="fa fa-fw fa-lg fa-times-circle"></i>
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
footerAdmin($data);
?>