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
            { "data": "plazo" },
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
                    try {
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
                    } catch (error) {
                        console.error('Error al procesar formulario:', error);
                        console.error('Respuesta del servidor:', request.responseText);
                        Swal.fire("Error", "Error al procesar la solicitud", "error");
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
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    let estado = objData.data.estado == 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                    document.querySelector("#celObjetoContrato").innerHTML = objData.data.objeto_contrato;
                    document.querySelector("#celFechaInicio").innerHTML = objData.data.fecha_inicio;
                    document.querySelector("#celFechaTerminacion").innerHTML = objData.data.fecha_terminacion;
                    
                    // Mostrar el plazo con su tipo
                    let tipoPlazo = objData.data.tipo_plazo == 'dias' ? 'días' : 'meses';
                    document.querySelector("#celPlazo").innerHTML = objData.data.plazo + ' ' + tipoPlazo;
                    
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
            } catch (error) {
                console.error('Error al cargar datos del contrato:', error);
                console.error('Respuesta del servidor:', request.responseText);
                Swal.fire("Error", "Error al cargar los datos del contrato", "error");
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
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector("#id").value = objData.data.id;
                    document.querySelector("#objeto_contrato").value = objData.data.objeto_contrato;
                    document.querySelector("#fecha_inicio").value = objData.data.fecha_inicio;
                    document.querySelector("#fecha_terminacion").value = objData.data.fecha_terminacion;
                    document.querySelector("#plazo").value = objData.data.plazo;
                    document.querySelector("#tipo_plazo").value = objData.data.tipo_plazo;
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
                            if (estadoValue.includes('En progreso')) {
                                estadoValue = '1';
                            } else if (estadoValue.includes('Finalizado')) {
                                estadoValue = '2';
                            } else if (estadoValue.includes('Liquidado')) {
                                estadoValue = '3';
                            } else {
                                estadoValue = '1'; // Por defecto
                            }
                        }
                        document.querySelector("#estado").value = estadoValue;
                    }
                }
            } catch (error) {
                console.error('Error al cargar datos para editar:', error);
                console.error('Respuesta del servidor:', request.responseText);
                Swal.fire("Error", "Error al cargar los datos para editar", "error");
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
                    try {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            Swal.fire("Eliminar!", objData.msg, "success");
                            tableSeguimientoContrato.api().ajax.reload();
                        } else {
                            Swal.fire("Atención!", objData.msg, "error");
                        }
                    } catch (error) {
                        console.error('Error al eliminar contrato:', error);
                        console.error('Respuesta del servidor:', request.responseText);
                        Swal.fire("Error", "Error al eliminar el contrato", "error");
                    }
                }
            }
        }
    });
}

function openModal() {
    document.querySelector('#id').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-warning");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Contrato";
    document.querySelector("#formSeguimientoContrato").reset();
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

// Función para cargar métricas de las tarjetas
function cargarMetricas() {
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/SeguimientoContrato/getEstadisticasAvanzadas';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            console.log(request.responseText);
            
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    // Actualizar tarjetas de métricas
                    document.getElementById('totalContratos').textContent = objData.data.total || 0;
                    document.getElementById('enProgreso').textContent = objData.data.enProgreso || 0;
                    document.getElementById('finalizados').textContent = objData.data.finalizados || 0;
                    document.getElementById('liquidados').textContent = objData.data.liquidados || 0;
                    
                    // Actualizar métricas de resumen
                    document.getElementById('valorTotal').textContent = formatCurrency(objData.data.valorTotal || 0);
                    document.getElementById('valorPromedio').textContent = formatCurrency(objData.data.valorPromedio || 0);
                    document.getElementById('contratosActivos').textContent = objData.data.contratosActivos || 0;
                    document.getElementById('plazoPromedio').textContent = (objData.data.plazoPromedio || 0).toFixed(1);
                    
                    // Animar contadores
                    animateCounter('totalContratos', objData.data.total || 0);
                    animateCounter('enProgreso', objData.data.enProgreso || 0);
                    animateCounter('finalizados', objData.data.finalizados || 0);
                    animateCounter('liquidados', objData.data.liquidados || 0);
                }
            } catch (error) {
                console.error('Error al parsear JSON:', error);
                console.error('Respuesta del servidor:', request.responseText);
                // Establecer valores por defecto en caso de error
                document.getElementById('totalContratos').textContent = '0';
                document.getElementById('enProgreso').textContent = '0';
                document.getElementById('finalizados').textContent = '0';
                document.getElementById('liquidados').textContent = '0';
                document.getElementById('valorTotal').textContent = formatCurrency(0);
                document.getElementById('valorPromedio').textContent = formatCurrency(0);
                document.getElementById('contratosActivos').textContent = '0';
                document.getElementById('plazoPromedio').textContent = '0.0';
            }
        }
    }
}

