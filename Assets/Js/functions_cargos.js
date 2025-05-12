let tableCargos; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

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
            
            $('#listStatus').picker();
            let intEstatus = document.querySelector('#listStatus').value;

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
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cargos/setCargos'; 
            let formData = new FormData(formCargos);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            console.log(formData);
            
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                     let objData = JSON.parse(request.responseText);
                     
                    if(objData.status)
                    {
                    if(rowTable == ""){
                        tableCargos.api().ajax.reload();
                        // tableCargos.DataTable().ajax.reload();
                    }else{
                            htmlStatus = intEstatus == 1 ? 
                            '<span class="badge text-bg-success">Activo</span>' : 
                            '<span class="badge text-bg-danger">Inactivo</span>';
                            // tableUsuarios.api().ajax.reload();
                            rowTable.cells[0].textContent =  strNombresCargos;
                            rowTable.cells[1].textContent =  strNivel;
                            rowTable.cells[2].textContent =  intSalario;
                            rowTable.cells[3].innerHTML = htmlStatus;
                            rowTable = "";
                        }
                        $('#modalFormCargos').modal("hide");
                        formCargos.reset();
                        Swal.fire("Cargos", objData.msg ,"success");
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

// window.addEventListener('load', function() {
//     fntRolesUsuario();
// }, false);

// function fntRolesUsuario(){
// if(document.querySelector('#txtRolUsuario')){
//     let ajaxUrl = base_url+'/Roles/getSelectRoles';
//     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
//     request.open("GET",ajaxUrl,true);
//     request.send();
//     request.onreadystatechange = function(){
//         if(request.readyState == 4 && request.status == 200){
//             document.querySelector('#txtRolUsuario').innerHTML = request.responseText;
//             $('#txtRolUsuario').picker({search : true});
//             // $('.txtRolUsuario').selectpicker('refresh');
//             // $('#txtRolUsuario').picker();
//         }
//     }
// }
// }

function fntViewInfo(idecargos){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cargos/getCargo/'+idecargos;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {

                let estatus = objData.data.estatus == 1 ? 
                '<span class="badge text-bg-success">Activo</span>' : 
                '<span class="badge text-bg-danger">Inactivo</span>';

                // Eliminar o corregir el id ya que no existe en el modal
                // document.querySelector("#celIdeCragos").innerHTML = objData.data.idecargos;
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                document.querySelector("#celNivel").innerHTML = objData.data.nivel;
                document.querySelector("#celSalario").innerHTML = objData.data.salario;
                document.querySelector("#celEstadoCargo").innerHTML = estatus;
                
                $('#modalViewCargos').modal('show');
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, idecargos){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cargos/getCargo/'+idecargos;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#ideCargos").value = objData.data.idecargos;
                document.querySelector("#txtNombresCargos").value = objData.data.nombre;
                document.querySelector("#txtNivel").value = objData.data.nivel;
                document.querySelector("#txtSalario").value = objData.data.salario;
                
                
            }
        }
        $('#modalFormCargos').modal('show');
        
    }
    
}

function fntDelInfo(idecargos){
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
            let ajaxUrl = base_url+'/Cargos/delCargos';
            let strData = "ideCargos="+idecargos;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Eliminar!", objData.msg , "success");
                        tableCargos.api().ajax.reload();
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
    var myModal = new bootstrap.Modal(document.getElementById('modalFormCargos'));
    // myModal.show();
});


function openModal()
{
    rowTable = "";
    document.querySelector('#ideCargos').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formCargos").reset();
    $('#modalFormCargos').modal('show');
}




