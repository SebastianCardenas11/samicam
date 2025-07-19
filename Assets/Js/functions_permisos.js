let tablePermisos;
let tiposPermisos = [];

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar componentes
    initializeTable();
    loadTiposPermisos();
    setupEventListeners();
});

// Inicializar tabla de permisos
function initializeTable() {
    tablePermisos = $('#tablePermisos').DataTable({
        "aProcessing": true,
        "aServerSide": false,
        "language": {
            "url": base_url + "/Assets/plugins/datatables/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/Permisos/getPermisos",
            "method": "POST",
            "dataSrc": ""
        },
        "columns": [
            {"data": "nombre_completo"},
            {"data": "nm_identificacion"},
            {"data": "cargo"},
            {"data": "dependencia"},
            {"data": "fecha_permiso"},
            {
                "data": "tipo_permiso",
                "render": function(data, type, row) {
                    return `<span class="badge" style="background-color: ${row.color_display}">${data}</span>`;
                }
            },
            {"data": "motivo"},
            {
                "data": "estado",
                "render": function(data, type, row) {
                    let badgeClass = data === 'Aprobado' ? 'success' : 
                                   data === 'Rechazado' ? 'danger' : 'warning';
                    return `<span class="badge badge-${badgeClass}">${data}</span>`;
                }
            },
            {
                "data": "es_permiso_especial",
                "render": function(data, type, row) {
                    return data == 1 ? '<i class="fas fa-star text-warning" title="Permiso Especial"></i>' : '';
                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <div class="text-center">
                            <button class="btn btn-info btn-sm" onclick="verDetalle(${row.id_permiso})" title="Ver detalle">
                                <i class="far fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" onclick="editarPermiso(${row.id_permiso})" title="Editar">
                                <i class="far fa-edit"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[4, "desc"]]
    });
}

// Cargar tipos de permisos
function loadTiposPermisos() {
    $.ajax({
        url: base_url + '/Permisos/getTiposPermisos',
        type: 'POST',
        success: function(response) {
            tiposPermisos = JSON.parse(response);
            populateTiposSelect();
        },
        error: function() {
            Swal.fire('Error', 'No se pudieron cargar los tipos de permisos', 'error');
        }
    });
}

// Poblar select de tipos de permisos
function populateTiposSelect() {
    const select = document.getElementById('listTipoPermiso');
    select.innerHTML = '<option value="">Seleccionar tipo</option>';
    
    tiposPermisos.forEach(tipo => {
        const option = document.createElement('option');
        option.value = tipo.id_tipo_permiso;
        option.textContent = tipo.nombre;
        option.dataset.requiereJustificacion = tipo.requiere_justificacion;
        select.appendChild(option);
    });
}

// Configurar event listeners
function setupEventListeners() {
    // Cambio en tipo de permiso
    document.getElementById('listTipoPermiso').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const requiereJustificacion = selectedOption.dataset.requiereJustificacion == '1';
        
        const justificacionGroup = document.getElementById('justificacionGroup');
        if (requiereJustificacion) {
            justificacionGroup.style.display = 'block';
            document.getElementById('txtJustificacion').required = true;
        } else {
            justificacionGroup.style.display = 'none';
            document.getElementById('txtJustificacion').required = false;
        }
        
        // Validar límites si hay funcionario y fecha seleccionados
        validarLimitesPermiso();
    });

    // Cambio en fecha o funcionario
    document.getElementById('txtFechaPermiso').addEventListener('change', validarLimitesPermiso);
    document.getElementById('listFuncionario').addEventListener('change', validarLimitesPermiso);

    // Checkbox de permiso especial
    document.getElementById('checkPermisoEspecial').addEventListener('change', function() {
        const justificacionEspecial = document.getElementById('justificacionEspecialGroup');
        if (this.checked) {
            justificacionEspecial.style.display = 'block';
            document.getElementById('txtJustificacionEspecial').required = true;
        } else {
            justificacionEspecial.style.display = 'none';
            document.getElementById('txtJustificacionEspecial').required = false;
        }
    });
}

