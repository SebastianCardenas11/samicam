// functions_psi.js

let tblPrestamos, tblSalidas, tblIngresos;

function cargarFuncionariosPorTipo(tipo) {
    let url = tipo === 'planta'
        ? base_url + '/psi/getFuncionariosPlanta'
        : base_url + '/psi/getFuncionariosOps';
    fetch(url)
        .then(res => res.json())
        .then(data => {
            let select = document.getElementById('funcionario_responsable');
            select.innerHTML = '<option value="">Seleccione un funcionario</option>';
            data.forEach(f => {
                select.innerHTML += `<option value="${f.id || f.nombre_completo}" data-dependencia="${f.dependencia || ''}" data-cargo="${f.cargo || ''}">${f.nombre_completo}</option>`;
            });
        })
        .catch(error => {
            console.error('Error cargando funcionarios:', error);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    initPsiTables();
    
    // Los botones ya están conectados directamente en el HTML

    // Evento para los radio buttons
    document.querySelectorAll('input[name="tipo_funcionario"]').forEach(radio => {
        radio.onchange = function() {
            cargarFuncionariosPorTipo(this.value);
        };
    });

    // Autocompletar dependencia y cargo al seleccionar funcionario
    document.getElementById('funcionario_responsable').onchange = function() {
        let selected = this.options[this.selectedIndex];
        document.getElementById('dependencia').value = selected.getAttribute('data-dependencia') || '';
        document.getElementById('cargo_funcionario').value = selected.getAttribute('data-cargo') || '';
    };

    // Conectar el submit del formulario de préstamos
    document.getElementById('formPsi').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        
        let url = base_url + '/psi/setPrestamo';

        // Para préstamos, agregar datos de múltiples items
        const cantidadItems = document.getElementById('cantidad_items').value;
        if (cantidadItems > 1) {
            // Agregar datos de cada item al FormData
            for (let i = 0; i < cantidadItems; i++) {
                const itemField = document.getElementById(`item_${i}`);
                const dispositivoField = document.getElementById(`dispositivo_${i}`);
                const marcaModeloField = document.getElementById(`marca_modelo_${i}`);
                const activoField = document.getElementById(`activo_${i}`);
                const serialField = document.getElementById(`serial_${i}`);
                const estadoField = document.getElementById(`estado_${i}`);
                const macField = document.getElementById(`mac_${i}`);
                const equipoIdField = document.getElementById(`equipo_id_${i}`);
                const equipoTipoField = document.getElementById(`equipo_tipo_${i}`);
                
                if (itemField && itemField.value) {
                    formData.append(`item_${i}`, itemField.value);
                    formData.append(`dispositivo_${i}`, dispositivoField ? dispositivoField.value : '');
                    formData.append(`marca_modelo_${i}`, marcaModeloField ? marcaModeloField.value : '');
                    formData.append(`activo_${i}`, activoField ? activoField.value : '');
                    formData.append(`serial_${i}`, serialField ? serialField.value : '');
                    formData.append(`estado_${i}`, estadoField ? estadoField.value : '');
                    formData.append(`mac_${i}`, macField ? macField.value : '');
                    formData.append(`equipo_id_${i}`, equipoIdField ? equipoIdField.value : '');
                    formData.append(`equipo_tipo_${i}`, equipoTipoField ? equipoTipoField.value : '');
                }
            }
        }

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.result) {
                $('#modalPsi').modal('hide');
                tblPrestamos.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Préstamo guardado correctamente'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar el préstamo'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error de conexión'
            });
        });
    };

    // Conectar el submit del formulario de salidas
    document.getElementById('formPsiSalidas').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        
        let url = base_url + '/psi/setSalida';

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.result) {
                $('#modalPsiSalidas').modal('hide');
                tblSalidas.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Salida guardada correctamente'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar la salida'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error de conexión'
            });
        });
    };

    // Conectar el submit del formulario de ingresos
    document.getElementById('formPsiIngresos').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        
        let url = base_url + '/psi/setIngreso';

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.result) {
                $('#modalPsiIngresos').modal('hide');
                tblIngresos.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Ingreso guardado correctamente'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar el ingreso'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error de conexión'
            });
        });
    };

    // Limpiar formularios cuando se cierren los modales
    document.getElementById('modalPsi').addEventListener('hidden.bs.modal', function () {
        const form = document.getElementById('formPsi');
        form.reset();
    });

    document.getElementById('modalPsiSalidas').addEventListener('hidden.bs.modal', function () {
        const form = document.getElementById('formPsiSalidas');
        form.reset();
    });

    document.getElementById('modalPsiIngresos').addEventListener('hidden.bs.modal', function () {
        const form = document.getElementById('formPsiIngresos');
        form.reset();
    });
});

