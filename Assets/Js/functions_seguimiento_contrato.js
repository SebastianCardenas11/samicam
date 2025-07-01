let tableSeguimientoContrato;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){
    // Cargar dependencias al iniciar
    cargarDependencias();
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
            { "data": "dependencia_nombre" },
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
                "className": "btn btn-success mt-3",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                    "format": {
                        "body": function(data, row, column, node) {
                            // Para la columna 3 (objeto_contrato), obtener el texto original
                            if (column === 3) {
                                var api = $('#tableSeguimientoContrato').DataTable();
                                var rowData = api.row(row).data();
                                return rowData.objeto_contrato;
                            }
                            return data;
                        }
                    }
                }
            }
        ],
        "responsive": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });

    // Lógica para la pestaña de Vencimientos
    const selectVencimiento = document.querySelector('#selectVencimiento');
    if(selectVencimiento) {
        // Cargar datos cuando la pestaña se muestra por primera vez
        document.querySelector('#tab-vencimientos').addEventListener('shown.bs.tab', function () {
            cargarDatosVencimientos();
        });

        // Recargar datos cuando cambia la selección
        selectVencimiento.addEventListener('change', cargarDatosVencimientos);
    }

    const tabResumen = document.querySelector('#tab-resumen');
    if(tabResumen){
        tabResumen.addEventListener('shown.bs.tab', function(){
            // Esta función es para las tarjetas de conteo (Total, En progreso, etc.)
            cargarMetricas();
        });
    }

    const tabValor = document.querySelector('#tab-valor');
    if(tabValor){
        tabValor.addEventListener('shown.bs.tab', function(){
            // Esta función es para las tarjetas de análisis de valor y el gráfico.
            cargarDatosAnalisisValor();
        });
    }

    const tabLiquidacion = document.querySelector('#tab-liquidacion');
    if(tabLiquidacion){
        tabLiquidacion.addEventListener('shown.bs.tab', function(){
            cargarDatosLiquidacion();
        });
    }

    const tabLiquidacionesDetalle = document.getElementById('liquidaciones-tab-btn');
    if(tabLiquidacionesDetalle) {
        
        tabLiquidacionesDetalle.addEventListener('click', function() {
            setTimeout(function() {
                cargarDatosLiquidaciones();
            }, 100);
        });
        
        // También mantener el evento original por si acaso
        tabLiquidacionesDetalle.addEventListener('shown.bs.tab', function() {
            cargarDatosLiquidaciones();
        });
    }

    // Cargar historial general de prórrogas al mostrar el tab
    const tabHistorialProrrogas = document.getElementById('tab-historial-prorrogas');
    if(tabHistorialProrrogas){
        tabHistorialProrrogas.addEventListener('shown.bs.tab', function(){
            cargarHistorialProrrogasGeneral();
        });
    }

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
                        // Limpiar respuesta para extraer solo JSON
                        let responseText = request.responseText;
                        let jsonStart = responseText.indexOf('{');
                        if (jsonStart > 0) {
                            responseText = responseText.substring(jsonStart);
                        }
                        
                        let objData = JSON.parse(responseText);
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

    if (document.querySelector("#formProrrogaContrato")) {
        let formProrrogaContrato = document.querySelector("#formProrrogaContrato");
        formProrrogaContrato.onsubmit = function(e) {
            e.preventDefault();
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/SeguimientoContrato/setProrrogaContrato';
            let formData = new FormData(formProrrogaContrato);
            // Calcular días y agregarlo al formData
            let fechaAnterior = document.querySelector('#prorroga_fecha_anterior').value;
            let nuevaFecha = document.querySelector('#prorroga_nueva_fecha').value;
            let dias = calcularDiferenciaDias(fechaAnterior, nuevaFecha);
            formData.append('dias_prorroga', dias);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    try {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            $('#modalProrrogaContrato').modal("hide");
                            formProrrogaContrato.reset();
                            Swal.fire("Prórroga", objData.msg, "success");
                            tableSeguimientoContrato.api().ajax.reload();
                        } else {
                            Swal.fire("Error", objData.msg, "error");
                        }
                    } catch (error) {
                        console.error('Error al procesar prórroga:', error);
                        console.error('Respuesta del servidor:', request.responseText);
                        Swal.fire("Error", "Error al procesar la solicitud", "error");
                    }
                }
            }
        }
    }

    // --- SUBMIT ADICIÓN ---
    if (document.querySelector("#formAdicionContrato")) {
        let formAdicionContrato = document.querySelector("#formAdicionContrato");
        formAdicionContrato.onsubmit = function(e) {
            e.preventDefault();
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/SeguimientoContrato/setAdicionContrato';
            let formData = new FormData(formAdicionContrato);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    try {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            $('#modalAdicionContrato').modal("hide");
                            formAdicionContrato.reset();
                            Swal.fire("Adición", objData.msg, "success");
                            tableSeguimientoContrato.api().ajax.reload();
                        } else {
                            Swal.fire("Error", objData.msg, "error");
                        }
                    } catch (error) {
                        Swal.fire("Error", "Error al procesar la solicitud", "error");
                    }
                }
            }
        }
    }

    if (tableSeguimientoContrato) {
        tableSeguimientoContrato.on('draw', function() {
            $('#tableSeguimientoContrato tbody tr').each(function() {
                const $row = $(this);
                const estadoHtml = $row.find('td:eq(13)').html();
                if (estadoHtml && estadoHtml.includes('Liquidado')) {
                    // Oculta todos los botones excepto el de ver
                    $row.find('button, a').not('[title="Ver Contrato"]').hide();
                }
            });
        });
    }
    // También ocultar los botones del modal de más opciones si el contrato está liquidado
    $('#modalMoreOptions').on('show.bs.modal', function () {
        var id = $('#moreOptionsContratoId').val();
        // Buscar la fila correspondiente en la tabla
        var $row = $('#tableSeguimientoContrato tbody tr').filter(function() {
            return $(this).find('button[onClick*="fntViewContrato(' + id + '"]').length > 0;
        });
        if ($row.length) {
            var estadoHtml = $row.find('td:eq(13)').html();
            if (estadoHtml && estadoHtml.includes('Liquidado')) {
                // Oculta todos los botones del modal
                $('#modalMoreOptions .modal-body button').hide();
            } else {
                $('#modalMoreOptions .modal-body button').show();
            }
        }
    });
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
                    let estadoHtml = '';
                    switch (parseInt(objData.data.estado)) {
                        case 1:
                            estadoHtml = '<span class="badge text-bg-warning">En ejecucion</span>';
                            break;
                        case 2:
                            estadoHtml = '<span class="badge text-bg-danger">Finalizado</span>';
                            break;
                        case 3:
                            estadoHtml = '<span class="badge text-bg-info">Liquidado</span>';
                            break;
                        default:
                            estadoHtml = '<span class="badge text-bg-secondary">Desconocido</span>';
                            break;
                    }

                    document.querySelector("#celObjetoContrato").innerHTML = objData.data.objeto_contrato;
                    document.querySelector("#celFechaInicio").innerHTML = objData.data.fecha_inicio;
                    document.querySelector("#celFechaTerminacion").innerHTML = objData.data.fecha_terminacion;
                    
                    let tipoPlazo = objData.data.tipo_plazo == 'dias' ? 'días' : 'meses';
                    document.querySelector("#celPlazo").innerHTML = objData.data.plazo + ' ' + tipoPlazo;
                    
                    document.querySelector("#celValorTotalContrato").innerHTML = formatCurrency(objData.data.valor_total_contrato);
                    document.querySelector("#celDiaCorteInforme").innerHTML = objData.data.dia_corte_informe;
                    document.querySelector("#celObservacionesEjecucion").innerHTML = objData.data.observaciones_ejecucion;
                    document.querySelector("#celEvidenciadoSecop").innerHTML = objData.data.evidenciado_secop;
                    document.querySelector("#celFechaVerificacion").innerHTML = objData.data.fecha_verificacion;
                    document.querySelector("#celLiquidacion").innerHTML = formatCurrency(objData.data.liquidacion);
                    document.querySelector("#celEstado").innerHTML = estadoHtml;
                    document.querySelector("#celNumeroContrato").innerHTML = objData.data.numero_contrato;
                    document.querySelector("#celDependencia").innerHTML = objData.data.dependencia_nombre || 'N/A';
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
                    document.querySelector("#dependencia_id").value = objData.data.dependencia_id || '';
                    document.querySelector("#fecha_aprobacion_entidad").value = objData.data.fecha_aprobacion_entidad;
                    if(document.querySelector("#estado")){
                        let estadoValue = objData.data.estado;
                        if (typeof estadoValue === 'string') {
                            if (estadoValue.includes('En ejecucion')) {
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
    cargarDependencias();
    $('#modalFormSeguimientoContrato').modal('show');
}

function cargarDependencias() {
    let request = new XMLHttpRequest();
    request.open('GET', base_url + '/SeguimientoContrato/getDependencias', true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let dependencias = JSON.parse(request.responseText);
            let select = document.querySelector('#dependencia_id');
            select.innerHTML = '<option value="">Seleccionar dependencia</option>';
            dependencias.forEach(function(dep) {
                select.innerHTML += `<option value="${dep.id}">${dep.dependencia}</option>`;
            });
        }
    };
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
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getEstadisticasAvanzadas';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    let data = objData; // The structure is now different
                    let totalContratos = (data.total && data.total[0]) ? parseInt(data.total[0].total) : 0;
                    let enProgreso = 0;
                    let finalizados = 0;
                    let liquidados = 0;

                    if(data.estado){
                        data.estado.forEach(item => {
                            if(item.estado == 1) enProgreso = parseInt(item.cantidad);
                            if(item.estado == 2) finalizados = parseInt(item.cantidad);
                            if(item.estado == 3) liquidados = parseInt(item.cantidad);
                        });
                    }

                    animateCounter('totalContratos', totalContratos);
                    animateCounter('enProgreso', enProgreso);
                    animateCounter('finalizados', finalizados);
                    animateCounter('liquidados', liquidados);

                } else {
                    console.error('No se pudieron cargar las métricas.');
                }
            } catch (error) {
                console.error("Error al procesar métricas:", error);
                console.error("Respuesta del servidor:", request.responseText);
            }
        }
    }
}

