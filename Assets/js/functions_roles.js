function reload(time) {
    setTimeout(() => {
        location.reload();
    }, time);
}
var tableRoles;
let rowTable = "";
var divLoading;
document.addEventListener('DOMContentLoaded', function(){
    divLoading = document.querySelector("#divLoading");

	tableRoles = $('#tableRoles').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/Roles/getRoles",
            "dataSrc":""
        },
        "columns":[
            {"data":"nombrerol"},
            {"data":"descripcion"},
            {"data":"status"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });


    //NUEVO ROL
    var formRol = document.querySelector("#formRol");
    formRol.onsubmit = function(e) {
        e.preventDefault();

        var intIdRol = document.querySelector('#idRol').value;
        var strNombre = document.querySelector('#txtNombre').value;
        var strDescripcion = document.querySelector('#txtDescripcion').value;
        var intStatus = document.querySelector('#listStatus').value;        
        if(strNombre == '' || strDescripcion == '' || intStatus == '')
        {
            Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        
        // Verificar si es el rol de superadministrador
        if(intIdRol == 1) {
            Swal.fire("Atención", "No se puede modificar el rol de Superadministrador." , "error");
            return false;
        }
        
        if(divLoading) {
            if(divLoading) divLoading.style.display = "flex";
        }
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Roles/setRol'; 
        var formData = new FormData(formRol);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                try {
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormRol').modal("hide");
                        formRol.reset();
                        Swal.fire("Rol Creado", objData.msg ,"success");
                        tableRoles.api().ajax.reload();
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                } catch (e) {
                    console.error("Error al procesar la respuesta:", e);
                    Swal.fire("Error", "Error al procesar la respuesta del servidor", "error");
                }              
            } 
            if(divLoading) {
                if(divLoading) divLoading.style.display = "none";
            }
            return false;
        }
        
    }

});

function openModal(){

    document.querySelector('#idRol').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector("#formRol").reset();
	$('#modalFormRol').modal('show');
}

window.addEventListener('load', function() {
//    fntEditRol();
//     fntDelRol();
//     fntPermisos();
}, false);

function fntEditRol(idrol){
    // Verificar si es el rol de superadministrador
    if(idrol == 1) {
        Swal.fire("Atención", "No se puede editar el rol de Superadministrador." , "error");
        return false;
    }
    
    document.querySelector('#titleModal').innerHTML ="Actualizar Rol";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    var idrol = idrol;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl  = base_url+'/Roles/getRol/'+idrol;
    request.open("GET",ajaxUrl ,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            try {
                var objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    document.querySelector("#idRol").value = objData.data.idrol;
                    document.querySelector("#txtNombre").value = objData.data.nombrerol;
                    document.querySelector("#txtDescripcion").value = objData.data.descripcion;

                    // ESTADO ACTIVO O INACTIVO
                    // $('#listStatus').selectpicker('render');
                    if(objData.data.status == 1){
                        document.querySelector("#listStatus").value = 1;
                    }else{
                        document.querySelector("#listStatus").value = 2;
                    }

                    $('#modalFormRol').modal('show');
                }else{
                    Swal.fire("Error", objData.msg , "error");
                }
            } catch (e) {
                console.error("Error al procesar la respuesta:", e);
                Swal.fire("Error", "Error al procesar la respuesta del servidor", "error");
            }
        }
    }

}

function fntDelRol(idrol){
    // Verificar si es el rol de superadministrador
    if(idrol == 1) {
        Swal.fire("Atención", "No se puede eliminar el rol de Superadministrador." , "error");
        return false;
    }
    
    var idrol = idrol;
        Swal.fire({
            title: "Eliminar Rol",
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

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Roles/delRol/';
            var strData = "idrol="+idrol;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    try {
                        var objData = JSON.parse(request.responseText);
                        if(objData.status)
                        {
                            Swal.fire("Eliminado", objData.msg , "success");
                            tableRoles.api().ajax.reload();
                        }else{
                            Swal.fire("Atención!", objData.msg , "error");
                        }
                    } catch (e) {
                        console.error("Error al procesar la respuesta:", e);
                        Swal.fire("Error", "Error al procesar la respuesta del servidor", "error");
                    }
                }
            }
        
        }
    });
}

function fntPermisos(idrol){
    // Verificar si es el rol de superadministrador
    if(idrol == 1) {
        Swal.fire("Atención", "No se pueden modificar los permisos del Superadministrador." , "error");
        return false;
    }
    
    var idrol = idrol;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#contentAjax').innerHTML = request.responseText;
            $('.modalPermiso').modal('show');
            document.querySelector('#modalFormPermiso').addEventListener('submit',fntSavePermisos,false);
        }
    }
}

function fntSavePermisos(evnet){
    evnet.preventDefault();
    
    // Verificar si es el rol de superadministrador
    var idrol = document.querySelector("#idrol").value;
    if(idrol == 1) {
        Swal.fire("Atención", "No se pueden modificar los permisos del Superadministrador." , "error");
        return false;
    }
    
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/setPermisos'; 
    var formElement = document.querySelector("#formPermiso");
    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            try {
                var objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormPermiso').modal("hide");
                    formPermiso.reset();
                    Swal.fire("Permisos", objData.msg ,"success");
                }else{
                    Swal.fire("Error", objData.msg , "error");
                }
            } catch (e) {
                console.error("Error al procesar la respuesta:", e);
                Swal.fire("Error", "Error al procesar la respuesta del servidor", "error");
            }
        }
    }
    
}

// Checkbox maestro por fila en permisos
$(document).on('change', '.check-row-master', function() {
    var row = $(this).data('row');
    var checked = $(this).is(':checked');
    $(this).closest('tr').find('input[type=checkbox]').not(this).prop('checked', checked);
});

// Función para sincronizar el checkbox maestro de cada fila
function sincronizarCheckboxMaestroPermisos() {
    $('tr').each(function() {
        var checkboxes = $(this).find('input[type=checkbox]').not('.check-row-master');
        var master = $(this).find('.check-row-master');
        if (checkboxes.length && master.length) {
            var allChecked = true;
            checkboxes.each(function() {
                if (!$(this).is(':checked')) allChecked = false;
            });
            master.prop('checked', allChecked);
        }
    });
}

// Ejecutar al cargar la página
$(document).ready(function() {
    sincronizarCheckboxMaestroPermisos();
});

// Ejecutar cada vez que se muestre el modal de permisos
$(document).on('shown.bs.modal', '#modalFormPermiso', function() {
    sincronizarCheckboxMaestroPermisos();
});