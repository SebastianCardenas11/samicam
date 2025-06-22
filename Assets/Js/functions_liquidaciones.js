let tableLiquidaciones;

document.addEventListener('DOMContentLoaded', function(){
    // Inicializar tabla de liquidaciones cuando se active el tab
    document.getElementById('tab-liquidaciones').addEventListener('click', function() {
        if (!tableLiquidaciones) {
            initTableLiquidaciones();
        }
        loadLiquidacionesMetrics();
    });
    
    // Inicializar formulario
    if(document.querySelector('#formLiquidacion')){
        let formLiquidacion = document.querySelector('#formLiquidacion');
        formLiquidacion.addEventListener('submit', function(e) {
            e.preventDefault();
            setLiquidacion();
        });
    }
    
    // Cargar contratos en el select
    loadContratosSelect();
    
    // Event listeners para filtros
    document.getElementById('filtroEstadoLiq').addEventListener('change', filtrarLiquidaciones);
    document.getElementById('filtroFechaDesde').addEventListener('change', filtrarLiquidaciones);
    document.getElementById('filtroFechaHasta').addEventListener('change', filtrarLiquidaciones);
});

function initTableLiquidaciones() {
    tableLiquidaciones = $('#tableLiquidaciones').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": base_url + "/Assets/plugins/datatables/spanish.json"
        },
        "ajax": {
            "url": base_url + "/SeguimientoContrato/getLiquidaciones",
            "dataSrc": ""
        },
        "columns": [
            {"data": "id_liquidacion"},
            {"data": "numero_contrato"},
            {"data": "objeto_contrato"},
            {"data": "fecha_liquidacion"},
            {"data": "tipo_liquidacion"},
            {"data": "valor_liquidado"},
            {"data": "estado"},
            {"data": "responsable"},
            {"data": "observaciones"},
            {"data": "options"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });
}

function openModalLiquidacion() {
    document.querySelector('#idLiquidacion').value = "";
    document.querySelector('.modal-title').innerHTML = "Nueva Liquidación";
    document.querySelector('#btnActionForm').innerHTML = '<i class="fas fa-save"></i> Guardar';
    document.querySelector('#formLiquidacion').reset();
    $('#modalLiquidaciones').modal('show');
}

