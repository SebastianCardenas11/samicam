let tableTareas;
document.addEventListener('DOMContentLoaded', function(){

    tableTareas = $('#tableTareas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Tareas/getTareas",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_tarea"},
            {"data":"asignado_nombre"},
            {"data":"tipo"},
            {"data":"descripcion", "render": function(data) {
                return `<div class="text-truncate" style="max-width: 200px;" title="${data}">${data}</div>`;
            }},
            {"data":"dependencia_nombre"},
            {"data":"estado", "render": function(data, type, row) {
                let estado = data.toLowerCase();
                let badge = '';
                if(estado === 'completada') {
                    badge = '<span class="badge text-bg-success">Completada</span>';
                } else if(estado === 'en curso') {
                    badge = '<span class="badge text-bg-warning text-black">En curso</span>';
                } else if(estado === 'sin empezar') {
                    badge = '<span class="badge text-bg-secondary text-black">Sin empezar</span>';
                } else if(estado === 'vencida') {
                    badge = '<span class="badge text-bg-danger text-black">Vencida</span>';
                } else {
                    badge = '<span class="badge text-bg-info">'+data+'</span>';
                }
                return badge;
            }},
            {"data":"fecha_inicio", "render": function(data) {
                return data.split(' ')[0]; // Mostrar solo la parte de la fecha
            }},
            {"data":"fecha_fin", "render": function(data) {
                return data.split(' ')[0]; // Mostrar solo la parte de la fecha
            }},
            {"data":"tiempo_restante", "render": function(data, type, row) {
                let fechaFin = new Date(row.fecha_fin);
                let fechaActual = new Date();
                
                // Si la tarea está completada
                if (row.estado.toLowerCase() === 'completada') {
                    return '<span class="badge text-bg-success">Completada</span>';
                }
                
                // Si la fecha ya pasó
                if (fechaFin < fechaActual) {
                    return '<span class="badge text-bg-danger">Vencida</span>';
                }
                
                // Calcular días restantes
                let diferencia = fechaFin.getTime() - fechaActual.getTime();
                let diasRestantes = Math.ceil(diferencia / (1000 * 3600 * 24));
                
                let badge = diasRestantes <= 2 ? 'text-bg-danger' : 
                           diasRestantes <= 5 ? 'text-bg-warning' : 
                           'text-bg-info';
                
                return `<span class="badge ${badge}">${diasRestantes} día${diasRestantes !== 1 ? 's' : ''}</span>`;
            }},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
           {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    // Función utilitaria para mostrar toast arriba a la derecha
    function showToast(msg, icon = 'success') {
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            icon: icon,
            title: msg
        });
    }

    // Formulario Nueva Tarea
    let formTarea = document.querySelector("#formTarea");
    formTarea.onsubmit = async function(e) {
        e.preventDefault();
        let strUsuariosIds = document.querySelector('#usuariosIds').value;
        let strTipo = document.querySelector('#listTipo').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let strDependencia = document.querySelector('#listDependencia').value;
        let strFechaInicio = document.querySelector('#txtFechaInicio').value;
        let strFechaFin = document.querySelector('#txtFechaFin').value;
        if(strUsuariosIds == '' || strTipo == '' || strDescripcion == '' || strDependencia == '' || 
            strFechaInicio == '' || strFechaFin == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        // Validar que la fecha de fin sea posterior a la fecha de inicio
        let fechaInicio = new Date(strFechaInicio);
        let fechaFin = new Date(strFechaFin);
        if(fechaFin < fechaInicio) {
            Swal.fire("Atención", "La fecha de fin debe ser posterior a la fecha de inicio.", "error");
            return false;
        }
        // Mostrar modal de cargando
        var modalLoading = new bootstrap.Modal(document.getElementById('modalLoadingTarea'));
        modalLoading.show();
        let formData = new FormData(formTarea);
        try {
            let response = await fetch(base_url+'/Tareas/setTarea', {
                method: 'POST',
                body: formData
            });
            let objData = await response.json();
            modalLoading.hide();
            if(objData.status) {
                var modalTarea = bootstrap.Modal.getInstance(document.getElementById('modalFormTareas'));
                modalTarea.hide();
                formTarea.reset();
                Swal.fire("Tareas", objData.msg, "success");
                tableTareas.api().ajax.reload();
                if(window.calendar && typeof window.calendar.refetchEvents === 'function') {
                    window.calendar.refetchEvents();
                }
                let idTarea = objData.idTarea;
                if(idTarea) {
                    // Enviar notificación WhatsApp
                    fetch(base_url+'/Tareas/notificarWhatsApp', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'idTarea='+encodeURIComponent(idTarea)
                    })
                    .then(res => res.json())
                    .then(data => {
                        showToast(data.msg, data.status ? 'success' : 'error');
                    })
                    .catch(() => {
                        showToast('Error al enviar notificación WhatsApp', 'error');
                    });
                    // Enviar notificación Correo
                    fetch(base_url+'/Tareas/notificarCorreo', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'idTarea='+encodeURIComponent(idTarea)
                    })
                    .then(res => res.json())
                    .then(data => {
                        showToast(data.msg, data.status ? 'success' : 'error');
                    })
                    .catch(() => {
                        showToast('Error al enviar notificación Correo', 'error');
                    });
                }
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        } catch (err) {
            modalLoading.hide();
            Swal.fire("Error", "Error de conexión o servidor.", "error");
        }
    }

    // Formulario Nueva Observación
    let formNuevaObservacion = document.querySelector("#formNuevaObservacion");
    if(formNuevaObservacion) {
        formNuevaObservacion.onsubmit = function(e) {
            e.preventDefault();
            
            let strObservacion = document.querySelector('#txtNuevaObservacion').value;
            
            if(strObservacion == '') {
                Swal.fire("Atención", "La observación no puede estar vacía.", "error");
                return false;
            }

            Swal.fire({
                title: 'Enviando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => { Swal.showLoading(); }
            });
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Tareas/addObservacion';
            let formData = new FormData(formNuevaObservacion);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    Swal.close();
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        document.querySelector('#txtNuevaObservacion').value = '';
                        Swal.fire("Observación", objData.msg, "success");
                        
                        // Recargar la lista de observaciones
                        let idTarea = document.querySelector('#idTareaObsList').value;
                        cargarObservaciones(idTarea);
                        
                        // Actualizar la tabla de tareas para mostrar el nuevo contador
                        tableTareas.api().ajax.reload(null, false);
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                }
            }
        }
    }

    // Configurar el evento para el botón de confirmar selección de usuarios
    let btnConfirmarUsuarios = document.querySelector('#btnConfirmarUsuarios');
    if(btnConfirmarUsuarios) {
        btnConfirmarUsuarios.addEventListener('click', confirmarSeleccionUsuarios);
    }

    // Cargar dependencias
    fntDependencias();

}, false);

