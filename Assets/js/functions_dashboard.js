// Variables globales para almacenar las instancias de los gráficos
let chartBars = null;
let chartLine = null;
let chartIngresos = null;
let chartBubble = null;

document.addEventListener('DOMContentLoaded', function() {
    
    // Solo inicializar si estamos en la página del dashboard
    const chartElements = [
        document.getElementById('chart-bars'),
        document.getElementById('chart-ingresos'),
        document.getElementById('chart-bubble')
    ];
    
    const hasChartElements = chartElements.some(element => element !== null);
    
    if (hasChartElements) {
        // Pequeño retraso para asegurar que todo esté listo
        setTimeout(() => {
            inicializarGraficos();
        }, 100);
    } 
});

function inicializarGraficos() {
    
    // Verificar que Chart.js esté disponible
    if (typeof Chart === 'undefined') {
        console.error('Chart.js no está disponible. Cargando dinámicamente...');
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        script.onload = function() {
            setTimeout(inicializarGraficos, 100);
        };
        document.head.appendChild(script);
        return;
    }
    
    // Inicializar gráfico de funcionarios por cargo
    if (document.getElementById('chart-bars')) {
        setTimeout(() => {
            cargarFuncionariosPorCargo();
        }, 200);
    }
    
    // Inicializar gráfico de ingresos por mes
    if (document.getElementById('chart-ingresos')) {
        setTimeout(() => {
            cargarGraficaIngresos();
        }, 300);
    } else {
        console.warn('Elemento chart-ingresos no encontrado');
    }
    
    // Inicializar bubble chart
    if (document.getElementById('chart-bubble')) {
        setTimeout(() => {
            cargarBubbleChart();
        }, 400);
    } else {
        console.warn('Elemento chart-bubble no encontrado');
    }
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
            
            if (data && data.length > 0) {
                const ctx = document.getElementById('chart-bars');
                if (!ctx) {
                    console.error('No se encontró el elemento canvas #chart-bars');
                    return;
                }
                
                // Destruir gráfico existente si existe
                if (chartBars) {
                    chartBars.destroy();
                }
                
                const labels = data.map(item => item.nombre_cargo);
                const valores = data.map(item => item.total_funcionarios);
                
                // Generar colores dinámicos para las barras
                const colores = [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(199, 199, 199, 0.8)',
                    'rgba(83, 102, 255, 0.8)'
                ];
                
                const backgroundColor = labels.map((_, index) => colores[index % colores.length]);
                
                chartBars = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Funcionarios',
                            data: valores,
                            backgroundColor: backgroundColor,
                            borderColor: backgroundColor.map(color => color.replace('0.8', '1')),
                            borderWidth: 2,
                            borderRadius: 6,
                            borderSkipped: false,
                            maxBarThickness: 50
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
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#fff',
                                borderWidth: 1,
                                cornerRadius: 6,
                                displayColors: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    padding: 10,
                                    font: {
                                        size: 12,
                                        family: "Open Sans, sans-serif",
                                        weight: 'bold'
                                    },
                                    color: '#333'
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
                                    padding: 10,
                                    font: {
                                        size: 11,
                                        family: "Open Sans, sans-serif",
                                        weight: 'bold'
                                    },
                                    color: '#333',
                                    maxRotation: 45,
                                    minRotation: 0
                                }
                            },
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        }
                    },
                });
                
            } else {
                // Mostrar mensaje en el canvas
                const ctx = document.getElementById('chart-bars');
                if (ctx) {
                    const context = ctx.getContext('2d');
                    context.clearRect(0, 0, ctx.width, ctx.height);
                    context.font = '16px Arial';
                    context.fillStyle = '#666';
                    context.textAlign = 'center';
                    context.fillText('No hay datos disponibles', ctx.width / 2, ctx.height / 2);
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar datos de funcionarios por cargo:', error);
            // Mostrar mensaje de error en el canvas
            const ctx = document.getElementById('chart-bars');
            if (ctx) {
                const context = ctx.getContext('2d');
                context.clearRect(0, 0, ctx.width, ctx.height);
                context.font = '14px Arial';
                context.fillStyle = '#ff0000';
                context.textAlign = 'center';
                context.fillText('Error al cargar datos', ctx.width / 2, ctx.height / 2);
            }
        });
}

