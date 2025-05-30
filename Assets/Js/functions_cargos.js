let tableCargos; 
let rowTable = "";
let divLoading;
document.addEventListener('DOMContentLoaded', function(){
    divLoading = document.querySelector("#divLoading");
    
    // Registrar acceso al módulo de cargos en auditoría
    registrarAccesoModulo('Cargos');

    tableCargos = $('#tableCargos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Cargos/getCargos",
            "dataSrc":""
        },
        "columns":[
            
            {"data":"nombre"},
            {"data":"nivel"},
            {"data":"salario"},
            {"data":"estatus"},
            {"data":"options"}

        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success mt-3"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger mt-3"
            }
            
        ],
        "responsive":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

	if(document.querySelector("#formCargos")){
        let formCargos = document.querySelector("#formCargos");
        formCargos.onsubmit = function(e) {
            e.preventDefault();
            var intIdeCargos = document.querySelector('#ideCargos').value;
            let strNombresCargos = document.querySelector('#txtNombresCargos').value;
            let strNivel = document.querySelector('#txtNivel').value;
            let intSalario = document.querySelector('#txtSalario').value;
            
            // Obtener el valor del estado directamente
            let intEstatus = document.querySelector('#listStatus') ? document.querySelector('#listStatus').value : "1";

            if(strNombresCargos == '' || strNivel == '' || intSalario == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            if(divLoading) {
                divLoading.style.display = "flex";
            }
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cargos/setCargos'; 
            let formData = new FormData(formCargos);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    try {
                        let objData = JSON.parse(request.responseText);
                        
                        if(objData.status) {
                            if(rowTable == ""){
                                tableCargos.api().ajax.reload();
                            } else {
                                let htmlStatus = intEstatus == 1 ? 
                                '<span class="badge text-bg-success">Activo</span>' : 
                                '<span class="badge text-bg-danger">Inactivo</span>';
                                
                                // Actualizar las celdas de la tabla
                                rowTable.cells[0].textContent = strNombresCargos;
                                rowTable.cells[1].textContent = strNivel;
                                
                                // Formatear el salario como peso colombiano
                                let formattedSalario = '$ ' + parseFloat(intSalario).toLocaleString('es-CO', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).replace(/\./g, ',').replace(/,(\d{2})$/, '.$1');
                                
                                rowTable.cells[2].textContent = formattedSalario;
                                rowTable.cells[3].innerHTML = htmlStatus;
                                rowTable = "";
                            }
                            $('#modalFormCargos').modal("hide");
                            formCargos.reset();
                            Swal.fire({
                                title: "Cargos",
                                text: objData.msg,
                                icon: "success",
                                confirmButtonText: "Aceptar"
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: objData.msg,
                                icon: "error",
                                confirmButtonText: "Aceptar"
                            });
                        }
                    } catch (error) {
                        console.error("Error al procesar la respuesta:", error);
                        console.log("Respuesta recibida:", request.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "Ocurrió un error al procesar la respuesta del servidor",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    }
                }
                if(divLoading) {
                    divLoading.style.display = "none";
                }
                return false;
            }
        }
    }

}, false);


function fntViewInfo(idecargos){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cargos/getCargo/'+idecargos;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    let estatus = objData.data.estatus == 1 ? 
                    '<span class="badge text-bg-success">Activo</span>' : 
                    '<span class="badge text-bg-danger">Inactivo</span>';

                    if(document.querySelector("#celNombre")) {
                        document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                    }
                    if(document.querySelector("#celNivel")) {
                        document.querySelector("#celNivel").innerHTML = objData.data.nivel;
                    }
                    if(document.querySelector("#celSalario")) {
                        document.querySelector("#celSalario").innerHTML = objData.data.salario;
                    }
                    if(document.querySelector("#celEstadoCargo")) {
                        document.querySelector("#celEstadoCargo").innerHTML = estatus;
                    }
                    
                    $('#modalViewCargos').modal('show');
                } else {
                    Swal.fire("Error", objData.msg , "error");
                }
            } catch (error) {
                console.error("Error al procesar la respuesta:", error);
                Swal.fire("Error", "Ocurrió un error al procesar la respuesta", "error");
            }
        }
    }
}

function fntEditInfo(element, idecargos){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Cargos";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cargos/getCargo/'+idecargos;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    document.querySelector("#ideCargos").value = objData.data.idecargos;
                    document.querySelector("#txtNombresCargos").value = objData.data.nombre;
                    document.querySelector("#txtNivel").value = objData.data.nivel;
                    
                    // Extraer solo el valor numérico del salario (quitar formato de moneda)
                    let salarioNumerico = objData.data.salario;
                    if (typeof salarioNumerico === 'string') {
                        salarioNumerico = salarioNumerico.replace(/[^\d.,]/g, '');
                        salarioNumerico = salarioNumerico.replace(/\./g, '');
                        salarioNumerico = salarioNumerico.replace(',', '.');
                    }
                    
                    document.querySelector("#txtSalario").value = salarioNumerico;
                    
                    if(document.querySelector("#listStatus")) {
                        document.querySelector("#listStatus").value = objData.data.estatus;
                    }
                }
            } catch (error) {
                console.error("Error al procesar la respuesta:", error);
                Swal.fire("Error", "Ocurrió un error al procesar la respuesta", "error");
            }
        }
        $('#modalFormCargos').modal('show');
    }
}

function fntDelInfo(idecargos){
    Swal.fire({
        title: "Eliminar Cargo",
        text: "¿Estás seguro?",
        imageUrl: base_url + "/Assets/images/iconos/eliminar.png",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonColor: "#00A6FF",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cargos/delCargos';
            let strData = "ideCargos="+idecargos;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    try {
                        let objData = JSON.parse(request.responseText);
                        if(objData.status)
                        {
                            Swal.fire("Eliminar!", objData.msg , "success");
                            tableCargos.api().ajax.reload();
                        } else {
                            Swal.fire("Atención!", objData.msg , "error");
                        }
                    } catch (error) {
                        console.error("Error al procesar la respuesta:", error);
                        Swal.fire("Error", "Ocurrió un error al procesar la respuesta", "error");
                    }
                }
            }
        }
    });
}

function openModal()
{
    rowTable = "";
    document.querySelector('#ideCargos').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cargos";
    document.querySelector("#formCargos").reset();
    $('#modalFormCargos').modal('show');
}

// Función para registrar acceso al módulo en auditoría
function registrarAccesoModulo(modulo) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/auditoria/registrarAccesoJS';
    let formData = new FormData();
    formData.append('modulo', modulo);
    
    request.open("POST", ajaxUrl, true);
    request.send(formData);
}