function fntViewTarea(idtarea) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getTarea/'+idtarea;
    request.open("GET",ajaxUrl,true);
    request.setRequestHeader("Content-Type", "application/json");
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                let objTarea = objData.data;
                document.querySelector("#celId").innerHTML = objTarea.id_tarea;
                document.querySelector("#celCreador").innerHTML = objTarea.creador_nombre;
                
                // Mostrar todos los usuarios asignados
                let usuariosAsignados = objTarea.usuarios_asignados || [];
                let usuariosHtml = '';
                
                if (usuariosAsignados.length > 0) {
                    usuariosAsignados.forEach(usuario => {
                        usuariosHtml += `<span class="badge bg-info text-dark me-1">${usuario.nombres}</span>`;
                    });
                } else {
                    usuariosHtml = objTarea.asignado_nombre;
                }
                
                document.querySelector("#celAsignado").innerHTML = usuariosHtml;
                document.querySelector("#celTipo").innerHTML = objTarea.tipo;
                document.querySelector("#celDescripcion").innerHTML = objTarea.descripcion;
                document.querySelector("#celDependencia").innerHTML = objTarea.dependencia_nombre;
                

                let estado = objTarea.estado;
                let estadoHtml = "";
                switch(estado) {
                    case 'sin empezar':
                        estadoHtml = '<span class=" badge text-bg-secondary text-black">Sin empezar</span>';
                        break;
                    case 'en curso':
                        estadoHtml = '<span class=" badge text-bg-warning text-black">En curso</span>';
                        break;
                    case 'completada':
                        estadoHtml = '<span class=" badge text-bg-success text-black">Completada</span>';
                        break;
                }
                document.querySelector("#celEstado").innerHTML = estadoHtml;
                
                let numObservaciones = objTarea.num_observaciones || 0;
                document.querySelector("#celObservacion").innerHTML = `<button class="btn btn-info btn-sm" onClick="openModalObservaciones(${objTarea.id_tarea})"><i class="fas fa-comments"></i> Ver observaciones (${numObservaciones})</button>`;
                document.querySelector("#celFechaInicio").innerHTML = objTarea.fecha_inicio_format;
                document.querySelector("#celFechaFin").innerHTML = objTarea.fecha_fin_format;
                
                let tiempoRestante = objTarea.tiempo_restante;
                let tiempoHtml = "";
                if(tiempoRestante === 'Vencida') {
                    tiempoHtml = '<span class=" badge text-bg-danger text-black">Vencida</span>';
                } else {
                    tiempoHtml = '<span class="badge text-bg-info text-black">'+tiempoRestante+'</span>';
                }
                document.querySelector("#celTiempoRestante").innerHTML = tiempoHtml;
                
                document.querySelector("#celFechaCompletada").innerHTML = objTarea.fecha_completada ? objTarea.fecha_completada : 'No completada';
                
                let divAgregarObservacion = document.querySelector("#divAgregarObservacion");
                let idUsuarioActual = document.querySelector("#idUser") ? document.querySelector("#idUser").value : 0;
                let fechaActual = new Date();
                let fechaFin = new Date(objTarea.fecha_fin);

                // Verificar si el usuario actual está entre los asignados
                let esUsuarioAsignado = false;
                if (usuariosAsignados.length > 0) {
                    esUsuarioAsignado = usuariosAsignados.some(usuario => usuario.ideusuario == idUsuarioActual);
                } else {
                    esUsuarioAsignado = (objTarea.id_usuario_asignado == idUsuarioActual);
                }

                if(objTarea.estado === 'completada') {
                    divAgregarObservacion.style.display = "none";
                } else if(esUsuarioAsignado && 
                          objTarea.estado === 'en curso' && 
                          fechaFin > fechaActual) {
                    divAgregarObservacion.style.display = "block";
                } else {
                    divAgregarObservacion.style.display = "none";
                }
                
                var modalView = new bootstrap.Modal(document.getElementById('modalViewTarea'));
                modalView.show();
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        } catch (e) {
            console.error("Error al parsear JSON:", e);
            console.log("Respuesta recibida:", request.responseText);
            Swal.fire("Error", "Error al procesar la respuesta del servidor", "error");
        }
        }
    }
}

