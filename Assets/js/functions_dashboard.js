// Función para cargar los datos cuando el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos para los gráficos
    getFuncionariosPorCargo();
    getPermisosPorMes();
});

// Función para obtener funcionarios por cargo
function getFuncionariosPorCargo() {
    fetch(base_url + '/Dashboard/getFuncionariosPorCargo')
        .then(response => response.json())
        .then(data => {
            // Preparar datos para el gráfico
            const labels = data.map(item => item.nombre_cargo);
            const valores = data.map(item => parseInt(item.cantidad));
            
            // Configurar y mostrar el gráfico de barras
            var ctx = document.getElementById("chart-bars").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Funcionarios por Cargo",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "#fff",
                        data: valores,
                        maxBarThickness: 6
                    }],
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
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: Math.max(...valores) + 2,
                                beginAtZero: true,
                                padding: 15,
                                font: {
                                    size: 14,
                                    family: "Inter",
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
                                color: "#fff",
                                padding: 10,
                                font: {
                                    size: 12,
                                    family: "Inter",
                                    style: 'normal'
                                }
                            },
                        },
                    },
                },
            });
        })
        .catch(error => console.error('Error al cargar funcionarios por cargo:', error));
}

// Función para obtener permisos por mes
function getPermisosPorMes() {
    // Realizar una solicitud para obtener los permisos por mes
    fetch(base_url + '/Dashboard/getPermisosPorMes')
        .then(response => response.json())
        .then(data => {
            mostrarGraficoPermisosPorMes(data);
        })
        .catch(error => {
           console.error(error);
        });
}

// Función para mostrar el gráfico de permisos por mes
function mostrarGraficoPermisosPorMes(datos) {
    // Traducir meses si están en inglés
    const traduccionMeses = {
        'January': 'Enero',
        'February': 'Febrero',
        'March': 'Marzo',
        'April': 'Abril',
        'May': 'Mayo',
        'June': 'Junio',
        'July': 'Julio',
        'August': 'Agosto',
        'September': 'Septiembre',
        'October': 'Octubre',
        'November': 'Noviembre',
        'December': 'Diciembre'
    };
    
    // Preparar datos para el gráfico
    const labels = datos.map(item => traduccionMeses[item.mes] || item.mes);
    const permisosData = datos.map(item => parseInt(item.total_permisos));
    
    // Configurar y mostrar el gráfico de líneas
    var ctx2 = document.getElementById("chart-line").getContext("2d");
    
    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');
    
    new Chart(ctx2, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Permisos por Mes",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#cb0c9f",
                    borderWidth: 3,
                    backgroundColor: gradientStroke1,
                    fill: true,
                    data: permisosData,
                    maxBarThickness: 6
                }
            ],
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
}

// Configuración para el scrollbar en Windows
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}