function initPsiTables() {
    tblPrestamos = $('#tablaPrestamos').DataTable({
        language: {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":           "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        ajax: { url: base_url + '/psi/getPrestamos', dataSrc: '' },
        columns: [
            { data: 'funcionario_responsable' },
            { data: 'fecha_prestamo' },
            { data: 'fecha_devolucion' },
            { data: 'item' },
            { data: 'dispositivo' },
            { data: null, render: function(data, type, row) {
                return `
                    <div class="text-center">
                        <div class="btn-group">
                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" onclick="verPrestamoPsi(${row.id_prestamos})" title="Ver">
                                <i class="far fa-eye"></i>
                            </button>
                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" onclick="openModalPsi('prestamo', ${row.id_prestamos})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" onclick="eliminarPrestamoPsi(${row.id_prestamos})" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-datatable btn-icon btn-transparent-dark" onclick="imprimirPrestamoPsi(${row.id_prestamos})" title="Imprimir">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </div>
                `;
            }}
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, 'desc']]
    });
    tblSalidas = $('#tablaSalidas').DataTable({
        language: {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":           "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        ajax: { url: base_url + '/psi/getSalidas', dataSrc: '' },
        columns: [
            { data: 'id_salida' },
            { data: 'fecha' },
            { data: 'item' },
            { data: 'tipo_dispositivo' },
            { data: 'descripcion_dispositivo' },
            { data: 'marca' },
            { data: 'modelo' },
            { data: 'numero_activo' },
            { data: 'serial' },
            { data: 'dependencia' },
            { data: 'observaciones' },
            { data: null, render: function(data, type, row) {
                return `
                  <button class='btn btn-sm btn-info me-1' onclick='openModalPsiSalidas(${row.id_salida})'>Editar</button>
                  <button class='btn btn-sm btn-danger me-1' onclick='eliminarSalidaPsi(${row.id_salida})'>Eliminar</button>
                `;
            }}
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, 'desc']]
    });
    tblIngresos = $('#tablaIngresos').DataTable({
        language: {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":           "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        ajax: { url: base_url + '/psi/getIngresos', dataSrc: '' },
        columns: [
            { data: 'id_ingreso' },
            { data: 'fecha' },
            { data: 'item' },
            { data: 'tipo_dispositivo' },
            { data: 'descripcion_dispositivo' },
            { data: 'marca' },
            { data: 'modelo' },
            { data: 'numero_activo' },
            { data: 'serial' },
            { data: 'dependencia' },
            { data: 'observaciones' },
            { data: null, render: function(data, type, row) {
                return `
                  <button class='btn btn-sm btn-info me-1' onclick='openModalPsiIngresos(${row.id_ingreso})'>Editar</button>
                  <button class='btn btn-sm btn-danger me-1' onclick='eliminarIngresoPsi(${row.id_ingreso})'>Eliminar</button>
                `;
            }}
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, 'desc']]
    });
}

function openModalPsi(tipo, id = null) {
    const modal = document.getElementById('modalPsi');
    const modalTitle = modal.querySelector('.modal-title');
    const form = document.getElementById('formPsi');
    
    // Resetear formulario
    form.reset();
    
    // Solo manejar préstamos
    modalTitle.textContent = 'Registro de Préstamo';
    
    document.getElementById('id_prestamos').value = '';
    cargarFuncionariosPorTipo('planta');
    document.getElementById('tipo_planta').checked = true;
    
    // Limpiar contenedor de items
    const itemsContainer = document.getElementById('items_container');
    itemsContainer.innerHTML = '';
    
    // Mostrar tab de inventario por defecto
    document.getElementById('inventario_tab_prestamo').style.display = 'block';
    
    // Cargar datos del inventario y generar formulario para 1 item
    cargarDatosInventarioDisponibles();
    generarFormulariosItems(1);
    
    if (id) {
        fetch(base_url + '/psi/getPrestamo/' + id)
            .then(res => res.json())
            .then(data => {
                for (let key in data) {
                    const element = document.getElementsByName(key)[0];
                    if (element) {
                        element.value = data[key];
                    }
                }
                if(document.getElementById('id_prestamos')){
                    document.getElementById('id_prestamos').value = data.id_prestamos;
                }
            })
            .catch(error => {
                console.error('Error cargando préstamo:', error);
            });
    }
    
    $('#modalPsi').modal('show');
}