function fntEditTarea(idtarea) {
    document.querySelector('#titleModal').innerHTML ="Actualizar Tarea";
    
    // Verificar si el elemento tiene la clase antes de intentar reemplazarla
    if(document.querySelector('.modal-header').classList.contains("headerRegister")) {
        document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    } else {
        document.querySelector('.modal-header').classList.add("headerUpdate");
    }
    
    // Verificar si el botón tiene la clase antes de intentar reemplazarla
    if(document.querySelector('#btnActionForm').classList.contains("btn-primary")) {
        document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    } else {
        document.querySelector('#btnActionForm').classList.add("btn-info");
    }
    
    document.querySelector('#btnText').innerHTML ="Actualizar";
    document.querySelector('#divEstado').style.display = "block";
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getTarea/'+idtarea;
    request.open("GET",ajaxUrl,true);
    request.setRequestHeader("Content-Type", "application/json");
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                let objTarea = objData.data;
                document.querySelector("#idTarea").value = objTarea.id_tarea;
                
                // Obtener los usuarios asignados
                let usuariosAsignados = objTarea.usuarios_asignados || [];
                let usuariosIds = [];
                let usuariosHtml = '';
                
                if (usuariosAsignados.length > 0) {
                    usuariosAsignados.forEach(usuario => {
                        usuariosIds.push(usuario.ideusuario);
                        usuariosHtml += `<span class="user-badge">${usuario.nombres} <i class="fas fa-user"></i></span> `;
                    });
                } else {
                    // Si no hay usuarios asignados en la nueva estructura, usar el usuario principal
                    usuariosIds.push(objTarea.id_usuario_asignado);
                    usuariosHtml = `<span class="user-badge">${objTarea.asignado_nombre} <i class="fas fa-user"></i></span> `;
                }
                
                document.querySelector('#usuariosIds').value = usuariosIds.join(',');
                document.querySelector('#usuariosSeleccionados').innerHTML = usuariosHtml;
                
                document.querySelector("#listTipo").value = objTarea.tipo;
                document.querySelector("#txtDescripcion").value = objTarea.descripcion;
                document.querySelector("#listDependencia").value = objTarea.dependencia_fk;
                document.querySelector("#listEstado").value = objTarea.estado;
                
                // Formatear fechas para el input date
                let fechaInicio = new Date(objTarea.fecha_inicio);
                let fechaFin = new Date(objTarea.fecha_fin);
                
                document.querySelector("#txtFechaInicio").value = formatDate(fechaInicio);
                document.querySelector("#txtFechaFin").value = formatDate(fechaFin);
                
                var modalTarea = new bootstrap.Modal(document.getElementById('modalFormTareas'));
                modalTarea.show();
            }
        } catch (e) {
            console.error("Error al parsear JSON:", e);
            console.log("Respuesta recibida:", request.responseText);
            Swal.fire("Error", "Error al procesar la respuesta del servidor", "error");
        }
        }
    }
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    
    return `${year}-${month}-${day}`;
}

