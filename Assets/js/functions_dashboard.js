document.addEventListener('DOMContentLoaded', function() {
    // Cargar las gráficas cuando el documento esté listo
    cargarGraficaUsuariosPorRol();
    cargarGraficaFuncionariosPorCargo();
    cargarGraficaFuncionariosPorTipoContrato();
    cargarGraficaHorasPorMes();
    cargarGraficaHorasPorInstructor();
});

// Gráfica de usuarios por rol
function cargarGraficaUsuariosPorRol() {
    fetch(base_url + '/dashboard/getUsuariosPorRol')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.nombrerol);
            const valores = data.map(item => parseInt(item.cantidad));
            
            const ctx = document.getElementById('graficaUsuariosPorRol').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: valores,
                        backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Distribución de Usuarios por Rol',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al cargar datos de usuarios por rol:', error));
}

// Gráfica de funcionarios por cargo
function cargarGraficaFuncionariosPorCargo() {
    fetch(base_url + '/dashboard/getFuncionariosPorCargo')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.nombre_cargo);
            const valores = data.map(item => parseInt(item.cantidad));
            
            const ctx = document.getElementById('graficaFuncionariosPorCargo').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: valores,
                        backgroundColor: [
                            '#1cc88a', '#4e73df', '#36b9cc', '#f6c23e', '#e74a3b', '#858796',
                            '#5a5c69', '#2ecc71', '#3498db', '#e67e22', '#9b59b6', '#34495e'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Distribución de Funcionarios por Cargo',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al cargar datos de funcionarios por cargo:', error));
}

// Gráfica de funcionarios por tipo de contrato
function cargarGraficaFuncionariosPorTipoContrato() {
    fetch(base_url + '/dashboard/getFuncionariosPorTipoContrato')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.tipo_contrato);
            const valores = data.map(item => parseInt(item.cantidad));
            
            const ctx = document.getElementById('graficaFuncionariosPorTipoContrato').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cantidad de funcionarios',
                        data: valores,
                        backgroundColor: [
                            'rgba(28, 200, 138, 0.7)',
                            'rgba(78, 115, 223, 0.7)',
                            'rgba(54, 185, 204, 0.7)',
                            'rgba(246, 194, 62, 0.7)',
                            'rgba(231, 74, 59, 0.7)'
                        ],
                        borderColor: [
                            'rgb(28, 200, 138)',
                            'rgb(78, 115, 223)',
                            'rgb(54, 185, 204)',
                            'rgb(246, 194, 62)',
                            'rgb(231, 74, 59)'
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
                            title: {
                                display: true,
                                text: 'Cantidad'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Funcionarios por Tipo de Contrato',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al cargar datos de funcionarios por tipo de contrato:', error));
}

// Gráfica de horas por mes
function cargarGraficaHorasPorMes() {
    fetch(base_url + '/dashboard/getHorasPorMesControlador')
        .then(response => response.json())
        .then(data => {
            // Agrupar datos por ficha
            const fichasUnicas = [...new Set(data.map(item => item.numeroficha))];
            const datasets = fichasUnicas.map((ficha, index) => {
                const fichaData = data.filter(item => item.numeroficha === ficha);
                return {
                    label: `Ficha ${ficha}`,
                    data: fichaData.map(item => parseInt(item.avancehorascompetencia)),
                    backgroundColor: getColor(index, 0.7),
                    borderColor: getColor(index, 1),
                    borderWidth: 1
                };
            });
            
            const ctx = document.getElementById('graficaHorasPorMes');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Horas'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Avance de Horas por Mes',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al cargar datos de horas por mes:', error));
}

// Gráfica de horas por instructor
function cargarGraficaHorasPorInstructor() {
    fetch(base_url + '/dashboard/getHorasPorInstructor')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.nombres);
            const valores = data.map(item => parseInt(item.instructor));
            
            const ctx = document.getElementById('graficaHorasPorInstructor');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Horas asignadas',
                        data: valores,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Horas'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Horas Asignadas por Instructor',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al cargar datos de horas por instructor:', error));
}

// Función para generar colores
function getColor(index, alpha) {
    const colors = [
        `rgba(78, 115, 223, ${alpha})`,
        `rgba(28, 200, 138, ${alpha})`,
        `rgba(54, 185, 204, ${alpha})`,
        `rgba(246, 194, 62, ${alpha})`,
        `rgba(231, 74, 59, ${alpha})`,
        `rgba(133, 135, 150, ${alpha})`,
        `rgba(90, 92, 105, ${alpha})`,
        `rgba(46, 204, 113, ${alpha})`,
        `rgba(52, 152, 219, ${alpha})`,
        `rgba(230, 126, 34, ${alpha})`,
        `rgba(155, 89, 182, ${alpha})`,
        `rgba(52, 73, 94, ${alpha})`
    ];
    return colors[index % colors.length];
}