// Función para formatear moneda
function formatCurrency(value) {
    if (typeof value !== 'number') {
        return '0';
    }
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
}

// Función para animar contadores
function animateCounter(elementId, finalValue, duration = 100) {
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
                            label: 'En Ejecucion',
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
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosPorTipoPlazo';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    const ctx = document.getElementById('chartDoughnutValores').getContext('2d');
                    if(charts.doughnut) charts.doughnut.destroy();
                    
                    let dias = objData.data.dias || 0;
                    let meses = objData.data.meses || 0;
                    
                    charts.doughnut = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Días', 'Meses'],
                            datasets: [{
                                data: [dias, meses],
                                backgroundColor: [
                                    colores.info + '80',
                                    colores.success + '80',
                                ],
                                borderColor: [
                                    colores.info,
                                    colores.success,
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
                                        padding: 20
                                    }
                                },
                                tooltip: {
                                    enabled: true,
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error al cargar gráfico de tipo de plazo:', error);
                console.error('Respuesta del servidor:', request.responseText);
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

function cargarDatosVencimientos() {
    let dias = document.querySelector('#selectVencimiento').value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getContratosPorVencer?dias=' + dias;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    let tableBody = document.querySelector("#tableVencimientos tbody");
                    tableBody.innerHTML = ""; // Limpiar tabla
                    if(objData.data.length > 0){
                        objData.data.forEach(function(contrato) {
                            let dias_restantes = parseInt(contrato.dias_restantes);
                            let badgeClass = 'bg-info';
                            let textoBadge = `Vence en ${dias_restantes} días`;

                            if (dias_restantes < 0) {
                                badgeClass = 'bg-danger';
                                textoBadge = `Vencido hace ${Math.abs(dias_restantes)} días`;
                            } else if (dias_restantes == 0) {
                                badgeClass = 'bg-warning text-dark';
                                textoBadge = 'Vence Hoy';
                            } else if (dias_restantes == 1) {
                                textoBadge = 'Vence Mañana';
                            }

                            let row = `<tr>
                                <td>${contrato.numero_contrato}</td>
                                <td>${contrato.objeto_contrato}</td>
                                <td>${contrato.fecha_terminacion}</td>
                                <td><span class="badge ${badgeClass}">${textoBadge}</span></td>
                            </tr>`;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML = `<tr><td colspan="4" class="text-center">No hay contratos por vencer o recién vencidos en el período seleccionado.</td></tr>`;
                    }
                } else {
                    console.error("Error al obtener los datos de vencimientos.");
                }
            } catch (error) {
                console.error('Error al procesar datos de vencimientos:', error);
                console.error('Respuesta del servidor:', request.responseText);
            }
        }
    }
}

function cargarDatosAnalisisValor(){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getEstadisticasAvanzadas';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    // Verificar que 'total' y sus datos existan
                    const valorTotal = (objData.total && objData.total[0]) ? parseFloat(objData.total[0].valor_total) : 0;
                    const valorPromedio = (objData.total && objData.total[0]) ? parseFloat(objData.total[0].promedio) : 0;
                    const plazoPromedio = (objData.total && objData.total[0]) ? parseFloat(objData.total[0].plazo_promedio) : 0;
                    let contratosActivos = 0;

                    if(objData.estado){
                        objData.estado.forEach(item => {
                            if(item.estado == 1) contratosActivos = parseInt(item.cantidad);
                        });
                    }
                    
                    document.querySelector('#valorTotalContratado').textContent = `$ ${valorTotal.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    document.querySelector('#valorPromedioContrato').textContent = `$ ${valorPromedio.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    document.querySelector('#contratosActivos').textContent = contratosActivos;
                    document.querySelector('#plazoPromedio').textContent = Math.round(plazoPromedio);

                    // Preparar datos para el gráfico
                    let labels = ['En Ejecucion', 'Finalizado', 'Liquidado'];
                    let dataValues = [0, 0, 0];

                    objData.estado.forEach(item => {
                        if(item.estado == 1) dataValues[0] = parseFloat(item.valor_total);
                        if(item.estado == 2) dataValues[1] = parseFloat(item.valor_total);
                        if(item.estado == 3) dataValues[2] = parseFloat(item.valor_total);
                    });
                    
                    // Renderizar gráfico
                    renderizarGraficoValorEstado(labels, dataValues);
                }
            } catch (error) {
                console.error('Error al procesar análisis de valor:', error);
                console.error('Respuesta del servidor:', request.responseText);
            }
        }
    }
}

