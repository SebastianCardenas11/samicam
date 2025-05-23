/**
 * Script para corregir problemas con las gráficas del dashboard
 */
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si estamos en la página del dashboard
    if (document.getElementById('chart-bars') || document.getElementById('chart-line')) {
        console.log('Inicializando corrección de gráficas del dashboard');
        
        // Asegurar que Chart.js esté cargado
        if (typeof Chart === 'undefined') {
            console.error('Chart.js no está cargado correctamente');
            
            // Cargar Chart.js dinámicamente si no está disponible
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
            script.onload = function() {
                console.log('Chart.js cargado dinámicamente');
                inicializarGraficas();
            };
            document.head.appendChild(script);
        } else {
            console.log('Chart.js ya está cargado');
            inicializarGraficas();
        }
    }
});

function inicializarGraficas() {
    // Intentar cargar las gráficas
    setTimeout(() => {
        if (document.getElementById('chart-bars')) {
            cargarFuncionariosPorCargo();
        }
        
        if (document.getElementById('chart-line')) {
            cargarPermisosPorMes();
        }
    }, 500); // Pequeño retraso para asegurar que el DOM esté listo
}

function cargarFuncionariosPorCargo() {
    fetch(base_url + '/Dashboard/getFuncionariosPorCargo')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos de funcionarios por cargo:', data);
            
            if (data && data.length > 0) {
                const ctx = document.getElementById('chart-bars');
                if (!ctx) {
                    console.error('No se encontró el elemento canvas #chart-bars');
                    return;
                }
                
                // Limpiar cualquier gráfica existente
                if (window.funcionariosChart) {
                    window.funcionariosChart.destroy();
                }
                
                const labels = data.map(item => item.nombre_cargo);
                const valores = data.map(item => item.total_funcionarios);
                
                window.funcionariosChart = new Chart(ctx, {
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
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos de permisos por mes:', data);
            
            if (data && data.length > 0) {
                const ctx = document.getElementById('chart-line');
                if (!ctx) {
                    console.error('No se encontró el elemento canvas #chart-line');
                    return;
                }
                
                // Limpiar cualquier gráfica existente
                if (window.permisosChart) {
                    window.permisosChart.destroy();
                }
                
                const labels = data.map(item => item.mes);
                const valores = data.map(item => item.total_permisos);
                
                window.permisosChart = new Chart(ctx, {
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