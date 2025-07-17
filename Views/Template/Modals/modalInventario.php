<!-- Modal Inventario -->
<div class="modal fade" id="modalInventario" tabindex="-1" role="dialog" aria-labelledby="modalInventarioLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInventarioLabel">Gestionar Inventario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario Impresoras -->
                <form id="formImpresora" name="formImpresora" method="POST">
                    <input type="hidden" id="idImpresora" name="idImpresora" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtNumeroImpresora">Número de Impresora *</label>
                                <input type="text" class="form-control" id="txtNumeroImpresora" name="txtNumeroImpresora" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtMarca">Marca *</label>
                                <input type="text" class="form-control" id="txtMarca" name="txtMarca" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtModelo">Modelo *</label>
                                <input type="text" class="form-control" id="txtModelo" name="txtModelo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtSerial">Serial</label>
                                <input type="text" class="form-control" id="txtSerial" name="txtSerial">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtConsumible">Consumible</label>
                                <input type="text" class="form-control" id="txtConsumible" name="txtConsumible">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtEstado">Estado *</label>
                                <select class="form-control" id="txtEstado" name="txtEstado" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Malo">Malo</option>
                                    <option value="De baja">De baja</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtDisponibilidad">Disponibilidad *</label>
                                <select class="form-control" id="txtDisponibilidad" name="txtDisponibilidad" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="No Disponible">No Disponible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Formulario Escáneres -->
                <form id="formEscaner" name="formEscaner" method="POST" style="display: none;">
                    <input type="hidden" id="idEscaner" name="idEscaner" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtNumeroEscaner">Número de Escáner *</label>
                                <input type="text" class="form-control" id="txtNumeroEscaner" name="txtNumeroEscaner" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtMarcaEscaner">Marca *</label>
                                <input type="text" class="form-control" id="txtMarcaEscaner" name="txtMarca" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtModeloEscaner">Modelo *</label>
                                <input type="text" class="form-control" id="txtModeloEscaner" name="txtModelo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtSerialEscaner">Serial</label>
                                <input type="text" class="form-control" id="txtSerialEscaner" name="txtSerial">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtEstadoEscaner">Estado *</label>
                                <select class="form-control" id="txtEstadoEscaner" name="txtEstado" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Malo">Malo</option>
                                    <option value="De baja">De baja</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtDisponibilidadEscaner">Disponibilidad *</label>
                                <select class="form-control" id="txtDisponibilidadEscaner" name="txtDisponibilidad" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="No Disponible">No Disponible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Formulario Papelería -->
                <form id="formPapeleria" name="formPapeleria" method="POST" style="display: none;">
                    <input type="hidden" id="idPapeleria" name="idPapeleria" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtItemPapeleria">Item *</label>
                                <input type="text" class="form-control" id="txtItemPapeleria" name="txtItem" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtDisponibilidadPapeleria">Disponibilidad *</label>
                                <input type="number" class="form-control" id="txtDisponibilidadPapeleria" name="txtDisponibilidad" min="0" required>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Formulario Tintas y Tóner -->
                <form id="formTintaToner" name="formTintaToner" method="POST" style="display: none;">
                    <input type="hidden" id="idTintaToner" name="idTintaToner" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtItem">Item *</label>
                                <input type="text" class="form-control" id="txtItem" name="txtItem" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtDisponibles">Disponibles *</label>
                                <input type="number" class="form-control" id="txtDisponibles" name="txtDisponibles" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="selectImpresoraTintaToner">Impresora</label>
                                <select class="form-control" id="selectImpresoraTintaToner" name="txtImpresora">
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtModelosCompatibles">Modelos Compatibles</label>
                                <input type="text" class="form-control" id="txtModelosCompatibles" name="txtModelosCompatibles">
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Formulario PC Torre -->
                <form id="formPcTorre" name="formPcTorre" method="POST" style="display: none;">
                    <input type="hidden" id="idPcTorre" name="idPcTorre" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtNumeroPcTorre">Número *</label>
                                <input type="text" class="form-control" id="txtNumeroPcTorre" name="txtNumeroPcTorre" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtMarcaPcTorre">Marca *</label>
                                <input type="text" class="form-control" id="txtMarcaPcTorre" name="txtMarcaPcTorre" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtSerialPcTorre">Serial</label>
                                <input type="text" class="form-control" id="txtSerialPcTorre" name="txtSerialPcTorre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtModeloPcTorre">Modelo *</label>
                                <input type="text" class="form-control" id="txtModeloPcTorre" name="txtModeloPcTorre" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtRamPcTorre">RAM</label>
                                <input type="text" class="form-control" id="txtRamPcTorre" name="txtRamPcTorre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtVelocidadRamPcTorre">Velocidad RAM</label>
                                <input type="text" class="form-control" id="txtVelocidadRamPcTorre" name="txtVelocidadRamPcTorre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtProcesadorPcTorre">Procesador</label>
                                <input type="text" class="form-control" id="txtProcesadorPcTorre" name="txtProcesadorPcTorre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtVelocidadProcesadorPcTorre">Velocidad Procesador</label>
                                <input type="text" class="form-control" id="txtVelocidadProcesadorPcTorre" name="txtVelocidadProcesadorPcTorre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtDiscoDuroPcTorre">Disco Duro *</label>
                                <select class="form-control" id="txtDiscoDuroPcTorre" name="txtDiscoDuroPcTorre" required>
                                    <option value="">Seleccione...</option>
                                    <option value="HDD">HDD</option>
                                    <option value="SSD">SSD</option>
                                    <option value="Híbrido">Híbrido</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtCapacidadPcTorre">Capacidad</label>
                                <input type="text" class="form-control" id="txtCapacidadPcTorre" name="txtCapacidadPcTorre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtSistemaOperativoPcTorre">Sistema Operativo</label>
                                <input type="text" class="form-control" id="txtSistemaOperativoPcTorre" name="txtSistemaOperativoPcTorre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtNumeroActivoPcTorre">N° Activo</label>
                                <input type="text" class="form-control" id="txtNumeroActivoPcTorre" name="txtNumeroActivoPcTorre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtMonitorPcTorre">Monitor</label>
                                <input type="text" class="form-control" id="txtMonitorPcTorre" name="txtMonitorPcTorre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtNumeroActivoMonitorPcTorre">N° Activo Monitor</label>
                                <input type="text" class="form-control" id="txtNumeroActivoMonitorPcTorre" name="txtNumeroActivoMonitorPcTorre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtSerialMonitorPcTorre">Serial Monitor</label>
                                <input type="text" class="form-control" id="txtSerialMonitorPcTorre" name="txtSerialMonitorPcTorre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtEstadoPcTorre">Estado *</label>
                                <select class="form-control" id="txtEstadoPcTorre" name="txtEstadoPcTorre" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Malo">Malo</option>
                                    <option value="De Baja">De Baja</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtDisponibilidadPcTorre">Disponibilidad *</label>
                                <select class="form-control" id="txtDisponibilidadPcTorre" name="txtDisponibilidadPcTorre" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="No Disponible">No Disponible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Formulario PC Todo en Uno -->
                <form id="formTodoEnUno" name="formTodoEnUno" method="POST" style="display: none;">
                    <input type="hidden" id="idTodoEnUno" name="idTodoEnUno" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtNumeroTodoEnUno">Número *</label>
                                <input type="text" class="form-control" id="txtNumeroTodoEnUno" name="txtNumeroTodoEnUno" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtMarcaTodoEnUno">Marca *</label>
                                <input type="text" class="form-control" id="txtMarcaTodoEnUno" name="txtMarcaTodoEnUno" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtModeloTodoEnUno">Modelo *</label>
                                <input type="text" class="form-control" id="txtModeloTodoEnUno" name="txtModeloTodoEnUno" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtRamTodoEnUno">RAM</label>
                                <input type="text" class="form-control" id="txtRamTodoEnUno" name="txtRamTodoEnUno">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtVelocidadRamTodoEnUno">Velocidad RAM</label>
                                <input type="text" class="form-control" id="txtVelocidadRamTodoEnUno" name="txtVelocidadRamTodoEnUno">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtProcesadorTodoEnUno">Procesador</label>
                                <input type="text" class="form-control" id="txtProcesadorTodoEnUno" name="txtProcesadorTodoEnUno">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtVelocidadProcesadorTodoEnUno">Velocidad Procesador</label>
                                <input type="text" class="form-control" id="txtVelocidadProcesadorTodoEnUno" name="txtVelocidadProcesadorTodoEnUno">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtDiscoDuroTodoEnUno">Disco Duro *</label>
                                <select class="form-control" id="txtDiscoDuroTodoEnUno" name="txtDiscoDuroTodoEnUno" required>
                                    <option value="">Seleccione...</option>
                                    <option value="HDD">HDD</option>
                                    <option value="SSD">SSD</option>
                                    <option value="Híbrido">Híbrido</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtCapacidadTodoEnUno">Capacidad</label>
                                <input type="text" class="form-control" id="txtCapacidadTodoEnUno" name="txtCapacidadTodoEnUno">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtSerialTodoEnUno">Serial</label>
                                <input type="text" class="form-control" id="txtSerialTodoEnUno" name="txtSerialTodoEnUno">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtSistemaOperativoTodoEnUno">Sistema Operativo</label>
                                <input type="text" class="form-control" id="txtSistemaOperativoTodoEnUno" name="txtSistemaOperativoTodoEnUno">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtNumeroActivoTodoEnUno">N° Activo</label>
                                <input type="text" class="form-control" id="txtNumeroActivoTodoEnUno" name="txtNumeroActivoTodoEnUno">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtEstadoTodoEnUno">Estado *</label>
                                <select class="form-control" id="txtEstadoTodoEnUno" name="txtEstadoTodoEnUno" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Malo">Malo</option>
                                    <option value="De baja">De baja</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtDisponibilidadTodoEnUno">Disponibilidad *</label>
                                <select class="form-control" id="txtDisponibilidadTodoEnUno" name="txtDisponibilidadTodoEnUno" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="No Disponible">No Disponible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Formulario Portátiles -->
                <form id="formPortatil" name="formPortatil" method="POST" style="display: none;">
                    <input type="hidden" id="idPortatil" name="idPortatil" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtNumeroPortatil">Número *</label>
                                <input type="text" class="form-control" id="txtNumeroPortatil" name="txtNumeroPortatil" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtMarcaPortatil">Marca *</label>
                                <input type="text" class="form-control" id="txtMarcaPortatil" name="txtMarcaPortatil" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtModeloPortatil">Modelo *</label>
                                <input type="text" class="form-control" id="txtModeloPortatil" name="txtModeloPortatil" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtRamPortatil">RAM</label>
                                <input type="text" class="form-control" id="txtRamPortatil" name="txtRamPortatil">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtVelocidadRamPortatil">Velocidad RAM</label>
                                <input type="text" class="form-control" id="txtVelocidadRamPortatil" name="txtVelocidadRamPortatil">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtProcesadorPortatil">Procesador</label>
                                <input type="text" class="form-control" id="txtProcesadorPortatil" name="txtProcesadorPortatil">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtVelocidadProcesadorPortatil">Velocidad Procesador</label>
                                <input type="text" class="form-control" id="txtVelocidadProcesadorPortatil" name="txtVelocidadProcesadorPortatil">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtDiscoDuroPortatil">Disco Duro *</label>
                                <select class="form-control" id="txtDiscoDuroPortatil" name="txtDiscoDuroPortatil" required>
                                    <option value="">Seleccione...</option>
                                    <option value="HDD">HDD</option>
                                    <option value="SSD">SSD</option>
                                    <option value="Híbrido">Híbrido</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtCapacidadPortatil">Capacidad</label>
                                <input type="text" class="form-control" id="txtCapacidadPortatil" name="txtCapacidadPortatil">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtSerialPortatil">Serial</label>
                                <input type="text" class="form-control" id="txtSerialPortatil" name="txtSerialPortatil">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtSistemaOperativoPortatil">Sistema Operativo</label>
                                <input type="text" class="form-control" id="txtSistemaOperativoPortatil" name="txtSistemaOperativoPortatil">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtNumeroActivoPortatil">N° Activo</label>
                                <input type="text" class="form-control" id="txtNumeroActivoPortatil" name="txtNumeroActivoPortatil">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtEstadoPortatil">Estado *</label>
                                <select class="form-control" id="txtEstadoPortatil" name="txtEstadoPortatil" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Malo">Malo</option>
                                    <option value="De baja">De baja</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtDisponibilidadPortatil">Disponibilidad *</label>
                                <select class="form-control" id="txtDisponibilidadPortatil" name="txtDisponibilidadPortatil" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="No Disponible">No Disponible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Formulario Herramientas -->
                <form id="formHerramienta" name="formHerramienta" method="POST" style="display: none;">
                    <input type="hidden" id="idHerramienta" name="idHerramienta" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtItemHerramienta">Item *</label>
                                <input type="text" class="form-control" id="txtItemHerramienta" name="txtItemHerramienta" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtMarcaHerramienta">Marca *</label>
                                <input type="text" class="form-control" id="txtMarcaHerramienta" name="txtMarcaHerramienta" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtDisponibilidadHerramienta">Disponibilidad *</label>
                                <select class="form-control" id="txtDisponibilidadHerramienta" name="txtDisponibilidadHerramienta" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="En Uso">En Uso</option>
                                    <option value="Reservado">Reservado</option>
                                    <option value="No Disponible">No Disponible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnActionForm">Guardar</button>
            </div>
        </div>
    </div>
</div>