function renderizarGraficoValorEstado(labels, dataValues){
    const ctx = document.getElementById('chartValorPorEstado').getContext('2d');
    
    if(charts.valorPorEstado) {
        charts.valorPorEstado.destroy();
    }

    charts.valorPorEstado = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Valor Total por Estado',
                data: dataValues,
                backgroundColor: [
                    'rgba(255, 193, 7, 0.5)',  // Warning
                    'rgba(220, 53, 69, 0.5)', // Danger
                    'rgba(13, 202, 240, 0.5)'  // Info
                ],
                borderColor: [
                    'rgba(255, 193, 7, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(13, 202, 240, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return '$ ' + value.toLocaleString('es-PE');
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += '$ ' + context.parsed.y.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
}

function cargarDatosLiquidacion(){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getEstadisticasAvanzadas';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    let valorLiquidado = 0;
                    let valorPendiente = 0;

                    objData.estado.forEach(item => {
                        if(item.estado == 3) { // Liquidado
                            valorLiquidado = parseFloat(item.valor_total);
                        }
                        if(item.estado == 2) { // Finalizado pero no liquidado
                            valorPendiente = parseFloat(item.valor_total);
                        }
                    });

                    document.querySelector('#valorTotalLiquidado').textContent = `$ ${valorLiquidado.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    document.querySelector('#valorPendienteLiquidacion').textContent = `$ ${valorPendiente.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    
                    // Obtener contratos pendientes de liquidación
                    let sqlPendientes = "SELECT numero_contrato, objeto_contrato, fecha_terminacion, valor_total_contrato FROM seguimiento_contrato WHERE estado = 2 ORDER BY fecha_terminacion DESC";
                    let contratosPendientes = [];
                    
                    // Hacer una llamada adicional para obtener contratos pendientes
                    let requestPendientes = new XMLHttpRequest();
                    requestPendientes.open("GET", base_url + '/SeguimientoContrato/getContratosPendientesLiquidacion', true);
                    requestPendientes.send();
                    requestPendientes.onreadystatechange = function(){
                        if(requestPendientes.readyState == 4 && requestPendientes.status == 200){
                            try {
                                let dataPendientes = JSON.parse(requestPendientes.responseText);
                                if(dataPendientes.status && dataPendientes.data){
                                    let tablaBody = document.querySelector('#tablePendientesLiquidacion tbody');
                                    tablaBody.innerHTML = '';
                                    
                                    dataPendientes.data.forEach(contrato => {
                                        let row = document.createElement('tr');
                                        row.innerHTML = `
                                            <td>${contrato.numero_contrato}</td>
                                            <td>${contrato.objeto_contrato}</td>
                                            <td>${contrato.fecha_terminacion}</td>
                                            <td>$ ${parseFloat(contrato.valor_total_contrato).toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                        `;
                                        tablaBody.appendChild(row);
                                    });
                                }
                            } catch (error) {
                                console.error('Error al procesar contratos pendientes:', error);
                            }
                        }
                    };
                }
            } catch (error) {
                console.error('Error al procesar datos de liquidación:', error);
                console.error('Respuesta del servidor:', request.responseText);
            }
        }
    };
}