// Validar límites de permisos
function validarLimitesPermiso() {
    const funcionarioId = document.getElementById('listFuncionario').value;
    const tipoPermisoId = document.getElementById('listTipoPermiso').value;
    const fechaPermiso = document.getElementById('txtFechaPermiso').value;
    const tipoFuncionario = document.getElementById('listTipoFuncionario').value;

    if (!funcionarioId || !tipoPermisoId || !fechaPermiso) {
        document.getElementById('limitesInfo').innerHTML = '';
        return;
    }

    $.ajax({
        url: base_url + '/Permisos/validarLimites',
        type: 'POST',
        data: {
            funcionario_id: funcionarioId,
            tipo_permiso_id: tipoPermisoId,
            fecha_permiso: fechaPermiso,
            tipo_funcionario: tipoFuncionario
        },
        success: function(response) {
            const validacion = JSON.parse(response);
            mostrarInfoLimites(validacion);
        },
        error: function() {
            console.error('Error al validar límites');
        }
    });
}

// Mostrar información de límites
function mostrarInfoLimites(validacion) {
    const infoDiv = document.getElementById('limitesInfo');
    let alertClass = validacion.permitido ? 'alert-success' : 'alert-warning';
    let icon = validacion.permitido ? 'fa-check-circle' : 'fa-exclamation-triangle';
    
    infoDiv.innerHTML = `
        <div class="alert ${alertClass} alert-sm">
            <i class="fas ${icon}"></i>
            <strong>Límites:</strong> ${validacion.permisos_usados}/${validacion.limite_mensual} permisos usados este mes.
            ${validacion.permisos_restantes > 0 ? 
                `Quedan ${validacion.permisos_restantes} permisos disponibles.` : 
                'Límite mensual alcanzado. Considere marcar como permiso especial.'
            }
        </div>
    `;
}

// Abrir modal para nuevo permiso
function openModal() {
    document.getElementById('idPermiso').value = '';
    document.getElementById('titleModal').innerHTML = 'Nuevo Permiso';
    document.getElementById('btnActionForm').innerHTML = 'Guardar';
    document.getElementById('formPermiso').reset();
    document.getElementById('limitesInfo').innerHTML = '';
    document.getElementById('justificacionGroup').style.display = 'none';
    document.getElementById('justificacionEspecialGroup').style.display = 'none';
    $('#modalFormPermiso').modal('show');
}

// Guardar permiso
function fntSavePermiso() {
    const formData = new FormData(document.getElementById('formPermiso'));
    
    $.ajax({
        url: base_url + '/Permisos/crearPermiso',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            const result = JSON.parse(response);
            
            if (result.success) {
                $('#modalFormPermiso').modal('hide');
                Swal.fire('Éxito', result.message, 'success');
                tablePermisos.ajax.reload();
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Error en la comunicación con el servidor', 'error');
        }
    });
}

// Ver detalle del permiso
function verDetalle(idPermiso) {
    // Implementar modal de detalle
    console.log('Ver detalle del permiso:', idPermiso);
}

// Editar permiso
function editarPermiso(idPermiso) {
    // Implementar edición
    console.log('Editar permiso:', idPermiso);
}

// Filtrar permisos
function filtrarPermisos() {
    const filtros = {
        funcionario_id: document.getElementById('filtroFuncionario').value,
        fecha_inicio: document.getElementById('filtroFechaInicio').value,
        fecha_fin: document.getElementById('filtroFechaFin').value,
        tipo_permiso: document.getElementById('filtroTipoPermiso').value,
        dependencia: document.getElementById('filtroDependencia').value
    };

    tablePermisos.ajax.url(base_url + '/Permisos/getPermisos').load();
}

