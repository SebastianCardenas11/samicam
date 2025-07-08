<?php 
headerAdmin($data); 
getModal('modalPermisos', $data);
?>

<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-calendar-check"></i> <?= $data['page_title'] ?></h1>
            <p>Gestión centralizada de permisos de funcionarios</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active"><?= $data['page_title'] ?></li>
        </ul>
    </div>

    <!-- Filtros -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="tile-title"><i class="fas fa-filter"></i> Filtros de Búsqueda</h3>
                    <div class="tile-title-btn">
                        <a href="<?= base_url(); ?>/permisoscontroller/motivos" class="btn btn-warning">
                            <i class="fas fa-cogs"></i> Gestión de Motivos
                        </a>
                        <button class="btn btn-primary" onclick="openModal()">
                            <i class="fas fa-plus"></i> Nuevo Permiso
                        </button>
                    </div>
                </div>
                <div class="tile-body">
                    <form id="formFiltros" class="row">
                        <div class="col-md-3">
                            <label>Funcionario</label>
                            <select class="form-control" id="filtroFuncionario">
                                <option value="">Todos</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Fecha Inicio</label>
                            <input type="date" class="form-control" id="filtroFechaInicio">
                        </div>
                        <div class="col-md-2">
                            <label>Fecha Fin</label>
                            <input type="date" class="form-control" id="filtroFechaFin">
                        </div>
                        <div class="col-md-2">
                            <label>Tipo Permiso</label>
                            <select class="form-control" id="filtroTipoPermiso">
                                <option value="">Todos</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Dependencia</label>
                            <input type="text" class="form-control" id="filtroDependencia" placeholder="Buscar...">
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-info btn-sm" onclick="filtrarPermisos()">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarFiltros()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs para lista y estadísticas -->
    <ul class="nav nav-tabs mb-3" id="permisosTabs" role="tablist" style="margin-top: 1rem;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-lista" data-bs-toggle="tab" data-bs-target="#tabLista" type="button" role="tab" aria-controls="tabLista" aria-selected="true">Lista de Permisos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-estadisticas" data-bs-toggle="tab" data-bs-target="#tabEstadisticas" type="button" role="tab" aria-controls="tabEstadisticas" aria-selected="false">Estadísticas</button>
        </li>
    </ul>
    <div class="tab-content" id="permisosTabsContent">
        <div class="tab-pane fade show active" id="tabLista" role="tabpanel" aria-labelledby="tab-lista">
            <!-- Tabla de permisos -->
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-title-w-btn">
                            <h3 class="tile-title"><i class="fas fa-list"></i> Lista de Permisos</h3>
                            <div class="tile-title-btn">
                                <button class="btn btn-success btn-sm" onclick="exportarExcel()">
                                    <i class="fas fa-file-excel"></i> Exportar
                                </button>
                                <button class="btn btn-info btn-sm" onclick="mostrarEstadisticas()">
                                    <i class="fas fa-chart-bar"></i> Estadísticas
                                </button>
                            </div>
                        </div>
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tablePermisos">
                                    <thead>
                                        <tr>
                                            <th>Funcionario</th>
                                            <th>Identificación</th>
                                            <th>Cargo</th>
                                            <th>Dependencia</th>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Motivo</th>
                                            <th>Estado</th>
                                            <th>Especial</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabEstadisticas" role="tabpanel" aria-labelledby="tab-estadisticas">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="filtroAnioEstadisticas">Año</label>
                    <select class="form-control" id="filtroAnioEstadisticas"></select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">Funcionarios con más permisos por mes</div>
                        <div class="card-body">
                            <canvas id="chartPermisosPorMes"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">Cantidad de permisos por funcionario</div>
                        <div class="card-body">
                            <canvas id="chartPermisosPorFuncionario"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">Dependencia con más permisos</div>
                        <div class="card-body">
                            <canvas id="chartPermisosPorDependencia"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal para permisos -->
<div class="modal fade" id="modalFormPermiso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Permiso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPermiso" name="formPermiso">
                    <input type="hidden" id="idPermiso" name="id_permiso">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Funcionario <span class="text-danger">*</span></label>
                                <select class="form-control" id="listTipoFuncionario" name="tipo_funcionario" required>
                                    <option value="planta">Planta</option>
                                    <option value="ops">OPS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Funcionario <span class="text-danger">*</span></label>
                                <select class="form-control" id="listFuncionario" name="funcionario_id" required>
                                    <option value="">Seleccionar funcionario</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha del Permiso <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="txtFechaPermiso" name="fecha_permiso" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Permiso <span class="text-danger">*</span></label>
                                <select class="form-control" id="listTipoPermiso" name="tipo_permiso_id" required>
                                    <option value="">Seleccionar tipo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Motivo <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="txtMotivo" name="motivo" rows="3" required></textarea>
                    </div>

                    <div id="limitesInfo"></div>

                    <div class="form-group" id="justificacionGroup" style="display: none;">
                        <label>Justificación <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="txtJustificacion" name="justificacion" rows="2"></textarea>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkPermisoEspecial" name="es_especial" value="1">
                        <label class="form-check-label" for="checkPermisoEspecial">
                            Permiso Especial (excede límites normales)
                        </label>
                    </div>

                    <div class="form-group" id="justificacionEspecialGroup" style="display: none;">
                        <label>Justificación para Permiso Especial <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="txtJustificacionEspecial" name="justificacion_especial" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea class="form-control" id="txtObservaciones" name="observaciones" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnActionForm" onclick="fntSavePermiso()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>