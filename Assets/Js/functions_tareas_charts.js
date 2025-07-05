document.addEventListener('DOMContentLoaded', function() {
    // Inicializar los gráficos cuando se cambia a la pestaña de gráficos
    const graficosTab = document.getElementById('graficos-tab');
    if (graficosTab) {
        graficosTab.addEventListener('shown.bs.tab', function (e) {
            cargarEstadisticas();
        });
    }
    
    // Si la pestaña de gráficos está activa al cargar la página, cargar estadísticas
    if (document.querySelector('#graficos-tab.active')) {
        setTimeout(() => {
            cargarEstadisticas();
        }, 500);
    }
});

function cargarEstadisticas() {
    // Mostrar loader mientras se cargan los datos
    showLoading('graficosLoader', 'Cargando estadísticas...');
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getEstadisticasTareas';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            try {
                let data = JSON.parse(request.responseText);
                if(data.success) {
                    actualizarContadores(data);
                    crearGraficoProgreso(data.tareasCompletadas);
                    crearGraficoEstados(data.estadoTareas);
                    crearGraficoTipos(data.tiposTarea);
                } else {
                    console.error("Error al cargar estadísticas:", data.msg);
                    mostrarErrorGraficos("Error al cargar las estadísticas: " + data.msg);
                }
            } catch (error) {
                console.error("Error al procesar datos:", error);
                mostrarErrorGraficos("Error al procesar los datos de estadísticas");
            }
        } else if(request.readyState == 4 && request.status != 200) {
            console.error("Error HTTP:", request.status);
            mostrarErrorGraficos("Error de conexión al cargar estadísticas");
        }
        
        // Ocultar loader
        hideLoading('graficosLoader');
    }
}

function mostrarErrorGraficos(mensaje) {
    // Mostrar mensaje de error en los contenedores de gráficos
    const contenedores = ['tareasCompletadasChart', 'estadoTareasChart', 'tipoTareasChart'];
    contenedores.forEach(id => {
        const canvas = document.getElementById(id);
        if (canvas) {
            mostrarMensajeEnCanvas(canvas, 'Error al cargar gráfico', mensaje, '#dc3545');
        }
    });
}

function mostrarMensajeSinDatos(canvas, mensaje) {
    mostrarMensajeEnCanvas(canvas, 'Sin datos', mensaje, '#6c757d');
}

function mostrarMensajeEnCanvas(canvas, titulo, mensaje, color) {
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Crear un mensaje en el canvas
    ctx.fillStyle = color;
    ctx.font = 'bold 14px Arial';
    ctx.textAlign = 'center';
    ctx.fillText(titulo, canvas.width / 2, canvas.height / 2 - 10);
    
    ctx.font = '12px Arial';
    ctx.fillText(mensaje, canvas.width / 2, canvas.height / 2 + 10);
}

function actualizarContadores(data) {
    document.getElementById('completadas-count').textContent = data.estadoTareas.completadas || 0;
    document.getElementById('encurso-count').textContent = data.estadoTareas.enCurso || 0;
    document.getElementById('sinempezar-count').textContent = data.estadoTareas.sinEmpezar || 0;
    document.getElementById('vencidas-count').textContent = data.estadoTareas.vencidas || 0;
}

function crearGraficoProgreso(data) {
    const canvas = document.getElementById('tareasCompletadasChart');
    if (!canvas) {
        console.error('Canvas tareasCompletadasChart no encontrado');
        return;
    }
    
    const ctx = canvas.getContext('2d');
    
    // Destruir el gráfico existente si hay uno
    if (window.progresoChart) {
        window.progresoChart.destroy();
    }
    
    // Validar que los datos existan y no estén vacíos
    if (!data || !Array.isArray(data) || data.length === 0) {
        console.warn('No hay datos para el gráfico de progreso');
        mostrarMensajeSinDatos(canvas, 'No hay datos de tareas completadas');
        return;
    }
    
    // Formatear los datos para el gráfico de línea
    const meses = data.map(item => {
        const [year, month] = item.mes.split('-');
        return new Date(year, month - 1).toLocaleString('es', { month: 'long', year: '2-digit' });
    }).reverse();

    const cantidades = data.map(item => item.cantidad).reverse();
    
    // Configurar datos para el gráfico de línea
    const chartData = {
        labels: meses,
        datasets: [{
            label: 'Tareas Completadas',
            data: cantidades,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4,
            fill: true,
            pointStyle: 'circle',
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    };
    
    // Configurar opciones del gráfico
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    };
    
    // Crear el gráfico
    window.progresoChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: options
    });
}

function crearGraficoEstados(data) {
    const canvas = document.getElementById('estadoTareasChart');
    if (!canvas) {
        console.error('Canvas estadoTareasChart no encontrado');
        return;
    }
    
    const ctx = canvas.getContext('2d');
    
    // Destruir el gráfico existente si hay uno
    if (window.estadosChart) {
        window.estadosChart.destroy();
    }
    
    // Validar que los datos existan
    if (!data) {
        console.warn('No hay datos para el gráfico de estados');
        mostrarMensajeSinDatos(canvas, 'No hay datos de estados de tareas');
        return;
    }
    
    // Configurar datos para el gráfico de dona
    const chartData = {
        labels: ['Completadas', 'En Curso', 'Sin Empezar', 'Vencidas'],
        datasets: [{
            data: [
                data.completadas || 0,
                data.enCurso || 0,
                data.sinEmpezar || 0,
                data.vencidas || 0
            ],
            backgroundColor: [
                '#28a745', // Verde para completadas
                '#ffc107', // Amarillo para en curso
                '#17a2b8', // Azul para sin empezar
                '#dc3545'  // Rojo para vencidas
            ]
        }]
    };
    
    // Configurar opciones del gráfico
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            },
            title: {
                display: true,
                text: 'Distribución Total de Tareas',
                padding: {
                    bottom: 30
                }
            }
        }
    };
    
    // Crear el gráfico
    window.estadosChart = new Chart(ctx, {
        type: 'doughnut',
        data: chartData,
        options: options
    });
}

function crearGraficoTipos(data) {
    const canvas = document.getElementById('tipoTareasChart');
    if (!canvas) {
        console.error('Canvas tipoTareasChart no encontrado');
        return;
    }
    
    const ctx = canvas.getContext('2d');
    
    // Destruir el gráfico existente si hay uno
    if (window.tiposChart) {
        window.tiposChart.destroy();
    }
    
    // Validar que los datos existan y no estén vacíos
    if (!data || !Array.isArray(data) || data.length === 0) {
        console.warn('No hay datos para el gráfico de tipos');
        mostrarMensajeSinDatos(canvas, 'No hay datos de tipos de tareas');
        return;
    }
    
    // Configurar datos para el gráfico de barras
    const chartData = {
        labels: data.map(tipo => tipo.nombre),
        datasets: [{
            label: 'Cantidad de Tareas',
            data: data.map(tipo => tipo.cantidad),
            backgroundColor: '#007bff',
            borderRadius: 6
        }]
    };
    
    // Configurar opciones del gráfico
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };
    
    // Crear el gráfico
    window.tiposChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: options
    });
} 