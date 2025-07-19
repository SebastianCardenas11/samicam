// functions_inventario.js

let tblImpresoras;
let tblEscaneres;
let tblPapeleria;
let tblTintasToner;
let tblPcTorre;
let tblTodoEnUno;
let tblPortatiles;
let tblHerramientas;
let tblHistoricoGlobal;
let currentForm = 'impresora';

// ==================== FUNCIONES HELPER ====================

// Función helper para manejar respuestas de fetch de forma robusta
async function fetchJSON(url, options = {}) {
    try {
        const response = await fetch(url, options);
        
        // Verificar si la respuesta es exitosa
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Intentar parsear JSON directamente
        try {
            const jsonData = await response.json();
            return jsonData;
        } catch (jsonError) {
            // Si falla el parseo JSON, verificar el tipo de contenido
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                // Si el header dice que es JSON pero falló el parseo, mostrar el error
                const text = await response.text();
                console.error('Respuesta JSON inválida:', text.substring(0, 200));
                throw new Error('El servidor devolvió JSON inválido');
            } else {
                // Si no es JSON según el header, intentar parsear de todas formas
                const text = await response.text();
                try {
                    const jsonData = JSON.parse(text);
                    return jsonData;
                } catch (parseError) {
                    console.error('Respuesta no JSON recibida:', text.substring(0, 200));
                    throw new Error('El servidor no devolvió JSON válido');
                }
            }
        }
    } catch (error) {
        console.error('Error en fetchJSON:', error);
        throw error;
    }
}

// Configuración de idioma para DataTables
const dataTableLanguage = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
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
};

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTables
    initDataTables();
    
    // Cargar datos iniciales
    // loadDependencias(); // Eliminado - no se usa en inventario
    // loadFuncionarios(); // Eliminado - no se usa en inventario
    // loadCargos(); // Eliminado - no se usa en inventario
    
    // Event listeners
    setupEventListeners();
});

