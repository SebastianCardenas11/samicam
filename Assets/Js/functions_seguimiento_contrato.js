let tableSeguimientoContrato;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){
    tableSeguimientoContrato = $('#tableSeguimientoContrato').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "./es.json"
        },
        "ajax": {
            "url": " " + base_url + "/SeguimientoContrato/getContratos",
            "dataSrc": ""
        },
        "columns": [
            { "data": "fecha_aprobacion_entidad" },
            { "data": "numero_contrato" },
            { 
                "data": "objeto_contrato",
                "render": function(data, type, row) {
                    if (typeof data === 'string' && data.length > 50) {
                        return data.substring(0, 50) + '...';
                    }
                    return data;
                }
            },
            { "data": "fecha_inicio" },
            { "data": "fecha_terminacion" },
            { "data": "plazo_meses" },
            { "data": "valor_total_contrato" },
            { "data": "dia_corte_informe" },
            { "data": "observaciones_ejecucion" },
            { "data": "evidenciado_secop" },
            { "data": "fecha_verificacion" },
            { "data": "liquidacion" },
            { "data": "estado" },
            { "data": "options" }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success mt-3"
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger mt-3"
            }
        ],
        "responsive": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });

    if (document.querySelector("#formSeguimientoContrato")) {
        let formSeguimientoContrato = document.querySelector("#formSeguimientoContrato");
        formSeguimientoContrato.onsubmit = function(e) {
            e.preventDefault();
            // All fields are required based on modal
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/SeguimientoContrato/setContrato';
            let formData = new FormData(formSeguimientoContrato);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        $('#modalFormSeguimientoContrato').modal("hide");
                        formSeguimientoContrato.reset();
                        if(document.querySelector("#numero_contrato")) document.querySelector("#numero_contrato").value = "";
                        if(document.querySelector("#fecha_aprobacion_entidad")) document.querySelector("#fecha_aprobacion_entidad").value = "";
                        Swal.fire("Seguimiento de Contrato", objData.msg, "success");
                        tableSeguimientoContrato.api().ajax.reload();
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                }
            }
        }
    }
}, false);

function fntViewContrato(id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getContrato/' + id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let estado = objData.data.estado == 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                document.querySelector("#celObjetoContrato").innerHTML = objData.data.objeto_contrato;
                document.querySelector("#celFechaInicio").innerHTML = objData.data.fecha_inicio;
                document.querySelector("#celFechaTerminacion").innerHTML = objData.data.fecha_terminacion;
                document.querySelector("#celPlazoMeses").innerHTML = objData.data.plazo_meses;
                document.querySelector("#celValorTotalContrato").innerHTML = objData.data.valor_total_contrato;
                document.querySelector("#celDiaCorteInforme").innerHTML = objData.data.dia_corte_informe;
                document.querySelector("#celObservacionesEjecucion").innerHTML = objData.data.observaciones_ejecucion;
                document.querySelector("#celEvidenciadoSecop").innerHTML = objData.data.evidenciado_secop;
                document.querySelector("#celFechaVerificacion").innerHTML = objData.data.fecha_verificacion;
                document.querySelector("#celLiquidacion").innerHTML = '$' + parseFloat(objData.data.liquidacion).toFixed(2);
                document.querySelector("#celEstado").innerHTML = estado;
                document.querySelector("#celNumeroContrato").innerHTML = objData.data.numero_contrato;
                document.querySelector("#celFechaAprobacionEntidad").innerHTML = objData.data.fecha_aprobacion_entidad;
                $('#modalViewContrato').modal('show');
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    }
}

