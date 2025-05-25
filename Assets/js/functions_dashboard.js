// Variables globales para almacenar las instancias de los gráficos
let chartBars = null;
let chartLine = null;

document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos para las gráficas
    cargarFuncionariosPorCargo();
    cargarPermisosPorMes();
});

function cargarFuncionariosPorCargo() {
    fetch(base_url + '/Dashboard/getFuncionariosPorCargo')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                console.log('Datos de funcionarios por cargo:', data);
                const ctx = document.getElementById('chart-bars');
                if (!ctx) {
                    console.error('No se encontró el elemento canvas #chart-bars');
                    return;
                }
                
                // Destruir el gráfico existente si existe
                if (chartBars) {
                    chartBars.destroy();
                }
                
                const ctxContext = ctx.getContext('2d');
                const labels = data.map(item => item.nombre_cargo);
                const valores = data.map(item => item.total_funcionarios);
                
                chartBars = new Chart(ctxContext, {
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
                                        size: 14,
                                        family: "Open Sans",
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
                                        size: 14,
                                        family: "Open Sans",
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
                console.log('Datos de permisos por mes:', data);
                const ctx = document.getElementById('chart-line');
                if (!ctx) {
                    console.error('No se encontró el elemento canvas #chart-line');
                    return;
                }
                
                // Destruir el gráfico existente si existe
                if (chartLine) {
                    chartLine.destroy();
                }
                
                const ctxContext = ctx.getContext('2d');
                
                // Convertir nombres de meses numéricos a nombres
                const nombresMeses = {
                    '1': 'Enero', '2': 'Febrero', '3': 'Marzo', '4': 'Abril',
                    '5': 'Mayo', '6': 'Junio', '7': 'Julio', '8': 'Agosto',
                    '9': 'Septiembre', '10': 'Octubre', '11': 'Noviembre', '12': 'Diciembre'
                };
                
                const labels = data.map(item => nombresMeses[item.mes] || item.mes);
                const valores = data.map(item => item.total_permisos);
                
                chartLine = new Chart(ctxContext, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Permisos',
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 0,
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
                            }
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
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: "Roboto",
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
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: "Roboto",
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