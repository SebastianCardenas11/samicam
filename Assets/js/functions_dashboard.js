// Variables globales para almacenar las instancias de los gráficos
let chartBars = null;
let chartLine = null;

document.addEventListener('DOMContentLoaded', function() {
    // Limpiar cualquier gráfico existente
    limpiarGraficos();
    
    // Esperar a que el DOM esté completamente cargado
    setTimeout(() => {
        inicializarGraficos();
    }, 300);
});

function limpiarGraficos() {
    // Destruir gráficos existentes si existen
    if (chartBars) {
        chartBars.destroy();
        chartBars = null;
    }
    
    if (chartLine) {
        chartLine.destroy();
        chartLine = null;
    }
    
    // Recrear los elementos canvas
    recrearCanvas('chart-bars');
    recrearCanvas('chart-line');
}

function recrearCanvas(id) {
    const contenedor = document.querySelector(`#${id}`).parentNode;
    const canvasAntiguo = document.querySelector(`#${id}`);
    
    if (canvasAntiguo) {
        // Eliminar el canvas antiguo
        canvasAntiguo.remove();
        
        // Crear un nuevo canvas con el mismo ID
        const nuevoCanvas = document.createElement('canvas');
        nuevoCanvas.id = id;
        nuevoCanvas.className = 'chart-canvas';
        nuevoCanvas.height = 170;
        
        // Añadir el nuevo canvas al contenedor
        contenedor.appendChild(nuevoCanvas);
    }
}

function inicializarGraficos() {
    cargarFuncionariosPorCargo();
    cargarPermisosPorMes();
}

function cargarFuncionariosPorCargo() {
    fetch(base_url + '/Dashboard/getFuncionariosPorCargo')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
               
                const ctx = document.getElementById('chart-bars');
                if (!ctx) {
                    console.error('No se encontró el elemento canvas #chart-bars');
                    return;
                }
                
                const labels = data.map(item => item.nombre_cargo);
                const valores = data.map(item => item.total_funcionarios);
                
                chartBars = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Funcionarios',
                            tension: 0.4,
                            borderWidth: 0,
                            borderRadius: 4,
                            borderSkipped: false,
                            backgroundColor: '#fff',
                            data: valores,
                            maxBarThickness: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                },
                                ticks: {
                                    suggestedMin: 0,
                                    suggestedMax: 500,
                                    beginAtZero: true,
                                    padding: 15,
                                    font: {
                                        size: 12,
                                        family: "Open Sans, sans-serif",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                    color: "#fff"
                                },
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false
                                },
                                ticks: {
                                    display: true,
                                    color: '#fff',
                                    padding: 10,
                                    font: {
                                        size: 12,
                                        family: "Open Sans, sans-serif",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    },
                });
            } else {
                console.warn('No hay datos de funcionarios por cargo disponibles');
            }
        })
        .catch(error => console.error('Error al cargar datos de funcionarios por cargo:', error));
}

function cargarPermisosPorMes() {
    fetch(base_url + '/Dashboard/getPermisosPorMes')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                const ctx = document.getElementById('chart-line');
                if (!ctx) {
                    console.error('No se encontró el elemento canvas #chart-line');
                    return;
                }
                
                // Convertir nombres de meses numéricos a nombres
                const nombresMeses = {
                    '1': 'Enero', '2': 'Febrero', '3': 'Marzo', '4': 'Abril',
                    '5': 'Mayo', '6': 'Junio', '7': 'Julio', '8': 'Agosto',
                    '9': 'Septiembre', '10': 'Octubre', '11': 'Noviembre', '12': 'Diciembre'
                };
                
                const labels = data.map(item => nombresMeses[item.mes] || item.mes);
                const valores = data.map(item => item.total_permisos);
                
                chartLine = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Permisos',
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 2,
                            pointBackgroundColor: "#cb0c9f",
                            pointBorderColor: "#cb0c9f",
                            borderColor: "#cb0c9f",
                            backgroundColor: 'rgba(203, 12, 159, 0.2)',
                            fill: true,
                            data: valores,
                            maxBarThickness: 6
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
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Permisos: ' + context.raw;
                                    }
                                },
                                titleFont: {
                                    family: "Open Sans, sans-serif",
                                    size: 12
                                },
                                bodyFont: {
                                    family: "Open Sans, sans-serif",
                                    size: 12
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(255, 255, 255, .2)'
                                },
                                ticks: {
                                    display: true,
                                    color: '#000000',
                                    padding: 10,
                                    font: {
                                        size: 12,
                                        weight: 400,
                                        family: "Open Sans, sans-serif",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    color: '#000000',
                                    padding: 10,
                                    font: {
                                        size: 12,
                                        weight: 400,
                                        family: "Open Sans, sans-serif",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    },
                });
            } else {
                console.warn('No hay datos de permisos por mes disponibles');
            }
        })
        .catch(error => console.error('Error al cargar datos de permisos por mes:', error));
}