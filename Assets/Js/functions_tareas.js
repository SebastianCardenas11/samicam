let tableTareas;
document.addEventListener('DOMContentLoaded', function(){

    tableTareas = $('#tableTareas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Tareas/getTareas",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_tarea"},
            {"data":"asignado_nombre"},
            {"data":"tipo"},
            {"data":"descripcion"},
            {"data":"dependencia_nombre"},
            {"data":"estado"},
            {"data":"fecha_inicio"},
            {"data":"fecha_fin"},
            {"data":"tiempo_restante"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    // Formulario Nueva Tarea
    let formTarea = document.querySelector("#formTarea");
    formTarea.onsubmit = function(e) {
        e.preventDefault();
        
        let strUsuarioAsignado = document.querySelector('#listUsuarioAsignado').value;
        let strTipo = document.querySelector('#listTipo').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let strDependencia = document.querySelector('#listDependencia').value;
        let strFechaInicio = document.querySelector('#txtFechaInicio').value;
        let strFechaFin = document.querySelector('#txtFechaFin').value;
        
        if(strUsuarioAsignado == '' || strTipo == '' || strDescripcion == '' || strDependencia == '' || 
           strFechaInicio == '' || strFechaFin == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        // Validar que la fecha de fin sea posterior a la fecha de inicio
        let fechaInicio = new Date(strFechaInicio);
        let fechaFin = new Date(strFechaFin);
        if(fechaFin <= fechaInicio) {
            Swal.fire("Atención", "La fecha de fin debe ser posterior a la fecha de inicio.", "error");
            return false;
        }

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Tareas/setTarea';
        let formData = new FormData(formTarea);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                    var modalTarea = bootstrap.Modal.getInstance(document.getElementById('modalFormTareas'));
                    modalTarea.hide();
                    formTarea.reset();
                    Swal.fire("Tareas", objData.msg, "success");
                    tableTareas.api().ajax.reload();
                    if(window.calendar) {
                        window.calendar.refetchEvents();
                    }
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            }
        }
    }

    // Formulario Editar Observación
    let formObservacion = document.querySelector("#formObservacion");
    formObservacion.onsubmit = function(e) {
        e.preventDefault();
        
        let strObservacion = document.querySelector('#txtObservacionEdit').value;
        
        if(strObservacion == '') {
            Swal.fire("Atención", "La observación no puede estar vacía.", "error");
            return false;
        }

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Tareas/updateObservacion';
        let formData = new FormData(formObservacion);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                    var modalObs = bootstrap.Modal.getInstance(document.getElementById('modalFormObservacion'));
                    modalObs.hide();
                    formObservacion.reset();
                    Swal.fire("Tareas", objData.msg, "success");
                    tableTareas.api().ajax.reload();
                    if(window.calendar) {
                        window.calendar.refetchEvents();
                    }
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            }
        }
    }

    // Cargar usuarios asignables
    fntUsuariosAsignables();
    // Cargar dependencias
    fntDependencias();

}, false);