// Función para formatear moneda
function formatCurrency(value) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
}

// Función para animar contadores
function animateCounter(elementId, finalValue, duration = 2000) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const startValue = 0;
    const increment = finalValue / (duration / 16);
    let currentValue = startValue;
    
    const timer = setInterval(() => {
        currentValue += increment;
        if (currentValue >= finalValue) {
            currentValue = finalValue;
            clearInterval(timer);
        }
        element.textContent = Math.floor(currentValue);
    }, 16);
}

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
            try {
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
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
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
                                    enabled: false
                                }
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error al cargar gráfico TimeScale:', error);
                console.error('Respuesta del servidor:', request.responseText);
                // Ocultar loading en caso de error
                if (window.chartHelpers) {
                    window.chartHelpers.hideChartLoading('chartTimeScale');
                }
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
            try {
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
                                yAxisID: 'y1',
                                pointRadius: 3,
                                pointBorderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
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
                                },
                                tooltip: {
                                    enabled: false
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error al cargar gráfico Combo:', error);
                console.error('Respuesta del servidor:', request.responseText);
            }
        }
    }
}

// 4. Stacked Bar Chart - Valores por estado agrupados
function cargarGraficoStacked() {
    if(!document.querySelector('#chartStackedBar')) return;
    
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosActivosInactivos';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                const ctx = document.getElementById('chartStackedBar').getContext('2d');
                if(charts.stacked) charts.stacked.destroy();
                
                // Usar datos reales del estado
                let enProgreso = objData.data.en_progreso || 0;
                let finalizado = objData.data.finalizado || 0;
                let liquidado = objData.data.liquidado || 0;
                
                charts.stacked = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Contratos por Estado'],
                        datasets: [{
                            label: 'En Progreso',
                            data: [enProgreso],
                            backgroundColor: colores.warning + '80',
                            borderColor: colores.warning,
                            borderWidth: 1
                        }, {
                            label: 'Finalizado',
                            data: [finalizado],
                            backgroundColor: colores.danger + '80',
                            borderColor: colores.danger,
                            borderWidth: 1
                        }, {
                            label: 'Liquidado',
                            data: [liquidado],
                            backgroundColor: colores.info + '80',
                            borderColor: colores.info,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            x: {
                                stacked: true
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cantidad de Contratos'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                enabled: false
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
                            tension: 0.4,
                            pointRadius: 3,
                            pointBorderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
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
                
                // Usar datos reales
                let enProgreso = objData.data.en_progreso || 0;
                let finalizado = objData.data.finalizado || 0;
                let liquidado = objData.data.liquidado || 0;
                
                charts.doughnut = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['En Progreso', 'Finalizados', 'Liquidados'],
                        datasets: [{
                            data: [enProgreso, finalizado, liquidado],
                            backgroundColor: [
                                colores.warning + '80',
                                colores.danger + '80',
                                colores.info + '80'
                            ],
                            borderColor: [
                                colores.warning,
                                colores.danger,
                                colores.info
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 10
                                }
                            },
                            tooltip: {
                                enabled: false
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
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    const ctx = document.getElementById('chartProgressLine').getContext('2d');
                    if(charts.progress) charts.progress.destroy();
                    
                    let data = Object.values(objData.data);

                    charts.progress = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: meses,
                            datasets: [{
                                label: 'Contratos por Mes',
                                data: data,
                                backgroundColor: colores.primary + '90',
                                borderColor: colores.primary,
                                borderRadius: 6, // Bordes redondeados
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    enabled: true,
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Cantidad de Contratos'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)', // Líneas horizontales muy tenues
                                    },
                                    ticks: {
                                        precision: 0 // Asegurar que solo haya números enteros
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false, // Sin líneas verticales
                                    },
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error al cargar gráfico de progreso:', error);
                console.error('Respuesta del servidor:', request.responseText);
            }
        }
    }
}

// Función para exportar gráfico como imagen
function exportChartAsImage(chartInstance, filename = 'grafica') {
    if (!chartInstance) {
        Swal.fire("Error", "Gráfico no disponible", "error");
        return;
    }
    
    try {
        const canvas = chartInstance.canvas;
        const link = document.createElement('a');
        link.download = filename + '.png';
        link.href = canvas.toDataURL('image/png', 1.0);
        link.click();
        
        // Mostrar notificación de éxito
        Swal.fire({
            title: "¡Éxito!",
            text: "Gráfico exportado correctamente",
            icon: "success",
            timer: 2000,
            showConfirmButton: false
        });
    } catch (error) {
        console.error('Error al exportar gráfico:', error);
        Swal.fire("Error", "No se pudo exportar el gráfico", "error");
    }
}

// Función para imprimir gráfico
function printChart(chartInstance) {
    if (!chartInstance) {
        Swal.fire("Error", "Gráfico no disponible", "error");
        return;
    }
    
    try {
        const canvas = chartInstance.canvas;
        const dataURL = canvas.toDataURL('image/png', 1.0);
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Imprimir Gráfico</title>
                    <style>
                        body { 
                            margin: 0; 
                            padding: 20px; 
                            text-align: center; 
                            font-family: Arial, sans-serif;
                        }
                        img { 
                            max-width: 100%; 
                            height: auto; 
                            border: 1px solid #ddd;
                            border-radius: 8px;
                        }
                        .header {
                            margin-bottom: 20px;
                            color: #333;
                        }
                        @media print {
                            body { padding: 0; }
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h2>Gráfico de Seguimiento de Contratos</h2>
                        <p>Fecha de impresión: ${new Date().toLocaleDateString('es-CO')}</p>
                    </div>
                    <img src="${dataURL}" alt="Gráfico">
                    <div class="no-print" style="margin-top: 20px;">
                        <button onclick="window.print()">Imprimir</button>
                        <button onclick="window.close()">Cerrar</button>
                    </div>
                    <script>
                        window.onload = function() { 
                            // Auto-print after a short delay
                            setTimeout(function() {
                                window.print();
                            }, 500);
                        }
                    </script>
                </body>
            </html>
        `);
        printWindow.document.close();
    } catch (error) {
        console.error('Error al imprimir gráfico:', error);
        Swal.fire("Error", "No se pudo imprimir el gráfico", "error");
    }
}

// Función para exportar todas las gráficas
function exportAllCharts() {
    const chartNames = {
        'timeScale': 'evolucion-temporal',
        'doughnut': 'distribucion-estado',
        'combo': 'contratos-mes-combo',
        'stacked': 'valores-estado-stacked',
        'area': 'tendencia-mensual',
        'progress': 'progreso-anual'
    };
    
    let exportedCount = 0;
    const totalCharts = Object.keys(chartNames).length;
    
    Swal.fire({
        title: "Exportando gráficos...",
        text: "Preparando archivos para descarga",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Crear un ZIP con todas las imágenes
    const JSZip = window.JSZip;
    if (JSZip) {
        const zip = new JSZip();
        
        Object.keys(chartNames).forEach((chartKey, index) => {
            const chart = charts[chartKey];
            if (chart && chart.canvas) {
                try {
                    const canvas = chart.canvas;
                    const dataURL = canvas.toDataURL('image/png', 1.0);
                    const base64Data = dataURL.split(',')[1];
                    
                    zip.file(`${chartNames[chartKey]}.png`, base64Data, {base64: true});
                    exportedCount++;
                } catch (error) {
                    console.error(`Error al exportar ${chartKey}:`, error);
                }
            }
        });
        
        // Generar y descargar el ZIP
        zip.generateAsync({type: "blob"}).then(function(content) {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(content);
            link.download = `graficos-seguimiento-contratos-${new Date().toISOString().split('T')[0]}.zip`;
            link.click();
            
            Swal.fire({
                title: "¡Éxito!",
                text: `${exportedCount} gráficos exportados correctamente`,
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        });
    } else {
        // Fallback: exportar una por una
        Object.keys(chartNames).forEach((chartKey, index) => {
            const chart = charts[chartKey];
            if (chart) {
                setTimeout(() => {
                    exportChartAsImage(chart, chartNames[chartKey]);
                }, index * 500);
            }
        });
        
        Swal.fire({
            title: "Exportación iniciada",
            text: "Los gráficos se descargarán uno por uno",
            icon: "info",
            timer: 2000,
            showConfirmButton: false
        });
    }
}

// Función principal para cargar todos los gráficos
function cargarTodosLosGraficos() {
    cargarMetricas();
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