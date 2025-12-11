var tablePrestamos, tableSalidas, tableIngresos;

document.addEventListener('DOMContentLoaded', function(){
    // Cargar funcionarios al iniciar
    fntGetFuncionarios();
    fntGetDependencias();
    
    // Inicializar tablas
    initializeTables();
    
    // Manejar cambio de pestañas
    document.querySelectorAll('#psiTabs button[data-bs-toggle="tab"]').forEach(function(tab) {
        tab.addEventListener('shown.bs.tab', function(e) {
            if(e.target.id === 'salidas-tab' && !tableSalidas) {
                initializeSalidasTable();
            } else if(e.target.id === 'ingresos-tab' && !tableIngresos) {
                initializeIngresosTable();
            }
        });
    });

    // CREAR/EDITAR PRÉSTAMO
    let formPrestamo = document.querySelector("#formPrestamo");
    formPrestamo.onsubmit = function(e) {
        e.preventDefault();
        
        let intFuncionario = document.querySelector('#listFuncionario').value;
        let strFechaPrestamo = document.querySelector('#txtFechaPrestamo').value;
        let strTipoEquipo = document.querySelector('#listTipoEquipo').value;
        let intEquipo = document.querySelector('#listEquipo').value;
        
        if(intFuncionario == '' || strFechaPrestamo == '' || strTipoEquipo == '' || intEquipo == '') {
            Swal.fire("Atención", "Todos los campos marcados con * son obligatorios.", "error");
            return false;
        }
        
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/psi/setPrestamo'; 
        let formData = new FormData(formPrestamo);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                try {
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        $('#modalFormPrestamos').modal("hide");
                        formPrestamo.reset();
                        Swal.fire("PSI", objData.msg, "success");
                        tablePrestamos.api().ajax.reload();
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                } catch (e) {
                    console.error("Error al parsear JSON:", request.responseText);
                    Swal.fire("Error", "Ocurrió un error en el servidor", "error");
                }
            }
        }
    }

    // Cambio de tipo de equipo
    document.getElementById('listTipoEquipo').addEventListener('change', function() {
        cargarEquipos(this.value);
    });

    // Cambio de tipo de equipo para salidas
    let tipoEquipoSalida = document.getElementById('listTipoEquipoSalida');
    if(tipoEquipoSalida) {
        tipoEquipoSalida.addEventListener('change', function() {
            cargarEquiposSalidaCheckbox(this.value);
        });
    }

    // Cambio de tipo de equipo para ingresos
    let tipoEquipoIngreso = document.getElementById('listTipoEquipoIngreso');
    if(tipoEquipoIngreso) {
        tipoEquipoIngreso.addEventListener('change', function() {
            cargarEquiposIngresoCheckbox(this.value);
        });
    }

    // Buscador de equipos salida
    let buscadorSalida = document.getElementById('txtBuscarEquipoSalida');
    if(buscadorSalida) {
        buscadorSalida.addEventListener('input', function() {
            filtrarEquipos(this.value, 'equiposListaSalida');
        });
    }

    // Buscador de equipos ingreso
    let buscadorIngreso = document.getElementById('txtBuscarEquipoIngreso');
    if(buscadorIngreso) {
        buscadorIngreso.addEventListener('input', function() {
            filtrarEquipos(this.value, 'equiposListaIngreso');
        });
    }

    // Cambio de funcionario
    document.getElementById('listFuncionario').addEventListener('change', function() {
        cargarDatosFuncionario(this.value);
    });

    // CREAR/EDITAR SALIDA
    let formSalida = document.querySelector("#formSalida");
    if(formSalida) {
        formSalida.onsubmit = function(e) {
            e.preventDefault();
            
            let strFecha = document.querySelector('#txtFechaSalida').value;
            let strTipoEquipo = document.querySelector('#listTipoEquipoSalida').value;
            let equiposSeleccionados = document.querySelectorAll('.equipo-checkbox:checked');
            let strDependencia = document.querySelector('#listDependenciaSalida').value;
            
            if(strFecha == '' || strTipoEquipo == '' || equiposSeleccionados.length == 0 || strDependencia == '') {
                Swal.fire("Atención", "Todos los campos marcados con * son obligatorios.", "error");
                return false;
            }
            
            // Agregar equipos seleccionados al formulario
            let equiposIds = [];
            equiposSeleccionados.forEach(cb => equiposIds.push(cb.value));
            let inputEquipos = document.createElement('input');
            inputEquipos.type = 'hidden';
            inputEquipos.name = 'equiposSeleccionados';
            inputEquipos.value = JSON.stringify(equiposIds);
            formSalida.appendChild(inputEquipos);
            
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/psi/setSalida'; 
            let formData = new FormData(formSalida);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    try {
                        let objData = JSON.parse(request.responseText);
                        if(objData.status) {
                            $('#modalFormSalidas').modal("hide");
                            formSalida.reset();
                            Swal.fire("PSI", objData.msg, "success");
                            if(tableSalidas) tableSalidas.api().ajax.reload();
                        } else {
                            Swal.fire("Error", objData.msg, "error");
                        }
                    } catch (e) {
                        console.error("Error al parsear JSON:", request.responseText);
                        Swal.fire("Error", "Ocurrió un error en el servidor", "error");
                    }
                }
            }
        }
    }

    // CREAR/EDITAR INGRESO
    let formIngreso = document.querySelector("#formIngreso");
    if(formIngreso) {
        formIngreso.onsubmit = function(e) {
            e.preventDefault();
            
            let strFecha = document.querySelector('#txtFechaIngreso').value;
            let strTipoEquipo = document.querySelector('#listTipoEquipoIngreso').value;
            let equiposSeleccionados = document.querySelectorAll('.equipo-checkbox-ingreso:checked');
            let strDependencia = document.querySelector('#listDependenciaIngreso').value;
            
            if(strFecha == '' || strTipoEquipo == '' || equiposSeleccionados.length == 0 || strDependencia == '') {
                Swal.fire("Atención", "Todos los campos marcados con * son obligatorios.", "error");
                return false;
            }
            
            // Agregar equipos seleccionados al formulario
            let equiposIds = [];
            equiposSeleccionados.forEach(cb => equiposIds.push(cb.value));
            let inputEquipos = document.createElement('input');
            inputEquipos.type = 'hidden';
            inputEquipos.name = 'equiposSeleccionados';
            inputEquipos.value = JSON.stringify(equiposIds);
            formIngreso.appendChild(inputEquipos);
            
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/psi/setIngreso'; 
            let formData = new FormData(formIngreso);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    try {
                        let objData = JSON.parse(request.responseText);
                        if(objData.status) {
                            $('#modalFormIngresos').modal("hide");
                            formIngreso.reset();
                            Swal.fire("PSI", objData.msg, "success");
                            if(tableIngresos) tableIngresos.api().ajax.reload();
                        } else {
                            Swal.fire("Error", objData.msg, "error");
                        }
                    } catch (e) {
                        console.error("Error al parsear JSON:", request.responseText);
                        Swal.fire("Error", "Ocurrió un error en el servidor", "error");
                    }
                }
            }
        }
    }
});

