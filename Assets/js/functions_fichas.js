let tableFichas; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableFichas = $('#tableFichas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Fichas/getFichas",
            "dataSrc":""
        },
        "columns":[
            {"data":"numeroficha"},
            {"data":"nombreprograma"},
            {"data":"nombres"},
            {"data":"status"},
            {"data":"options"}

        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-warning mt-3"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success mt-3"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger mt-3"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info mt-3"
            }
        ],
        "responsive":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });



	if(document.querySelector("#formFicha")){
        let formFicha = document.querySelector("#formFicha");
        formFicha.onsubmit = function(e) {
            e.preventDefault();
            var intIdeFicha = document.querySelector('#ideFicha').value;
            let intNumeroFicha = document.querySelector('#txtFichaPrograma').value;
            let intUsuarioIde= document.querySelector('#txtIdeUsuario').value;
            let strIdeInstructor = document.querySelector('#txtIdeInstructor').value;
            let strCodigoPrograma = document.querySelector('#txtCodigoPrograma').value;
            let intProgramaIde= document.querySelector('#txtIdPrograma').value;


            if(strCodigoPrograma == '' || intProgramaIde == '' || intNumeroFicha == '' || strIdeInstructor == '')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos no estén vacíos" , "error");
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Fichas/setFicha'; 
            let formData = new FormData(formFicha);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableFichas.api().ajax.reload();
                        }else{
                            tableFichas.api().ajax.reload();
                           rowTable = "";
                        }
                        $('#modalFormFicha').modal("hide");
                        formFicha.reset();
                        Swal.fire("Ficha", objData.msg ,"success");
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



function fntViewInfo(ideficha){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Fichas/getFicha/'+ideficha;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                
                document.querySelector("#celIdeFicha").innerHTML = objData.data.numeroficha;
                document.querySelector("#celCodigoPrograma").innerHTML = objData.data.nombreprograma;
                document.querySelector("#celNumeroFicha").innerHTML = objData.data.nombres;
                document.querySelector("#celIdeInstructor").innerHTML = objData.data.horasprograma;
                document.querySelector("#celEstadoFicha").innerHTML = objData.data.nivelprograma;
                
                $('#modalViewFicha').modal('show');
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, ideficha){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Ficha";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Fichas/getFicha/'+ideficha;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                
                document.querySelector("#ideFicha").value = objData.data.ideficha;
                document.querySelector("#txtCodigoPrograma").value = objData.data.codigoprograma;
                document.querySelector("#txtIdPrograma").value = objData.data.ideprograma;
                document.querySelector("#txtFichaPrograma").value = objData.data.numeroficha;
                document.querySelector("#txtIdeInstructor").value =objData.data.identificacion;
                document.querySelector("#txtIdeUsuario").value =objData.data.ideusuario;

                
            }
        }
        $('#modalFormFicha').modal('show');
        
    }
    
}


function fntDelInfo(ideficha){
    Swal.fire({
        title: "Eliminar Programa",
        text: "¿Está seguro?",
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
            let ajaxUrl = base_url+'/Fichas/delFicha';
            let strData = "ideficha="+ideficha;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Eliminar!", objData.msg , "success");
                        tableFichas.api().ajax.reload();
                    }else{
                        Swal.fire("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}

function openModal()
{
    rowTable = "";
    document.querySelector('#ideFicha').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Ficha";
    document.querySelector("#formFicha").reset();
    $('#modalFormFicha').modal('show');
}



function fntViewInfoCodigoPrograma(codprograma){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Fichas/getPrograma/'+codprograma;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.getElementById('txtIdPrograma').value = objData.data.ideprograma;
            }else{
                document.getElementById("txtIdPrograma").value = '';
            }
        }
    }
}

function fntViewInfoIdeInstructor(identificacion){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Fichas/getInstructor/'+identificacion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.getElementById('txtIdeUsuario').value = objData.data.ideusuario;
            }else{
                document.getElementById("txtIdeUsuario").value = '';
            }
        }
    }
}

