// functions_inventario.js

let tblImpresoras;
let tblEscaneres;
let tblPapeleria;
let tblTintasToner;
let tblPcTorre;
let tblTodoEnUno;
let tblPortatiles;
let tblHerramientas;
let currentForm = 'impresora';
let funcionariosPlanta = [];

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTables
    initDataTables();
    
    // Cargar listas de selección
    loadDependencias();
    loadFuncionarios();
    loadCargos();
    loadContactos();
    
    // Event listeners
    setupEventListeners();
});

function initDataTables() {
    // DataTable para Impresoras
    if (tblImpresoras === undefined) {
        tblImpresoras = $('#tablaImpresoras').DataTable({
            "processing": true,
            "serverSide": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": base_url + "/Inventario/getImpresoras",
                "dataSrc": ""
            },
            "columns": [
                { "data": "numero_impresora" },
                { "data": "marca" },
                { "data": "modelo" },
                { "data": "serial" },
                { "data": "consumible" },
                { 
                    "data": "estado",
                    "render": function(data, type, row) {
                        if (data == 'Bueno') {
                            return '<span class="badge text-bg-success">Bueno</span>';
                        } else if (data == 'Regular') {
                            return '<span class="badge text-bg-warning">Regular</span>';
                        } else if (data == 'De baja') {
                            return '<span class="badge text-bg-danger">De baja</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    "data": "disponibilidad",
                    "render": function(data, type, row) {
                        if (data == 'Disponible') {
                            return '<span class="badge text-bg-success">Disponible</span>';
                        } else if (data == 'No Disponible') {
                            return '<span class="badge text-bg-danger">No Disponible</span>';
                        }
                    }
                },
                { "data": "nombre_dependencia" },
                { "data": "oficina" },
                { "data": "nombre_funcionario" },
                { "data": "nombre_cargo" },
                { "data": "nombre_contacto" },
                { 
                    "data": "id_impresora",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editImpresora(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delImpresora(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button>`;
                        return buttons;
                    }
                }
            ],
            "responsive": true,
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[0, "asc"]]
        });
    }

    // DataTable para Escáneres
    if (tblEscaneres === undefined) {
        tblEscaneres = $('#tablaEscaneres').DataTable({
            "processing": true,
            "serverSide": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": base_url + "/Inventario/getEscaneres",
                "dataSrc": ""
            },
            "columns": [
                { "data": "numero_escaner" },
                { "data": "marca" },
                { "data": "modelo" },
                { "data": "serial" },
                { "data": "estado" },
                { "data": "disponibilidad" },
                { "data": "nombre_dependencia" },
                { "data": "oficina" },
                { "data": "nombre_funcionario" },
                { "data": "nombre_cargo" },
                { "data": "nombre_contacto" },
                { 
                    "data": "id_escaner",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editEscaner(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delEscaner(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button>`;
                        return buttons;
                    }
                }
            ],
            "responsive": true,
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[0, "asc"]]
        });
    }

    // DataTable para Papelería
    if ($.fn.DataTable.isDataTable('#tablaPapeleria')) {
        $('#tablaPapeleria').DataTable().destroy();
    }
    tblPapeleria = $('#tablaPapeleria').DataTable({
        "processing": true,
        "serverSide": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/Inventario/getPapeleria",
            "dataSrc": ""
        },
        "columns": [
            { "data": "item" },
            { "data": "disponibilidad" },
            { "data": "options", "orderable": false, "searchable": false }
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });

    // DataTable para Tintas y Tóner
    if ($.fn.DataTable.isDataTable('#tablaTintasToner')) {
        $('#tablaTintasToner').DataTable().destroy();
    }
    tblTintasToner = $('#tablaTintasToner').DataTable({
        "processing": true,
        "serverSide": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/Inventario/getTintasToner",
            "dataSrc": ""
        },
        "columns": [
            { "data": "item" },
            { "data": "disponibles" },
            { "data": "impresora" },
            { "data": "modelos_compatibles" },
            { "data": "options", "orderable": false, "searchable": false }
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });

    // DataTable para PC Torre
    if (tblPcTorre === undefined) {
        tblPcTorre = $('#tablaPcTorre').DataTable({
            "processing": true,
            "serverSide": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": base_url + "/Inventario/getPcTorre",
                "dataSrc": ""
            },
            "columns": [
                { "data": "numero_pc" },
                { "data": "marca" },
                { "data": "serial" },
                { "data": "modelo" },
                { "data": "ram" },
                { "data": "velocidad_ram" },
                { "data": "procesador" },
                { "data": "velocidad_procesador" },
                { "data": "disco_duro" },
                { "data": "capacidad" },
                { "data": "sistema_operativo" },
                { "data": "numero_activo" },
                { "data": "monitor" },
                { "data": "numero_activo_monitor" },
                { "data": "serial_monitor" },
                { "data": "estado" },
                { "data": "disponibilidad" },
                { "data": "nombre_dependencia" },
                { "data": "oficina" },
                { "data": "nombre_funcionario" },
                { "data": "nombre_cargo" },
                { "data": "nombre_contacto" },
                { 
                    "data": "id_pc_torre",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editPcTorre(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delPcTorre(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button>`;
                        return buttons;
                    }
                }
            ],
            "responsive": true,
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[0, "asc"]]
        });
    }

    // DataTable para PC Todo en Uno
    if (tblTodoEnUno === undefined) {
        tblTodoEnUno = $('#tablaTodoEnUno').DataTable({
            "processing": true,
            "serverSide": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": base_url + "/Inventario/getTodoEnUno",
                "dataSrc": ""
            },
            "columns": [
                { "data": "numero_pc" },
                { "data": "marca" },
                { "data": "modelo" },
                { "data": "ram" },
                { "data": "velocidad_ram" },
                { "data": "procesador" },
                { "data": "velocidad_procesador" },
                { "data": "disco_duro" },
                { "data": "capacidad" },
                { "data": "serial" },
                { "data": "sistema_operativo" },
                { "data": "numero_activo" },
                { "data": "estado" },
                { "data": "disponibilidad" },
                { "data": "nombre_dependencia" },
                { "data": "oficina" },
                { "data": "nombre_funcionario" },
                { "data": "nombre_cargo" },
                { "data": "nombre_contacto" },
                { 
                    "data": "id_pc_todo_en_uno",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editTodoEnUno(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delTodoEnUno(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button>`;
                        return buttons;
                    }
                }
            ],
            "responsive": true,
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[0, "asc"]]
        });
    }

    // DataTable para Portátiles
    if (tblPortatiles === undefined) {
        tblPortatiles = $('#tablaPortatiles').DataTable({
            "processing": true,
            "serverSide": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": base_url + "/Inventario/getPortatiles",
                "dataSrc": ""
            },
            "columns": [
                { "data": "numero_pc" },
                { "data": "marca" },
                { "data": "modelo" },
                { "data": "ram" },
                { "data": "velocidad_ram" },
                { "data": "procesador" },
                { "data": "velocidad_procesador" },
                { "data": "disco_duro" },
                { "data": "capacidad" },
                { "data": "serial" },
                { "data": "sistema_operativo" },
                { "data": "numero_activo" },
                { "data": "estado" },
                { "data": "disponibilidad" },
                { "data": "nombre_dependencia" },
                { "data": "oficina" },
                { "data": "nombre_funcionario" },
                { "data": "nombre_cargo" },
                { "data": "nombre_contacto" },
                { 
                    "data": "id_portatil",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editPortatil(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delPortatil(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button>`;
                        return buttons;
                    }
                }
            ],
            "responsive": true,
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[0, "asc"]]
        });
    }

    // DataTable para Herramientas
    if ($.fn.DataTable.isDataTable('#tablaHerramientas')) {
        $('#tablaHerramientas').DataTable().destroy();
    }
    tblHerramientas = $('#tablaHerramientas').DataTable({
        "processing": true,
        "serverSide": false,
        "language": {
            "url": "./es.json"
        },
        "ajax": {
            "url": base_url + "/Inventario/getHerramientas",
            "dataSrc": "",
            "error": function(xhr, error, code) {
                console.log('Error en AJAX:', xhr.responseText);
            }
        },
        "columns": [
            { "data": "item" },
            { "data": "marca" },
            { "data": "disponibilidad" },
            { "data": "options", "orderable": false, "searchable": false }
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

function setupEventListeners() {
    // Botón de acción del modal
    document.getElementById('btnActionForm').addEventListener('click', function() {
        if (currentForm === 'impresora') {
            saveImpresora();
        } else if (currentForm === 'escaner') {
            saveEscaner();
        } else if (currentForm === 'papeleria') {
            saveArticuloPapeleria();
        } else if (currentForm === 'tinta_toner') {
            saveTintaToner();
        } else if (currentForm === 'pc_torre') {
            savePcTorre();
        } else if (currentForm === 'todoEnUno') {
            saveTodoEnUno();
        } else if (currentForm === 'portatil') {
            savePortatil();
        } else if (currentForm === 'herramienta') {
            saveHerramienta();
        }
    });

    // Cambio de pestañas
    document.getElementById('impresoras-tab').addEventListener('click', function() {
        currentForm = 'impresora';
        showForm('impresora');
    });

    document.getElementById('escaneres-tab').addEventListener('click', function() {
        currentForm = 'escaner';
        showForm('escaner');
    });

    document.getElementById('papeleria-tab').addEventListener('click', function() {
        currentForm = 'papeleria';
        showForm('papeleria');
    });

    document.getElementById('tintas-toner-tab').addEventListener('click', function() {
        currentForm = 'tinta_toner';
        showForm('tinta_toner');
    });

    document.getElementById('pc-torre-tab').addEventListener('click', function() {
        currentForm = 'pc_torre';
        showForm('pc_torre');
    });

    document.getElementById('todo-en-uno-tab').addEventListener('click', function() {
        currentForm = 'todoEnUno';
        showForm('todoEnUno');
    });

    document.getElementById('portatiles-tab').addEventListener('click', function() {
        currentForm = 'portatil';
        showForm('portatil');
    });

    document.getElementById('herramientas-tab').addEventListener('click', function() {
        currentForm = 'herramienta';
        showForm('herramienta');
    });
}

// ==================== FUNCIONES DE CARGA ====================

function loadDependencias() {
    fetch(base_url + '/Inventario/getDependencias')
        .then(response => response.json())
        .then(data => {
            const selects = ['listDependencia', 'listDependenciaEscaner', 'listDependenciaPapeleria'];
            selects.forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    select.innerHTML = '<option value="">Seleccione...</option>';
                    data.forEach(item => {
                        select.innerHTML += `<option value="${item.id_dependencia}">${item.nombre_dependencia}</option>`;
                    });
                }
            });
        })
        .catch(error => console.error('Error:', error));
}

function loadFuncionarios() {
    fetch(base_url + '/Inventario/getFuncionarios')
        .then(response => response.json())
        .then(data => {
            funcionariosPlanta = data; // Guardar el array completo para uso posterior
            const selects = ['listFuncionario', 'listFuncionarioEscaner', 'listFuncionarioPapeleria'];
            selects.forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    select.innerHTML = '<option value="">Seleccione...</option>';
                    data.forEach(item => {
                        select.innerHTML += `<option value="${item.id_funcionario}">${item.nombre_completo}</option>`;
                    });
                }
            });
        })
        .catch(error => console.error('Error:', error));
}

function loadCargos() {
    fetch(base_url + '/Inventario/getCargos')
        .then(response => response.json())
        .then(data => {
            const selects = ['listCargo', 'listCargoEscaner', 'listCargoPapeleria'];
            selects.forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    select.innerHTML = '<option value="">Seleccione...</option>';
                    data.forEach(item => {
                        select.innerHTML += `<option value="${item.id_cargo}">${item.nombre_cargo}</option>`;
                    });
                }
            });
        })
        .catch(error => console.error('Error:', error));
}

function loadContactos() {
    fetch(base_url + '/Inventario/getContactos')
        .then(response => response.json())
        .then(data => {
            const selects = ['listContacto', 'listContactoEscaner', 'listContactoPapeleria'];
            selects.forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    select.innerHTML = '<option value="">Seleccione...</option>';
                    data.forEach(item => {
                        select.innerHTML += `<option value="${item.id_contacto}">${item.nombre_contacto}</option>`;
                    });
                }
            });
        })
        .catch(error => console.error('Error:', error));
}

// ==================== FUNCIONES DE MODAL ====================

function showForm(type) {
    // Ocultar todos los formularios
    $('form[id^="form"]').hide();
    
    // Mostrar el formulario correspondiente
    switch(type) {
        case 'impresora':
            $('#formImpresora').show();
            break;
        case 'escaner':
            $('#formEscaner').show();
            break;
        case 'papeleria':
            $('#formPapeleria').show();
            break;
        case 'tinta_toner':
            $('#formTintaToner').show();
            break;
        case 'pc_torre':
            $('#formPcTorre').show();
            break;
        case 'todoEnUno':
            $('#formTodoEnUno').show();
            break;
        case 'portatil':
            $('#formPortatil').show();
            break;
        case 'herramienta':
            $('#formHerramienta').show();
            break;
    }
}

function openModalImpresora() {
    currentForm = 'impresora';
    showForm('impresora');
    document.getElementById('modalInventarioLabel').textContent = 'Nueva Impresora';
    document.getElementById('formImpresora').reset();
    document.getElementById('idImpresora').value = '';
    $('#modalInventario').modal('show');
}

function openModalEscaner() {
    currentForm = 'escaner';
    showForm('escaner');
    document.getElementById('modalInventarioLabel').textContent = 'Nuevo Escáner';
    document.getElementById('formEscaner').reset();
    document.getElementById('idEscaner').value = '';
    $('#modalInventario').modal('show');
}

function openModalPapeleria() {
    currentForm = 'papeleria';
    showForm('papeleria');
    document.getElementById('modalInventarioLabel').textContent = 'Nuevo Artículo de Papelería';
    document.getElementById('formPapeleria').reset();
    document.getElementById('idPapeleria').value = '';
    $('#modalInventario').modal('show');
}

function openModalTintaToner() {
    currentForm = 'tinta_toner';
    showForm('tinta_toner');
    document.getElementById('modalInventarioLabel').textContent = 'Nuevo Tinta/Tóner';
    document.getElementById('formTintaToner').reset();
    document.getElementById('idTintaToner').value = '';
    $('#modalInventario').modal('show');
}

function openModalPcTorre() {
    currentForm = 'pc_torre';
    showForm('pc_torre');
    document.getElementById('modalInventarioLabel').textContent = 'Nuevo PC Torre';
    document.getElementById('formPcTorre').reset();
    document.getElementById('idPcTorre').value = '';
    $('#modalInventario').modal('show');
}

function openModalTodoEnUno() {
    currentForm = 'todoEnUno';
    showForm('todoEnUno');
    $('#modalInventario').modal('show');
}

function openModalPortatil() {
    currentForm = 'portatil';
    showForm('portatil');
    $('#modalInventario').modal('show');
}

function openModalHerramienta() {
    currentForm = 'herramienta';
    showForm('herramienta');
    document.getElementById('modalInventarioLabel').textContent = 'Nueva Herramienta';
    document.getElementById('formHerramienta').reset();
    document.getElementById('idHerramienta').value = '';
    $('#modalInventario').modal('show');
}

// ==================== FUNCIONES DE IMPRESORAS ====================

function editImpresora(idImpresora) {
    fetch(base_url + '/Inventario/getImpresora/' + idImpresora)
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos del servidor:', data);
            if (data.status) {
                const impresora = data.data;
                console.log('Datos de la impresora:', impresora);
                console.log('Estado:', impresora.estado);
                console.log('Disponibilidad:', impresora.disponibilidad);
                currentForm = 'impresora';
                showForm('impresora');
                
                document.getElementById('modalInventarioLabel').textContent = 'Editar Impresora';
                document.getElementById('idImpresora').value = impresora.id_impresora;
                document.getElementById('txtNumeroImpresora').value = impresora.numero_impresora;
                document.getElementById('txtMarca').value = impresora.marca;
                document.getElementById('txtModelo').value = impresora.modelo;
                document.getElementById('txtSerial').value = impresora.serial;
                document.getElementById('txtConsumible').value = impresora.consumible;
                $('#txtEstado').val(impresora.estado || '');
                $('#txtDisponibilidad').val(impresora.disponibilidad || '');
                document.getElementById('txtDependencia').value = impresora.nombre_dependencia || '';
                document.getElementById('listDependencia').value = impresora.id_dependencia || '';
                document.getElementById('txtOficina').value = impresora.oficina || '';
                document.getElementById('listFuncionario').value = impresora.id_funcionario || '';
                document.getElementById('txtCargo').value = impresora.nombre_cargo || '';
                document.getElementById('listCargo').value = impresora.id_cargo || '';
                document.getElementById('txtContacto').value = impresora.nombre_contacto || '';
                document.getElementById('listContacto').value = impresora.id_contacto || '';
                
                $('#modalInventario').modal('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveImpresora() {
    console.log('=== INICIANDO GUARDADO DE IMPRESORA ===');
    
    // Validación detallada de campos
    const campos = {
        'txtNumeroImpresora': $('#txtNumeroImpresora').val(),
        'txtMarca': $('#txtMarca').val(),
        'txtModelo': $('#txtModelo').val(),
        'txtSerial': $('#txtSerial').val(),
        'txtConsumible': $('#txtConsumible').val(),
        'txtEstado': $('#txtEstado').val(),
        'txtDisponibilidad': $('#txtDisponibilidad').val(),
        'listDependencia': $('#listDependencia').val(),
        'txtOficina': $('#txtOficina').val(),
        'listFuncionario': $('#listFuncionario').val(),
        'listCargo': $('#listCargo').val(),
        'listContacto': $('#listContacto').val()
    };
    
    console.log('Valores de campos:', campos);
    
    // Verificar campos obligatorios
    const camposObligatorios = ['txtNumeroImpresora', 'txtMarca', 'txtModelo', 'txtEstado', 'txtDisponibilidad'];
    const camposVacios = camposObligatorios.filter(campo => !campos[campo] || campos[campo].trim() === '');
    
    if (camposVacios.length > 0) {
        console.error('Campos obligatorios vacíos:', camposVacios);
        Swal.fire({
            title: "Campos obligatorios",
            text: "Los siguientes campos son obligatorios " ,
            icon: "warning"
        });
        return;
    }
    
    if ($('#formImpresora')[0].checkValidity()) {
        const formData = $('#formImpresora').serialize();
        console.log('Datos del formulario serializado:', formData);
        
        $.ajax({
            url: base_url + '/Inventario/setImpresora',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                console.log('Enviando petición AJAX a:', base_url + '/Inventario/setImpresora');
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formImpresora')[0].reset();
                    tblImpresoras.ajax.reload();
                    Swal.fire("¡Éxito!", response.msg, "success");
                } else {
                    console.error('Error en respuesta:', response.msg);
                    Swal.fire("Error", response.msg, "error");
                }
            },
            error: function(xhr, status, error) {
                console.error('=== ERROR EN AJAX ===');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response Text:', xhr.responseText);
                console.error('Status Code:', xhr.status);
                console.error('Ready State:', xhr.readyState);
                console.error('URL:', base_url + '/Inventario/setImpresora');
                
                Swal.fire({
                    title: "Error al guardar",
                    text: "Revisa la consola para más detalles. Error: " + error,
                    icon: "error"
                });
            }
        });
    } else {
        console.log('Formulario no válido según checkValidity()');
        $('#formImpresora')[0].reportValidity();
    }
}

function delImpresora(idImpresora) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('idImpresora', idImpresora);
            
            fetch(base_url + '/Inventario/delImpresora', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    tblImpresoras.ajax.reload();
                    Swal.fire(
                        '¡Eliminado!',
                        data.msg,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        data.msg,
                        'error'
                    );
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
}

// ==================== FUNCIONES DE ESCÁNERES ====================

function editEscaner(idEscaner) {
    fetch(base_url + '/Inventario/getEscaner/' + idEscaner)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const escaner = data.data;
                currentForm = 'escaner';
                showForm('escaner');
                
                document.getElementById('modalInventarioLabel').textContent = 'Editar Escáner';
                document.getElementById('idEscaner').value = escaner.id_escaner;
                document.getElementById('txtNumeroEscaner').value = escaner.numero_escaner;
                document.getElementById('txtMarcaEscaner').value = escaner.marca;
                document.getElementById('txtModeloEscaner').value = escaner.modelo;
                document.getElementById('txtSerialEscaner').value = escaner.serial;
                document.getElementById('txtEstadoEscaner').value = escaner.estado;
                document.getElementById('txtDisponibilidadEscaner').value = escaner.disponibilidad;
                document.getElementById('listDependenciaEscaner').value = escaner.id_dependencia;
                document.getElementById('txtOficinaEscaner').value = escaner.oficina;
                document.getElementById('listFuncionarioEscaner').value = escaner.id_funcionario;
                document.getElementById('listCargoEscaner').value = escaner.id_cargo;
                document.getElementById('listContactoEscaner').value = escaner.id_contacto;
                
                $('#modalInventario').modal('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveEscaner() {
    if ($('#formEscaner')[0].checkValidity()) {
        $.ajax({
            url: base_url + '/Inventario/setEscaner',
            type: 'POST',
            data: $('#formEscaner').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formEscaner')[0].reset();
                    loadEscaneres();
                    swal.fire("¡Éxito!", response.msg, "success");
                } else {
                    swal.fire("Error", response.msg, "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Error al guardar los datos", "error");
            }
        });
    } else {
        $('#formEscaner')[0].reportValidity();
    }
}

function delEscaner(idEscaner) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('idEscaner', idEscaner);
            
            fetch(base_url + '/Inventario/delEscaner', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    tblEscaneres.ajax.reload();
                    Swal.fire(
                        '¡Eliminado!',
                        data.msg,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        data.msg,
                        'error'
                    );
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
}

// ==================== FUNCIONES DE PAPELERÍA ====================

function editArticuloPapeleria(idPapeleria) {
    fetch(base_url + '/Inventario/getArticuloPapeleria/' + idPapeleria)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const articulo = data.data;
                currentForm = 'papeleria';
                showForm('papeleria');
                
                document.getElementById('modalInventarioLabel').textContent = 'Editar Artículo de Papelería';
                document.getElementById('idPapeleria').value = articulo.id_papeleria;
                document.getElementById('txtItemPapeleria').value = articulo.item;
                document.getElementById('txtDisponibilidadPapeleria').value = articulo.disponibilidad;
                
                $('#modalInventario').modal('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveArticuloPapeleria() {
    if ($('#formPapeleria')[0].checkValidity()) {
        $.ajax({
            url: base_url + '/Inventario/setArticuloPapeleria',
            type: 'POST',
            data: $('#formPapeleria').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formPapeleria')[0].reset();
                    tblPapeleria.ajax.reload();
                    swal.fire("¡Éxito!", response.msg, "success");
                } else {
                    swal.fire("Error", response.msg, "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Error al guardar los datos", "error");
            }
        });
    } else {
        $('#formPapeleria')[0].reportValidity();
    }
}

function delArticuloPapeleria(idPapeleria) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('idPapeleria', idPapeleria);
            
            fetch(base_url + '/Inventario/delArticuloPapeleria', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    tblPapeleria.ajax.reload();
                    Swal.fire(
                        '¡Eliminado!',
                        data.msg,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        data.msg,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Error al eliminar',
                    'error'
                );
            });
        }
    });
}

// ==================== FUNCIONES DE TINTAS Y TÓNER ====================

function editTintaToner(idTintaToner) {
    fetch(base_url + '/Inventario/getTintaToner/' + idTintaToner)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const tintaToner = data.data;
                currentForm = 'tinta_toner';
                showForm('tinta_toner');
                
                document.getElementById('modalInventarioLabel').textContent = 'Editar Tinta/Tóner';
                document.getElementById('idTintaToner').value = tintaToner.id_tinta_toner;
                document.getElementById('txtItem').value = tintaToner.item;
                document.getElementById('txtDisponibles').value = tintaToner.disponibles;
                document.getElementById('txtImpresora').value = tintaToner.impresora;
                document.getElementById('txtModelosCompatibles').value = tintaToner.modelos_compatibles;
                
                $('#modalInventario').modal('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveTintaToner() {
    if ($('#formTintaToner')[0].checkValidity()) {
        $.ajax({
            url: base_url + '/Inventario/setTintaToner',
            type: 'POST',
            data: $('#formTintaToner').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formTintaToner')[0].reset();
                    tblTintasToner.ajax.reload();
                    swal.fire("¡Éxito!", response.msg, "success");
                } else {
                    swal.fire("Error", response.msg, "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Error al guardar los datos", "error");
            }
        });
    } else {
        $('#formTintaToner')[0].reportValidity();
    }
}

function delTintaToner(idTintaToner) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('idTintaToner', idTintaToner);
            
            fetch(base_url + '/Inventario/delTintaToner', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    tblTintasToner.ajax.reload();
                    Swal.fire(
                        '¡Eliminado!',
                        data.msg,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        data.msg,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Error al eliminar',
                    'error'
                );
            });
        }
    });
}

// ==================== FUNCIONES DE PC TORRE ====================

function editPcTorre(idPcTorre) {
    fetch(base_url + '/Inventario/getPcTorreById/' + idPcTorre)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const pc = data.data;
                currentForm = 'pc_torre';
                showForm('pc_torre');
                document.getElementById('modalInventarioLabel').textContent = 'Editar PC Torre';
                document.getElementById('idPcTorre').value = pc.id_pc_torre;
                document.getElementById('txtNumeroPcTorre').value = pc.numero_pc;
                document.getElementById('txtMarcaPcTorre').value = pc.marca;
                document.getElementById('txtSerialPcTorre').value = pc.serial;
                document.getElementById('txtModeloPcTorre').value = pc.modelo;
                document.getElementById('txtRamPcTorre').value = pc.ram;
                document.getElementById('txtVelocidadRamPcTorre').value = pc.velocidad_ram;
                document.getElementById('txtProcesadorPcTorre').value = pc.procesador;
                document.getElementById('txtVelocidadProcesadorPcTorre').value = pc.velocidad_procesador;
                document.getElementById('txtDiscoDuroPcTorre').value = pc.disco_duro;
                document.getElementById('txtCapacidadPcTorre').value = pc.capacidad;
                document.getElementById('txtSistemaOperativoPcTorre').value = pc.sistema_operativo;
                document.getElementById('txtNumeroActivoPcTorre').value = pc.numero_activo;
                document.getElementById('txtMonitorPcTorre').value = pc.monitor;
                document.getElementById('txtNumeroActivoMonitorPcTorre').value = pc.numero_activo_monitor;
                document.getElementById('txtSerialMonitorPcTorre').value = pc.serial_monitor;
                document.getElementById('txtEstadoPcTorre').value = pc.estado;
                document.getElementById('txtDisponibilidadPcTorre').value = pc.disponibilidad;
                document.getElementById('listDependenciaPcTorre').value = pc.id_dependencia;
                document.getElementById('txtOficinaPcTorre').value = pc.oficina;
                document.getElementById('listFuncionarioPcTorre').value = pc.id_funcionario;
                document.getElementById('listCargoPcTorre').value = pc.id_cargo;
                document.getElementById('listContactoPcTorre').value = pc.id_contacto;
                $('#modalInventario').modal('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function savePcTorre() {
    if ($('#formPcTorre')[0].checkValidity()) {
        $.ajax({
            url: base_url + '/Inventario/setPcTorre',
            type: 'POST',
            data: $('#formPcTorre').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formPcTorre')[0].reset();
                    loadPcTorre();
                    swal.fire("¡Éxito!", response.msg, "success");
                } else {
                    swal.fire("Error", response.msg, "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Error al guardar los datos", "error");
            }
        });
    } else {
        $('#formPcTorre')[0].reportValidity();
    }
}

function delPcTorre(idPcTorre) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('idPcTorre', idPcTorre);
            fetch(base_url + '/Inventario/delPcTorre', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    loadPcTorre();
                    Swal.fire(
                        '¡Eliminado!',
                        data.msg,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        data.msg,
                        'error'
                    );
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
}

// ==================== FUNCIONES DE PC TODO EN UNO ====================

function editTodoEnUno(idTodoEnUno) {
    currentForm = 'todoEnUno';
    showForm('todoEnUno');
    
    $.ajax({
        url: base_url + '/Inventario/getTodoEnUnoById/' + idTodoEnUno,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                const data = response.data;
                $('#idTodoEnUno').val(data.id_pc_todo_en_uno);
                $('#txtNumeroTodoEnUno').val(data.numero_pc);
                $('#txtMarcaTodoEnUno').val(data.marca);
                $('#txtModeloTodoEnUno').val(data.modelo);
                $('#txtRamTodoEnUno').val(data.ram);
                $('#txtVelocidadRamTodoEnUno').val(data.velocidad_ram);
                $('#txtProcesadorTodoEnUno').val(data.procesador);
                $('#txtVelocidadProcesadorTodoEnUno').val(data.velocidad_procesador);
                $('#txtDiscoDuroTodoEnUno').val(data.disco_duro);
                $('#txtCapacidadTodoEnUno').val(data.capacidad);
                $('#txtSerialTodoEnUno').val(data.serial);
                $('#txtSistemaOperativoTodoEnUno').val(data.sistema_operativo);
                $('#txtNumeroActivoTodoEnUno').val(data.numero_activo);
                $('#txtEstadoTodoEnUno').val(data.estado);
                $('#txtDisponibilidadTodoEnUno').val(data.disponibilidad);
                $('#listDependenciaTodoEnUno').val(data.id_dependencia);
                $('#txtOficinaTodoEnUno').val(data.oficina);
                $('#listFuncionarioTodoEnUno').val(data.id_funcionario);
                $('#listCargoTodoEnUno').val(data.id_cargo);
                $('#listContactoTodoEnUno').val(data.id_contacto);
                
                $('#modalInventario').modal('show');
            } else {
                swal.fire("Error", response.msg, "error");
            }
        },
        error: function() {
            swal.fire("Error", "Error al cargar los datos", "error");
        }
    });
}

function saveTodoEnUno() {
    if ($('#formTodoEnUno')[0].checkValidity()) {
        $.ajax({
            url: base_url + '/Inventario/setTodoEnUno',
            type: 'POST',
            data: $('#formTodoEnUno').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formTodoEnUno')[0].reset();
                    loadTodoEnUno();
                    swal.fire("¡Éxito!", response.msg, "success");
                } else {
                    swal.fire("Error", response.msg, "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Error al guardar los datos", "error");
            }
        });
    } else {
        $('#formTodoEnUno')[0].reportValidity();
    }
}

function delTodoEnUno(idTodoEnUno) {
    swal.fire({
        title: "¿Está seguro?",
        text: "Se eliminará el PC Todo en Uno",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: base_url + '/Inventario/delTodoEnUno',
                type: 'POST',
                data: { idTodoEnUno: idTodoEnUno },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        loadTodoEnUno();
                        swal.fire("¡Eliminado!", response.msg, "success");
                    } else {
                        swal.fire("Error", response.msg, "error");
                    }
                },
                error: function() {
                    swal.fire("Error", "Error al eliminar", "error");
                }
            });
        } else {
            swal.fire("Cancelado", "No se eliminó el registro", "info");
        }
    });
}

// ==================== PORTÁTILES ====================

function editPortatil(idPortatil) {
    currentForm = 'portatil';
    showForm('portatil');
    
    $.ajax({
        url: base_url + '/Inventario/getPortatilById/' + idPortatil,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                const data = response.data;
                $('#idPortatil').val(data.id_portatil);
                $('#txtNumeroPortatil').val(data.numero_pc);
                $('#txtMarcaPortatil').val(data.marca);
                $('#txtModeloPortatil').val(data.modelo);
                $('#txtRamPortatil').val(data.ram);
                $('#txtVelocidadRamPortatil').val(data.velocidad_ram);
                $('#txtProcesadorPortatil').val(data.procesador);
                $('#txtVelocidadProcesadorPortatil').val(data.velocidad_procesador);
                $('#txtDiscoDuroPortatil').val(data.disco_duro);
                $('#txtCapacidadPortatil').val(data.capacidad);
                $('#txtSerialPortatil').val(data.serial);
                $('#txtSistemaOperativoPortatil').val(data.sistema_operativo);
                $('#txtNumeroActivoPortatil').val(data.numero_activo);
                $('#txtEstadoPortatil').val(data.estado);
                $('#txtDisponibilidadPortatil').val(data.disponibilidad);
                $('#listDependenciaPortatil').val(data.id_dependencia);
                $('#txtOficinaPortatil').val(data.oficina);
                $('#listFuncionarioPortatil').val(data.id_funcionario);
                $('#listCargoPortatil').val(data.id_cargo);
                $('#listContactoPortatil').val(data.id_contacto);
                
                $('#modalInventario').modal('show');
            } else {
                swal.fire("Error", response.msg, "error");
            }
        },
        error: function() {
            swal.fire("Error", "Error al cargar los datos", "error");
        }
    });
}

function savePortatil() {
    if ($('#formPortatil')[0].checkValidity()) {
        $.ajax({
            url: base_url + '/Inventario/setPortatil',
            type: 'POST',
            data: $('#formPortatil').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formPortatil')[0].reset();
                    loadPortatiles();
                    swal.fire("¡Éxito!", response.msg, "success");
                } else {
                    swal.fire("Error", response.msg, "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Error al guardar los datos", "error");
            }
        });
    } else {
        $('#formPortatil')[0].reportValidity();
    }
}

function delPortatil(idPortatil) {
    swal.fire({
        title: "¿Está seguro?",
        text: "Se eliminará el portátil",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: base_url + '/Inventario/delPortatil',
                type: 'POST',
                data: { idPortatil: idPortatil },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        loadPortatiles();
                        swal.fire("¡Eliminado!", response.msg, "success");
                    } else {
                        swal.fire("Error", response.msg, "error");
                    }
                },
                error: function() {
                    swal.fire("Error", "Error al eliminar", "error");
                }
            });
        } else {
            swal.fire("Cancelado", "No se eliminó el registro", "info");
        }
    });
}

// ==================== HERRAMIENTAS ====================

function editHerramienta(idHerramienta) {
    fetch(base_url + '/Inventario/getHerramientaById/' + idHerramienta)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const herramienta = data.data;
                currentForm = 'herramienta';
                showForm('herramienta');
                
                document.getElementById('modalInventarioLabel').textContent = 'Editar Herramienta';
                document.getElementById('idHerramienta').value = herramienta.id_herramienta;
                document.getElementById('txtItemHerramienta').value = herramienta.item;
                document.getElementById('txtMarcaHerramienta').value = herramienta.marca;
                document.getElementById('txtDisponibilidadHerramienta').value = herramienta.disponibilidad;
                
                $('#modalInventario').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.msg
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar los datos'
            });
        });
}

function saveHerramienta() {
    if ($('#formHerramienta')[0].checkValidity()) {
        $.ajax({
            url: base_url + '/Inventario/setHerramienta',
            type: 'POST',
            data: $('#formHerramienta').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formHerramienta')[0].reset();
                    tblHerramientas.ajax.reload();
                    swal.fire("¡Éxito!", response.msg, "success");
                } else {
                    swal.fire("Error", response.msg, "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Error al guardar los datos", "error");
            }
        });
    } else {
        $('#formHerramienta')[0].reportValidity();
    }
}

function delHerramienta(idHerramienta) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('idHerramienta', idHerramienta);
            
            fetch(base_url + '/Inventario/delHerramienta', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    tblHerramientas.ajax.reload();
                    Swal.fire(
                        '¡Eliminado!',
                        data.msg,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        data.msg,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Error al eliminar',
                    'error'
                );
            });
        }
    });
}

// Autocompletar dependencia, cargo y contacto al seleccionar funcionario
$(document).on('change', '#listFuncionario', function() {
    const idFuncionario = $(this).val();
    const funcionario = funcionariosPlanta.find(f => f.id_funcionario == idFuncionario);
    if (funcionario) {
        $('#txtDependencia').val(funcionario.nombre_dependencia);
        $('#listDependencia').val(funcionario.id_dependencia);
        $('#txtCargo').val(funcionario.nombre_cargo);
        $('#listCargo').val(funcionario.id_cargo);
        $('#txtContacto').val(funcionario.telefono);
        $('#listContacto').val(funcionario.id_funcionario);
    } else {
        $('#txtDependencia').val('');
        $('#listDependencia').val('');
        $('#txtCargo').val('');
        $('#listCargo').val('');
        $('#txtContacto').val('');
        $('#listContacto').val('');
    }
}); 