document.addEventListener('DOMContentLoaded', function () {
    const anioActual = new Date().getFullYear();
    document.getElementById('anioActual').textContent = anioActual;

    cargarCapitalDisponible(anioActual);
    cargarHistoricoViaticos(anioActual);
    cargarDetalleViaticos(anioActual);

    // Inicializar DataTables con opciones para quitar hover
    $('#tableHistoricoViaticos').DataTable({
        "rowCallback": function(row, data, index) {
            $(row).removeClass('hover');
        }
    });
    
    $('#tableDetalleViaticos').DataTable({
        "rowCallback": function(row, data, index) {
            $(row).removeClass('hover');
        }
    });
});

function cargarCapitalDisponible(anio) {
    fetch(base_url + '/FuncionariosViaticos/getCapitalDisponible/' + anio)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            const capitalDisponible = parseFloat(data.capitalDisponible) || 0;
            const capitalTotal = parseFloat(data.capitalTotal) || 0;
            
            // Mostrar el capital total y disponible
            document.getElementById('totalViaticos').textContent = formatearMoneda(capitalTotal);
            
            // Calcular viáticos descontados
            const viaticosUsados = capitalTotal - capitalDisponible;
            document.getElementById('viaticosDescontados').textContent = formatearMoneda(viaticosUsados);
            
            // Crear gráfico con Chart.js
            const ctx = document.getElementById('chartCapitalDisponible').getContext('2d');
            if(window.chartInstance) {
                window.chartInstance.destroy();
            }
            window.chartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Disponible', 'Usado'],
                    datasets: [{
                        data: [capitalDisponible, viaticosUsados],
                        backgroundColor: ['#28a745', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error al cargar capital disponible:', error);
            document.getElementById('totalViaticos').textContent = formatearMoneda(0);
            document.getElementById('viaticosDescontados').textContent = formatearMoneda(0);
            
            // Crear gráfico vacío
            const ctx = document.getElementById('chartCapitalDisponible').getContext('2d');
            if(window.chartInstance) {
                window.chartInstance.destroy();
            }
            window.chartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Sin datos'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['#cccccc']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
}

function cargarHistoricoViaticos(anio) {
    fetch(base_url + '/FuncionariosViaticos/getHistoricoViaticos/' + anio)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            const table = $('#tableHistoricoViaticos').DataTable();
            table.clear();
            if (data && data.length > 0) {
                data.forEach(item => {
                    table.row.add([
                        item.nombre_completo,
                        formatearMoneda(parseFloat(item.total_viaticos))
                    ]);
                });
            }
            table.draw();
        })
        .catch(error => {
            console.error('Error al cargar histórico de viáticos:', error);
            const table = $('#tableHistoricoViaticos').DataTable();
            table.clear().draw();
        });
}

function cargarDetalleViaticos(anio) {
    fetch(base_url + '/FuncionariosViaticos/getDetalleViaticos/' + anio)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            const table = $('#tableDetalleViaticos').DataTable();
            table.clear();
            if (data && data.length > 0) {
                data.forEach(item => {
                    table.row.add([
                        item.nombre_completo,
                        item.descripcion,
                        formatearMoneda(parseFloat(item.monto)),
                        item.fecha,
                        item.uso
                    ]);
                });
            }
            table.draw();
        })
        .catch(error => {
            console.error('Error al cargar detalle de viáticos:', error);
            const table = $('#tableDetalleViaticos').DataTable();
            table.clear().draw();
        });
}

function formatearMoneda(valor) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 2
    }).format(valor);
}

function openModalViatico() {
    $('#modalViaticos').modal('show');
}

function openModalPresupuesto() {
    $('#modalPresupuestoViaticos').modal('show');
}