function fntGetFuncionarios() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/psi/getFuncionariosPlanta';
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let htmlOption = '<option value="">Seleccione un funcionario</option>';
            objData.forEach(function(funcionario) {
                htmlOption += '<option value="'+funcionario.id+'" data-dependencia="'+funcionario.dependencia+'" data-cargo="'+funcionario.cargo+'">'+funcionario.nombre_completo+'</option>';
            });
            document.querySelector("#listFuncionario").innerHTML = htmlOption;
        }
    }
}

function cargarDatosFuncionario(funcionarioId) {
    const select = document.getElementById('listFuncionario');
    const option = select.options[select.selectedIndex];
    
    if(option && funcionarioId) {
        document.getElementById('txtDependencia').value = option.getAttribute('data-dependencia') || '';
        document.getElementById('txtCargo').value = option.getAttribute('data-cargo') || '';
    } else {
        document.getElementById('txtDependencia').value = '';
        document.getElementById('txtCargo').value = '';
    }
}

function cargarEquipos(tipoEquipo) {
    if(!tipoEquipo) {
        document.getElementById('listEquipo').innerHTML = '<option value="">Primero seleccione el tipo de equipo</option>';
        return;
    }

    let ajaxUrl = '';
    switch(tipoEquipo) {
        case 'pc_torre':
            ajaxUrl = base_url + '/psi/getPcTorre';
            break;
        case 'todo_en_uno':
            ajaxUrl = base_url + '/psi/getTodoEnUno';
            break;
        case 'portatil':
            ajaxUrl = base_url + '/psi/getPortatiles';
            break;
        case 'impresora':
            ajaxUrl = base_url + '/psi/getImpresoras';
            break;
        case 'escaner':
            ajaxUrl = base_url + '/psi/getEscaneres';
            break;
        case 'herramienta':
            ajaxUrl = base_url + '/psi/getHerramientas';
            break;
    }

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let htmlOption = '<option value="">Seleccione un equipo</option>';
            objData.forEach(function(equipo) {
                let equipoText = '';
                switch(tipoEquipo) {
                    case 'pc_torre':
                        equipoText = equipo.numero_pc + ' - ' + equipo.marca + ' ' + equipo.modelo;
                        break;
                    case 'todo_en_uno':
                        equipoText = equipo.numero_todo_en_uno + ' - ' + equipo.marca + ' ' + equipo.modelo;
                        break;
                    case 'portatil':
                        equipoText = equipo.numero_portatil + ' - ' + equipo.marca + ' ' + equipo.modelo;
                        break;
                    case 'impresora':
                        equipoText = equipo.numero_impresora + ' - ' + equipo.marca + ' ' + equipo.modelo;
                        break;
                    case 'escaner':
                        equipoText = equipo.numero_escaner + ' - ' + equipo.marca + ' ' + equipo.modelo;
                        break;
                    case 'herramienta':
                        equipoText = equipo.item + ' - ' + equipo.marca;
                        break;
                }
                htmlOption += '<option value="'+equipo.id+'">'+equipoText+'</option>';
            });
            document.querySelector("#listEquipo").innerHTML = htmlOption;
        }
    }
}