function cargarDatosLiquidaciones() {
    let request = new XMLHttpRequest();
    let url = base_url + '/SeguimientoContrato/getLiquidacionesCompletas';
    
    request.open('GET', url, true);
    request.send();
    
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            try {
                let response = JSON.parse(request.responseText);
                if (response.status) {
                    // Actualizar métricas
                    document.getElementById('total-liquidado').textContent = '$' + parseFloat(response.total_liquidado || 0).toLocaleString('es-CO');
                    document.getElementById('pendiente-liquidacion').textContent = '$' + parseFloat(response.pendiente_liquidacion || 0).toLocaleString('es-CO');
                    document.getElementById('promedio-liquidacion').textContent = '$' + parseFloat(response.promedio_liquidacion || 0).toLocaleString('es-CO');
                    document.getElementById('tiempo-promedio').textContent = (response.tiempo_promedio || 0) + ' días';
                    
                    // Llenar tabla
                    let tbody = document.querySelector('#tabla-liquidaciones tbody');
                    tbody.innerHTML = '';
                    
                    if (response.liquidaciones && response.liquidaciones.length > 0) {
                        response.liquidaciones.forEach(item => {
                            let row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.numero_contrato || '-'}</td>
                                <td>$${parseFloat(item.valor || 0).toLocaleString('es-CO')}</td>
                                <td>$${parseFloat(item.liquidacion || 0).toLocaleString('es-CO')}</td>
                                <td>${item.fecha_inicio || 'N/A'}</td>
                                <td>${item.fecha_terminacion || 'Pendiente'}</td>
                                <td>${item.dias !== null && item.dias >= 0 ? item.dias : '-'}</td>
                                <td><span class="badge ${item.estado_texto === 'Liquidado' ? 'bg-success' : item.estado_texto === 'Finalizado' ? 'bg-warning' : 'bg-info'}">${item.estado_texto}</span></td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No hay datos de liquidaciones disponibles</td></tr>';
                    }
                    
                    // Crear gráficos si existen los elementos
                    if (response.grafico_evolucion && document.getElementById('chartLiquidacionesArea')) {
                        crearGraficoLiquidacionesArea(response.grafico_evolucion);
                    }
                    if (response.grafico_distribucion && document.getElementById('chartLiquidacionesBar')) {
                        crearGraficoLiquidacionesBar(response.grafico_distribucion);
                    }
                } else {
                    console.error('Error en la respuesta del servidor:', response.msg || 'Error desconocido');
                }
            } catch (error) {
                console.error('Error al procesar liquidaciones:', error);
                // Mostrar mensaje de error en la tabla
                let tbody = document.querySelector('#tabla-liquidaciones tbody');
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error al cargar los datos</td></tr>';
            }
        }
    };
}