function openModalPsiSalidas(id = null) {
    const modal = document.getElementById('modalPsiSalidas');
    const form = document.getElementById('formPsiSalidas');
    
    // Resetear formulario
    form.reset();
    document.getElementById('id_salida').value = '';
    
    // Mostrar inventario por defecto
    const invSalida = document.getElementById('inventario_tab_salida');
    if (invSalida) {
        invSalida.style.display = 'block';
        cargarDatosInventario('salida');
    }
    
    if (id) {
        fetch(base_url + '/psi/getSalida/' + id)
            .then(res => res.json())
            .then(data => {
                Object.keys(data).forEach(key => {
                    const el = form.querySelector(`[name="${key}"]`);
                    if (el) el.value = data[key];
                });
                if (document.getElementById('id_salida')) document.getElementById('id_salida').value = data.id_salida;
            })
            .catch(err => console.error('Error cargando salida:', err));
    }
    
    $('#modalPsiSalidas').modal('show');
}

function openModalPsiIngresos(id = null) {
    const modal = document.getElementById('modalPsiIngresos');
    const form = document.getElementById('formPsiIngresos');
    
    // Resetear formulario
    form.reset();
    document.getElementById('id_ingreso').value = '';
    
    // Mostrar inventario por defecto
    const invIngreso = document.getElementById('inventario_tab_ingreso');
    if (invIngreso) {
        invIngreso.style.display = 'block';
        cargarDatosInventario('ingreso');
    }
    
    if (id) {
        fetch(base_url + '/psi/getIngreso/' + id)
            .then(res => res.json())
            .then(data => {
                Object.keys(data).forEach(key => {
                    const el = form.querySelector(`[name="${key}"]`);
                    if (el) el.value = data[key];
                });
                if (document.getElementById('id_ingreso')) document.getElementById('id_ingreso').value = data.id_ingreso;
            })
            .catch(err => console.error('Error cargando ingreso:', err));
    }
    
    $('#modalPsiIngresos').modal('show');
}

function verPrestamoPsi(id) {
    fetch(base_url + '/psi/getPrestamo/' + id)
        .then(res => res.json())
        .then(data => {
            const detalles = `
                <div class="row">
                    <div class="col-md-6"><strong>Dependencia:</strong> ${data.dependencia || ''}</div>
                    <div class="col-md-6"><strong>Funcionario:</strong> ${data.funcionario_responsable || ''}</div>
                    <div class="col-md-6"><strong>Cargo:</strong> ${data.cargo_funcionario || ''}</div>
                    <div class="col-md-6"><strong>Fecha Préstamo:</strong> ${data.fecha_prestamo || ''}</div>
                    <div class="col-md-6"><strong>Fecha Devolución:</strong> ${data.fecha_devolucion || ''}</div>
                    <div class="col-md-6"><strong>Item:</strong> ${data.item || ''}</div>
                    <div class="col-md-6"><strong>Dispositivo:</strong> ${data.dispositivo || ''}</div>
                    <div class="col-md-6"><strong>Marca/Modelo:</strong> ${data.marca_modelo || ''}</div>
                    <div class="col-md-6"><strong>Activo:</strong> ${data.activo || ''}</div>
                    <div class="col-md-6"><strong>Serial:</strong> ${data.serial || ''}</div>
                    <div class="col-md-6"><strong>Estado:</strong> ${data.estado || ''}</div>
                    <div class="col-md-6"><strong>MAC:</strong> ${data.mac || ''}</div>
                    <div class="col-12 mt-2"><strong>Observaciones:</strong> ${data.observaciones || ''}</div>
                </div>
            `;
            Swal.fire({
                title: 'Detalles del Préstamo',
                html: detalles,
                width: '800px',
                confirmButtonText: 'Cerrar'
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar los detalles del préstamo'
            });
        });
}

function imprimirPrestamoPsi(id) {
    Swal.fire({
        icon: 'info',
        title: 'Imprimir Préstamo',
        text: 'Funcionalidad de impresión próximamente. ID: ' + id
    });
}

// Función para cargar gráficos (futura implementación)
function cargarGraficosPsi() {
    // Aquí irá la lógica para los gráficos con Chart.js
    console.log('Cargando gráficos PSI...');
}

function eliminarPrestamoPsi(id) {
    if (!confirm('¿Seguro que desea eliminar este préstamo?')) return;
    fetch(base_url + '/psi/delPrestamo', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        if (data.result) {
        tblPrestamos.ajax.reload();
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Préstamo eliminado correctamente'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al eliminar el préstamo'
            });
        }
    });
}