function initializeTables() {
    tablePrestamos = $('#tablePrestamos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": base_url + "/es.json"
        },
        "ajax": {
            "url": base_url + "/psi/getPrestamos",
            "dataSrc": ""
        },
        "columns": [
            {"data": "funcionario_responsable"},
            {"data": "dependencia"},
            {"data": "cargo_funcionario"},
            {"data": "fecha_prestamo"},
            {"data": "fecha_devolucion"},
            {"data": "item"},
            {"data": "dispositivo"},
            {"data": "estado"},
            {"data": "options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[3, "desc"]]
    });
}

function initializeSalidasTable() {
    tableSalidas = $('#tableSalidas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": base_url + "/es.json"
        },
        "ajax": {
            "url": base_url + "/psi/getSalidas",
            "dataSrc": ""
        },
        "columns": [
            {"data": "fecha"},
            {"data": "dependencia"},
            {"data": "total_equipos"},
            {"data": "observaciones"},
            {"data": "options"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });
}

function initializeIngresosTable() {
    tableIngresos = $('#tableIngresos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": base_url + "/es.json"
        },
        "ajax": {
            "url": base_url + "/psi/getIngresos",
            "dataSrc": ""
        },
        "columns": [
            {"data": "fecha"},
            {"data": "item"},
            {"data": "tipo_dispositivo"},
            {"data": "descripcion_dispositivo"},
            {"data": "marca"},
            {"data": "modelo"},
            {"data": "serial"},
            {"data": "dependencia"},
            {"data": "options"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });
}

