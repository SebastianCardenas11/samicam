   document.addEventListener('DOMContentLoaded', function () {
    const anioActual = new Date().getFullYear();
    document.getElementById('anioActual').textContent = anioActual;

    cargarCapitalDisponible(anioActual);
    cargarHistoricoViaticos(anioActual);
    cargarDetalleViaticos(anioActual);

    // Inicializar DataTables
    $('#tableHistoricoViaticos').DataTable();
    $('#tableDetalleViaticos').DataTable();
});

function cargarCapitalDisponible(anio) {
    fetch(base_url + '/FuncionariosViaticos/getCapitalDisponible/' + anio)
        .then(response => response.json())
        .then(data => {
            const capital = data.capitalDisponible || 0;
            document.getElementById('totalViaticos').textContent = capital.toFixed(2);
            // Aquí se puede agregar lógica para calcular viáticos descontados y mostrarlos
            document.getElementById('viaticosDescontados').textContent = '0.00'; // Placeholder

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
                        data: [capital, 0], // Placeholder para usado
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
        });
}

function cargarHistoricoViaticos(anio) {
    fetch(base_url + '/FuncionariosViaticos/getHistoricoViaticos/' + anio)
        .then(response => response.json())
        .then(data => {
            const table = $('#tableHistoricoViaticos').DataTable();
            table.clear();
            data.forEach(item => {
                table.row.add([
                    item.nombre,
                    item.total_viaticos.toFixed(2)
                ]);
            });
            table.draw();
        });
}

function cargarDetalleViaticos(anio) {
    fetch(base_url + '/FuncionariosViaticos/getDetalleViaticos/' + anio)
        .then(response => response.json())
        .then(data => {
            const table = $('#tableDetalleViaticos').DataTable();
            table.clear();
            data.forEach(item => {
                table.row.add([
                    item.nombre,
                    item.descripcion,
                    item.monto.toFixed(2),
                    item.fecha,
                    item.uso
                ]);
            });
            table.draw();
        });
}

function openModalViatico() {
    $('#modalViaticos').modal('show');
}

function openModalPresupuesto() {
    $('#modalPresupuestoViaticos').modal('show');
}

document.addEventListener('DOMContentLoaded', function () {
    const anioActual = new Date().getFullYear();
    document.getElementById('anioActual').textContent = anioActual;

    cargarCapitalDisponible(anioActual);
    cargarHistoricoViaticos(anioActual);
    cargarDetalleViaticos(anioActual);

    // Inicializar DataTables
    $('#tableHistoricoViaticos').DataTable();
    $('#tableDetalleViaticos').DataTable();
});