function fntDelTarea(idtarea) {
    Swal.fire({
        title: "Eliminar Tarea",
        text: "¿Realmente quiere eliminar esta tarea?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Tareas/delTarea';
            let strData = "idTarea="+idtarea;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        Swal.fire("Eliminar!", objData.msg, "success");
                        tableTareas.api().ajax.reload(null, false);
                        // Actualizar calendario si existe la función
                        if (typeof refreshCalendar === 'function') {
                            refreshCalendar();
                        }
                    } else {
                        Swal.fire("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function fntStartTarea(idtarea) {
    Swal.fire({
        title: "Iniciar Tarea",
        text: "¿Está seguro de iniciar esta tarea?",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Si, iniciar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Enviando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => { Swal.showLoading(); }
            });
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Tareas/startTarea';
            let strData = "idTarea="+idtarea;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    Swal.close();
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        Swal.fire("Tarea iniciada!", objData.msg, "success");
                        tableTareas.api().ajax.reload(null, false);
                        if (typeof refreshCalendar === 'function') {
                            refreshCalendar();
                        }
                    } else {
                        Swal.fire("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function fntCompleteTarea(idtarea) {
    Swal.fire({
        title: "Completar Tarea",
        text: "¿Está seguro de marcar esta tarea como completada? Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, completar!",
        cancelButtonText: "No, cancelar!",
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Enviando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => { Swal.showLoading(); }
            });
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Tareas/completeTarea';
            let strData = "idTarea="+idtarea;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    Swal.close();
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        Swal.fire("Tarea completada!", objData.msg, "success");
                        tableTareas.api().ajax.reload(null, false);
                        if (typeof refreshCalendar === 'function') {
                            refreshCalendar();
                        }
                    } else {
                        Swal.fire("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function openModal() {
    document.querySelector('#idTarea').value ="";
    // Verificar si el elemento tiene la clase antes de intentar reemplazarla
    if(document.querySelector('.modal-header').classList.contains("headerUpdate")) {
        document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    } else {
        document.querySelector('.modal-header').classList.add("headerRegister");
    }
    
    // Verificar si el botón tiene la clase antes de intentar reemplazarla
    if(document.querySelector('#btnActionForm').classList.contains("btn-info")) {
        document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    } else {
        document.querySelector('#btnActionForm').classList.add("btn-primary");
    }
    
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Tarea";
    document.querySelector('#divEstado').style.display = "none";
    document.querySelector('#formTarea').reset();
    document.querySelector('#usuariosSeleccionados').innerHTML = '<p class="text-muted">No hay usuarios seleccionados</p>';
    
    var modalTarea = new bootstrap.Modal(document.getElementById('modalFormTareas'));
    modalTarea.show();
}

function openModalUsuarios() {
    // Cargar usuarios asignables si no se han cargado
    if (document.querySelectorAll('#usuariosCheckboxes .form-check').length === 0) {
        cargarUsuariosAsignables();
    }
    
    // Mostrar el modal
    var modalUsuarios = new bootstrap.Modal(document.getElementById('modalUsuarios'));
    modalUsuarios.show();
}

// Función para cargar los usuarios asignables en el modal
function cargarUsuariosAsignables() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getUsuariosAsignables';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            try {
                let usuarios = JSON.parse(request.responseText);
                let html = '';
                
                if(usuarios.length > 0) {
                    for(let i = 0; i < usuarios.length; i++) {
                        html += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chkUsuario" value="${usuarios[i].ideusuario}" id="usuario${usuarios[i].ideusuario}">
                            <label class="form-check-label" for="usuario${usuarios[i].ideusuario}">
                                ${usuarios[i].nombres}
                            </label>
                        </div>`;
                    }
                } else {
                    html = '<div class="alert alert-info">No hay usuarios disponibles para asignar.</div>';
                }
                
                document.querySelector('#usuariosCheckboxes').innerHTML = html;
                
                // Marcar los usuarios ya seleccionados
                let usuariosIds = document.querySelector('#usuariosIds').value;
                if (usuariosIds) {
                    let ids = usuariosIds.split(',');
                    ids.forEach(id => {
                        let checkbox = document.querySelector('#usuario' + id);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                }
            } catch (e) {
                console.error("Error al parsear JSON:", e);
                document.querySelector('#usuariosCheckboxes').innerHTML = '<div class="alert alert-danger">Error al cargar los usuarios.</div>';
            }
        }
    }
}

// Función para confirmar la selección de usuarios
function confirmarSeleccionUsuarios() {
    let checkboxes = document.querySelectorAll('#usuariosCheckboxes input[type="checkbox"]:checked');
    let usuariosSeleccionados = [];
    let usuariosIds = [];
    
    if(checkboxes.length === 0) {
        Swal.fire("Atención", "Debe seleccionar al menos un usuario.", "warning");
        return;
    }
    
    checkboxes.forEach(function(checkbox) {
        usuariosIds.push(checkbox.value);
        usuariosSeleccionados.push({
            id: checkbox.value,
            nombre: checkbox.nextElementSibling.textContent.trim()
        });
    });
    
    // Actualizar el campo oculto con los IDs de usuarios
    document.querySelector('#usuariosIds').value = usuariosIds.join(',');
    
    // Mostrar los usuarios seleccionados en el div
    let html = '';
    usuariosSeleccionados.forEach(function(usuario) {
        html += `<span class="user-badge">${usuario.nombre} <i class="fas fa-user"></i></span> `;
    });
    
    document.querySelector('#usuariosSeleccionados').innerHTML = html;
    
    // Cerrar el modal
    var modalUsuarios = bootstrap.Modal.getInstance(document.getElementById('modalUsuarios'));
    modalUsuarios.hide();
}

function openModalObservaciones(idtarea) {
    // Establecer el ID de la tarea en el formulario
    document.querySelector("#idTareaObsList").value = idtarea;
    
    // Limpiar el formulario
    document.querySelector("#formNuevaObservacion").reset();
    
    // Cargar las observaciones existentes
    cargarObservaciones(idtarea);
    
    // Verificar el estado de la tarea para mostrar u ocultar el formulario de observaciones
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getTarea/'+idtarea;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                let objTarea = objData.data;
                let formObservacion = document.querySelector("#formNuevaObservacion");
                
                // Si la tarea está completada, ocultar el formulario
                if(objTarea.estado === 'completada') {
                    formObservacion.style.display = "none";
                } else {
                    formObservacion.style.display = "block";
                }
            }
        }
    };
    
    // Ocultar el modal de vista de tarea
    var modalView = bootstrap.Modal.getInstance(document.getElementById('modalViewTarea'));
    modalView.hide();
    
    // Mostrar el modal de observaciones
    setTimeout(function() {
        var modalObs = new bootstrap.Modal(document.getElementById('modalObservaciones'));
        modalObs.show();
    }, 500);
}

function cargarObservaciones(idtarea) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getObservaciones/'+idtarea;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                let html = '';
                
                if(objData.status) {
                    let observaciones = objData.data;
                    
                    if(observaciones.length > 0) {
                        for(let i = 0; i < observaciones.length; i++) {
                            html += `
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <strong>${observaciones[i].usuario_nombre}</strong> - ${observaciones[i].fecha_format}
                                </div>
                                <div class="card-body">
                                    <p class="card-text">${observaciones[i].observacion}</p>
                                </div>
                            </div>`;
                        }
                    } else {
                        html = '<div class="alert ">No hay observaciones para esta tarea.</div>';
                    }
                } else {
                    html = '<div class="alert ">No hay observaciones para esta tarea.</div>';
                }
                
                document.querySelector('#listaObservaciones').innerHTML = html;
            } catch (e) {
                console.error("Error al parsear JSON:", e);
                document.querySelector('#listaObservaciones').innerHTML = '<div class="alert alert-danger">Error al cargar las observaciones.</div>';
            }
        }
    }
}

function fntDependencias() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getDependencias';
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listDependencia').innerHTML = request.responseText;
        }
    }
}