function eliminarSalidaPsi(id) {
    if (!confirm('¿Seguro que desea eliminar esta salida?')) return;
    fetch(base_url + '/psi/delSalida', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        if (data.result) {
            tblSalidas.ajax.reload();
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Salida eliminada correctamente'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al eliminar la salida'
            });
        }
    });
}

function eliminarIngresoPsi(id) {
    if (!confirm('¿Seguro que desea eliminar este ingreso?')) return;
    fetch(base_url + '/psi/delIngreso', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        if (data.result) {
            tblIngresos.ajax.reload();
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Ingreso eliminado correctamente'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al eliminar el ingreso'
            });
        }
    });
} 

// Función para mostrar/ocultar el tab de inventario
function toggleInventarioTab(tipo) {
    const selectElement = document.getElementById(`tipo_dispositivo_${tipo}`);
    const inventarioTab = document.getElementById(`inventario_tab_${tipo}`);
    
    if (selectElement.value === 'interno') {
        inventarioTab.style.display = 'block';
        // Cargar datos del inventario
        cargarDatosInventario(tipo);
    } else {
        inventarioTab.style.display = 'none';
    }
}

// Función para mostrar/ocultar el tab de inventario para salidas
function toggleInventarioTabSalidas() {
    const selectElement = document.getElementById('tipo_dispositivo_salida');
    const inventarioTab = document.getElementById('inventario_tab_salida');
    
    if (selectElement.value === 'interno') {
        inventarioTab.style.display = 'block';
        cargarDatosInventario('salida');
    } else {
        inventarioTab.style.display = 'none';
    }
}

// Función para mostrar/ocultar el tab de inventario para ingresos
function toggleInventarioTabIngresos() {
    const selectElement = document.getElementById('tipo_dispositivo_ingreso');
    const inventarioTab = document.getElementById('inventario_tab_ingreso');
    
    if (selectElement.value === 'interno') {
        inventarioTab.style.display = 'block';
        cargarDatosInventario('ingreso');
    } else {
        inventarioTab.style.display = 'none';
    }
}

// Función para mostrar/ocultar el tab de inventario para préstamos
function toggleInventarioTabPrestamo() {
    const cantidadItems = document.getElementById('cantidad_items').value;
    const inventarioTab = document.getElementById('inventario_tab_prestamo');
    const itemsContainer = document.getElementById('items_container');
    
    if (cantidadItems >= 1) {
        inventarioTab.style.display = 'block';
        // Cargar datos del inventario solo disponibles
        cargarDatosInventarioDisponibles();
        // Generar formularios dinámicos
        generarFormulariosItems(cantidadItems);
    } else {
        inventarioTab.style.display = 'none';
        itemsContainer.innerHTML = '';
    }
}

// Función para cargar datos del inventario solo disponibles
function cargarDatosInventarioDisponibles() {
    // Cargar PC Torre disponibles
    cargarTablaInventarioDisponibles('pc_torre', 'prestamo');
    // Cargar Todo en Uno disponibles
    cargarTablaInventarioDisponibles('todo_en_uno', 'prestamo');
    // Cargar Portátiles disponibles
    cargarTablaInventarioDisponibles('portatiles', 'prestamo');
    // Cargar Impresoras disponibles
    cargarTablaInventarioDisponibles('impresoras', 'prestamo');
    // Cargar Escáneres disponibles
    cargarTablaInventarioDisponibles('escaneres', 'prestamo');
    // Cargar Herramientas disponibles
    cargarTablaInventarioDisponibles('herramientas', 'prestamo');
}

