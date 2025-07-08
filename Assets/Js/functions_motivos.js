let tableMotivos;

document.addEventListener('DOMContentLoaded', function(){
    fntMotivos();
});

function fntMotivos(){
    if ($.fn.DataTable.isDataTable('#tableMotivos')) {
        $('#tableMotivos').DataTable().destroy();
    }
    
    tableMotivos = $('#tableMotivos').DataTable({
        "ajax": {
            "url": base_url + '/MotivoPermiso/getMotivos',
            "type": "POST",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_motivo" },
            { "data": "nombre" },
            { "data": "descripcion" },
            { 
                "data": "status",
                "render": function(data) {
                    return data == 1 ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-danger">Inactivo</span>';
                }
            },
            {
                "data": "id_motivo",
                "orderable": false,
                "render": function(data) {
                    return '<button class="btn btn-info btn-sm" onclick="fntViewMotivo(' + data + ')" title="Ver"><i class="far fa-eye"></i></button> ' +
                           '<button class="btn btn-warning btn-sm" onclick="fntEditMotivo(' + data + ')" title="Editar"><i class="fas fa-pencil-alt"></i></button> ' +
                           '<button class="btn btn-danger btn-sm" onclick="fntDelMotivo(' + data + ')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "responsive": true
    });
}

function openModal(){
    document.querySelector('#idMotivo').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-success");
    document.querySelector('#btnActionForm').textContent = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Motivo";
    document.querySelector("#formMotivo").reset();
    
    // Remover atributos readonly y disabled
    document.querySelector('#txtNombre').removeAttribute('readonly');
    document.querySelector('#txtDescripcion').removeAttribute('readonly');
    document.querySelector('#listStatus').removeAttribute('disabled');
    document.querySelector('#btnActionForm').style.display = 'block';
    
    $('#modalFormMotivo').modal({
        backdrop: 'static',
        keyboard: false
    }).modal('show');
}

function fntViewMotivo(idmotivo){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/MotivoPermiso/getMotivo/' + idmotivo;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData){
                document.querySelector("#idMotivo").value = objData.id_motivo;
                document.querySelector("#txtNombre").value = objData.nombre;
                document.querySelector("#txtDescripcion").value = objData.descripcion;
                document.querySelector("#listStatus").value = objData.status;
                
                document.querySelector('#txtNombre').setAttribute('readonly', true);
                document.querySelector('#txtDescripcion').setAttribute('readonly', true);
                document.querySelector('#listStatus').setAttribute('disabled', true);
                document.querySelector('#btnActionForm').style.display = 'none';
                
                document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
                document.querySelector('#titleModal').innerHTML = "Ver Motivo";
                $('#modalFormMotivo').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            }
        }
    }
}

function fntEditMotivo(idmotivo){
    document.querySelector('#titleModal').innerHTML = "Actualizar Motivo";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-success", "btn-info");
    document.querySelector('#btnActionForm').textContent = "Actualizar";
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/MotivoPermiso/getMotivo/' + idmotivo;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData){
                document.querySelector("#idMotivo").value = objData.id_motivo;
                document.querySelector("#txtNombre").value = objData.nombre;
                document.querySelector("#txtDescripcion").value = objData.descripcion;
                document.querySelector("#listStatus").value = objData.status;
                
                document.querySelector('#txtNombre').removeAttribute('readonly');
                document.querySelector('#txtDescripcion').removeAttribute('readonly');
                document.querySelector('#listStatus').removeAttribute('disabled');
                document.querySelector('#btnActionForm').style.display = 'block';
                
                $('#modalFormMotivo').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            }
        }
    }
}

function fntDelMotivo(idmotivo){
    Swal.fire({
        title: 'Eliminar Motivo',
        text: '¿Realmente quiere eliminar el motivo? Si está siendo usado en permisos, solo se desactivará.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/MotivoPermiso/delMotivo';
            let strData = "id_motivo=" + idmotivo;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    
                    let objData = JSON.parse(request.responseText);
                    if(objData.status){
                        Swal.fire({
                            title: 'Eliminado',
                            text: objData.msg,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then(() => {
                            tableMotivos.ajax.reload();
                        });
                    }else{
                        Swal.fire('Error', objData.msg, 'error');
                    }
                }
            }
        }
    });
}

function fntSaveMotivo(){
    let strNombre = document.querySelector('#txtNombre').value;
    if(strNombre == ''){
        Swal.fire('Atención', 'Todos los campos son obligatorios.', 'error');
        return false;
    }
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/MotivoPermiso/setMotivo';
    let formData = new FormData(document.querySelector('#formMotivo'));
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                $('#modalFormMotivo').modal("hide");
                Swal.fire('Motivos de permisos', objData.msg, 'success');
                tableMotivos.ajax.reload();
            }else{
                Swal.fire('Error', objData.msg, 'error');
            }
        }
    }
}