function initDataTables() {
    // DataTable para Impresoras
    if (tblImpresoras === undefined) {
        tblImpresoras = $('#tablaImpresoras').DataTable({
            "processing": true,
            "serverSide": false,
            "language": dataTableLanguage,
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
                        let estado = (data || '').toString().trim().toLowerCase();
                        if (estado === 'bueno') {
                            return '<span class="badge text-bg-success">BUENO</span>';
                        } else if (estado === 'regular') {
                            return '<span class="badge text-bg-warning">REGULAR</span>';
                        } else if (estado === 'malo') {
                            return '<span class="badge text-bg-danger">MALO</span>';
                        } else if (estado === 'de baja') {
                            return '<span class="badge text-bg-dark">DE BAJA</span>';
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
                        } else {
                            return '<span class="badge text-bg-danger">No Disponible</span>';
                        }
                    }
                },
                {
                    "data": "id_impresora",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<div class="btn-group" role="group">`;
                        buttons += `<button class="btn btn-info btn-sm" onclick="verImpresora(${data})" title="Ver"><i class="fas fa-eye"></i></button> &nbsp;`;
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editImpresora(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> &nbsp;`;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delImpresora(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button> &nbsp;`;
                        buttons += `<button class="btn btn-secondary btn-sm" onclick="cargarHistoricoMovimientos(${data}, 'impresora')" title="Ver histórico"><i class="fas fa-history"></i></button> &nbsp;`;
                        buttons += `</div>`;
                        
                        // Lógica basada en el último movimiento
                        if(row.ultimo_movimiento === 'entrada') {
                            buttons += `<button class='btn btn-danger btn-sm ' onclick='abrirModalMovimientoEquipo(${data}, "impresora", "salida")' title='Salida de mantenimiento'><i class='fas fa-sign-out-alt'></i> Salida</button> `;
                        } else {
                            buttons += `<button class='btn btn-success btn-sm ' onclick='abrirModalMovimientoEquipo(${data}, "impresora", "entrada")' title='Entrada a mantenimiento'><i class='fas fa-sign-in-alt'></i> Entrada</button> `;
                        }
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
            "language": dataTableLanguage,
            "ajax": {
                "url": base_url + "/Inventario/getEscaneres",
                "dataSrc": ""
            },
            "columns": [
                { "data": "numero_escaner" },
                { "data": "marca" },
                { "data": "modelo" },
                { "data": "serial" },
                { 
                    "data": "estado",
                    "render": function(data, type, row) {
                        let estado = (data || '').toString().trim().toLowerCase();
                        if (estado === 'bueno') {
                            return '<span class="badge text-bg-success">BUENO</span>';
                        } else if (estado === 'regular') {
                            return '<span class="badge text-bg-warning">REGULAR</span>';
                        } else if (estado === 'malo') {
                            return '<span class="badge text-bg-danger">MALO</span>';
                        } else if (estado === 'de baja') {
                            return '<span class="badge text-bg-dark">DE BAJA</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    "data": "disponibilidad",
                    "render": function(data, type, row) {
                        let disp = (data || '').toString().trim().toLowerCase();
                        if (disp === 'disponible') {
                            return '<span class="badge text-bg-success">Disponible</span>';
                        } else if (disp === 'no disponible') {
                            return '<span class="badge text-bg-danger">No Disponible</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    "data": "id_escaner",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<div class="btn-group" role="group">`;
                        buttons += `<button class="btn btn-info btn-sm" onclick="verEscaner(${data})" title="Ver"><i class="fas fa-eye"></i></button> `;
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editEscaner(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delEscaner(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button> `;
                        buttons += `<button class="btn btn-secondary btn-sm" onclick="cargarHistoricoMovimientos(${data}, 'escaner')" title="Ver histórico"><i class="fas fa-history"></i></button>`;
                        buttons += `</div> `;
                        
                        // Botón Entrada/Salida según disponibilidad
                        if(row.disponibilidad.toLowerCase() === 'disponible') {
                            buttons += `<button class='btn btn-warning btn-sm mt-1' onclick='abrirModalMovimientoEquipo(${data}, "escaner", "entrada")' title='Entrada a mantenimiento'><i class='fas fa-sign-in-alt'></i> Entrada</button> `;
                        } else {
                            buttons += `<button class='btn btn-success btn-sm mt-1' onclick='abrirModalMovimientoEquipo(${data}, "escaner", "salida")' title='Salida de mantenimiento'><i class='fas fa-sign-out-alt'></i> Salida</button> `;
                        }
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
        "language": dataTableLanguage,
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
        "language": dataTableLanguage,
        "ajax": {
            "url": base_url + "/Inventario/getTintasToner",
            "dataSrc": ""
        },
        "columns": [
            { "data": "item" },
            { "data": "disponibles" },
            { "data": "numero_impresora" },
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
            "language": dataTableLanguage,
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
                { "data": "estado",
                    "render": function(data, type, row) {
                        let estado = (data || '').toString().trim();
                        if (estado === 'Bueno') {
                            return '<span class="badge text-bg-success">BUENO</span>';
                        } else if (estado === 'Regular') {
                            return '<span class="badge text-bg-warning">REGULAR</span>';
                        } else if (estado === 'Malo') {
                            return '<span class="badge text-bg-danger">MALO</span>';
                        } else if (estado === 'De Baja') {
                            return '<span class="badge text-bg-dark">DE BAJA</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { "data": "disponibilidad",
                    "render": function(data, type, row) {
                        let disp = (data || '').toString().trim();
                        if (disp === 'Disponible') {
                            return '<span class="badge text-bg-success">Disponible</span>';
                        } else if (disp === 'No Disponible') {
                            return '<span class="badge text-bg-danger">No Disponible</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    "data": "id_pc_torre",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<div class="btn-group" role="group">`;
                        buttons += `<button class="btn btn-info btn-sm" onclick="verPcTorre(${data})" title="Ver"><i class="fas fa-eye"></i></button> `;
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editPcTorre(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delPcTorre(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button> `;
                        buttons += `<button class="btn btn-secondary btn-sm" onclick="cargarHistoricoMovimientos(${data}, 'pc_torre')" title="Ver histórico"><i class="fas fa-history"></i></button>`;
                        buttons += `</div><br>`;
                        
                        // Botón Entrada/Salida según disponibilidad
                        let disp = (row.disponibilidad || '').toString().trim();
                        if (disp === 'Disponible') {
                            buttons += `<button class='btn btn-warning btn-sm w-100 mt-1' onclick='abrirModalMovimientoEquipo(${data}, "pc_torre", "entrada")' title='Entrada a mantenimiento'><i class='fas fa-sign-in-alt'></i> Entrada</button> `;
                        } else {
                            buttons += `<button class='btn btn-success btn-sm w-100 mt-1' onclick='abrirModalMovimientoEquipo(${data}, "pc_torre", "salida")' title='Salida de mantenimiento'><i class='fas fa-sign-out-alt'></i> Salida</button> `;
                        }
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
            "language": dataTableLanguage,
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
                { 
                    "data": "estado",
                    "render": function(data, type, row) {
                        let estado = (data || '').toString().trim().toLowerCase();
                        if (estado === 'bueno') {
                            return '<span class="badge text-bg-success">BUENO</span>';
                        } else if (estado === 'regular') {
                            return '<span class="badge text-bg-warning">REGULAR</span>';
                        } else if (estado === 'malo') {
                            return '<span class="badge text-bg-danger">MALO</span>';
                        } else if (estado === 'de baja') {
                            return '<span class="badge text-bg-dark">DE BAJA</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    "data": "disponibilidad",
                    "render": function(data, type, row) {
                        let disp = (data || '').toString().trim().toLowerCase();
                        if (disp === 'disponible') {
                            return '<span class="badge text-bg-success">Disponible</span>';
                        } else if (disp === 'no disponible') {
                            return '<span class="badge text-bg-danger">No Disponible</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    "data": "id_todo_en_uno",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<div class="btn-group" role="group">`;
                        buttons += `<button class="btn btn-info btn-sm" onclick="verTodoEnUno(${data})" title="Ver"><i class="fas fa-eye"></i></button> `;
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editTodoEnUno(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delTodoEnUno(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button> `;
                        buttons += `<button class="btn btn-secondary btn-sm" onclick="cargarHistoricoMovimientos(${data}, 'todo_en_uno')" title="Ver histórico"><i class="fas fa-history"></i></button>`;
                        buttons += `</div><br>`;
                        
                        // Botón Entrada/Salida según disponibilidad
                        let disp = (row.disponibilidad || '').toString().trim().toLowerCase();
                        if (disp === 'disponible') {
                            buttons += `<button class='btn btn-warning btn-sm w-100 mt-1' onclick='abrirModalMovimientoEquipo(${data}, "todo_en_uno", "entrada")' title='Entrada a mantenimiento'><i class='fas fa-sign-in-alt'></i> Entrada</button> `;
                        } else {
                            buttons += `<button class='btn btn-success btn-sm w-100 mt-1' onclick='abrirModalMovimientoEquipo(${data}, "todo_en_uno", "salida")' title='Salida de mantenimiento'><i class='fas fa-sign-out-alt'></i> Salida</button> `;
                        }
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
            "language": dataTableLanguage,
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
                { 
                    "data": "estado",
                    "render": function(data, type, row) {
                        let estado = (data || '').toString().trim().toLowerCase();
                        if (estado === 'bueno') {
                            return '<span class="badge text-bg-success">BUENO</span>';
                        } else if (estado === 'regular') {
                            return '<span class="badge text-bg-warning">REGULAR</span>';
                        } else if (estado === 'malo') {
                            return '<span class="badge text-bg-danger">MALO</span>';
                        } else if (estado === 'de baja') {
                            return '<span class="badge text-bg-dark">DE BAJA</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    "data": "disponibilidad",
                    "render": function(data, type, row) {
                        let disp = (data || '').toString().trim().toLowerCase();
                        if (disp === 'disponible') {
                            return '<span class="badge text-bg-success">Disponible</span>';
                        } else if (disp === 'no disponible') {
                            return '<span class="badge text-bg-danger">No Disponible</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">' + data + '</span>';
                        }
                    }
                },
                { 
                    "data": "id_portatil",
                    "render": function(data, type, row) {
                        let buttons = '';
                        buttons += `<div class="btn-group" role="group">`;
                        buttons += `<button class="btn btn-info btn-sm" onclick="verPortatil(${data})" title="Ver"><i class="fas fa-eye"></i></button> `;
                        buttons += `<button class="btn btn-primary btn-sm" onclick="editPortatil(${data})" title="Editar"><i class="fas fa-pencil-alt"></i></button> `;
                        buttons += `<button class="btn btn-danger btn-sm" onclick="delPortatil(${data})" title="Eliminar"><i class="fas fa-trash-alt"></i></button> `;
                        buttons += `<button class="btn btn-secondary btn-sm" onclick="cargarHistoricoMovimientos(${data}, 'portatil')" title="Ver histórico"><i class="fas fa-history"></i></button>`;
                        buttons += `</div><br>`;
                        
                        // Botón Entrada/Salida según disponibilidad
                        let disp = (row.disponibilidad || '').toString().trim().toLowerCase();
                        if (disp === 'disponible') {
                            buttons += `<button class='btn btn-warning btn-sm w-100 mt-1' onclick='abrirModalMovimientoEquipo(${data}, "portatil", "entrada")' title='Entrada a mantenimiento'><i class='fas fa-sign-in-alt'></i> Entrada</button> `;
                        } else {
                            buttons += `<button class='btn btn-success btn-sm w-100 mt-1' onclick='abrirModalMovimientoEquipo(${data}, "portatil", "salida")' title='Salida de mantenimiento'><i class='fas fa-sign-out-alt'></i> Salida</button> `;
                        }
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
        "language": dataTableLanguage,
        "ajax": {
            "url": base_url + "/Inventario/getHerramientas",
            "dataSrc": "",
            "error": function(xhr, error, code) {
                // Error en AJAX
            }
        },
        "columns": [
            { "data": "item" },
            { "data": "marca" },
            { 
                "data": "disponibilidad",
                "render": function(data, type, row) {
                    let disp = (data || '').toString().trim();
                    if (disp === 'Disponible') {
                        return '<span class="badge text-bg-success">Disponible</span>';
                    } else if (disp === 'No Disponible') {
                        return '<span class="badge text-bg-danger">No Disponible</span>';
                    } else {
                        return '<span class="badge text-bg-secondary">' + data + '</span>';
                    }
                }
            },
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

    document.getElementById('historico-tab').addEventListener('click', function() {
        initHistoricoGlobal();
        loadEstadisticas();
    });
}

// ==================== FUNCIONES DE CARGA ====================







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
    // Cargar impresoras activas en el select
    fetch(base_url + '/Inventario/getImpresorasActivas')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('selectImpresoraTintaToner');
            select.innerHTML = '<option value="">Seleccione...</option>';
            data.forEach(item => {
                select.innerHTML += `<option value="${item.id_impresora}">${item.numero_impresora}</option>`;
            });
        });
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
            if (data.status) {
                const impresora = data.data;
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
                
                $('#modalInventario').modal('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveImpresora() {
    
    // Validación detallada de campos
    const campos = {
        'txtNumeroImpresora': $('#txtNumeroImpresora').val(),
        'txtMarca': $('#txtMarca').val(),
        'txtModelo': $('#txtModelo').val(),
        'txtSerial': $('#txtSerial').val(),
        'txtConsumible': $('#txtConsumible').val(),
        'txtEstado': $('#txtEstado').val(),
        'txtDisponibilidad': $('#txtDisponibilidad').val()
    };
    
    
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
        
        $.ajax({
            url: base_url + '/Inventario/setImpresora',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                // Enviando datos
            },
            success: function(response) {
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
                    tblEscaneres.ajax.reload();
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
                document.getElementById('txtModelosCompatibles').value = tintaToner.modelos_compatibles;
                // Cargar impresoras activas y seleccionar la correspondiente
                fetch(base_url + '/Inventario/getImpresorasActivas')
                    .then(response => response.json())
                    .then(impresoras => {
                        const select = document.getElementById('selectImpresoraTintaToner');
                        select.innerHTML = '<option value="">Seleccione...</option>';
                        impresoras.forEach(item => {
                            select.innerHTML += `<option value="${item.id_impresora}">${item.numero_impresora}</option>`;
                        });
                        select.value = tintaToner.impresora; // Selecciona la impresora correspondiente
                    });
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
                $('#modalInventario').modal('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function savePcTorre() {
    if ($('#formPcTorre')[0].checkValidity()) {
        var formData = $('#formPcTorre').serialize();
        $.ajax({
            url: base_url + '/Inventario/setPcTorre',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formPcTorre')[0].reset();
                    if (typeof tblPcTorre !== 'undefined') {
                        tblPcTorre.ajax.reload(null, false);
                    }
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
                    if (typeof tblPcTorre !== 'undefined') {
                        tblPcTorre.ajax.reload(null, false);
                    }
                    Swal.fire('¡Eliminado!', data.msg, 'success');
                } else {
                    Swal.fire('Error', data.msg, 'error');
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
    // Refuerzo: asegúrate de limpiar el campo antes de llenarlo
    $('#idTodoEnUno').val('');
    $.ajax({
        url: base_url + '/Inventario/getTodoEnUnoById/' + idTodoEnUno,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                const data = response.data;
                // Refuerzo: llena el campo oculto correctamente
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
        // No resetear antes de guardar
        $.ajax({
            url: base_url + '/Inventario/setTodoEnUno',
            type: 'POST',
            data: $('#formTodoEnUno').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#modalInventario').modal('hide');
                    $('#formTodoEnUno')[0].reset();
                    if (typeof tblTodoEnUno !== 'undefined') {
                        tblTodoEnUno.ajax.reload(null, false);
                    }
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
            formData.append('idTodoEnUno', idTodoEnUno);
            fetch(base_url + '/Inventario/delTodoEnUno', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    if (typeof tblTodoEnUno !== 'undefined') {
                        tblTodoEnUno.ajax.reload(null, false);
                    }
                    Swal.fire('¡Eliminado!', data.msg, 'success');
                } else {
                    Swal.fire('Error', data.msg, 'error');
                }
            })
            .catch(error => console.error('Error:', error));
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
                const d = response.data;
                $('#idPortatil').val(d.id_portatil);
                $('#txtNumeroPortatil').val(d.numero_pc);
                $('#txtMarcaPortatil').val(d.marca);
                $('#txtModeloPortatil').val(d.modelo);
                $('#txtRamPortatil').val(d.ram);
                $('#txtVelocidadRamPortatil').val(d.velocidad_ram);
                $('#txtProcesadorPortatil').val(d.procesador);
                $('#txtVelocidadProcesadorPortatil').val(d.velocidad_procesador);
                $('#txtDiscoDuroPortatil').val(d.disco_duro);
                $('#txtCapacidadPortatil').val(d.capacidad);
                $('#txtSerialPortatil').val(d.serial);
                $('#txtSistemaOperativoPortatil').val(d.sistema_operativo);
                $('#txtNumeroActivoPortatil').val(d.numero_activo);
                $('#txtEstadoPortatil').val(d.estado);
                $('#txtDisponibilidadPortatil').val(d.disponibilidad);
                
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
                    if (typeof tblPortatiles !== 'undefined') {
                        tblPortatiles.ajax.reload(null, false);
                    }
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
            formData.append('idPortatil', idPortatil);
            fetch(base_url + '/Inventario/delPortatil', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    if (typeof tblPortatiles !== 'undefined') {
                        tblPortatiles.ajax.reload(null, false);
                    }
                    Swal.fire('¡Eliminado!', data.msg, 'success');
                } else {
                    Swal.fire('Error', data.msg, 'error');
                }
            })
            .catch(error => console.error('Error:', error));
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



// Función utilitaria para deshabilitar todos los campos de un formulario
function setFormReadOnly(formSelector, readOnly = true) {
    $(formSelector).find('input, select, textarea').prop('disabled', readOnly);
    if (readOnly) {
        $('#btnActionForm').hide();
    } else {
        $('#btnActionForm').show();
    }
}

// IMPRESORA
function verImpresora(idImpresora) {
    fetch(base_url + '/Inventario/getImpresora/' + idImpresora)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const d = data.data;
                showVerModal('Detalles de Impresora', [
                    { label: 'Número', value: d.numero_impresora },
                    { label: 'Marca', value: d.marca },
                    { label: 'Modelo', value: d.modelo },
                    { label: 'Serial', value: d.serial },
                    { label: 'Consumible', value: d.consumible },
                    { label: 'Estado', value: badgeEstado(d.estado) },
                    { label: 'Disponibilidad', value: badgeDisponibilidad(d.disponibilidad) },
                    { label: 'Acciones', value: `<button class="btn btn-secondary btn-sm mt-2" onclick="cargarHistoricoMovimientos(${idImpresora}, 'impresora')" title="Ver histórico"><i class="fas fa-history"></i> Ver histórico de movimientos</button>` }
                ]);
            }
        });
}
// ESCÁNER
function verEscaner(idEscaner) {
    fetch(base_url + '/Inventario/getEscaner/' + idEscaner)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const d = data.data;
                showVerModal('Detalles de Escáner', [
                    { label: 'Número', value: d.numero_escaner },
                    { label: 'Marca', value: d.marca },
                    { label: 'Modelo', value: d.modelo },
                    { label: 'Serial', value: d.serial },
                    { label: 'Estado', value: badgeEstado(d.estado) },
                    { label: 'Disponibilidad', value: badgeDisponibilidad(d.disponibilidad) },
                    { label: 'Acciones', value: `<button class="btn btn-secondary btn-sm mt-2" onclick="cargarHistoricoMovimientos(${idEscaner}, 'escaner')" title="Ver histórico"><i class="fas fa-history"></i> Ver histórico de movimientos</button>` }
                ]);
            }
        });
}
// PC TORRE
function verPcTorre(idPcTorre) {
    fetch(base_url + '/Inventario/getPcTorreById/' + idPcTorre)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const d = data.data;
                showVerModal('Detalles de PC Torre', [
                    { label: 'Número', value: d.numero_pc },
                    { label: 'Marca', value: d.marca },
                    { label: 'Modelo', value: d.modelo },
                    { label: 'RAM', value: d.ram },
                    { label: 'Procesador', value: d.procesador },
                    { label: 'Disco Duro', value: d.disco_duro },
                    { label: 'Capacidad', value: d.capacidad },
                    { label: 'Estado', value: badgeEstado(d.estado) },
                    { label: 'Disponibilidad', value: badgeDisponibilidad(d.disponibilidad) },
                    { label: 'Acciones', value: `<button class="btn btn-secondary btn-sm mt-2" onclick="cargarHistoricoMovimientos(${idPcTorre}, 'pc_torre')" title="Ver histórico"><i class="fas fa-history"></i> Ver histórico de movimientos</button>` }
                ]);
            }
        });
}
// TODO EN UNO
function verTodoEnUno(idTodoEnUno) {
    $.ajax({
        url: base_url + '/Inventario/getTodoEnUnoById/' + idTodoEnUno,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                const d = response.data;
                showVerModal('Detalles de PC Todo en Uno', [
                    { label: 'Número', value: d.numero_pc },
                    { label: 'Marca', value: d.marca },
                    { label: 'Modelo', value: d.modelo },
                    { label: 'RAM', value: d.ram },
                    { label: 'Procesador', value: d.procesador },
                    { label: 'Disco Duro', value: d.disco_duro },
                    { label: 'Capacidad', value: d.capacidad },
                    { label: 'Estado', value: badgeEstado(d.estado) },
                    { label: 'Disponibilidad', value: badgeDisponibilidad(d.disponibilidad) },
                    { label: 'Acciones', value: `<button class="btn btn-secondary btn-sm mt-2" onclick="cargarHistoricoMovimientos(${idTodoEnUno}, 'todo_en_uno')" title="Ver histórico"><i class="fas fa-history"></i> Ver histórico de movimientos</button>` }
                ]);
            }
        },
        error: function() {
            swal.fire("Error", "Error al cargar los datos", "error");
        }
    });
}
// PORTÁTIL
function verPortatil(idPortatil) {
    $.ajax({
        url: base_url + '/Inventario/getPortatilById/' + idPortatil,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                const d = response.data;
                showVerModal('Detalles de Portátil', [
                    { label: 'Número', value: d.numero_pc },
                    { label: 'Marca', value: d.marca },
                    { label: 'Modelo', value: d.modelo },
                    { label: 'RAM', value: d.ram },
                    { label: 'Procesador', value: d.procesador },
                    { label: 'Disco Duro', value: d.disco_duro },
                    { label: 'Capacidad', value: d.capacidad },
                    { label: 'Estado', value: badgeEstado(d.estado) },
                    { label: 'Disponibilidad', value: badgeDisponibilidad(d.disponibilidad) },
                    { label: 'Acciones', value: `<button class="btn btn-secondary btn-sm mt-2" onclick="cargarHistoricoMovimientos(${idPortatil}, 'portatil')" title="Ver histórico"><i class="fas fa-history"></i> Ver histórico de movimientos</button>` }
                ]);
            }
        },
        error: function() {
            swal.fire("Error", "Error al cargar los datos", "error");
        }
    });
}
// Al cerrar el modal, volver a habilitar los campos y mostrar el botón guardar
$('#modalInventario').on('hidden.bs.modal', function () {
    setFormReadOnly('#formImpresora', false);
    setFormReadOnly('#formEscaner', false);
    setFormReadOnly('#formPcTorre', false);
    setFormReadOnly('#formTodoEnUno', false);
    setFormReadOnly('#formPortatil', false);
}); 

// Utilidad para badge de estado/disponibilidad
function badgeEstado(estado) {
    if (!estado) return '';
    if (['Bueno', 'BUENO'].includes(estado)) return '<span class="badge bg-success">' + estado.toUpperCase() + '</span>';
    if (['Regular', 'REGULAR'].includes(estado)) return '<span class="badge bg-warning">' + estado.toUpperCase() + '</span>';
    if (['Malo', 'MALO'].includes(estado)) return '<span class="badge bg-danger">' + estado.toUpperCase() + '</span>';
    if (['De Baja', 'DE BAJA'].includes(estado)) return '<span class="badge bg-dark">' + estado.toUpperCase() + '</span>';
    return '<span class="badge bg-secondary">' + estado + '</span>';
}
function badgeDisponibilidad(disp) {
    if (!disp) return '';
    if (disp === 'Disponible') return '<span class="badge bg-success">Disponible</span>';
    if (disp === 'No Disponible') return '<span class="badge bg-danger">No Disponible</span>';
    return '<span class="badge bg-secondary">' + disp + '</span>';
}

function showVerModal(titulo, filas) {
    $('#modalVerInventarioLabel').text(titulo);
    let html = '';
    filas.forEach(f => {
        html += `<tr><td class='fw-bold' style='width: 40%'>${f.label}</td><td>${f.value}</td></tr>`;
    });
    $('#tablaVerInventario').html(html);
    $('#modalVerInventario').modal('show');
} 

// --- MOVIMIENTOS DE EQUIPO ---
function abrirModalMovimientoEquipo(idEquipo, tipoEquipo, tipoMovimiento) {
    // Eliminar cualquier modal existente
    const existingModal = document.getElementById('modalMovimientoDinamico');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Crear el modal dinámicamente
    const modalHTML = `
        <div class="modal fade" id="modalMovimientoDinamico" tabindex="-1" aria-labelledby="modalMovimientoDinamicoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMovimientoDinamicoLabel">
                            ${tipoMovimiento === 'entrada' 
                                ? `Registrar Entrada a Mantenimiento - ${tipoEquipo.charAt(0).toUpperCase() + tipoEquipo.slice(1)} #${idEquipo}`
                                : `Registrar Salida de Mantenimiento - ${tipoEquipo.charAt(0).toUpperCase() + tipoEquipo.slice(1)} #${idEquipo}`
                            }
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formMovimientoDinamico">
                            <input type="hidden" id="mov_idEquipo_dinamico" name="idEquipo" value="${idEquipo}">
                            <input type="hidden" id="mov_tipoEquipo_dinamico" name="tipoEquipo" value="${tipoEquipo}">
                            <input type="hidden" id="mov_tipoMovimiento_dinamico" name="tipoMovimiento" value="${tipoMovimiento}">
                            <div class="mb-3">
                                <label for="mov_observacion_dinamico" class="form-label">Observación</label>
                                <textarea class="form-control" id="mov_observacion_dinamico" name="observacion" rows="3" required placeholder="Motivo o detalle del movimiento..."></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Agregar el modal al body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Obtener referencias del nuevo modal
    const modalEl = document.getElementById('modalMovimientoDinamico');
    const formMovimiento = document.getElementById('formMovimientoDinamico');
    
    // Configurar el submit del formulario
    formMovimiento.onsubmit = function(e) {
        e.preventDefault();
        
        const formData = new FormData(formMovimiento);
        const submitBtn = formMovimiento.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;
        
        fetch(base_url + '/Inventario/setMovimientoEquipo', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(function(response) {
            if (submitBtn) submitBtn.disabled = false;
            
            if (response && response.status) {
                Swal.fire('¡Éxito!', 'Movimiento registrado correctamente', 'success');
                $('#modalMovimientoDinamico').modal('hide');
                
                // Recargar tablas
                setTimeout(() => {
                    if (typeof tblImpresoras !== 'undefined') tblImpresoras.ajax.reload();
                    if (typeof tblPcTorre !== 'undefined') tblPcTorre.ajax.reload();
                    if (typeof tblPortatiles !== 'undefined') tblPortatiles.ajax.reload();
                    if (typeof tblTodoEnUno !== 'undefined') tblTodoEnUno.ajax.reload();
                    if (typeof tblEscanners !== 'undefined') tblEscanners.ajax.reload();
                }, 500);
            } else {
                Swal.fire('Error', response && response.msg ? response.msg : 'Error al registrar el movimiento', 'error');
            }
        })
        .catch(function(error) {
            if (submitBtn) submitBtn.disabled = false;
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión al registrar el movimiento', 'error');
        });
    };
    
    // Event listener para limpiar el modal cuando se cierre
    modalEl.addEventListener('hidden.bs.modal', function () {
        setTimeout(() => {
            if (modalEl && modalEl.parentNode) {
                modalEl.remove();
            }
        }, 300);
    });
    
    // Abrir el modal
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

// ==================== HISTÓRICO GLOBAL Y ESTADÍSTICAS ====================

// Variables para los gráficos
let graficoEstadoEquipos;
let graficoDisponibilidadEquipos;
let graficoMovimientosMes;
let graficoEquiposMantenimientos;

// Inicializar el histórico global cuando se hace clic en la pestaña
document.addEventListener('DOMContentLoaded', function() {
    // Agregar evento para la pestaña de histórico
    if (document.getElementById('historico-tab')) {
        document.getElementById('historico-tab').addEventListener('click', function() {
            initHistoricoGlobal();
            loadEstadisticas();
        });
    }
});

function initHistoricoGlobal() {
    try {
        // Verificar si la tabla existe en el DOM
        const tabla = document.getElementById('tablaHistoricoGlobal');
        if (!tabla) {
            console.warn('La tabla tablaHistoricoGlobal no existe en el DOM');
            return;
        }
        
        // Destruir la tabla existente de forma segura
        if ($.fn.DataTable.isDataTable('#tablaHistoricoGlobal')) {
            try {
                $('#tablaHistoricoGlobal').DataTable().destroy();
            } catch (error) {
                console.warn('Error al destruir tabla existente:', error);
                // Limpiar manualmente si es necesario
                $('#tablaHistoricoGlobal').empty();
            }
        }
        
        // Crear nueva tabla
        tblHistoricoGlobal = $('#tablaHistoricoGlobal').DataTable({
            "processing": true,
            "serverSide": false,
            "language": dataTableLanguage,
            "ajax": {
                "url": base_url + "/Inventario/getHistoricoGlobal",
                "dataSrc": function(json) {
                    return json.data || [];
                }
            },
            "columns": [
                { "data": "fecha_hora" },
                { 
                    "data": "tipo_equipo",
                    "render": function(data) {
                        switch(data) {
                            case 'impresora': return 'Impresora';
                            case 'escaner': return 'Escáner';
                            case 'pc_torre': return 'PC Torre';
                            case 'todo_en_uno': return 'Todo en Uno';
                            case 'portatil': return 'Portátil';
                            default: return data;
                        }
                    }
                },
                { 
                    "data": null,
                    "render": function(data) {
                        return data.nombre_equipo || `#${data.id_equipo}`;
                    }
                },
                { 
                    "data": "tipo_movimiento",
                    "render": function(data) {
                        if (data === 'entrada') {
                            return '<span class="badge bg-warning">Entrada a Mantenimiento</span>';
                        } else {
                            return '<span class="badge bg-success">Salida de Mantenimiento</span>';
                        }
                    }
                },
                { "data": "observacion" },
                { "data": "usuario" }
            ],
            "responsive": true,
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[0, "desc"]]
        });
    } catch (error) {
        console.error('Error al inicializar tabla histórico global:', error);
    }
}

function loadEstadisticas() {
    fetchJSON(base_url + '/Inventario/getEstadisticasInventario')
        .then(data => {
            if (data.status) {
                renderGraficoEstadoEquipos(data.estadoEquipos);
                renderGraficoDisponibilidadEquipos(data.disponibilidadEquipos);
                renderGraficoMovimientosPorMes(data.movimientosPorMes);
                renderGraficoEquiposConMasMantenimientos(data.equiposConMasMantenimientos);
            } else {
                console.error('Error al cargar estadísticas:', data.msg);
                Swal.fire('Error', 'No se pudieron cargar las estadísticas', 'error');
            }
        })
        .catch(error => {
            console.error('Error cargando estadísticas:', error);
            Swal.fire('Error', 'Error al cargar las estadísticas', 'error');
        });
}

function renderGraficoEstadoEquipos(datos) {
    const ctx = document.getElementById('graficoEstadoEquipos').getContext('2d');
    
    // Procesar datos para el gráfico
    const estados = ['Bueno', 'Regular', 'Malo', 'De Baja'];
    const tiposEquipo = [...new Set(datos.map(item => item.tipo))];
    
    // Crear datasets
    const datasets = estados.map(estado => {
        const data = tiposEquipo.map(tipo => {
            const item = datos.find(d => d.tipo === tipo && d.estado.toLowerCase() === estado.toLowerCase());
            return item ? parseInt(item.cantidad) : 0;
        });
        
        let color;
        switch(estado.toLowerCase()) {
            case 'bueno': color = 'rgba(40, 167, 69, 0.7)'; break;
            case 'regular': color = 'rgba(255, 193, 7, 0.7)'; break;
            case 'malo': color = 'rgba(220, 53, 69, 0.7)'; break;
            case 'de baja': color = 'rgba(52, 58, 64, 0.7)'; break;
            default: color = 'rgba(108, 117, 125, 0.7)';
        }
        
        return {
            label: estado,
            data: data,
            backgroundColor: color,
            borderColor: color.replace('0.7', '1'),
            borderWidth: 1
        };
    });
    
    // Destruir gráfico existente si hay uno
    if (graficoEstadoEquipos) {
        graficoEstadoEquipos.destroy();
    }
    
    // Crear nuevo gráfico
    graficoEstadoEquipos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: tiposEquipo,
            datasets: datasets
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
                        text: 'Tipo de Equipo'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Equipos por Estado'
                }
            }
        }
    });
}

function renderGraficoDisponibilidadEquipos(datos) {
    const ctx = document.getElementById('graficoDisponibilidadEquipos').getContext('2d');
    
    // Procesar datos para el gráfico
    const tiposEquipo = [...new Set(datos.map(item => item.tipo))];
    
    // Datos para disponibles y no disponibles
    const disponibles = tiposEquipo.map(tipo => {
        const item = datos.find(d => d.tipo === tipo && d.disponibilidad.toLowerCase() === 'disponible');
        return item ? parseInt(item.cantidad) : 0;
    });
    
    const noDisponibles = tiposEquipo.map(tipo => {
        const item = datos.find(d => d.tipo === tipo && d.disponibilidad.toLowerCase() === 'no disponible');
        return item ? parseInt(item.cantidad) : 0;
    });
    
    // Destruir gráfico existente si hay uno
    if (graficoDisponibilidadEquipos) {
        graficoDisponibilidadEquipos.destroy();
    }
    
    // Crear nuevo gráfico
    graficoDisponibilidadEquipos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: tiposEquipo,
            datasets: [
                {
                    label: 'Disponibles',
                    data: disponibles,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'No Disponibles',
                    data: noDisponibles,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
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
                        text: 'Tipo de Equipo'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Equipos por Disponibilidad'
                }
            }
        }
    });
}

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
    
    // Crear nuevo gráfico
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
                    tension: 0.1
                },
                {
                    label: 'Salidas de Mantenimiento',
                    data: salidas,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    tension: 0.1
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
            }
        }
    });
}

