let tablaHojasVida;
let equipoSeleccionado = {};

document.addEventListener('DOMContentLoaded', function() {
    tablaHojasVida = $('#tablaHojasVida').DataTable({
        "aProcessing": true,
        "aServerSide": false,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        "ajax": {
            "url": " " + base_url + "/HojasVidaEquipos/getEquiposConMovimientos",
            "dataSrc": ""
        },
        "columns": [
            {"data": "tipo_equipo", "render": function(data) {
                return ucfirst(data.replace('_', ' '));
            }},
            {"data": "numero"},
            {"data": "marca"},
            {"data": "modelo"},
            {"data": "estado", "render": function(data) {
                let badgeClass = data === 'Bueno' ? 'badge-estado-bueno' : 
                               data === 'Regular' ? 'badge-estado-regular' : 'badge-estado-malo';
                return `<span class="badge ${badgeClass}">${data}</span>`;
            }},
            {"data": "disponibilidad", "render": function(data) {
                let badgeClass = data === 'Disponible' ? 'badge-disponible' : 'badge-no-disponible';
                return `<span class="badge ${badgeClass}">${data}</span>`;
            }},
            {"data": "total_movimientos"},
            {"data": "ultimo_movimiento", "render": function(data) {
                return data ? formatDateTime(data) : 'Sin movimientos';
            }},
            {"data": null, "render": function(data, type, row) {
                return `<div class="text-center">
                    <button class="btn btn-hoja-vida btn-sm" onclick="verHojaVida(${row.id_equipo}, '${row.tipo_equipo}')" title="Ver Hoja de Vida">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="generarPDFDirecto(${row.id_equipo}, '${row.tipo_equipo}')" title="Generar PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>`;
            }}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[7, "desc"]]
    });
});

function verHojaVida(idEquipo, tipoEquipo) {
    let ajaxUrl = base_url + '/HojasVidaEquipos/getHojaVidaEquipo/' + idEquipo + '/' + tipoEquipo;
    
    $.ajax({
        url: ajaxUrl,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                equipoSeleccionado = {
                    id: idEquipo,
                    tipo: tipoEquipo
                };
                mostrarHojaVida(response.data);
                $('#modalHojaVida').modal('show');
            } else {
                Swal.fire('Error', response.msg, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Error al cargar la hoja de vida', 'error');
        }
    });
}

function mostrarHojaVida(data) {
    let equipo = data.equipo;
    let movimientos = data.movimientos;
    let tipoEquipo = data.tipo_equipo;
    
    let numero = equipo.numero_impresora || equipo.numero_escaner || equipo.numero_pc || equipo.item || 'N/A';
    
    let html = `
        <div class="row">
            <div class="col-md-6">
                <div class="card info-equipo-card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información General</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr><td><strong>Tipo de Equipo:</strong></td><td>${ucfirst(tipoEquipo.replace('_', ' '))}</td></tr>
                            <tr><td><strong>Número/ID:</strong></td><td>${numero}</td></tr>
                            ${equipo.marca ? `<tr><td><strong>Marca:</strong></td><td>${equipo.marca}</td></tr>` : ''}
                            ${equipo.modelo ? `<tr><td><strong>Modelo:</strong></td><td>${equipo.modelo}</td></tr>` : ''}
                            ${equipo.serial ? `<tr><td><strong>Serial:</strong></td><td>${equipo.serial}</td></tr>` : ''}
                            <tr><td><strong>Estado:</strong></td><td><span class="badge bg-${equipo.estado === 'Bueno' ? 'success' : equipo.estado === 'Regular' ? 'warning' : 'danger'}">${equipo.estado}</span></td></tr>
                            <tr><td><strong>Disponibilidad:</strong></td><td><span class="badge bg-${equipo.disponibilidad === 'Disponible' ? 'success' : 'warning'}">${equipo.disponibilidad}</span></td></tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card estadisticas-card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Estadísticas</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr><td><strong>Total Movimientos:</strong></td><td>${movimientos.length}</td></tr>
                            <tr><td><strong>Entradas a Mantenimiento:</strong></td><td>${movimientos.filter(m => m.tipo_movimiento === 'entrada').length}</td></tr>
                            <tr><td><strong>Salidas de Mantenimiento:</strong></td><td>${movimientos.filter(m => m.tipo_movimiento === 'salida').length}</td></tr>
                            <tr><td><strong>Último Movimiento:</strong></td><td>${movimientos.length > 0 ? formatDateTime(movimientos[0].fecha_hora) : 'Sin movimientos'}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card historial-card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-history"></i> Historial de Movimientos</h6>
                    </div>
                    <div class="card-body">
                        ${movimientos.length > 0 ? `
                            <div class="table-responsive">
                                <table class="table table-sm table-striped tabla-movimientos">
                                    <thead>
                                        <tr>
                                            <th>Fecha/Hora</th>
                                            <th>Tipo</th>
                                            <th>Observación</th>
                                            <th>Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${movimientos.map(mov => `
                                            <tr>
                                                <td>${formatDateTime(mov.fecha_hora)}</td>
                                                <td><span class="badge bg-${mov.tipo_movimiento === 'entrada' ? 'danger' : 'success'}">${ucfirst(mov.tipo_movimiento)}</span></td>
                                                <td>${mov.observacion}</td>
                                                <td>${mov.usuario}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        ` : '<p class="text-muted">No hay movimientos registrados para este equipo.</p>'}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('contenidoHojaVida').innerHTML = html;
}

function generarPDFHojaVida() {
    if (!equipoSeleccionado.id || !equipoSeleccionado.tipo) {
        Swal.fire('Error', 'No hay equipo seleccionado', 'error');
        return;
    }
    
    let formData = new FormData();
    formData.append('idEquipo', equipoSeleccionado.id);
    formData.append('tipoEquipo', equipoSeleccionado.tipo);
    
    fetch(base_url + '/HojasVidaEquipos/generarPDFHojaVida', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            return response.blob();
        }
        throw new Error('Error al generar PDF');
    })
    .then(blob => {
        let url = window.URL.createObjectURL(blob);
        let a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = `hoja_vida_${equipoSeleccionado.tipo}_${equipoSeleccionado.id}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    })
    .catch(error => {
        Swal.fire('Error', 'Error al generar el PDF', 'error');
    });
}

function generarPDFDirecto(idEquipo, tipoEquipo) {
    let formData = new FormData();
    formData.append('idEquipo', idEquipo);
    formData.append('tipoEquipo', tipoEquipo);
    
    fetch(base_url + '/HojasVidaEquipos/generarPDFHojaVida', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            return response.blob();
        }
        throw new Error('Error al generar PDF');
    })
    .then(blob => {
        let url = window.URL.createObjectURL(blob);
        let a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = `hoja_vida_${tipoEquipo}_${idEquipo}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    })
    .catch(error => {
        Swal.fire('Error', 'Error al generar el PDF', 'error');
    });
}

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function formatDateTime(dateTime) {
    let date = new Date(dateTime);
    return date.toLocaleString('es-CO', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}