// Función para cargar una tabla específica del inventario (solo disponibles)
function cargarTablaInventarioDisponibles(categoria, tipo) {
    // Mapear categorías a IDs de tabla correctos
    const tablaIdMap = {
        'pc_torre': `tablaPcTorre${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'todo_en_uno': `tablaTodoEnUno${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'portatiles': `tablaPortatiles${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'impresoras': `tablaImpresoras${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'escaneres': `tablaEscaneres${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'herramientas': `tablaHerramientas${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`
    };
    
    const tablaId = tablaIdMap[categoria];
    const tbody = document.querySelector(`#${tablaId} tbody`);
    
    if (!tbody) {
        console.error(`No se encontró el tbody para la tabla: ${tablaId}`);
        return;
    }
    
    // Limpiar tabla
    tbody.innerHTML = '';
    
    // Mapear categorías a métodos del controlador
    const metodoMap = {
        'pc_torre': 'getPcTorre',
        'todo_en_uno': 'getTodoEnUno',
        'portatiles': 'getPortatiles',
        'impresoras': 'getImpresoras',
        'escaneres': 'getEscaneres',
        'herramientas': 'getHerramientas'
    };
    
    const metodo = metodoMap[categoria];
    if (!metodo) {
        console.error(`Método no encontrado para categoría: ${categoria}`);
        return;
    }
    
    // Hacer petición AJAX para obtener datos
    fetch(`${base_url}/psi/${metodo}`)
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            
            if (!Array.isArray(data)) {
                return;
            }
            
            // Filtrar solo equipos disponibles
            const equiposDisponibles = data.filter(item => 
                item.disponibilidad === 'Disponible' || item.estado === 'Bueno'
            );
            
            equiposDisponibles.forEach(item => {
                const row = document.createElement('tr');
                
                // Mapear campos según la categoría
                let numero = '';
                let id = '';
                
                switch(categoria) {
                    case 'pc_torre':
                        numero = item.numero_pc || '';
                        id = item.id_pc_torre || item.id || '';
                        break;
                    case 'todo_en_uno':
                        numero = item.numero_pc || '';
                        id = item.id_todo_en_uno || item.id || '';
                        break;
                    case 'portatiles':
                        numero = item.numero_pc || '';
                        id = item.id_portatil || item.id || '';
                        break;
                    case 'impresoras':
                        numero = item.numero_impresora || '';
                        id = item.id_impresora || item.id || '';
                        break;
                    case 'escaneres':
                        numero = item.numero_escaner || '';
                        id = item.id_escaner || item.id || '';
                        break;
                    case 'herramientas':
                        numero = item.numero_herramienta || item.item || '';
                        id = item.id_herramienta || item.id || '';
                        break;
                }
                
                row.innerHTML = `
                    <td>${numero}</td>
                    <td>${item.marca || ''}</td>
                    <td>${item.modelo || ''}</td>
                    <td>${item.serial || ''}</td>
                    <td>${item.numero_activo || ''}</td>
                    <td>${item.estado || ''}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="seleccionarEquipoPrestamo('${categoria}', ${id}, 'prestamo')">
                            Seleccionar
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Error al cargar datos: ${error.message}</td></tr>`;
        });
}

// Función para generar formularios dinámicos de items
function generarFormulariosItems(cantidad) {
    const container = document.getElementById('items_container');
    container.innerHTML = '<h6 class="border-bottom pb-2 mb-3">Items Seleccionados</h6>';
    
    for (let i = 0; i < cantidad; i++) {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'row mb-3 p-3 border rounded';
        itemDiv.innerHTML = `
            <div class="col-12 mb-2">
                <h6 class="text-primary">Item ${i + 1}</h6>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Item</label>
                    <input type="text" class="form-control" name="item_${i}" id="item_${i}" required readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Dispositivo</label>
                    <input type="text" class="form-control" name="dispositivo_${i}" id="dispositivo_${i}" required readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Marca/Modelo</label>
                    <input type="text" class="form-control" name="marca_modelo_${i}" id="marca_modelo_${i}" required readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Activo</label>
                    <input type="text" class="form-control" name="activo_${i}" id="activo_${i}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Serial</label>
                    <input type="text" class="form-control" name="serial_${i}" id="serial_${i}" required readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Estado</label>
                    <input type="text" class="form-control" name="estado_${i}" id="estado_${i}" required readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>MAC</label>
                    <input type="text" class="form-control" name="mac_${i}" id="mac_${i}">
                </div>
            </div>
            <input type="hidden" name="equipo_id_${i}" id="equipo_id_${i}">
            <input type="hidden" name="equipo_tipo_${i}" id="equipo_tipo_${i}">
        `;
        container.appendChild(itemDiv);
    }
}

// Función para seleccionar un equipo del inventario
function seleccionarEquipo(categoria, id, tipo) {
    // Mapear categorías a métodos del controlador
    const metodoMap = {
        'pc_torre': 'getPcTorreById',
        'todo_en_uno': 'getTodoEnUnoById',
        'portatiles': 'getPortatilById',
        'impresoras': 'getImpresoraById',
        'escaneres': 'getEscanerById',
        'herramientas': 'getHerramientaById'
    };
    
    const metodo = metodoMap[categoria];
    if (!metodo) return;
    
    // Hacer petición AJAX para obtener detalles del equipo
    fetch(`${base_url}/psi/${metodo}/${id}`)
        .then(res => res.json())
        .then(response => {
            if (response.status && response.data) {
                const data = response.data;
                
                // Mapear campos según la categoría
                let numero = '';
                switch(categoria) {
                    case 'pc_torre':
                        numero = data.numero_pc || '';
                        break;
                    case 'todo_en_uno':
                        numero = data.numero_pc || '';
                        break;
                    case 'portatiles':
                        numero = data.numero_pc || '';
                        break;
                    case 'impresoras':
                        numero = data.numero_impresora || '';
                        break;
                    case 'escaneres':
                        numero = data.numero_escaner || '';
                        break;
                    case 'herramientas':
                        numero = data.numero_herramienta || data.item || '';
                        break;
                }
                
                // Llenar los campos del formulario según el tipo
                document.querySelector(`[name="item"]`).value = numero;
                document.querySelector(`[name="descripcion_dispositivo"]`).value = `${categoria.charAt(0).toUpperCase() + categoria.slice(1)} - ${data.marca || ''} ${data.modelo || ''}`;
                document.querySelector(`[name="marca"]`).value = data.marca || '';
                document.querySelector(`[name="modelo"]`).value = data.modelo || '';
                document.querySelector(`[name="numero_activo"]`).value = data.numero_activo || '';
                document.querySelector(`[name="serial"]`).value = data.serial || '';
                document.getElementById(`equipo_id_${tipo}`).value = id;
                document.getElementById(`equipo_tipo_${tipo}`).value = categoria;
                
                Swal.fire({
                    icon: 'success',
                    title: 'Equipo Seleccionado',
                    text: 'Equipo agregado correctamente',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Error al obtener los detalles del equipo: ${error.message}`
            });
        });
}

// Función para seleccionar un equipo del inventario para préstamos
function seleccionarEquipoPrestamo(categoria, id, tipo) {
    // Mapear categorías a métodos del controlador
    const metodoMap = {
        'pc_torre': 'getPcTorreById',
        'todo_en_uno': 'getTodoEnUnoById',
        'portatiles': 'getPortatilById',
        'impresoras': 'getImpresoraById',
        'escaneres': 'getEscanerById',
        'herramientas': 'getHerramientaById'
    };
    
    const metodo = metodoMap[categoria];
    if (!metodo) {
        return;
    }
    
    // Hacer petición AJAX para obtener detalles del equipo
    fetch(`${base_url}/psi/${metodo}/${id}`)
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(response => {
            
            if (response.status && response.data) {
                const data = response.data;
                
                // Encontrar el próximo item vacío
                const cantidadItems = document.getElementById('cantidad_items').value;
                let itemIndex = -1;
                
                for (let i = 0; i < cantidadItems; i++) {
                    const itemField = document.getElementById(`item_${i}`);
                    if (itemField && !itemField.value) {
                        itemIndex = i;
                        break;
                    }
                }
                
                if (itemIndex === -1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Aviso',
                        text: 'Todos los items ya han sido seleccionados. Cambia la cantidad de items si necesitas agregar más.'
                    });
                    return;
                }
                
                // Mapear campos según la categoría
                let numero = '';
                switch(categoria) {
                    case 'pc_torre':
                        numero = data.numero_pc || '';
                        break;
                    case 'todo_en_uno':
                        numero = data.numero_pc || '';
                        break;
                    case 'portatiles':
                        numero = data.numero_pc || '';
                        break;
                    case 'impresoras':
                        numero = data.numero_impresora || '';
                        break;
                    case 'escaneres':
                        numero = data.numero_escaner || '';
                        break;
                    case 'herramientas':
                        numero = data.numero_herramienta || data.item || '';
                        break;
                }
                
                // Llenar los campos del formulario
                document.getElementById(`item_${itemIndex}`).value = numero;
                document.getElementById(`dispositivo_${itemIndex}`).value = `${categoria.charAt(0).toUpperCase() + categoria.slice(1)} - ${data.marca || ''} ${data.modelo || ''}`;
                document.getElementById(`marca_modelo_${itemIndex}`).value = `${data.marca || ''} ${data.modelo || ''}`;
                document.getElementById(`activo_${itemIndex}`).value = data.numero_activo || '';
                document.getElementById(`serial_${itemIndex}`).value = data.serial || '';
                document.getElementById(`estado_${itemIndex}`).value = data.estado || '';
                document.getElementById(`mac_${itemIndex}`).value = data.mac || '';
                document.getElementById(`equipo_id_${itemIndex}`).value = id;
                document.getElementById(`equipo_tipo_${itemIndex}`).value = categoria;
                
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Equipo Seleccionado',
                    text: `Equipo agregado al item ${itemIndex + 1}`,
                    timer: 2000,
                    showConfirmButton: false
                });
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg || 'Error al obtener los detalles del equipo'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Error al obtener los detalles del equipo: ${error.message}`
            });
        });
}

// Función para cargar datos del inventario
function cargarDatosInventario(tipo) {
    // Cargar PC Torre
    cargarTablaInventario('pc_torre', tipo);
    // Cargar Todo en Uno
    cargarTablaInventario('todo_en_uno', tipo);
    // Cargar Portátiles
    cargarTablaInventario('portatiles', tipo);
    // Cargar Impresoras
    cargarTablaInventario('impresoras', tipo);
    // Cargar Escáneres
    cargarTablaInventario('escaneres', tipo);
    // Cargar Herramientas
    cargarTablaInventario('herramientas', tipo);
}

// Función para cargar una tabla específica del inventario
function cargarTablaInventario(categoria, tipo) {
    // Mapear categorías a IDs de tabla correctos
    const tablaIdMap = {
        'pc_torre': `tablaPcTorre${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'todo_en_uno': `tablaTodoEnUno${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'portatiles': `tablaPortatiles${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'impresoras': `tablaImpresoras${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'escaneres': `tablaEscaneres${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
        'herramientas': `tablaHerramientas${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`
    };
    
    const tablaId = tablaIdMap[categoria];
    const tbody = document.querySelector(`#${tablaId} tbody`);
    
    if (!tbody) {
        console.error(`No se encontró el tbody para la tabla: ${tablaId}`);
        return;
    }
    
    // Limpiar tabla
    tbody.innerHTML = '';
    
    // Mapear categorías a métodos del controlador
    const metodoMap = {
        'pc_torre': 'getPcTorre',
        'todo_en_uno': 'getTodoEnUno',
        'portatiles': 'getPortatiles',
        'impresoras': 'getImpresoras',
        'escaneres': 'getEscaneres',
        'herramientas': 'getHerramientas'
    };
    
    const metodo = metodoMap[categoria];
    if (!metodo) {
        return;
    }
    
    // Hacer petición AJAX para obtener datos
    fetch(`${base_url}/psi/${metodo}`)
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            if (!Array.isArray(data)) {
                return;
            }
            
            data.forEach(item => {
                const row = document.createElement('tr');
                
                // Mapear campos según la categoría
                let numero = '';
                let id = '';
                
                switch(categoria) {
                    case 'pc_torre':
                        numero = item.numero_pc || '';
                        id = item.id_pc_torre || item.id || '';
                        break;
                    case 'todo_en_uno':
                        numero = item.numero_pc || '';
                        id = item.id_todo_en_uno || item.id || '';
                        break;
                    case 'portatiles':
                        numero = item.numero_pc || '';
                        id = item.id_portatil || item.id || '';
                        break;
                    case 'impresoras':
                        numero = item.numero_impresora || '';
                        id = item.id_impresora || item.id || '';
                        break;
                    case 'escaneres':
                        numero = item.numero_escaner || '';
                        id = item.id_escaner || item.id || '';
                        break;
                    case 'herramientas':
                        numero = item.numero_herramienta || item.item || '';
                        id = item.id_herramienta || item.id || '';
                        break;
                }
                
                row.innerHTML = `
                    <td>${numero}</td>
                    <td>${item.marca || ''}</td>
                    <td>${item.modelo || ''}</td>
                    <td>${item.serial || ''}</td>
                    <td>${item.numero_activo || ''}</td>
                    <td>${item.estado || ''}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="seleccionarEquipo('${categoria}', ${id}, '${tipo}')">
                            Seleccionar
                        </button>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Error al cargar datos: ${error.message}</td></tr>`;
        });
}

// Función para seleccionar un equipo del inventario
function seleccionarEquipo(categoria, id, tipo) {
    console.log(`Seleccionando equipo: ${categoria}, ID: ${id}, Tipo: ${tipo}`);
    
    // Mapear categorías a métodos del controlador
    const metodoMap = {
        'pc_torre': 'getPcTorreById',
        'todo_en_uno': 'getTodoEnUnoById',
        'portatiles': 'getPortatilById',
        'impresoras': 'getImpresoraById',
        'escaneres': 'getEscanerById',
        'herramientas': 'getHerramientaById'
    };
    
    const metodo = metodoMap[categoria];
    if (!metodo) {
        return;
    }
    
    // Hacer petición AJAX para obtener detalles del equipo
    fetch(`${base_url}/psi/${metodo}/${id}`)
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(response => {
            if (response.status && response.data) {
                const data = response.data;
                
                // Mapear campos según la categoría
                let numero = '';
                switch(categoria) {
                    case 'pc_torre':
                        numero = data.numero_pc || '';
                        break;
                    case 'todo_en_uno':
                        numero = data.numero_pc || '';
                        break;
                    case 'portatiles':
                        numero = data.numero_pc || '';
                        break;
                    case 'impresoras':
                        numero = data.numero_impresora || '';
                        break;
                    case 'escaneres':
                        numero = data.numero_escaner || '';
                        break;
                    case 'herramientas':
                        numero = data.numero_herramienta || data.item || '';
                        break;
                }
                
                // Llenar los campos del formulario según el tipo
                if (tipo === 'salida') {
                    const itemField = document.querySelector('[name="item_salida"]');
                    const descField = document.querySelector('[name="descripcion_dispositivo_salida"]');
                    const marcaField = document.querySelector('[name="marca_salida"]');
                    const modeloField = document.querySelector('[name="modelo_salida"]');
                    const activoField = document.querySelector('[name="numero_activo_salida"]');
                    const serialField = document.querySelector('[name="serial_salida"]');
                    const equipoIdField = document.querySelector('[name="equipo_id_salida"]');
                    const equipoTipoField = document.querySelector('[name="equipo_tipo_salida"]');
                    
                    if (itemField) itemField.value = numero;
                    if (descField) descField.value = `${categoria.charAt(0).toUpperCase() + categoria.slice(1)} - ${data.marca || ''} ${data.modelo || ''}`;
                    if (marcaField) marcaField.value = data.marca || '';
                    if (modeloField) modeloField.value = data.modelo || '';
                    if (activoField) activoField.value = data.numero_activo || '';
                    if (serialField) serialField.value = data.serial || '';
                    if (equipoIdField) equipoIdField.value = id;
                    if (equipoTipoField) equipoTipoField.value = categoria;
                } else if (tipo === 'ingreso') {
                    const itemField = document.querySelector('[name="item_ingreso"]');
                    const descField = document.querySelector('[name="descripcion_dispositivo_ingreso"]');
                    const marcaField = document.querySelector('[name="marca_ingreso"]');
                    const modeloField = document.querySelector('[name="modelo_ingreso"]');
                    const activoField = document.querySelector('[name="numero_activo_ingreso"]');
                    const serialField = document.querySelector('[name="serial_ingreso"]');
                    const equipoIdField = document.querySelector('[name="equipo_id_ingreso"]');
                    const equipoTipoField = document.querySelector('[name="equipo_tipo_ingreso"]');
                    
                    if (itemField) itemField.value = numero;
                    if (descField) descField.value = `${categoria.charAt(0).toUpperCase() + categoria.slice(1)} - ${data.marca || ''} ${data.modelo || ''}`;
                    if (marcaField) marcaField.value = data.marca || '';
                    if (modeloField) modeloField.value = data.modelo || '';
                    if (activoField) activoField.value = data.numero_activo || '';
                    if (serialField) serialField.value = data.serial || '';
                    if (equipoIdField) equipoIdField.value = id;
                    if (equipoTipoField) equipoTipoField.value = categoria;
                } else {
                    // Para otros tipos (prestamo, etc.)
                    const itemField = document.querySelector(`[name="item_${tipo}"]`);
                    const descField = document.querySelector(`[name="descripcion_dispositivo_${tipo}"]`);
                    const marcaField = document.querySelector(`[name="marca_${tipo}"]`);
                    const modeloField = document.querySelector(`[name="modelo_${tipo}"]`);
                    const activoField = document.querySelector(`[name="numero_activo_${tipo}"]`);
                    const serialField = document.querySelector(`[name="serial_${tipo}"]`);
                    
                    if (itemField) itemField.value = numero;
                    if (descField) descField.value = `${categoria.charAt(0).toUpperCase() + categoria.slice(1)} - ${data.marca || ''} ${data.modelo || ''}`;
                    if (marcaField) marcaField.value = data.marca || '';
                    if (modeloField) modeloField.value = data.modelo || '';
                    if (activoField) activoField.value = data.numero_activo || '';
                    if (serialField) serialField.value = data.serial || '';
                }
                
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Equipo Seleccionado',
                    text: 'Los datos del equipo han sido cargados automáticamente',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Ocultar el tab de inventario
                let inventarioTab;
                if (tipo === 'salida') {
                    inventarioTab = document.getElementById('inventario_tab_salida');
                } else if (tipo === 'ingreso') {
                    inventarioTab = document.getElementById('inventario_tab_ingreso');
                } else {
                    inventarioTab = document.getElementById(`inventario_tab_${tipo}`);
                }
                if (inventarioTab) {
                    inventarioTab.style.display = 'none';
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg || 'Error al obtener los detalles del equipo'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Error al obtener los detalles del equipo: ${error.message}`
            });
        });
} 