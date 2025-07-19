document.addEventListener('DOMContentLoaded', function() {
    // Inicializar gráficas del dashboard de usuario
    initUserDashboardCharts();
});

function initUserDashboardCharts() {
    // Gráfica de dona - Tareas por Estado
    initUserTasksDonutChart();
    
    // Gráfica de línea - Tareas completadas por mes
    initUserTasksLineChart();
}

function initUserTasksDonutChart() {
    const ctx = document.getElementById('chart-doughnut-user');
    if (!ctx) return;

    const data = window.tareasEstadoData || [];
    
    // Preparar datos para la gráfica
    const labels = data.map(item => item.estado);
    const values = data.map(item => parseInt(item.cantidad));
    
    // Colores para cada estado
    const backgroundColors = [
        '#17a2b8', // Sin Empezar - Info
        '#ffc107', // En Curso - Warning  
        '#28a745', // Completada - Success
        '#6c757d'  // Otro - Secondary
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: backgroundColors,
                borderWidth: 0,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((context.parsed * 100) / total) : 0;
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '60%',
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
}

function initUserTasksLineChart() {
    const ctx = document.getElementById('chart-line-user');
    if (!ctx) return;

    const data = window.tareasMesData || [];
    
    // Preparar datos para la gráfica
    const labels = data.map(item => item.mes);
    const values = data.map(item => parseInt(item.cantidad));

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(40, 167, 69, 0.8)');
    gradient.addColorStop(1, 'rgba(40, 167, 69, 0.1)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Tareas Completadas',
                data: values,
                borderColor: '#28a745',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#28a745',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
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
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#28a745',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return 'Completadas: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#9ca2b7'
                    }
                },
                y: {
                    display: true,
                    grid: {
                        color: 'rgba(156, 162, 183, 0.1)'
                    },
                    ticks: {
                        color: '#9ca2b7',
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