// Función para crear gráfico de área de evolución
function crearGraficoLiquidacionesArea(datos) {
    if (!document.getElementById('chartLiquidacionesArea')) return;
    
    if (charts.liquidacionesArea) {
        charts.liquidacionesArea.destroy();
    }
    
    let ctx = document.getElementById('chartLiquidacionesArea').getContext('2d');
    
    // Preparar datos para el gráfico
    let labels = [];
    let valores = [];
    
    datos.forEach(item => {
        labels.push(item.mes);
        valores.push(parseFloat(item.valor_total));
    });
    
    charts.liquidacionesArea = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Valor Liquidado',
                data: valores,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString('es-CO');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.raw.toLocaleString('es-CO');
                        }
                    }
                }
            }
        }
    });
}

// Función para crear gráfico de barras de distribución
function crearGraficoLiquidacionesBar(datos) {
    if (!document.getElementById('chartLiquidacionesBar')) return;
    
    if (charts.liquidacionesBar) {
        charts.liquidacionesBar.destroy();
    }
    
    let ctx = document.getElementById('chartLiquidacionesBar').getContext('2d');
    charts.liquidacionesBar = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: datos.meses,
            datasets: [{
                label: 'Liquidaciones por Mes',
                data: datos.cantidades,
                backgroundColor: 'rgba(54, 185, 204, 0.5)',
                borderColor: 'rgba(54, 185, 204, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

function fntProrrogaContrato(id, fecha_terminacion) {
    document.querySelector('#prorroga_id_contrato').value = id;
    document.querySelector('#prorroga_fecha_anterior').value = fecha_terminacion;
    document.querySelector('#prorroga_nueva_fecha').value = '';
    document.querySelector('#prorroga_motivo').value = '';
    document.querySelector('#prorroga_dias_diferencia').textContent = '';
    $('#modalProrrogaContrato').modal('show');
    // Evento para calcular diferencia de días y validar
    const inputNuevaFecha = document.querySelector('#prorroga_nueva_fecha');
    const btnGuardar = document.querySelector('#formProrrogaContrato button[type="submit"]');
    inputNuevaFecha.oninput = function() {
        let fechaAnterior = document.querySelector('#prorroga_fecha_anterior').value;
        let nuevaFecha = this.value;
        let dias = calcularDiferenciaDias(fechaAnterior, nuevaFecha);
        if (nuevaFecha && fechaAnterior && !isNaN(dias)) {
            if (dias <= 0) {
                document.querySelector('#prorroga_dias_diferencia').innerHTML = '<span class="text-danger">La nueva fecha debe ser mayor a la actual de terminación.</span>';
                btnGuardar.disabled = true;
            } else {
                document.querySelector('#prorroga_dias_diferencia').textContent = `Diferencia: ${dias} día(s)`;
                btnGuardar.disabled = false;
            }
        } else {
            document.querySelector('#prorroga_dias_diferencia').textContent = '';
            btnGuardar.disabled = false;
        }
    };
}

function calcularDiferenciaDias(fecha1, fecha2) {
    let f1 = new Date(fecha1);
    let f2 = new Date(fecha2);
    let diff = Math.round((f2 - f1) / (1000 * 60 * 60 * 24));
    return diff;
}

function fntHistorialProrrogas(id) {
    let tbody = document.querySelector('#tablaHistorialProrrogasIndividual tbody');
    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-secondary">Cargando...</td></tr>';
    $('#modalHistorialProrrogas').modal('show');
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getProrrogasContrato/' + id;
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status && objData.data.length > 0) {
                    let html = '';
                    objData.data.forEach(function(item) {
                        let fechaAnterior = formatearFecha(item.fecha_anterior);
                        let nuevaFecha = formatearFecha(item.nueva_fecha);
                        let fechaRegistro = formatearFechaHora(item.fecha_registro);
                        let motivo = item.motivo;
                        let motivoHtml = motivo.length > 30 ? `<span title="${motivo.replace(/\"/g, '&quot;')}">${motivo.substring(0, 30)}...</span>` : motivo;
                        html += `<tr>
                            <td>${fechaAnterior}</td>
                            <td>${nuevaFecha}</td>
                            <td>${item.dias_prorroga}</td>
                            <td>${motivoHtml}</td>
                            <td>${fechaRegistro}</td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Sin prórrogas registradas</td></tr>';
                }
            } catch (error) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error al cargar historial</td></tr>';
            }
        }
    }
}

function cargarHistorialProrrogasGeneral() {
    let tbody = document.querySelector('#tablaHistorialProrrogasGeneral tbody');
    tbody.innerHTML = '<tr><td colspan="8" class="text-center text-secondary">Cargando...</td></tr>';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getAllProrrogas';
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status && objData.data.length > 0) {
                    let html = '';
                    objData.data.forEach(function(item) {
                        let fechaAnterior = formatearFecha(item.fecha_anterior);
                        let nuevaFecha = formatearFecha(item.nueva_fecha);
                        let fechaRegistro = formatearFechaHora(item.fecha_registro);
                        let motivo = item.motivo;
                        let motivoHtml = motivo.length > 30 ? `<span title="${motivo.replace(/\"/g, '&quot;')}">${motivo.substring(0, 30)}...</span>` : motivo;
                        html += `<tr>
                            <td>${item.numero_contrato}</td>
                            <td>${item.dependencia ? item.dependencia : 'N/A'}</td>
                            <td>${item.objeto_contrato ? item.objeto_contrato.substring(0, 40) + (item.objeto_contrato.length > 40 ? '...' : '') : ''}</td>
                            <td>${fechaAnterior}</td>
                            <td>${nuevaFecha}</td>
                            <td>${item.dias_prorroga}</td>
                            <td>${motivoHtml}</td>
                            <td>${fechaRegistro}</td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Sin prórrogas registradas</td></tr>';
                }
            } catch (error) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error al cargar historial</td></tr>';
            }
        }
    }
}