function openModal() {
    document.querySelector('#idPrestamo').value = "";
    document.querySelector('.modal-title').innerHTML = "Nuevo Préstamo";
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#formPrestamo').reset();
    document.getElementById('txtDependencia').value = '';
    document.getElementById('txtCargo').value = '';
    $('#modalFormPrestamos').modal('show');
}

function fntEditInfo(idprestamo) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Préstamo";
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/psi/getPrestamo/'+idprestamo;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if(objData) {
                    document.querySelector("#idPrestamo").value = objData.id_prestamos;
                    document.querySelector("#txtFechaPrestamo").value = objData.fecha_prestamo;
                    document.querySelector("#txtFechaDevolucion").value = objData.fecha_devolucion;
                    document.querySelector("#listTipoEquipo").value = objData.equipo_tipo;
                    document.querySelector("#txtObservaciones").value = objData.observaciones;
                    
                    // Cargar equipos y seleccionar el actual
                    cargarEquipos(objData.equipo_tipo);
                    setTimeout(() => {
                        document.querySelector("#listEquipo").value = objData.equipo_id;
                    }, 500);
                    
                    // Seleccionar funcionario
                    if(objData.funcionario_id) {
                        document.querySelector("#listFuncionario").value = objData.funcionario_id;
                        cargarDatosFuncionario(objData.funcionario_id);
                    }

                    $('#modalFormPrestamos').modal('show');
                }
            } catch (e) {
                console.error("Error al parsear JSON:", request.responseText);
                Swal.fire("Error", "Ocurrió un error en el servidor", "error");
            }
        }
    }
}

function fntViewInfo(idprestamo) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/psi/getPrestamo/'+idprestamo;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if(objData) {
                    document.querySelector("#celFuncionario").innerHTML = objData.funcionario_responsable || '';
                    document.querySelector("#celDependencia").innerHTML = objData.dependencia || '';
                    document.querySelector("#celCargo").innerHTML = objData.cargo_funcionario || '';
                    document.querySelector("#celFechaPrestamo").innerHTML = objData.fecha_prestamo || '';
                    document.querySelector("#celFechaDevolucion").innerHTML = objData.fecha_devolucion || 'Pendiente';
                    document.querySelector("#celItem").innerHTML = objData.item || '';
                    document.querySelector("#celDispositivo").innerHTML = objData.dispositivo || '';
                    document.querySelector("#celEstado").innerHTML = objData.estado || '';
                    document.querySelector("#celObservaciones").innerHTML = objData.observaciones || '';
                    
                    $('#modalViewPrestamo').modal('show');
                }
            } catch (e) {
                console.error("Error al parsear JSON:", request.responseText);
                Swal.fire("Error", "Ocurrió un error en el servidor", "error");
            }
        }
    }
}

function fntDelInfo(idprestamo) {
    Swal.fire({
        title: "Eliminar Préstamo",
        text: "¿Realmente quiere eliminar este préstamo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/psi/delPrestamo';
            let strData = "idPrestamo="+idprestamo;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    try {
                        let objData = JSON.parse(request.responseText);
                        if(objData.status) {
                            Swal.fire("Eliminar", objData.msg, "success");
                            tablePrestamos.api().ajax.reload();
                        } else {
                            Swal.fire("Atención", objData.msg, "error");
                        }
                    } catch (e) {
                        console.error("Error al parsear JSON:", request.responseText);
                        Swal.fire("Error", "Ocurrió un error en el servidor", "error");
                    }
                }
            }
        }
    });
}

// ==================== FUNCIONES SALIDAS ====================
function openModalSalida() {
    document.querySelector('#idSalida').value = "";
    document.querySelector('#titleModalSalida').innerHTML = "Nueva Salida";
    document.querySelector('#btnTextSalida').innerHTML = "Guardar";
    document.querySelector('#formSalida').reset();
    $('#modalFormSalidas').modal('show');
}

// ==================== FUNCIONES INGRESOS ====================
function openModalIngreso() {
    document.querySelector('#idIngreso').value = "";
    document.querySelector('#titleModalIngreso').innerHTML = "Nuevo Ingreso";
    document.querySelector('#btnTextIngreso').innerHTML = "Guardar";
    document.querySelector('#formIngreso').reset();
    $('#modalFormIngresos').modal('show');
}