function editLiquidacion(id) {
    let ajaxUrl = base_url + '/SeguimientoContrato/getLiquidacion/' + id;
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            
            if(objData.status) {
                document.querySelector('#idLiquidacion').value = objData.data.id_liquidacion;
                document.querySelector('#listContratoLiq').value = objData.data.id_contrato;
                document.querySelector('#listTipoLiquidacion').value = objData.data.tipo_liquidacion;
                document.querySelector('#txtFechaLiquidacion').value = objData.data.fecha_liquidacion;
                document.querySelector('#txtValorLiquidar').value = objData.data.valor_liquidado;
                document.querySelector('#listEstadoLiquidacion').value = objData.data.estado;
                document.querySelector('#txtResponsableLiq').value = objData.data.responsable;
                document.querySelector('#txtNumeroActa').value = objData.data.numero_acta;
                document.querySelector('#txtValorEjecutado').value = objData.data.valor_ejecutado;
                document.querySelector('#txtSaldoPorEjecutar').value = objData.data.saldo_por_ejecutar;
                document.querySelector('#txtMultas').value = objData.data.multas;
                document.querySelector('#txtDescuentos').value = objData.data.descuentos;
                document.querySelector('#txtObservacionesLiq').value = objData.data.observaciones;
                
                document.querySelector('.modal-title').innerHTML = "Actualizar Liquidación";
                document.querySelector('#btnActionForm').innerHTML = '<i class="fas fa-sync-alt"></i> Actualizar';
                
                $('#modalLiquidaciones').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function viewLiquidacion(id) {
    let ajaxUrl = base_url + '/SeguimientoContrato/getLiquidacion/' + id;
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            
            if(objData.status) {
                let data = objData.data;
                let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Contrato:</strong> ${data.numero_contrato}</p>
                            <p><strong>Tipo:</strong> ${data.tipo_liquidacion}</p>
                            <p><strong>Fecha:</strong> ${data.fecha_liquidacion}</p>
                            <p><strong>Estado:</strong> <span class="badge bg-${getStatusColor(data.estado)}">${data.estado}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Valor Liquidado:</strong> $${formatNumber(data.valor_liquidado)}</p>
                            <p><strong>Responsable:</strong> ${data.responsable}</p>
                            <p><strong>Número Acta:</strong> ${data.numero_acta || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>Detalles Financieros:</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <p><strong>Valor Ejecutado:</strong><br>$${formatNumber(data.valor_ejecutado)}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Saldo por Ejecutar:</strong><br>$${formatNumber(data.saldo_por_ejecutar)}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Multas:</strong><br>$${formatNumber(data.multas)}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Descuentos:</strong><br>$${formatNumber(data.descuentos)}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    ${data.observaciones ? `
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>Observaciones:</h6>
                            <p>${data.observaciones}</p>
                        </div>
                    </div>
                    ` : ''}
                `;
                
                document.querySelector('#contentViewLiquidacion').innerHTML = html;
                $('#modalVerLiquidacion').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function deleteLiquidacion(id) {
    swal({
        title: "Eliminar Liquidación",
        text: "¿Realmente quiere eliminar esta liquidación?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/SeguimientoContrato/delLiquidacion';
            let strData = "idLiquidacion=" + id;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminado!", objData.msg, "success");
                        tableLiquidaciones.ajax.reload();
                        loadLiquidacionesMetrics();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function setLiquidacion() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/setLiquidacion';
    let formData = new FormData(document.querySelector('#formLiquidacion'));
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                $('#modalLiquidaciones').modal("hide");
                swal("Liquidación", objData.msg, "success");
                document.querySelector('#formLiquidacion').reset();
                tableLiquidaciones.ajax.reload();
                loadLiquidacionesMetrics();
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function loadContratosSelect() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getSelectContratos';
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            document.querySelector('#listContratoLiq').innerHTML = request.responseText;
        }
    }
}

function loadLiquidacionesMetrics() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getLiquidacionesMetrics';
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                document.querySelector('#totalLiquidaciones').innerHTML = objData.data.total;
                document.querySelector('#liquidacionesPendientes').innerHTML = objData.data.pendientes;
                document.querySelector('#liquidacionesCompletadas').innerHTML = objData.data.completadas;
                document.querySelector('#valorTotalLiquidaciones').innerHTML = '$' + formatNumber(objData.data.valor_total);
            }
        }
    }
}

function filtrarLiquidaciones() {
    let estado = document.querySelector('#filtroEstadoLiq').value;
    let fechaDesde = document.querySelector('#filtroFechaDesde').value;
    let fechaHasta = document.querySelector('#filtroFechaHasta').value;
    
    if (tableLiquidaciones) {
        tableLiquidaciones.ajax.url(base_url + '/SeguimientoContrato/getLiquidaciones?estado=' + estado + '&fecha_desde=' + fechaDesde + '&fecha_hasta=' + fechaHasta).load();
    }
}

function limpiarFiltrosLiq() {
    document.querySelector('#filtroEstadoLiq').value = '';
    document.querySelector('#filtroFechaDesde').value = '';
    document.querySelector('#filtroFechaHasta').value = '';
    
    if (tableLiquidaciones) {
        tableLiquidaciones.ajax.url(base_url + '/SeguimientoContrato/getLiquidaciones').load();
    }
}

function getStatusColor(status) {
    switch(status) {
        case 'Completada':
            return 'success';
        case 'En Proceso':
            return 'primary';
        case 'Pendiente':
            return 'warning';
        case 'Rechazada':
            return 'danger';
        default:
            return 'secondary';
    }
}

function formatNumber(num) {
    return parseFloat(num).toLocaleString('es-CO', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function exportLiquidaciones() {
    let estado = document.querySelector('#filtroEstadoLiq').value;
    let fechaDesde = document.querySelector('#filtroFechaDesde').value;
    let fechaHasta = document.querySelector('#filtroFechaHasta').value;
    
    let url = base_url + '/SeguimientoContrato/exportLiquidaciones?estado=' + estado + '&fecha_desde=' + fechaDesde + '&fecha_hasta=' + fechaHasta;
    window.open(url, '_blank');
}