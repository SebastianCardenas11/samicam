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
            $(row).css('transform', 'none');
            $(row).css('transition', 'none');
        }
    });
    
    $('#tableDetalleViaticos').DataTable({
        "rowCallback": function(row, data, index) {
            $(row).removeClass('hover');
            $(row).css('transform', 'none');
            $(row).css('transition', 'none');
        }
    });
    
    // Quitar efectos de zoom en tablas
    $('table, tr, td, th').css({
        'transform': 'none',
        'transition': 'none',
        'transform-origin': 'center',
        'perspective': 'none'
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
            const capitalTotal = parseFloat(data.capitalTotal) || 0;
            const capitalDisponible = parseFloat(data.capitalDisponible) || 0;
            const viaticosUsados = capitalTotal - capitalDisponible;
            
            // Mostrar el capital total y usado
            document.getElementById('totalViaticos').textContent = formatearMoneda(capitalTotal);
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
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 10
                                }
                            }
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
            
            // Quitar efectos de zoom en tablas después de cargar datos
            $('table, tr, td, th').css({
                'transform': 'none',
                'transition': 'none',
                'transform-origin': 'center',
                'perspective': 'none'
            });
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
                    const btnEliminar = `<button class="btn btn-danger btn-sm" onclick="eliminarViatico(${item.idViatico})"><i class="bi bi-trash"></i></button>`;
                    
                    table.row.add([
                        item.nombre_completo,
                        item.descripcion,
                        formatearMoneda(parseFloat(item.monto)),
                        item.fecha,
                        item.uso,
                        btnEliminar
                    ]);
                });
            }
            table.draw();
            
            // Quitar efectos de zoom en tablas después de cargar datos
            $('table, tr, td, th').css({
                'transform': 'none',
                'transition': 'none',
                'transform-origin': 'center',
                'perspective': 'none'
            });
        })
        .catch(error => {
            console.error('Error al cargar detalle de viáticos:', error);
            const table = $('#tableDetalleViaticos').DataTable();
            table.clear().draw();
        });
}

function eliminarViatico(idViatico) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "¡Esta acción no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar indicador de carga
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            const formData = new FormData();
            formData.append('idViatico', idViatico);
            
            fetch(base_url + '/FuncionariosViaticos/deleteViatico', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                if (data.status) {
                    Swal.fire('Eliminado', data.msg, 'success');
                    // Recargar datos
                    const anioActual = document.getElementById('anioActual').textContent || new Date().getFullYear();
                    
                    // Primero cargar el capital disponible para actualizar los valores
                    cargarCapitalDisponible(anioActual);
                    
                    // Luego actualizar las tablas
                    setTimeout(() => {
                        cargarHistoricoViaticos(anioActual);
                        cargarDetalleViaticos(anioActual);
                    }, 100);
                } else {
                    Swal.fire('Error', data.msg, 'error');
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
            });
        }
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