function formatearFecha(fecha) {
    if (!fecha) return '';
    let d = new Date(fecha);
    if (isNaN(d)) return fecha;
    return d.toLocaleDateString('es-CO');
}

function formatearFechaHora(fechaHora) {
    if (!fechaHora) return '';
    let d = new Date(fechaHora.replace(' ', 'T'));
    if (isNaN(d)) return fechaHora;
    return d.toLocaleDateString('es-CO') + ' ' + d.toLocaleTimeString('es-CO', {hour: '2-digit', minute:'2-digit'});
}

// Función para abrir el modal de adición
function fntAdicionContrato(id, valorContrato) {
    document.querySelector('#adicion_id_contrato').value = id;
    document.querySelector('#adicion_valor').value = '';
    document.querySelector('#adicion_motivo').value = '';
    document.querySelector('#adicion_validacion').textContent = '';
    document.querySelector('#adicion_valor').setAttribute('data-valor-contrato', valorContrato);
    // Mostrar valores en los inputs
    document.querySelector('#adicion_valor_total_contrato').value = `$${parseFloat(valorContrato).toLocaleString('es-CO')}`;
    let maximo = valorContrato * 0.5;
    document.querySelector('#adicion_valor_maximo').value = `$${parseFloat(maximo).toLocaleString('es-CO')}`;
    
    // Consultar adiciones existentes para mostrar valores informativos
    let idContrato = document.querySelector('#adicion_id_contrato').value;
    let request = new XMLHttpRequest();
    request.open('GET', base_url + '/SeguimientoContrato/getAdicionesContrato/' + idContrato, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let sumaExistente = 0;
            if (objData.status && objData.data.length > 0) {
                objData.data.forEach(function(item) {
                    sumaExistente += parseFloat(item.valor_adicion);
                });
            }
            let disponible = maximo - sumaExistente;
            
            document.querySelector('#adicion_valor_usado').value = `$${sumaExistente.toLocaleString('es-CO')}`;
            document.querySelector('#adicion_valor_disponible').value = `$${disponible.toLocaleString('es-CO')}`;
            
            // Inicializar gráfico
            actualizarGraficoAdicion(valorContrato, maximo, sumaExistente, 0);
        }
    };
    $('#modalAdicionContrato').modal('show');
    // Validación visual del 50% y gráfico
    const inputValor = document.querySelector('#adicion_valor');
    const btnGuardar = document.querySelector('#formAdicionContrato button[type="submit"]');
    inputValor.oninput = function() {
        let valorInicial = parseFloat(inputValor.getAttribute('data-valor-contrato'));
        let valor = parseFloat(this.value);
        if (isNaN(valor) || valor <= 0) {
            document.querySelector('#adicion_validacion').textContent = '';
            btnGuardar.disabled = true;
            actualizarGraficoAdicion(valorInicial, valorInicial * 0.5, 0, 0);
            return;
        }
        // Consultar suma de adiciones actuales por AJAX
        let idContrato = document.querySelector('#adicion_id_contrato').value;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/SeguimientoContrato/getAdicionesContrato/' + idContrato;
        request.open('GET', ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                let suma = 0;
                if (objData.status && objData.data.length > 0) {
                    objData.data.forEach(function(item) {
                        suma += parseFloat(item.valor_adicion);
                    });
                }
                let maximo = valorInicial * 0.5;
                let disponible = maximo - suma;
                
                actualizarGraficoAdicion(valorInicial, maximo, suma, valor);
                
                if (valor > disponible) {
                    document.querySelector('#adicion_validacion').innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Excede el valor disponible</span>`;
                    btnGuardar.disabled = true;
                } else {
                    let restante = disponible - valor;
                    document.querySelector('#adicion_validacion').innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> Válido. Quedarán: $${restante.toLocaleString('es-CO')}</span>`;
                    btnGuardar.disabled = false;
                }
            }
        }
    };
    // Disparar el evento para inicializar el gráfico
    inputValor.dispatchEvent(new Event('input'));
}

