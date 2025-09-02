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
            {"data": "nombre_peticionario"},
            {"data": "tipo_peticion_nombre"},
            {"data": "estado_badge"},
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

    // Manejar cambio de tipo de petición para establecer días automáticamente
    if(document.querySelector("#listTipoPeticion")){
        document.querySelector("#listTipoPeticion").addEventListener('change', function(){
            calcularFechaVencimiento();
        });
    }

    // Manejar cambio de fecha de ingreso para recalcular vencimiento
    if(document.querySelector("#txtFechaIngreso")){
        document.querySelector("#txtFechaIngreso").addEventListener('change', function(){
            calcularFechaVencimiento();
        });
    }
});

function openModal(){
    let idPeticion = document.querySelector('#idPeticion');
    let modalTitle = document.querySelector('#titleModal');
    let btnText = document.querySelector('#btnText');
    let formPeticion = document.querySelector("#formPeticion");
    
    if(idPeticion) idPeticion.value = "";
    if(modalTitle) modalTitle.innerHTML = "Nueva Petición";
    if(btnText) btnText.innerHTML = "Guardar";
    if(formPeticion) formPeticion.reset();
    
    $('#modalFormPeticion').modal('show');
}

function fntViewPeticion(idpeticion){
    let request = new XMLHttpRequest();
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

    let request = new XMLHttpRequest();
    let ajaxUrl = base_url+'/Peticiones/getPeticion/'+idpeticion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                let peticion = objData.data;
                document.querySelector("#idPeticion").value = peticion.id_peticion;
                document.querySelector("#txtFechaIngreso").value = peticion.fecha_ingreso;
                document.querySelector("#txtPeticionario").value = peticion.nombre_peticionario;
                document.querySelector("#txtDescripcion").value = peticion.descripcion_solicitud;
                document.querySelector("#listTipoPeticion").value = peticion.id_tipo_peticion;
                document.querySelector("#txtAreasResponsables").value = peticion.areas_responsables || '';
                document.querySelector("#txtObservaciones").value = peticion.observaciones;
                
                // Recalcular fecha de vencimiento después de cargar los datos
                calcularFechaVencimiento();
                $('#modalFormPeticion').modal('show');
            }else{
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntSavePeticion(){
    let strFechaIngreso = document.querySelector('#txtFechaIngreso').value;
    let strPeticionario = document.querySelector('#txtPeticionario').value;
    let strDescripcion = document.querySelector('#txtDescripcion').value;
    let intTipoPeticion = document.querySelector('#listTipoPeticion').value;
    let strAreasResponsables = document.querySelector('#txtAreasResponsables').value;

    if(strFechaIngreso == '' || strPeticionario == '' || strDescripcion == '' || intTipoPeticion == '' || strAreasResponsables == ''){
        alert("Atención: Todos los campos marcados con (*) son obligatorios.");
        return false;
    }

    let request = new XMLHttpRequest();
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
                alert("Petición: " + objData.msg);
            }else{
                alert("Error: " + objData.msg);
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
            let request = new XMLHttpRequest();
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
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url+'/Peticiones/getEstadisticas';
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            
            // Actualizar widgets
            let totalPeticiones = document.querySelector("#totalPeticiones");
            let enProceso = document.querySelector("#enProceso");
            let proximasVencer = document.querySelector("#proximasVencer");
            let vencidas = document.querySelector("#vencidas");
            
            if(totalPeticiones) totalPeticiones.innerHTML = objData.total_peticiones || 0;
            if(enProceso) enProceso.innerHTML = objData.por_estado?.en_proceso || 0;
            if(proximasVencer) proximasVencer.innerHTML = objData.proximas_vencer || 0;
            if(vencidas) vencidas.innerHTML = objData.vencidas || 0;
        }
    }
}

function fntActualizarEstados(){
    let request = new XMLHttpRequest();
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

function exportExcel(){
    window.open(base_url + '/Peticiones/getReporte?export=excel', '_blank');
}

function fntGenerarReporte(tipo){
    window.open(base_url + '/Peticiones/getReporte?tipo=' + tipo + '&export=excel', '_blank');
}

function calcularFechaVencimiento(){
    let selectTipo = document.querySelector('#listTipoPeticion');
    let fechaIngreso = document.querySelector('#txtFechaIngreso').value;
    let txtDiasVencer = document.querySelector('#txtDiasVencer');
    let txtVencimientoTotal = document.querySelector('#txtVencimientoTotal');
    
    if(selectTipo.selectedIndex > 0 && fechaIngreso){
        let selectedOption = selectTipo.options[selectTipo.selectedIndex];
        let diasPlazo = parseInt(selectedOption.getAttribute('data-dias'));
        
        // Establecer días a vencer
        txtDiasVencer.value = diasPlazo;
        
        // Calcular fecha de vencimiento
        let fechaInicio = new Date(fechaIngreso);
        let fechaVencimiento = new Date(fechaInicio);
        fechaVencimiento.setDate(fechaVencimiento.getDate() + diasPlazo);
        
        // Formatear fecha para input date (YYYY-MM-DD)
        let fechaFormateada = fechaVencimiento.toISOString().split('T')[0];
        txtVencimientoTotal.value = fechaFormateada;
    } else {
        txtDiasVencer.value = '';
        txtVencimientoTotal.value = '';
    }
}

