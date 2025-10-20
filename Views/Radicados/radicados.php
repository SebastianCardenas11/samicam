<?php headerAdmin($data); ?>

<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-file-alt"></i> <?= $data['page_title'] ?></h1>
            <p>Gestión de radicados de comunicaciones</p>
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
                        <button class="btn btn-primary" type="button" onclick="openModal()">
                            <i class="fas fa-plus"></i> Nuevo Radicado
                        </button>
                    </div>
                </div>
                <div class="tile-body">
                    <form id="formFiltros" class="row">
                        <div class="col-md-3">
                            <label>Fecha Inicio</label>
                            <input type="date" class="form-control" id="filtroFechaInicio">
                        </div>
                        <div class="col-md-3">
                            <label>Fecha Fin</label>
                            <input type="date" class="form-control" id="filtroFechaFin">
                        </div>
                        <div class="col-md-2">
                            <label>Medio de Envío</label>
                            <select class="form-control" id="filtroMedio">
                                <option value="">Todos</option>
                                <option value="Correo">Correo</option>
                                <option value="Fisico">Físico</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Entidad</label>
                            <input type="text" class="form-control" id="filtroEntidad" placeholder="Buscar entidad...">
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-info btn-sm" onclick="filtrarRadicados()">
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
    <ul class="nav nav-tabs mb-3" id="radicadosTabs" role="tablist" style="margin-top: 1rem;">
        <li class="nav-item">
            <a class="nav-link active" id="tab-lista" data-toggle="tab" href="#tabLista" role="tab" aria-controls="tabLista" aria-selected="true">Lista de Radicados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-estadisticas" data-toggle="tab" href="#tabEstadisticas" role="tab" aria-controls="tabEstadisticas" aria-selected="false">Estadísticas</a>
        </li>
    </ul>
    <div class="tab-content" id="radicadosTabsContent">
        <div class="tab-pane fade show active" id="tabLista" role="tabpanel" aria-labelledby="tab-lista">
            <!-- Tabla de radicados -->
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-title-w-btn">
                            <h3 class="tile-title"><i class="fas fa-list"></i> Lista de Radicados</h3>
                            <div class="tile-title-btn">
                                <button class="btn btn-success btn-sm" onclick="exportarExcel()">
                                    <i class="fas fa-file-excel"></i> Exportar
                                </button>
                            </div>
                        </div>
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tableRadicados">
                                    <thead>
                                        <tr>
                                            <th>Número Radicado</th>
                                            <th>Asunto</th>
                                            <th>Entidad</th>
                                            <th>Medio Envío</th>
                                            <th>Fecha Envío</th>
                                            <th>Fecha Radicado</th>
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
                        <div class="card-header">Radicados por Medio de Envío</div>
                        <div class="card-body">
                            <canvas id="chartRadicadosPorMedio"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">Radicados por Mes</div>
                        <div class="card-body">
                            <canvas id="chartRadicadosPorMes"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">Top Entidades con más Radicados</div>
                        <div class="card-body">
                            <canvas id="chartTopEntidades"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal para radicados -->
<div class="modal fade" id="modalFormRadicado" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Radicado</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 1.5rem; color: #fff; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRadicado" name="formRadicado">
                    <input type="hidden" id="idRadicado" name="idRadicado">
                    
                    <div class="form-group">
                        <label>Asunto de Comunicación <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="txtAsunto" name="txtAsunto" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Entidad a la cual se envía <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtEntidad" name="txtEntidad" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Medio de Envío <span class="text-danger">*</span></label>
                                <select class="form-control" id="listMedio" name="listMedio" required>
                                    <option value="">Seleccionar medio</option>
                                    <option value="Correo">Correo</option>
                                    <option value="Fisico">Físico</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de Envío <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="txtFechaEnvio" name="txtFechaEnvio" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número de Radicado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtNumeroRadicado" name="txtNumeroRadicado" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Fecha de Radicado <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="txtFechaRadicado" name="txtFechaRadicado" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnActionForm" onclick="fntSaveRadicado()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data); ?>