// Función para actualizar el gráfico de adición
let chartAdicion = null;
function actualizarGraficoAdicion(valorContrato, maximo, sumaAdiciones, nuevaAdicion) {
    let ctx = document.getElementById('graficoAdicionContrato').getContext('2d');
    let totalConNueva = sumaAdiciones + nuevaAdicion;
    if (window.chartAdicion) {
        window.chartAdicion.destroy();
    }
    if (window.Chart) {
        window.chartAdicion = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Máximo 50%', 'Actual + Nueva'],
                datasets: [{
                    label: 'Valores',
                    data: [maximo, totalConNueva],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.7)',
                        totalConNueva > maximo ? 'rgba(220,53,69,0.7)' : 'rgba(40,167,69,0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.max(valorContrato, maximo * 1.1, totalConNueva * 1.1)
                    }
                }
            }
        });
    } else {
        // Fallback: dibujar simple
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
        ctx.fillStyle = '#ffc107';
        let bar1 = Math.round((maximo / valorContrato) * ctx.canvas.width);
        ctx.fillRect(10, 10, bar1, 20);
        ctx.fillStyle = totalConNueva > maximo ? '#dc3545' : '#28a745';
        let bar2 = Math.round((totalConNueva / valorContrato) * ctx.canvas.width);
        ctx.fillRect(10, 40, bar2, 20);
        ctx.fillStyle = '#000';
        ctx.fillText('Máximo 50%', 10, 8);
        ctx.fillText('Actual + Nueva', 10, 38);
    }
}

// Cargar historial general de adiciones al mostrar el tab
const tabHistorialAdiciones = document.getElementById('tab-historial-adiciones');
if(tabHistorialAdiciones){
    tabHistorialAdiciones.addEventListener('shown.bs.tab', function(){
        cargarHistorialAdicionesGeneral();
    });
}