function cargarEquiposSalida(tipoEquipo) {
    if(!tipoEquipo) {
        document.getElementById('listEquiposSalida').innerHTML = '<option value="">Primero seleccione el tipo de equipo</option>';
        return;
    }

    let ajaxUrl = base_url + '/psi/get' + tipoEquipo.charAt(0).toUpperCase() + tipoEquipo.slice(1).replace('_', '');
    if(tipoEquipo === 'pc_torre') ajaxUrl = base_url + '/psi/getPcTorre';
    if(tipoEquipo === 'todo_en_uno') ajaxUrl = base_url + '/psi/getTodoEnUno';
    if(tipoEquipo === 'portatil') ajaxUrl = base_url + '/psi/getPortatiles';
    if(tipoEquipo === 'impresora') ajaxUrl = base_url + '/psi/getImpresoras';
    if(tipoEquipo === 'escaner') ajaxUrl = base_url + '/psi/getEscaneres';
    if(tipoEquipo === 'herramienta') ajaxUrl = base_url + '/psi/getHerramientas';

    let request = new XMLHttpRequest();
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let htmlOption = '';
            objData.forEach(function(equipo) {
                let equipoText = getEquipoText(tipoEquipo, equipo);
                htmlOption += '<option value="'+equipo.id+'">'+equipoText+'</option>';
            });
            document.querySelector("#listEquiposSalida").innerHTML = htmlOption;
        }
    }
}

function cargarEquiposIngreso(tipoEquipo) {
    if(!tipoEquipo) {
        document.getElementById('listEquiposIngreso').innerHTML = '<option value="">Primero seleccione el tipo de equipo</option>';
        return;
    }

    let ajaxUrl = base_url + '/psi/get' + tipoEquipo.charAt(0).toUpperCase() + tipoEquipo.slice(1).replace('_', '');
    if(tipoEquipo === 'pc_torre') ajaxUrl = base_url + '/psi/getPcTorre';
    if(tipoEquipo === 'todo_en_uno') ajaxUrl = base_url + '/psi/getTodoEnUno';
    if(tipoEquipo === 'portatil') ajaxUrl = base_url + '/psi/getPortatiles';
    if(tipoEquipo === 'impresora') ajaxUrl = base_url + '/psi/getImpresoras';
    if(tipoEquipo === 'escaner') ajaxUrl = base_url + '/psi/getEscaneres';
    if(tipoEquipo === 'herramienta') ajaxUrl = base_url + '/psi/getHerramientas';

    let request = new XMLHttpRequest();
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let htmlOption = '';
            objData.forEach(function(equipo) {
                let equipoText = getEquipoText(tipoEquipo, equipo);
                htmlOption += '<option value="'+equipo.id+'">'+equipoText+'</option>';
            });
            document.querySelector("#listEquiposIngreso").innerHTML = htmlOption;
        }
    }
}

function fntGetDependencias() {
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url+'/psi/getDependencias';
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let htmlOption = '<option value="">Seleccione dependencia</option>';
            objData.forEach(function(dep) {
                htmlOption += '<option value="'+dep.nombre+'">'+dep.nombre+'</option>';
            });
            document.querySelector("#listDependenciaSalida").innerHTML = htmlOption;
            document.querySelector("#listDependenciaIngreso").innerHTML = htmlOption;
        }
    }
}

function cargarEquiposSalidaCheckbox(tipoEquipo) {
    if(!tipoEquipo) {
        document.getElementById('equiposListaSalida').innerHTML = '<p class="text-muted">Primero seleccione el tipo de equipo</p>';
        return;
    }

    let ajaxUrl = getAjaxUrl(tipoEquipo);
    let request = new XMLHttpRequest();
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let html = '';
            objData.forEach(function(equipo) {
                let equipoText = getEquipoText(tipoEquipo, equipo);
                html += '<div class="form-check equipo-item" data-search="'+equipoText.toLowerCase()+'">';
                html += '<input class="form-check-input equipo-checkbox" type="checkbox" value="'+equipo.id+'" id="equipo_'+equipo.id+'">';
                html += '<label class="form-check-label" for="equipo_'+equipo.id+'">'+equipoText+'</label>';
                html += '</div>';
            });
            document.getElementById('equiposListaSalida').innerHTML = html;
        }
    }
}