function fntViewTarea(idtarea) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getTarea/'+idtarea;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                let objTarea = objData.data;
                document.querySelector("#celId").innerHTML = objTarea.id_tarea;
                document.querySelector("#celCreador").innerHTML = objTarea.creador_nombre;
                document.querySelector("#celAsignado").innerHTML = objTarea.asignado_nombre;
                document.querySelector("#celTipo").innerHTML = objTarea.tipo;
                document.querySelector("#celDescripcion").innerHTML = objTarea.descripcion;
                document.querySelector("#celDependencia").innerHTML = objTarea.dependencia_nombre;
                
                // Formatear estado
                let estado = objTarea.estado;
                let estadoHtml = "";
                switch(estado) {
                    case 'sin empezar':
                        estadoHtml = '<span class="badge badge-secondary">Sin empezar</span>';
                        break;
                    case 'en curso':
                        estadoHtml = '<span class="badge badge-primary">En curso</span>';
                        break;
                    case 'completada':
                        estadoHtml = '<span class="badge badge-success">Completada</span>';
                        break;
                }
                document.querySelector("#celEstado").innerHTML = estadoHtml;
                
                document.querySelector("#celObservacion").innerHTML = objTarea.observacion || 'No hay observaciones';
                document.querySelector("#celFechaInicio").innerHTML = objTarea.fecha_inicio;
                document.querySelector("#celFechaFin").innerHTML = objTarea.fecha_fin;
                
                // Formatear tiempo restante
                let tiempoRestante = objTarea.tiempo_restante;
                let tiempoHtml = "";
                if(tiempoRestante === 'Vencida') {
                    tiempoHtml = '<span class="badge badge-danger">Vencida</span>';
                } else {
                    tiempoHtml = '<span class="badge badge-info">'+tiempoRestante+'</span>';
                }
                document.querySelector("#celTiempoRestante").innerHTML = tiempoHtml;
                
                document.querySelector("#celFechaCreacion").innerHTML = objTarea.fecha_creacion;
                
                // Mostrar botón de editar observación solo si:
                // 1. Es el usuario asignado
                // 2. La tarea no está completada
                // 3. La tarea no ha vencido
                let divEditarObservacion = document.querySelector("#divEditarObservacion");
                let idUsuarioActual = document.querySelector("#idUser") ? document.querySelector("#idUser").value : 0;
                let fechaActual = new Date();
                let fechaFin = new Date(objTarea.fecha_fin);
                
                // Ocultar siempre el botón de editar observación si la tarea está completada
                if(objTarea.estado === 'completada') {
                    divEditarObservacion.style.display = "none";
                } else if(idUsuarioActual == objTarea.id_usuario_asignado && fechaFin > fechaActual) {
                    divEditarObservacion.style.display = "block";
                    document.querySelector("#idTareaObs").value = objTarea.id_tarea;
                    document.querySelector("#txtObservacionEdit").value = objTarea.observacion || '';
                } else {
                    divEditarObservacion.style.display = "none";
                }
                
                var modalView = new bootstrap.Modal(document.getElementById('modalViewTarea'));
                modalView.show();
            } else {
                Swal.fire("Error", objData.msg, "error");
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
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                let objTarea = objData.data;
                document.querySelector("#idTarea").value = objTarea.id_tarea;
                document.querySelector("#listUsuarioAsignado").value = objTarea.id_usuario_asignado;
                document.querySelector("#listTipo").value = objTarea.tipo;
                document.querySelector("#txtDescripcion").value = objTarea.descripcion;
                document.querySelector("#listDependencia").value = objTarea.dependencia_fk;
                document.querySelector("#listEstado").value = objTarea.estado;
                
                // Formatear fechas para el input date
                let fechaInicio = new Date(objTarea.fecha_inicio);
                let fechaFin = new Date(objTarea.fecha_fin);
                
                document.querySelector("#txtFechaInicio").value = formatDate(fechaInicio);
                document.querySelector("#txtFechaFin").value = formatDate(fechaFin);
                
                document.querySelector("#txtObservacion").value = objTarea.observacion || '';
                
                var modalTarea = new bootstrap.Modal(document.getElementById('modalFormTareas'));
                modalTarea.show();
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
                        tableTareas.api().ajax.reload();
                        if(window.calendar) {
                            window.calendar.refetchEvents();
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
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Tareas/startTarea';
            let strData = "idTarea="+idtarea;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        Swal.fire("Tarea iniciada!", objData.msg, "success");
                        tableTareas.api().ajax.reload();
                        if(window.calendar) {
                            window.calendar.refetchEvents();
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
        text: "¿Está seguro de marcar esta tarea como completada?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, completar!",
        cancelButtonText: "No, cancelar!",
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Confirmación adicional",
                text: "Esta acción no se puede deshacer. ¿Realmente desea marcar la tarea como completada?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, completar definitivamente!",
                cancelButtonText: "No, cancelar!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((confirmResult) => {
                if (confirmResult.isConfirmed) {
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Tareas/completeTarea';
                    let strData = "idTarea="+idtarea;
                    request.open("POST",ajaxUrl,true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function(){
                        if(request.readyState == 4 && request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status) {
                                Swal.fire("Tarea completada!", objData.msg, "success");
                                tableTareas.api().ajax.reload();
                                if(window.calendar) {
                                    window.calendar.refetchEvents();
                                }
                            } else {
                                Swal.fire("Atención!", objData.msg, "error");
                            }
                        }
                    }
                }
            });
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
    
    var modalTarea = new bootstrap.Modal(document.getElementById('modalFormTareas'));
    modalTarea.show();
}

function openModalObservacion() {
    var modalView = bootstrap.Modal.getInstance(document.getElementById('modalViewTarea'));
    modalView.hide();
    
    setTimeout(function() {
        var modalObs = new bootstrap.Modal(document.getElementById('modalFormObservacion'));
        modalObs.show();
    }, 500);
}

function fntUsuariosAsignables() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tareas/getUsuariosAsignables';
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listUsuarioAsignado').innerHTML = request.responseText;
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