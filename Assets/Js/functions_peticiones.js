let tablePeticiones;

document.addEventListener('DOMContentLoaded', function(){
    // Inicializar DataTable
    tablePeticiones = $('#tablePeticiones').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": base_url + "/es.json"
        },
        "ajax": {
            "url": " " + base_url + "/Peticiones/getPeticiones",
            "dataSrc": ""
        },
        "columns": [
            {"data": "numero_radicado"},
            {"data": "fecha_ingreso_format"},
            {"data": "nombre_peticionario"},
            {"data": "tipo_peticion_nombre"},
            {"data": "dependencia_nombre"},
            {"data": "estado_badge"},
            {"data": "semaforo"},
            {"data": "fecha_vencimiento_format"},
            {"data": "options"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[1, "desc"]]
    });

    // Cargar estadísticas
    fntLoadEstadisticas();

    // Configurar formularios
    if(document.querySelector("#formPeticion")){
        let formPeticion = document.querySelector("#formPeticion");
        formPeticion.onsubmit = function(e) {
            e.preventDefault();
            fntSavePeticion();
        }
    }

    if(document.querySelector("#formResponder")){
        let formResponder = document.querySelector("#formResponder");
        formResponder.onsubmit = function(e) {
            e.preventDefault();
            fntResponderPeticion();
        }
    }

    if(document.querySelector("#formRemitir")){
        let formRemitir = document.querySelector("#formRemitir");
        formRemitir.onsubmit = function(e) {
            e.preventDefault();
            fntRemitirPeticion();
        }
    }

    if(document.querySelector("#formDesistir")){
        let formDesistir = document.querySelector("#formDesistir");
        formDesistir.onsubmit = function(e) {
            e.preventDefault();
            fntDesistirPeticion();
        }
    }
});

function openModal(){
    document.querySelector('#idPeticion').value = "";
    document.querySelector('.modal-title').innerHTML = "Nueva Petición";
    document.querySelector('#btnActionForm').innerHTML = '<i class="fas fa-save"></i> Guardar';
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector("#formPeticion").reset();
    $('#modalFormPeticion').modal('show');
}