function cargarEquiposIngresoCheckbox(tipoEquipo) {
    if(!tipoEquipo) {
        document.getElementById('equiposListaIngreso').innerHTML = '<p class="text-muted">Primero seleccione el tipo de equipo</p>';
        return;
    }

    let ajaxUrl = getAjaxUrl(tipoEquipo);
    let request = new XMLHttpRequest();
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let html = '';
            objData.forEach(function(equipo) {
                let equipoText = getEquipoText(tipoEquipo, equipo);
                html += '<div class="form-check equipo-item" data-search="'+equipoText.toLowerCase()+'">';
                html += '<input class="form-check-input equipo-checkbox-ingreso" type="checkbox" value="'+equipo.id+'" id="equipo_ing_'+equipo.id+'">';
                html += '<label class="form-check-label" for="equipo_ing_'+equipo.id+'">'+equipoText+'</label>';
                html += '</div>';
            });
            document.getElementById('equiposListaIngreso').innerHTML = html;
        }
    }
}

function getAjaxUrl(tipoEquipo) {
    switch(tipoEquipo) {
        case 'pc_torre': return base_url + '/psi/getPcTorre';
        case 'todo_en_uno': return base_url + '/psi/getTodoEnUno';
        case 'portatil': return base_url + '/psi/getPortatiles';
        case 'impresora': return base_url + '/psi/getImpresoras';
        case 'escaner': return base_url + '/psi/getEscaneres';
        case 'herramienta': return base_url + '/psi/getHerramientas';
        default: return '';
    }
}

function getEquipoText(tipoEquipo, equipo) {
    switch(tipoEquipo) {
        case 'pc_torre':
            return equipo.numero_pc + ' - ' + equipo.marca + ' ' + equipo.modelo + ' (S/N: ' + equipo.serial + ')';
        case 'todo_en_uno':
            return equipo.numero_todo_en_uno + ' - ' + equipo.marca + ' ' + equipo.modelo + ' (S/N: ' + equipo.serial + ')';
        case 'portatil':
            return equipo.numero_portatil + ' - ' + equipo.marca + ' ' + equipo.modelo + ' (S/N: ' + equipo.serial + ')';
        case 'impresora':
            return equipo.numero_impresora + ' - ' + equipo.marca + ' ' + equipo.modelo + ' (S/N: ' + equipo.serial + ')';
        case 'escaner':
            return equipo.numero_escaner + ' - ' + equipo.marca + ' ' + equipo.modelo + ' (S/N: ' + equipo.serial + ')';
        case 'herramienta':
            return equipo.item + ' - ' + equipo.marca;
        default:
            return '';
    }
}

function seleccionarTodosEquipos() {
    document.querySelectorAll('.equipo-checkbox').forEach(cb => cb.checked = true);
}

function deseleccionarTodosEquipos() {
    document.querySelectorAll('.equipo-checkbox').forEach(cb => cb.checked = false);
}

function seleccionarTodosEquiposIngreso() {
    document.querySelectorAll('.equipo-checkbox-ingreso').forEach(cb => cb.checked = true);
}

function deseleccionarTodosEquiposIngreso() {
    document.querySelectorAll('.equipo-checkbox-ingreso').forEach(cb => cb.checked = false);
}

function filtrarEquipos(busqueda, contenedorId) {
    let items = document.querySelectorAll('#' + contenedorId + ' .equipo-item');
    items.forEach(function(item) {
        let texto = item.getAttribute('data-search');
        if(texto.includes(busqueda.toLowerCase())) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}