function renderGraficoEquiposConMasMantenimientos(datos) {
    // Crear una tabla con los equipos que más mantenimientos han tenido
    const container = document.getElementById('graficoMovimientosMes').parentNode;
    
    // Crear un div para la tabla
    let tableDiv = document.getElementById('equiposConMasMantenimientos');
    if (!tableDiv) {
        tableDiv = document.createElement('div');
        tableDiv.id = 'equiposConMasMantenimientos';
        tableDiv.className = 'mt-4';
        container.appendChild(tableDiv);
    }
    
    // Crear la tabla
    let html = `
        <h5 class="mb-3">Equipos con más mantenimientos</h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Equipo</th>
                        <th>Total Mantenimientos</th>
                        <th>Entradas</th>
                        <th>Salidas</th>
                        <th>Último Movimiento</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    datos.forEach(item => {
        html += `
            <tr>
                <td>${item.nombre_equipo}</td>
                <td><span class="badge bg-primary">${item.total_mantenimientos}</span></td>
                <td><span class="badge bg-warning">${item.entradas}</span></td>
                <td><span class="badge bg-success">${item.salidas}</span></td>
                <td>${item.ultimo_movimiento}</td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
    `;
    
    tableDiv.innerHTML = html;
}

function cargarHistoricoMovimientos(idEquipo, tipoEquipo) {
  // Actualizar el título del modal según el tipo de equipo
  let tipoEquipoTexto = '';
  switch(tipoEquipo) {
    case 'impresora': tipoEquipoTexto = 'Impresora'; break;
    case 'escaner': tipoEquipoTexto = 'Escáner'; break;
    case 'pc_torre': tipoEquipoTexto = 'PC Torre'; break;
    case 'todo_en_uno': tipoEquipoTexto = 'PC Todo en Uno'; break;
    case 'portatil': tipoEquipoTexto = 'Portátil'; break;
    default: tipoEquipoTexto = 'Equipo';
  }
  
  document.getElementById('modalHistoricoMovimientosLabel').innerHTML = 
    `<i class="fas fa-history"></i> Histórico de Movimientos - ${tipoEquipoTexto} #${idEquipo}`;
  
  // Mostrar el modal primero con mensaje de carga
  let tbody = document.querySelector('#tablaHistoricoMovimientos tbody');
  tbody.innerHTML = '<tr><td colspan="4" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></td></tr>';
  
  let historicoModal = new bootstrap.Modal(document.getElementById('modalHistoricoMovimientos'));
  historicoModal.show();
  
  // Cargar los datos del histórico
  fetch(base_url + '/Inventario/getMovimientosEquipo/' + idEquipo + '/' + tipoEquipo)
    .then(res => {
      if (!res.ok) {
        throw new Error('Error en la respuesta del servidor');
      }
      return res.json();
    })
    .then(function(response) {
      tbody.innerHTML = '';
      
      // Verificar si la respuesta tiene la estructura esperada
      if(response && response.status === true && Array.isArray(response.data)) {
        const data = response.data;
        
        if(data.length > 0) {
          data.forEach(function(mov) {
            tbody.innerHTML += `<tr>
              <td>${mov.fecha_hora}</td>
              <td>${mov.tipo_movimiento === 'entrada' ? '<span class="badge bg-warning">Entrada a Mantenimiento</span>' : '<span class="badge bg-success">Salida de Mantenimiento</span>'}</td>
              <td>${mov.observacion || ''}</td>
              <td>${mov.usuario || ''}</td>
            </tr>`;
          });
        } else {
          tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Sin movimientos registrados</td></tr>';
        }
      } else {
        // Si la respuesta no tiene la estructura esperada
        let errorMsg = 'No hay datos disponibles';
        if (response && response.msg) {
          errorMsg = response.msg;
        }
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-warning">${errorMsg}</td></tr>`;
      }
    })
    .catch(function(error) {
      console.error('Error al cargar histórico:', error);
      tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error al cargar el histórico. Intente nuevamente.</td></tr>';
    });
}

// ==================== EVENT LISTENERS GLOBALES ====================

// Función de prueba para el modal
function testModal() {
    abrirModalMovimientoEquipo(1, 'impresora', 'entrada');
}

// Asegurar que todo esté listo
$(document).ready(function() {
    // Event listener para cuando se cambie de tab
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        // Tab cambiado
    });
});