// Limpiar filtros
function limpiarFiltros() {
    document.getElementById('formFiltros').reset();
    tablePermisos.ajax.reload();
}

// Exportar a Excel
function exportarExcel() {
    // Implementar exportación
    console.log('Exportar a Excel');
}

// Mostrar estadísticas
function mostrarEstadisticas() {
    $.ajax({
        url: base_url + '/Permisos/getEstadisticas',
        type: 'POST',
        data: { anio: new Date().getFullYear() },
        success: function(response) {
            const estadisticas = JSON.parse(response);
        },
        error: function() {
            Swal.fire('Error', 'No se pudieron cargar las estadísticas', 'error');
        }
    });
}

// Poblar el filtro de año en estadísticas
function poblarFiltroAnioEstadisticas() {
    const select = document.getElementById('filtroAnioEstadisticas');
    const anioActual = new Date().getFullYear();
    select.innerHTML = '';
    for(let i = anioActual; i >= anioActual - 10; i--) {
        let opt = document.createElement('option');
        opt.value = i;
        opt.textContent = i;
        select.appendChild(opt);
    }
}

// Modificar cargarGraficosPermisos para usar el año seleccionado
function cargarGraficosPermisos() {
    const anio = document.getElementById('filtroAnioEstadisticas') ? document.getElementById('filtroAnioEstadisticas').value : new Date().getFullYear();
    // Funcionarios con más permisos por mes
    $.post(base_url + '/Permisos/getFuncionariosMasPermisosPorMes', {anio}, function(response) {
        const data = JSON.parse(response);
        const meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        let labels = meses;
        let datasets = [];
        let funcionarios = [...new Set(data.map(item => item.nombre_completo))];
        funcionarios.forEach(func => {
            let dataFunc = Array(12).fill(0);
            data.filter(item => item.nombre_completo === func).forEach(item => {
                dataFunc[item.mes - 1] = parseInt(item.total);
            });
            datasets.push({
                label: func,
                data: dataFunc,
                borderWidth: 2,
                fill: false
            });
        });
        if(window.chartPermisosPorMes) window.chartPermisosPorMes.destroy();
        window.chartPermisosPorMes = new Chart(document.getElementById('chartPermisosPorMes').getContext('2d'), {
            type: 'line',
            data: { labels, datasets },
            options: { responsive: true, plugins: { legend: { display: true } } }
        });
    });
    // Cantidad de permisos por funcionario
    $.post(base_url + '/Permisos/getCantidadPermisosPorFuncionario', {anio}, function(response) {
        const data = JSON.parse(response);
        let labels = data.map(item => item.nombre_completo);
        let values = data.map(item => parseInt(item.total));
        if(window.chartPermisosPorFuncionario) window.chartPermisosPorFuncionario.destroy();
        window.chartPermisosPorFuncionario = new Chart(document.getElementById('chartPermisosPorFuncionario').getContext('2d'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Permisos', data: values, backgroundColor: '#36a2eb' }] },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    });
    // Dependencia con más permisos
    $.post(base_url + '/Permisos/getDependenciaMasPermisos', {anio}, function(response) {
        const data = JSON.parse(response);
        let labels = data.map(item => item.dependencia);
        let values = data.map(item => parseInt(item.total));
        if(window.chartPermisosPorDependencia) window.chartPermisosPorDependencia.destroy();
        window.chartPermisosPorDependencia = new Chart(document.getElementById('chartPermisosPorDependencia').getContext('2d'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Permisos', data: values, backgroundColor: '#ff6384' }] },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    });
}

// Inicializar filtro de año y cargar gráficos al mostrar el tab
$(document).on('shown.bs.tab', 'button[data-bs-target="#tabEstadisticas"]', function () {
    poblarFiltroAnioEstadisticas();
    cargarGraficosPermisos();
});

// Recargar gráficos al cambiar el año
$(document).on('change', '#filtroAnioEstadisticas', function() {
    cargarGraficosPermisos();
});