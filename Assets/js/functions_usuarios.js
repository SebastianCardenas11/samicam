let tableUsuarios; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableUsuarios = $('#tableUsuarios').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"correo"},
            {"data":"nombres"},
            {"data":"nombrerol"},
            {"data":"status"},
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



	if(document.querySelector("#formUsuario")){
        let formUsuario = document.querySelector("#formUsuario");
        formUsuario.onsubmit = function(e) {
            e.preventDefault();
            var intIdeUsuario = document.querySelector('#ideUsuario').value;
            let strCorreoUsuario = document.querySelector('#txtCorreoUsuario').value;
            let strNombresUsuario = document.querySelector('#txtNombresUsuario').value;
            let strRolUsuario = document.querySelector('#txtRolUsuario').value;
            
            $('#listStatus').picker();
            let intStatus = document.querySelector('#listStatus').value;

            if(strCorreoUsuario == '' || strNombresUsuario == '' || strRolUsuario == '')
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
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/setUsuario'; 
            let formData = new FormData(formUsuario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableUsuarios.api().ajax.reload();
                            // tableUsuarios.DataTable().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1 ? 
                            '<span class="badge text-bg-success">Activo</span>' : 
                            '<span class="badge text-bg-danger">Inactivo</span>';
                            // tableUsuarios.api().ajax.reload();
                           rowTable.cells[1].textContent =  strCorreoUsuario;
                        //    rowTable.cells[2].textContent =  strRolUsuario;
                           rowTable.cells[2].textContent = document.querySelector("#txtRolUsuario").selectedOptions[0].text;
                            rowTable.cells[3].innerHTML = htmlStatus;
                           rowTable = "";
                        }
                        $('#modalFormUsuario').modal("hide");
                        formUsuario.reset();
                        Swal.fire("Usuario", objData.msg ,"success");
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

}, false);


window.addEventListener('load', function() {
    fntRolesUsuario();
}, false);

function fntRolesUsuario(){
if(document.querySelector('#txtRolUsuario')){
    let ajaxUrl = base_url+'/Roles/getSelectRoles';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#txtRolUsuario').innerHTML = request.responseText;
            // $('.txtRolUsuario').selectpicker('refresh');
            // $('#txtRolUsuario').picker();
        }
    }
}
}

function fntViewInfo(ideusuario){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+ideusuario;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        // console.log(request.responseText);
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
           
            
            if(objData.status)
            {

                let estadoUsuario = objData.data.status == 1 ? 
                '<span class="badge text-bg-success">Activo</span>' : 
                '<span class="badge text-bg-danger">Inactivo</span>';

                document.querySelector("#celIdeUsuario").innerHTML = objData.data.ideusuario;
                document.querySelector("#celCorreoUsuario").innerHTML = objData.data.correo;
                document.querySelector("#celNombresUsuario").innerHTML = objData.data.nombres;
                document.querySelector("#celRolUsuario").innerHTML = objData.data.nombrerol;
                document.querySelector("#celEstadoUsuario").innerHTML = estadoUsuario;
                
                $('#modalViewUsuario').modal('show');
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, ideusuario){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+ideusuario;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#ideUsuario").value = objData.data.ideusuario;
                document.querySelector("#txtCorreoUsuario").value = objData.data.correo;
                document.querySelector("#txtNombresUsuario").value = objData.data.nombres;
                document.querySelector("#txtRolUsuario").value = objData.data.idrol;
                
                // ESTADO ACTIVO O INACTIVO
                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                
            }
        }
        $('#modalFormUsuario').modal('show');
        
    }
    
}

function fntDelInfo(ideusuario){
    Swal.fire({
        title: "Eliminar la Asignación",
        text: "¿Estás seguro?",
        imageUrl: "Assets/images/iconos/eliminar.png" ,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonColor: "#00A6FF",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
      }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/delUsuario';
            let strData = "ideUsuario="+ideusuario;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Eliminar!", objData.msg , "success");
                        tableUsuarios.api().ajax.reload();
                    }else{
                        Swal.fire("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}

document.addEventListener('DOMContentLoaded', function () {
    console.log('La página está completamente cargada');
    var myModal = new bootstrap.Modal(document.getElementById('modalFormUsuario'));
    // myModal.show();
});


function openModal()
{
    rowTable = "";
    document.querySelector('#ideUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}




