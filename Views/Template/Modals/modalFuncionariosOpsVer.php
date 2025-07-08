<!-- Modal Visualización Funcionario OPS -->
<div class="modal fade" id="modalViewFuncionarioOps" tabindex="-1" aria-labelledby="modalViewFuncionarioOpsLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="modalViewFuncionarioOpsLabel">Información del Funcionario OPS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Fila 1: Contrato, Proceso, Contratista -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Información del Contrato</h5></div>
                                <div class="card-body">
                                    <p><b>Año:</b> <span id="view_anio"></span></p>
                                    <p><b>NIT:</b> <span id="view_nit"></span></p>
                                    <p><b>Nombre Entidad:</b> <span id="view_nombre_entidad"></span></p>
                                    <p><b>Número de Contrato:</b> <span id="view_numero_contrato"></span></p>
                                    <p><b>Fecha Firma Contrato:</b> <span id="view_fecha_firma_contrato"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Información del Proceso</h5></div>
                                <div class="card-body">
                                    <p><b>Número de Proceso:</b> <span id="view_numero_proceso"></span></p>
                                    <p><b>Forma de Contratación:</b> <span id="view_forma_contratacion"></span></p>
                                    <p><b>Código Banco Proyecto:</b> <span id="view_codigo_banco_proyecto"></span></p>
                                    <p><b>Línea Estrategia:</b> <span id="view_linea_estrategia"></span></p>
                                    <p><b>Fuente Recurso:</b> <span id="view_fuente_recurso"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Información del Contratista</h5></div>
                                <div class="card-body">
                                    <p><b>Nombre:</b> <span id="view_nombre_contratista"></span></p>
                                    <p><b>Identificación:</b> <span id="view_identificacion_contratista"></span></p>
                                    <p><b>Sexo:</b> <span id="view_sexo"></span></p>
                                    <p><b>Edad:</b> <span id="view_edad"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fila 2: Contacto y Bancaria -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Información de Contacto</h5></div>
                                <div class="card-body">
                                    <p><b>Dirección:</b> <span id="view_direccion_domicilio"></span></p>
                                    <p><b>Teléfono:</b> <span id="view_telefono_contacto"></span></p>
                                    <p><b>Correo electrónico:</b> <span id="view_correo_electronico"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Información Bancaria</h5></div>
                                <div class="card-body">
                                    <p><b>Entidad Bancaria:</b> <span id="view_entidad_bancaria"></span></p>
                                    <p><b>Tipo de Cuenta:</b> <span id="view_tipo_cuenta"></span></p>
                                    <p><b>Número de Cuenta:</b> <span id="view_numero_cuenta_bancaria"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fila 3: Presupuestal -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Información Presupuestal</h5></div>
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <p><b>Número Disponibilidad Presupuestal:</b> <span id="view_numero_disp_presupuestal"></span></p>
                                        <p><b>Fecha Disponibilidad Presupuestal:</b> <span id="view_fecha_disp_presupuestal"></span></p>
                                        <p><b>Valor Disponibilidad Presupuestal:</b> <span id="view_valor_disp_presupuestal"></span></p>
                                        <p><b>Número Registro Presupuestal:</b> <span id="view_numero_registro_presupuestal"></span></p>
                                        <p><b>Fecha Registro Presupuestal:</b> <span id="view_fecha_registro_presupuestal"></span></p>
                                        <p><b>Valor Registro Presupuestal:</b> <span id="view_valor_registro_presupuestal"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><b>Código Rubro:</b> <span id="view_cod_rubro"></span></p>
                                        <p><b>Rubro:</b> <span id="view_rubro"></span></p>
                                        <p><b>Fuente de Financiación:</b> <span id="view_fuente_financiacion"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fila 4: Detalles del Contrato e Interventor y Adicional -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Detalles del Contrato</h5></div>
                                <div class="card-body">
                                    <p><b>Objeto del Contrato:</b> <span id="view_objeto"></span></p>
                                    <p><b>Fecha de Inicio:</b> <span id="view_fecha_inicio"></span></p>
                                    <p><b>Días restantes:</b> <span id="view_dias_restantes"></span></p>
                                    <p><b>Plazo del Contrato:</b> <span id="view_plazo_contrato"></span></p>
                                    <p><b>Valor del Contrato:</b> <span id="view_valor_contrato"></span></p>
                                    <p><b>Clase de Contrato:</b> <span id="view_clase_contrato"></span></p>
                                    <p><b>Estado Contrato:</b> <span id="view_estado_contrato"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Información del Interventor</h5></div>
                                <div class="card-body">
                                    <p><b>Asignado Interventor:</b> <span id="view_asignado_interventor"></span></p>
                                    <p><b>Unidad de Ejecución:</b> <span id="view_unidad_ejecucion"></span></p>
                                    <p><b>Nombre Interventor:</b> <span id="view_nombre_interventor"></span></p>
                                    <p><b>Identificación Interventor:</b> <span id="view_identificacion_interventor"></span></p>
                                    <p><b>Tipo Vinculación Interventor:</b> <span id="view_tipo_vinculacion_interventor"></span></p>
                                    <p><b>Fecha Aprobación Garantía:</b> <span id="view_fecha_aprobacion_garantia"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-light"><h5 class="card-title mb-0">Información Adicional</h5></div>
                                <div class="card-body">
                                    <p><b>Anticipo Contrato:</b> <span id="view_anticipo_contrato"></span></p>
                                    <p><b>Valor Pagado Anticipo:</b> <span id="view_valor_pagado_anticipo"></span></p>
                                    <p><b>Fecha Pago Anticipo:</b> <span id="view_fecha_pago_anticipo"></span></p>
                                    <p><b>Número Adiciones:</b> <span id="view_numero_adiciones"></span></p>
                                    <p><b>Valor Total Adiciones:</b> <span id="view_valor_total_adiciones"></span></p>
                                    <p><b>Número Prórrogas:</b> <span id="view_numero_prorrogas"></span></p>
                                    <p><b>Tiempo Prórrogas:</b> <span id="view_tiempo_prorrogas"></span></p>
                                    <p><b>Número Suspensiones:</b> <span id="view_numero_suspensiones"></span></p>
                                    <p><b>Tiempo Suspensiones:</b> <span id="view_tiempo_suspensiones"></span></p>
                                    <p><b>Valor Total Pagos:</b> <span id="view_valor_total_pagos"></span></p>
                                    <p><b>Fecha Terminación:</b> <span id="view_fecha_terminacion"></span></p>
                                    <p><b>Fecha Acta Liquidación:</b> <span id="view_fecha_acta_liquidacion"></span></p>
                                    <p><b>Observaciones:</b> <span id="view_observaciones"></span></p>
                                    <p><b>Proviene Recurso Reactivación:</b> <span id="view_proviene_recurso_reactivacion"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> 