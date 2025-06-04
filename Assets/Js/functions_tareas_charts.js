document.addEventListener('DOMContentLoaded', function() {
    // Inicializar los gráficos cuando se cambia a la pestaña de gráficos
    document.getElementById('graficos-tab').addEventListener('shown.bs.tab', function (e) {
        cargarEstadisticas();
    });
});

function cargarEstadisticas() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getEstadisticas';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let data = JSON.parse(request.responseText);
            actualizarContadores(data);
            crearGraficoProgreso(data.progreso);
            crearGraficoEstados(data.estados);
            crearGraficoTipos(data.tipos);
        }
    }
}

function actualizarContadores(data) {
    document.getElementById('completadas-count').textContent = data.estados.completadas || 0;
    document.getElementById('encurso-count').textContent = data.estados.en_curso || 0;
    document.getElementById('sinempezar-count').textContent = data.estados.sin_empezar || 0;
    document.getElementById('vencidas-count').textContent = data.estados.vencidas || 0;
}

function crearGraficoProgreso(data) {
    const ctx = document.getElementById('tareasCompletadasChart').getContext('2d');
    
    // Destruir el gráfico existente si hay uno
    if (window.progresoChart) {
        window.progresoChart.destroy();
    }
    
    // Configurar datos para el gráfico de línea
    const chartData = {
        labels: data.labels,
        datasets: [{
            label: 'Tareas Completadas',
            data: data.values,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4,
            fill: true
        }]
    };
    
    // Configurar opciones del gráfico
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };
    
    // Crear el gráfico
    window.progresoChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: options
    });
}

function crearGraficoEstados(data) {
    const ctx = document.getElementById('estadoTareasChart').getContext('2d');
    
    // Destruir el gráfico existente si hay uno
    if (window.estadosChart) {
        window.estadosChart.destroy();
    }
    
    // Configurar datos para el gráfico de dona
    const chartData = {
        labels: ['Completadas', 'En Curso', 'Sin Empezar', 'Vencidas'],
        datasets: [{
            data: [
                data.completadas || 0,
                data.en_curso || 0,
                data.sin_empezar || 0,
                data.vencidas || 0
            ],
            backgroundColor: [
                '#28a745', // Verde para completadas
                '#ffc107', // Amarillo para en curso
                '#17a2b8', // Azul para sin empezar
                '#dc3545'  // Rojo para vencidas
            ]
        }]
    };
    
    // Configurar opciones del gráfico
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    };
    
    // Crear el gráfico
    window.estadosChart = new Chart(ctx, {
        type: 'doughnut',
        data: chartData,
        options: options
    });
}

function crearGraficoTipos(data) {
    const ctx = document.getElementById('tipoTareasChart').getContext('2d');
    
    // Destruir el gráfico existente si hay uno
    if (window.tiposChart) {
        window.tiposChart.destroy();
    }
    
    // Configurar datos para el gráfico de barras
    const chartData = {
        labels: Object.keys(data),
        datasets: [{
            label: 'Tareas por Tipo',
            data: Object.values(data),
            backgroundColor: [
                'rgba(40, 167, 69, 0.7)',  // Verde
                'rgba(255, 193, 7, 0.7)'   // Amarillo
            ],
            borderColor: [
                'rgb(40, 167, 69)',
                'rgb(255, 193, 7)'
            ],
            borderWidth: 1
        }]
    };
    
    // Configurar opciones del gráfico
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };
    
    // Crear el gráfico
    window.tiposChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: options
    });
} 