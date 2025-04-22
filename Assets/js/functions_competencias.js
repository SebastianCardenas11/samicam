let tableCompetencias; 
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableCompetencias = $('#tableCompetencias').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Competencias/getCompetencias",
            "dataSrc":""
        },
        "columns":[
            {"data":"codigocompetencia"},
            {"data":"nombrecompetencia"},
            {"data":"horascompetencia"},
            {"data":"avancehorascompetencia"},
            {"data":"numeroficha"},
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



	if(document.querySelector("#formCompetencia")){
        let formCompetencia = document.querySelector("#formCompetencia");

        formCompetencia.onsubmit = function(e) {
            e.preventDefault();
            var intIdeCompetencia = document.querySelector('#ideCompetencia').value;
            let strCodigoCompetencia = document.querySelector('#txtCodigoCompetencia').value;
            let strTipoCompetencia = document.querySelector('#txtTipoCompetencia').value;
            let strNombreCompetencia = document.querySelector('#txtNombreCompetencia').value;
            let strHorasCompetencia = document.querySelector('#txtHorasCompetencia').value;
            let strCodigoPrograma = document.querySelector('#txtCodigoPrograma').value;
            let strNombrePrograma= document.querySelector('#txtIdePrograma').value;

            if(strCodigoCompetencia == '' || strNombreCompetencia == '' || strNombrePrograma == '')
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
            let ajaxUrl = base_url+'/Competencias/setCompetencia'; 
            let formData = new FormData(formCompetencia);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableCompetencias.api().ajax.reload();
                            document.getElementById('modalFormCompetencia').innerHTML = '';
                        }else{
                            tableCompetencias.api().ajax.reload();
                           rowTable = "";
                        }
                        $('#modalFormCompetencia').modal("hide");
                        formCompetencia.reset();
                        Swal.fire("Competencia", objData.msg ,"success");
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
        //TODO  PENDIDENTE DE HACER PRUEBAS
        // fntProgramas();
        // fntProgramasEditar();
    }

}, false);



function fntViewInfo(idecompetencia){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Competencias/getCompetencia/'+idecompetencia;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                
                // document.querySelector("#celIdeCompetencia").innerHTML = objData.data.idecompetencia;
                document.querySelector("#celCodigoCompetencia").innerHTML = objData.data.codigocompetencia;
                document.querySelector("#celNombreCompetencia").innerHTML = objData.data.nombrecompetencia;
                document.querySelector("#celTipoPrograma").innerHTML = objData.data.tipocompetencia;
                document.querySelector("#celHorasCompetencia").innerHTML = objData.data.horascompetencia;
                document.querySelector("#celNombrePrograma").innerHTML = objData.data.nombreprograma;
                
                $('#modalViewCompetencia').modal('show');
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

// TODO SELECCIONAR PROGRAMAS
function fntProgramas(){
    if(document.querySelector('#ListadoProgramas')){
        let ajaxUrl = base_url+'/Competencias/getSelectProgramas?op=combo';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#ListadoProgramas').innerHTML = request.responseText;
                // $('#ListadoProgramas').html(data);
                formCompetencia.reset();

            }
        }
    }
    
}

function fntProgramasEditar(){
    if(document.querySelector('#ListadoProgramas')){
        let ajaxUrl = base_url+'/Competencias/getSelectProgramasEditar?op=combo';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                // document.querySelector('#ListadoProgramas').innerHTML = request.responseText;
                document.querySelector('#ListadoProgramas').append(request.responseText);
                // $('#ListadoProgramas').html(data);
                // formCompetencia.reset();

            }
        }
    }
    
}

// LIMPIAR MODAL
$('#modalFormCompetencia').on('hidden.bs.modal', function(e) {
    $(this).find('#formCompetencia')[0].reset();

    fntProgramas();
    fntProgramasEditar();
    // const formulario = document.getElementById('formCompetencia');
    // formulario.reset();
    // $('#ListadoProgramas').empty();

  });

function fntEditInfo(element, idecompetencia){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Competencia";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Competencias/getCompetencia/'+idecompetencia;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                // fntProgramas();
                document.querySelector("#ideCompetencia").value = objData.data.idecompetencia;
                document.querySelector("#txtCodigoCompetencia").value = objData.data.codigocompetencia;
                document.querySelector("#txtNombreCompetencia").value = objData.data.nombrecompetencia;
                document.querySelector("#txtHorasCompetencia").value = objData.data.horascompetencia;

                // const strListadoProgramas = document.getElementById('ListadoProgramas');
                document.querySelector("#txtCodigoPrograma").value = objData.data.codigoprograma;
                // const option = document.createElement('#ListadoProgramas');
                // option.value = objData.data.codigoprograma;
                // select.appendChild(option);

                document.querySelector("#txtIdePrograma").value =objData.data.ideprograma;
                
            }
        }
        $('#modalFormCompetencia').modal('show');
        // fntProgramasEditar();       
    }

}


function fntDelInfo(idecompetencia){
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
            let ajaxUrl = base_url+'/Competencias/delCompetencia';
            let strData = "ideCompetencia="+idecompetencia;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Eliminar!", objData.msg , "success");
                        tableCompetencias.api().ajax.reload();
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
    document.querySelector('#ideCompetencia').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Competencia";
    document.querySelector("#formCompetencia").reset();
    $('#modalFormCompetencia').modal('show');
    //TODO  PENDIDENTE DE HACER PRUEBAS
    fntProgramas();
    // fntProgramasEditar();


}

function fntViewInfoCodigoPrograma(codprograma){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Competencias/getPrograma/'+codprograma;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.getElementById('txtIdePrograma').value = objData.data.ideficha;
   
            }else{
                document.getElementById("txtIdePrograma").value = '';
            }
        }
    }
}

