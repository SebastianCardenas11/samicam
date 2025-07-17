/**
 * Mejoras para los gráficos de estadísticas
 */

// Sobrescribir la función renderGraficoMovimientosPorMes para corregir la visualización de líneas
function renderGraficoMovimientosPorMes(datos) {
    const ctx = document.getElementById('graficoMovimientosMes').getContext('2d');
    
    // Procesar datos para el gráfico
    const meses = datos.map(item => {
        const fecha = new Date(item.mes + '-01');
        return fecha.toLocaleDateString('es-ES', { month: 'short', year: 'numeric' });
    });
    
    const entradas = datos.map(item => parseInt(item.entradas));
    const salidas = datos.map(item => parseInt(item.salidas));
    
    // Destruir gráfico existente si hay uno
    if (graficoMovimientosMes) {
        graficoMovimientosMes.destroy();
    }
    
    // Crear nuevo gráfico con configuración mejorada para mostrar líneas correctamente
    graficoMovimientosMes = new Chart(ctx, {
        type: 'line',
        data: {
            labels: meses,
            datasets: [
                {
                    label: 'Entradas a Mantenimiento',
                    data: entradas,
                    backgroundColor: 'rgba(255, 193, 7, 0.2)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 2,
                    tension: 0.1,
                    fill: false,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(255, 193, 7, 1)'
                },
                {
                    label: 'Salidas de Mantenimiento',
                    data: salidas,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    tension: 0.1,
                    fill: false,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad'
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
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Movimientos de Mantenimiento por Mes'
                }
            },
            elements: {
                line: {
                    borderWidth: 2,
                    fill: false
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 6
                }
            }
        }
    });
}