function fntViewPeticion(idpeticion){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Peticiones/getPeticion/'+idpeticion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                let peticion = objData.data;
                let htmlInfo = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Radicado:</strong> ${peticion.numero_radicado}</p>
                            <p><strong>Fecha Ingreso:</strong> ${peticion.fecha_ingreso_format}</p>
                            <p><strong>Peticionario:</strong> ${peticion.nombre_peticionario}</p>
                            <p><strong>Tipo:</strong> ${peticion.tipo_peticion_nombre}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dependencia:</strong> ${peticion.dependencia_nombre}</p>
                            <p><strong>Estado:</strong> ${peticion.estado}</p>
                            <p><strong>Fecha Vencimiento:</strong> ${peticion.fecha_vencimiento_format}</p>
                            <p><strong>Días Restantes:</strong> ${peticion.dias_habiles_restantes}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Descripción:</strong></p>
                            <p>${peticion.descripcion_solicitud}</p>
                        </div>
                    </div>
                `;
                
                if(peticion.observaciones){
                    htmlInfo += `
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Observaciones:</strong></p>
                                <p>${peticion.observaciones}</p>
                            </div>
                        </div>
                    `;
                }

                document.querySelector("#divInfoPeticion").innerHTML = htmlInfo;
                $('#modalViewPeticion').modal('show');
            }else{
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntEditPeticion(idpeticion){
    document.querySelector('#titleModal').innerHTML = "Actualizar Petición";
    document.querySelector('#btnActionForm').innerHTML = '<i class="fas fa-sync-alt"></i> Actualizar';
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Peticiones/getPeticion/'+idpeticion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                let peticion = objData.data;
                document.querySelector("#idPeticion").value = peticion.id_peticion;
                document.querySelector("#txtRadicado").value = peticion.numero_radicado;
                document.querySelector("#txtFechaIngreso").value = peticion.fecha_ingreso;
                document.querySelector("#txtPeticionario").value = peticion.nombre_peticionario;
                document.querySelector("#txtDescripcion").value = peticion.descripcion_solicitud;
                document.querySelector("#listTipoPeticion").value = peticion.id_tipo_peticion;
                document.querySelector("#listDependencia").value = peticion.dependencia_responsable;
                document.querySelector("#txtObservaciones").value = peticion.observaciones;
                $('#modalFormPeticion').modal('show');
            }else{
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntSavePeticion(){
    let strRadicado = document.querySelector('#txtRadicado').value;
    let strFechaIngreso = document.querySelector('#txtFechaIngreso').value;
    let strPeticionario = document.querySelector('#txtPeticionario').value;
    let strDescripcion = document.querySelector('#txtDescripcion').value;
    let intTipoPeticion = document.querySelector('#listTipoPeticion').value;
    let intDependencia = document.querySelector('#listDependencia').value;

    if(strRadicado == '' || strFechaIngreso == '' || strPeticionario == '' || strDescripcion == '' || intTipoPeticion == '' || intDependencia == ''){
        swal("Atención", "Todos los campos marcados con (*) son obligatorios.", "error");
        return false;
    }

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Peticiones/setPeticion';
    let formData = new FormData(document.querySelector("#formPeticion"));
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                $('#modalFormPeticion').modal("hide");
                document.querySelector("#formPeticion").reset();
                tablePeticiones.ajax.reload();
                fntLoadEstadisticas();
                swal("Petición", objData.msg, "success");
            }else{
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntResponderPeticion(idpeticion){
    document.querySelector("#idPeticionResponder").value = idpeticion;
    document.querySelector("#formResponder").reset();
    $('#modalResponderPeticion').modal('show');
}

function fntRemitirPeticion(idpeticion){
    document.querySelector("#idPeticionRemitir").value = idpeticion;
    document.querySelector("#formRemitir").reset();
    $('#modalRemitirPeticion').modal('show');
}

function fntDesistirPeticion(idpeticion){
    document.querySelector("#idPeticionDesistir").value = idpeticion;
    document.querySelector("#formDesistir").reset();
    $('#modalDesistirPeticion').modal('show');
}

function fntDelPeticion(idpeticion){
    swal({
        title: "Eliminar Petición",
        text: "¿Realmente quiere eliminar la petición?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Peticiones/delPeticion/';
            let strData = "idPeticion="+idpeticion;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        swal("Eliminar!", objData.msg , "success");
                        tablePeticiones.ajax.reload();
                        fntLoadEstadisticas();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }
    });
}

function fntLoadEstadisticas(){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Peticiones/getEstadisticas';
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            
            // Actualizar widgets
            document.querySelector("#totalPeticiones").innerHTML = objData.total_peticiones || 0;
            document.querySelector("#enProceso").innerHTML = objData.por_estado?.en_proceso || 0;
            document.querySelector("#proximasVencer").innerHTML = objData.proximas_vencer || 0;
            document.querySelector("#vencidas").innerHTML = objData.vencidas || 0;
            
            // Actualizar semáforo
            document.querySelector("#semaforoVerde").innerHTML = objData.por_semaforo?.verde || 0;
            document.querySelector("#semaforoAmarillo").innerHTML = objData.por_semaforo?.amarillo || 0;
            document.querySelector("#semaforoRojo").innerHTML = objData.por_semaforo?.rojo || 0;
        }
    }
}

function fntActualizarEstados(){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Peticiones/actualizarEstados';
    request.open("POST",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                tablePeticiones.ajax.reload();
                fntLoadEstadisticas();
                swal("Actualización", objData.msg, "success");
            }else{
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntGenerarReporte(tipo){
    window.open(base_url + '/Peticiones/getReporte?tipo=' + tipo + '&export=excel', '_blank');
}