let tableRadicados;

document.addEventListener('DOMContentLoaded', function() {
    initializeTable();
    setupEventListeners();
});

// Inicializar tabla de radicados
function initializeTable() {
    tableRadicados = $('#tableRadicados').DataTable({
        "aProcessing": true,
        "aServerSide": false,
        "language": {
            "url": base_url + "/es.json"
        },
        "ajax": {
            "url": base_url + "/Radicados/getRadicados",
            "method": "POST",
            "dataSrc": ""
        },
        "columns": [
            {"data": "numero_radicado"},
            {
                "data": "asunto_comunicacion",
                "render": function(data, type, row) {
                    return data.length > 50 ? data.substring(0, 50) + '...' : data;
                }
            },
            {"data": "entidad_envio"},
            {
                "data": "medio_envio",
                "render": function(data, type, row) {
                    let badgeClass = data === 'Correo' ? 'badge-info' : 'badge-warning';
                    return `<span class="badge ${badgeClass}" style="color: white;">${data}</span>`;
                }
            },
            {"data": "fecha_envio"},
            {"data": "fecha_radicado"},
            {"data": "options"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[5, "desc"]]
    });
}

// Configurar event listeners
function setupEventListeners() {
    // Event listeners para filtros
    document.getElementById('filtroFechaInicio').addEventListener('change', filtrarRadicados);
    document.getElementById('filtroFechaFin').addEventListener('change', filtrarRadicados);
    document.getElementById('filtroMedio').addEventListener('change', filtrarRadicados);
    document.getElementById('filtroEntidad').addEventListener('input', filtrarRadicados);
}

// Abrir modal para nuevo radicado
function openModal() {
    document.getElementById('idRadicado').value = '';
    document.getElementById('titleModal').innerHTML = 'Nuevo Radicado';
    document.getElementById('btnActionForm').innerHTML = 'Guardar';
    document.getElementById('formRadicado').reset();
    $('#modalFormRadicado').modal('show');
}

// Guardar radicado
function fntSaveRadicado() {
    let formElement = document.querySelector("#formRadicado");
    let formData = new FormData(formElement);
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Radicados/setRadicado';
    
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                $('#modalFormRadicado').modal('hide');
                formElement.reset();
                Swal.fire({
                    title: "Radicados",
                    text: objData.msg,
                    icon: "success"
                });
                tableRadicados.ajax.reload();
            } else {
                Swal.fire({
                    title: "Error",
                    text: objData.msg,
                    icon: "error"
                });
            }
        }
    }
}

// Ver radicado
function fntViewRadicado(idRadicado) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Radicados/getRadicado/' + idRadicado;
    
    request.open("POST", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let radicado = objData.data;
                Swal.fire({
                    title: "Detalle del Radicado",
                    html: `
                        <div class="text-left">
                            <p><strong>Número:</strong> ${radicado.numero_radicado}</p>
                            <p><strong>Asunto:</strong> ${radicado.asunto_comunicacion}</p>
                            <p><strong>Entidad:</strong> ${radicado.entidad_envio}</p>
                            <p><strong>Medio:</strong> ${radicado.medio_envio}</p>
                            <p><strong>Fecha Envío:</strong> ${radicado.fecha_envio}</p>
                            <p><strong>Fecha Radicado:</strong> ${radicado.fecha_radicado}</p>
                        </div>
                    `,
                    width: 600,
                    showCloseButton: true,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: objData.msg,
                    icon: "error"
                });
            }
        }
    }
}

// Editar radicado
function fntEditRadicado(idRadicado) {
    document.getElementById('titleModal').innerHTML = 'Actualizar Radicado';
    document.getElementById('btnActionForm').innerHTML = 'Actualizar';
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Radicados/getRadicado/' + idRadicado;
    
    request.open("POST", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let radicado = objData.data;
                document.getElementById('idRadicado').value = radicado.id_radicado;
                document.getElementById('txtAsunto').value = radicado.asunto_comunicacion;
                document.getElementById('txtEntidad').value = radicado.entidad_envio;
                document.getElementById('listMedio').value = radicado.medio_envio;
                document.getElementById('txtFechaEnvio').value = radicado.fecha_envio;
                document.getElementById('txtNumeroRadicado').value = radicado.numero_radicado;
                document.getElementById('txtFechaRadicado').value = radicado.fecha_radicado;
                $('#modalFormRadicado').modal('show');
            } else {
                Swal.fire({
                    title: "Error",
                    text: objData.msg,
                    icon: "error"
                });
            }
        }
    }
}