function cargarGraficaIngresos() {
    fetch(base_url + '/Dashboard/getIngresosPorMes')
        .then(response => {
            return response.json();
        })
        .then(data => {
            const ctx = document.getElementById("chart-ingresos");
            if (!ctx) {
                console.error('No se encontró el elemento canvas #chart-ingresos');
                return;
            }

            var gradientStroke1 = ctx.getContext("2d").createLinearGradient(0, 230, 0, 50);
            gradientStroke1.addColorStop(1, 'rgba(255,193,7,0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(255,165,0,0.0)');
            gradientStroke1.addColorStop(0, 'rgba(255,193,7,0)');

            var gradientStroke2 = ctx.getContext("2d").createLinearGradient(0, 230, 0, 50);
            gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
            gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
            gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)');

            chartIngresos = new Chart(ctx, {
                type: "line",
                data: {
                    labels: data.meses,
                    datasets: [
                        {
                            label: "Practicantes",
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 0,
                            borderColor: "#FFA500",
                            backgroundColor: gradientStroke1,
                            fill: true,
                            data: data.practicantes,
                            maxBarThickness: 6
                        },
                        {
                            label: "Funcionarios (Planta + OPS)",
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 0,
                            borderColor: "#3A416F",
                            backgroundColor: gradientStroke2,
                            fill: true,
                            data: data.funcionarios,
                            maxBarThickness: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
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
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: '#b2b9bf',
                                font: {
                                    size: 11,
                                    family: "Inter",
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
                                color: '#b2b9bf',
                                padding: 20,
                                font: {
                                    size: 11,
                                    family: "Inter",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        })
        .catch(error => {
            console.error('Error al cargar datos de ingresos por mes:', error);
        });
}

function cargarBubbleChart() {
    fetch(base_url + '/Dashboard/getPermisosPorMes')
        .then(response => {
            return response.json();
        })
        .then(data => {
            const ctx = document.getElementById('chart-bubble');
            if (!ctx) {
                console.error('No se encontró el elemento canvas #chart-bubble');
                return;
            }

            // Etiquetas fijas de meses
            const labelsMeses = [
                'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
            ];

            // Mapeo de nombres de mes a índice
            const mapMes = {
                'Ene': 0, 'Enero': 0, '1': 0, 1: 0,
                'Feb': 1, 'Febrero': 1, '2': 1, 2: 1,
                'Mar': 2, 'Marzo': 2, '3': 2, 3: 2,
                'Abr': 3, 'Abril': 3, '4': 3, 4: 3,
                'May': 4, 'Mayo': 4, '5': 4, 5: 4,
                'Jun': 5, 'Junio': 5, '6': 5, 6: 5,
                'Jul': 6, 'Julio': 6, '7': 6, 7: 6,
                'Ago': 7, 'Agosto': 7, '8': 7, 8: 7,
                'Sep': 8, 'Septiembre': 8, '9': 8, 9: 8,
                'Oct': 9, 'Octubre': 9, '10': 9, 10: 9,
                'Nov': 10, 'Noviembre': 10, '11': 10, 11: 10,
                'Dic': 11, 'Diciembre': 11, '12': 11, 12: 11
            };

            // Inicializar valores en 0
            const valoresPermisos = Array(12).fill(0);
            data.forEach(item => {
                let mesKey = item.mes;
                let mesIndex = mapMes[mesKey] !== undefined ? mapMes[mesKey] : parseInt(mesKey) - 1;
                if (mesIndex >= 0 && mesIndex < 12) {
                    valoresPermisos[mesIndex] = parseInt(item.total_permisos) || 0;
                }
            });

            const bubbleData = labelsMeses.map((mes, index) => {
                if (valoresPermisos[index] > 0) {
                    return {
                        x: mes,
                        y: valoresPermisos[index],
                        r: Math.min(30, Math.max(5, valoresPermisos[index] * 2))
                    };
                } else {
                    return null;
                }
            }).filter(item => item !== null);

            chartBubble = new Chart(ctx, {
                type: 'bubble',
                data: {
                    datasets: [{
                        label: 'Permisos por Mes',
                        data: bubbleData,
                        backgroundColor: 'rgba(255, 193, 7, 0.6)',
                        borderColor: '#FFA500',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.raw.x}: ${context.raw.y} permisos`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            type: 'category',
                            labels: labelsMeses,
                            title: { display: true, text: 'Mes' },
                            grid: { display: true }
                        },
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Cantidad' },
                            grid: { display: true }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error al cargar datos de permisos por mes:', error);
        });
}