function fntEditContrato(element, id) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Contrato";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-warning");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getContrato/' + id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#id").value = objData.data.id;
                document.querySelector("#objeto_contrato").value = objData.data.objeto_contrato;
                document.querySelector("#fecha_inicio").value = objData.data.fecha_inicio;
                document.querySelector("#fecha_terminacion").value = objData.data.fecha_terminacion;
                document.querySelector("#plazo_meses").value = objData.data.plazo_meses;
                document.querySelector("#valor_total_contrato").value = objData.data.valor_total_contrato;
                document.querySelector("#dia_corte_informe").value = objData.data.dia_corte_informe;
                document.querySelector("#observaciones_ejecucion").value = objData.data.observaciones_ejecucion;
                document.querySelector("#evidenciado_secop").value = objData.data.evidenciado_secop;
                document.querySelector("#fecha_verificacion").value = objData.data.fecha_verificacion;
                document.querySelector("#liquidacion").value = objData.data.liquidacion;
                document.querySelector("#numero_contrato").value = objData.data.numero_contrato;
                document.querySelector("#fecha_aprobacion_entidad").value = objData.data.fecha_aprobacion_entidad;
                if(document.querySelector("#estado")){
                    let estadoValue = objData.data.estado;
                    if (typeof estadoValue === 'string') {
                        if (estadoValue.includes('Liquidado')) {
                            estadoValue = '1';
                        } else if (estadoValue.includes('En ejecución')) {
                            estadoValue = '2';
                        } else if (estadoValue.includes('Terminado')) {
                            estadoValue = '3';
                        } else {
                            estadoValue = '1'; // Por defecto
                        }
                    }
                    document.querySelector("#estado").value = estadoValue;
                }
            }
        }
        $('#modalFormSeguimientoContrato').modal('show');
    }
}

function fntDelContrato(id) {
    Swal.fire({
        title: "Eliminar Contrato",
        text: "¿Realmente quiere eliminar el Contrato?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/SeguimientoContrato/delContrato';
            let strData = "id=" + id;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminar!", objData.msg, "success");
                        tableSeguimientoContrato.api().ajax.reload();
                    } else {
                        Swal.fire("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function openModal() {
    rowTable = "";
    document.querySelector('#id').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-warning");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Contrato";
    document.querySelector("#formSeguimientoContrato").reset();
    if(document.querySelector("#numero_contrato")) document.querySelector("#numero_contrato").value = "";
    if(document.querySelector("#fecha_aprobacion_entidad")) document.querySelector("#fecha_aprobacion_entidad").value = "";
    $('#modalFormSeguimientoContrato').modal('show');
}

// Variables globales para los gráficos
let charts = {};
const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
const colores = {
    primary: '#6f42c1',
    success: '#198754',
    warning: '#ffc107',
    danger: '#dc3545',
    info: '#0dcaf0',
    secondary: '#6c757d'
};

// 1. Gráfico Time Scale - Evolución temporal mejorado
function cargarGraficoTimeScale() {
    if(!document.querySelector('#chartTimeScale')) return;
    
    // Mostrar loading
    if (window.chartHelpers) {
        window.chartHelpers.showChartLoading('chartTimeScale');
    }
    
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosPorMes';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                const ctx = document.getElementById('chartTimeScale').getContext('2d');
                if(charts.timeScale) charts.timeScale.destroy();
                
                // Ocultar loading
                if (window.chartHelpers) {
                    window.chartHelpers.hideChartLoading('chartTimeScale');
                }
                
                let data = Object.values(objData.data);
                
                // Crear gradiente para el fondo
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, colores.primary + '40');
                gradient.addColorStop(1, colores.primary + '10');
                
                charts.timeScale = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Contratos por Mes',
                            data: data,
                            borderColor: colores.primary,
                            backgroundColor: gradient,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colores.primary,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    lineWidth: 1
                                },
                                title: {
                                    display: true,
                                    text: 'Evolución Temporal Continua',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    color: '#495057'
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 0
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    lineWidth: 1
                                },
                                title: {
                                    display: true,
                                    text: 'Cantidad de Contratos',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    color: '#495057'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 20,
                                    font: {
                                        size: 13,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: 'rgba(255, 255, 255, 0.1)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                displayColors: true,
                                padding: 12,
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    title: function(context) {
                                        return 'Mes: ' + context[0].label;
                                    },
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y + ' contratos';
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            }
        }
    }
}



// 3. Combo Chart - Contratos y valores por mes
function cargarGraficoCombo() {
    if(!document.querySelector('#chartComboMes')) return;
    
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosPorMes';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                const ctx = document.getElementById('chartComboMes').getContext('2d');
                if(charts.combo) charts.combo.destroy();
                
                let data = Object.values(objData.data);
                let lineData = data.map(val => val * 1.5); // Simulando valores
                
                charts.combo = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [{
                            type: 'bar',
                            label: 'Cantidad de Contratos',
                            data: data,
                            backgroundColor: colores.primary + '80',
                            borderColor: colores.primary,
                            borderWidth: 1,
                            yAxisID: 'y'
                        }, {
                            type: 'line',
                            label: 'Tendencia',
                            data: lineData,
                            borderColor: colores.success,
                            backgroundColor: colores.success + '20',
                            tension: 0.4,
                            yAxisID: 'y1'
                        }]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cantidad'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Tendencia'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        }
                    }
                });
            }
        }
    }
}