// Eliminar radicado
function fntDelRadicado(idRadicado) {
    Swal.fire({
        title: "Eliminar Radicado",
        text: "¿Realmente quiere eliminar el radicado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Radicados/delRadicado/';
            let strData = "idRadicado=" + idRadicado;
            
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire({
                            title: "Eliminar!",
                            text: objData.msg,
                            icon: "success"
                        });
                        tableRadicados.ajax.reload();
                    } else {
                        Swal.fire({
                            title: "Atención!",
                            text: objData.msg,
                            icon: "error"
                        });
                    }
                }
            }
        }
    });
}

// Filtrar radicados
function filtrarRadicados() {
    tableRadicados.ajax.reload();
}

// Limpiar filtros
function limpiarFiltros() {
    document.getElementById('formFiltros').reset();
    tableRadicados.ajax.reload();
}

// Exportar a Excel
function exportarExcel() {
    window.open(base_url + '/Radicados/exportarExcel', '_blank');
}

// Poblar el filtro de año en estadísticas
function poblarFiltroAnioEstadisticas() {
    const select = document.getElementById('filtroAnioEstadisticas');
    const anioActual = new Date().getFullYear();
    select.innerHTML = '';
    for(let i = anioActual; i >= anioActual - 10; i--) {
        let opt = document.createElement('option');
        opt.value = i;
        opt.textContent = i;
        select.appendChild(opt);
    }
}

// Cargar gráficos de estadísticas
function cargarGraficosRadicados() {
    const anio = document.getElementById('filtroAnioEstadisticas') ? document.getElementById('filtroAnioEstadisticas').value : new Date().getFullYear();
    
    // Gráfico por medio de envío
    $.post(base_url + '/Radicados/getEstadisticasPorMedio', {anio}, function(response) {
        const data = JSON.parse(response);
        let labels = data.map(item => item.medio_envio);
        let values = data.map(item => parseInt(item.total));
        let colors = ['#36a2eb', '#ff6384'];
        
        if(window.chartRadicadosPorMedio) window.chartRadicadosPorMedio.destroy();
        window.chartRadicadosPorMedio = new Chart(document.getElementById('chartRadicadosPorMedio').getContext('2d'), {
            type: 'pie',
            data: { 
                labels, 
                datasets: [{ 
                    data: values, 
                    backgroundColor: colors 
                }] 
            },
            options: { 
                responsive: true, 
                plugins: { 
                    legend: { display: true } 
                } 
            }
        });
    });
    
    // Gráfico por mes
    $.post(base_url + '/Radicados/getEstadisticasPorMes', {anio}, function(response) {
        const data = JSON.parse(response);
        const meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        let labels = meses;
        let values = Array(12).fill(0);
        
        data.forEach(item => {
            values[item.mes - 1] = parseInt(item.total);
        });
        
        if(window.chartRadicadosPorMes) window.chartRadicadosPorMes.destroy();
        window.chartRadicadosPorMes = new Chart(document.getElementById('chartRadicadosPorMes').getContext('2d'), {
            type: 'bar',
            data: { 
                labels, 
                datasets: [{ 
                    label: 'Radicados', 
                    data: values, 
                    backgroundColor: '#4bc0c0' 
                }] 
            },
            options: { 
                responsive: true, 
                plugins: { 
                    legend: { display: false } 
                } 
            }
        });
    });
    
    // Gráfico top entidades
    $.post(base_url + '/Radicados/getTopEntidades', {anio}, function(response) {
        const data = JSON.parse(response);
        let labels = data.map(item => item.entidad_envio.length > 20 ? item.entidad_envio.substring(0, 20) + '...' : item.entidad_envio);
        let values = data.map(item => parseInt(item.total));
        
        if(window.chartTopEntidades) window.chartTopEntidades.destroy();
        window.chartTopEntidades = new Chart(document.getElementById('chartTopEntidades').getContext('2d'), {
            type: 'bar',
            data: { 
                labels, 
                datasets: [{ 
                    label: 'Radicados', 
                    data: values, 
                    backgroundColor: '#ff9f40' 
                }] 
            },
            options: { 
                responsive: true, 
                plugins: { 
                    legend: { display: false } 
                },
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 45
                        }
                    }
                }
            }
        });
    });
}

// Inicializar filtro de año y cargar gráficos al mostrar el tab
$(document).ready(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if (e.target.getAttribute('href') === '#tabEstadisticas') {
            poblarFiltroAnioEstadisticas();
            cargarGraficosRadicados();
        }
    });
});

// Recargar gráficos al cambiar el año
$(document).on('change', '#filtroAnioEstadisticas', function() {
    cargarGraficosRadicados();
});