function cargarHistorialAdicionesGeneral() {
    let tbody = document.querySelector('#tablaHistorialAdicionesGeneral tbody');
    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-secondary">Cargando...</td></tr>';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getAllAdiciones';
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status && objData.data.length > 0) {
                    let html = '';
                    objData.data.forEach(function(item) {
                        let fecha = formatearFechaHora(item.fecha_adicion);
                        let motivo = item.motivo;
                        let motivoHtml = motivo.length > 30 ? `<span title="${motivo.replace(/\"/g, '&quot;')}">${motivo.substring(0, 30)}...</span>` : motivo;
                        html += `<tr>
                            <td>${item.numero_contrato}</td>
                            <td>${item.dependencia ? item.dependencia : 'N/A'}</td>
                            <td>${item.objeto_contrato ? item.objeto_contrato.substring(0, 40) + (item.objeto_contrato.length > 40 ? '...' : '') : ''}</td>
                            <td>$${parseFloat(item.valor_adicion).toLocaleString('es-CO')}</td>
                            <td>${motivoHtml}</td>
                            <td>${fecha}</td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Sin adiciones registradas</td></tr>';
                }
            } catch (error) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error al cargar historial</td></tr>';
            }
        }
    }
}

function fntHistorialAdiciones(id) {
    let tbody = document.querySelector('#tablaHistorialAdicionesIndividual tbody');
    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-secondary">Cargando...</td></tr>';
    $('#modalHistorialAdiciones').modal('show');
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getAdicionesContrato/' + id;
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status && objData.data.length > 0) {
                    let html = '';
                    objData.data.forEach(function(item) {
                        let fecha = formatearFechaHora(item.fecha_adicion);
                        let motivo = item.motivo;
                        let motivoHtml = motivo.length > 30 ? `<span title="${motivo.replace(/\"/g, '&quot;')}">${motivo.substring(0, 30)}...</span>` : motivo;
                        html += `<tr>
                            <td>${item.dependencia ? item.dependencia : 'N/A'}</td>
                            <td>$${parseFloat(item.valor_adicion).toLocaleString('es-CO')}</td>
                            <td>${motivoHtml}</td>
                            <td>${fecha}</td>
                        </tr>`;
                    });
                    tbody.innerHTML = html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Sin adiciones registradas</td></tr>';
                }
            } catch (error) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error al cargar historial</td></tr>';
            }
        }
    }
}

// ... existing code ...
function fntShowMoreOptions(id) {
    // Asignar el ID al input oculto
    document.getElementById('moreOptionsContratoId').value = id;
    // Mostrar el modal
    $('#modalMoreOptions').modal('show');
}

// Listeners para los botones del modal de más opciones
$(document).ready(function() {
    $('#btnProrroga').on('click', function() {
        var id = document.getElementById('moreOptionsContratoId').value;
        var row = tableSeguimientoContrato.api().rows().data().toArray().find(r => r.id == id);
        if(row) {
            fntProrrogaContrato(id, row.fecha_terminacion);
        }
        $('#modalMoreOptions').modal('hide');
    });
    $('#btnHistorialProrrogas').on('click', function() {
        var id = document.getElementById('moreOptionsContratoId').value;
        fntHistorialProrrogas(id);
        $('#modalMoreOptions').modal('hide');
    });
    $('#btnAdicion').on('click', function() {
        var id = document.getElementById('moreOptionsContratoId').value;
        var row = tableSeguimientoContrato.api().rows().data().toArray().find(r => r.id == id);
        if(row) {
            fntAdicionContrato(id, row.valor_total_contrato_raw);
        }
        $('#modalMoreOptions').modal('hide');
    });
    $('#btnHistorialAdiciones').on('click', function() {
        var id = document.getElementById('moreOptionsContratoId').value;
        fntHistorialAdiciones(id);
        $('#modalMoreOptions').modal('hide');
    });
});
// ... existing code ...

// Modal de cambio de estado
let modalEstadoContrato = null;
let idContratoCambioEstado = null;

function fntCambiarEstadoContrato(id) {
    idContratoCambioEstado = id;
    if (!modalEstadoContrato) {
        // Crear modal si no existe
        const modalHtml = `
        <div class="modal fade" id="modalCambioEstadoContrato" tabindex="-1" aria-labelledby="modalCambioEstadoContratoLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCambioEstadoContratoLabel">Cambiar Estado del Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <form id="formCambioEstadoContrato">
                  <div class="mb-3">
                    <label for="nuevo_estado_contrato" class="form-label">Nuevo Estado</label>
                    <select class="form-control" id="nuevo_estado_contrato" name="nuevo_estado_contrato" required>
                      <option value="1">En ejecucion</option>
                      <option value="2">Finalizado</option>
                      <option value="3">Liquidado</option>
                    </select>
                  </div>
                  <div id="alertaLiquidado" class="alert alert-warning d-none" role="alert">
                    Al ser el contrato liquidado, no se podrá editar ni eliminar, solo ver.
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarCambioEstado">Confirmar</button>
              </div>
            </div>
          </div>
        </div>`;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        modalEstadoContrato = new bootstrap.Modal(document.getElementById('modalCambioEstadoContrato'));
        document.getElementById('btnConfirmarCambioEstado').onclick = confirmarCambioEstadoContrato;
        document.getElementById('nuevo_estado_contrato').addEventListener('change', function() {
            const alerta = document.getElementById('alertaLiquidado');
            if (this.value == '3') {
                alerta.classList.remove('d-none');
            } else {
                alerta.classList.add('d-none');
            }
        });
    }
    document.getElementById('formCambioEstadoContrato').reset();
    document.getElementById('alertaLiquidado').classList.add('d-none');
    modalEstadoContrato.show();
}

function confirmarCambioEstadoContrato() {
    const nuevoEstado = document.getElementById('nuevo_estado_contrato').value;
    if (!idContratoCambioEstado || !nuevoEstado) return;
    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea cambiar el estado del contrato?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cambiar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/SeguimientoContrato/changeEstadoContrato';
            let formData = new FormData();
            formData.append('id', idContratoCambioEstado);
            formData.append('estado', nuevoEstado);
            request.open('POST', ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    try {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            Swal.fire('Éxito', objData.msg, 'success');
                            tableSeguimientoContrato.api().ajax.reload();
                        } else {
                            Swal.fire('Error', objData.msg, 'error');
                        }
                        modalEstadoContrato.hide();
                    } catch (error) {
                        Swal.fire('Error', 'Error al procesar la solicitud', 'error');
                    }
                }
            }
        }
    });
}