// 4. Stacked Bar Chart - Valores por estado agrupados
function cargarGraficoStacked() {
    if(!document.querySelector('#chartStackedBar')) return;
    
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosPorMes';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                const ctx = document.getElementById('chartStackedBar').getContext('2d');
                if(charts.stacked) charts.stacked.destroy();
                
                let data = Object.values(objData.data);
                let data1 = data.map(val => Math.floor(val * 0.4));
                let data2 = data.map(val => Math.floor(val * 0.3));
                let data3 = data.map(val => Math.floor(val * 0.3));
                
                charts.stacked = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'En Progreso',
                            data: data1,
                            backgroundColor: colores.warning + '80',
                            borderColor: colores.warning,
                            borderWidth: 1
                        }, {
                            label: 'Finalizado',
                            data: data2,
                            backgroundColor: colores.danger + '80',
                            borderColor: colores.danger,
                            borderWidth: 1
                        }, {
                            label: 'Liquidado',
                            data: data3,
                            backgroundColor: colores.info + '80',
                            borderColor: colores.info,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                stacked: true
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cantidad'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        }
                    }
                });
            }
        }
    }
}

// 5. Gráfico de área - Tendencia mensual
function cargarGraficoArea() {
    if(!document.querySelector('#chartAreaTendencia')) return;
    
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosPorMes';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                const ctx = document.getElementById('chartAreaTendencia').getContext('2d');
                if(charts.area) charts.area.destroy();
                
                let data = Object.values(objData.data);
                charts.area = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Tendencia',
                            data: data,
                            borderColor: colores.primary,
                            backgroundColor: colores.primary + '30',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    }
}

// 6. Doughnut - Distribución de valores
function cargarGraficoDoughnut() {
    if(!document.querySelector('#chartDoughnutValores')) return;
    
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosActivosInactivos';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                const ctx = document.getElementById('chartDoughnutValores').getContext('2d');
                if(charts.doughnut) charts.doughnut.destroy();
                
                charts.doughnut = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Bajo', 'Medio', 'Alto', 'Premium'],
                        datasets: [{
                            data: [25, 35, 30, 10],
                            backgroundColor: [
                                colores.success + '80',
                                colores.warning + '80',
                                colores.danger + '80',
                                colores.info + '80'
                            ],
                            borderColor: [
                                colores.success,
                                colores.warning,
                                colores.danger,
                                colores.info
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 10
                                }
                            }
                        }
                    }
                });
            }
        }
    }
}

// 7. Línea de progreso anual
function cargarGraficoProgreso() {
    if(!document.querySelector('#chartProgressLine')) return;
    
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosPorMes';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                const ctx = document.getElementById('chartProgressLine').getContext('2d');
                if(charts.progress) charts.progress.destroy();
                
                let data = Object.values(objData.data);
                let total = data.reduce((a, b) => a + b, 0);
                let progreso = [];
                let acumulado = 0;
                data.forEach(val => {
                    acumulado += val;
                    progreso.push(total > 0 ? (acumulado / total * 100).toFixed(1) : 0);
                });
                
                charts.progress = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Progreso Acumulado',
                            data: progreso,
                            borderColor: colores.success,
                            backgroundColor: colores.success + '20',
                            tension: 0.3,
                            pointBackgroundColor: colores.success,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    }
}



// Función principal para cargar todos los gráficos
function cargarTodosLosGraficos() {
    cargarGraficoTimeScale();
    cargarGraficoCombo();
    cargarGraficoStacked();
    cargarGraficoArea();
    cargarGraficoDoughnut();
    cargarGraficoProgreso();
}

// Event listener para cargar gráficos al mostrar el tab
document.getElementById('tab-graficos').addEventListener('shown.bs.tab', function (e) {
    setTimeout(cargarTodosLosGraficos, 100);
}); 