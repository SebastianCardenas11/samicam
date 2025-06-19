let tableCategorias;
let rowTable = "";
document.addEventListener('DOMContentLoaded', function(){

    tableCategorias = $('#tableCategorias').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/CategoriasArchivos/getCategorias",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_categoria"},
            {"data":"nombre"},
            {"data":"descripcion"},
            {"data":"status"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    // Formulario para agregar/editar categoría
    let formCategoria = document.querySelector("#formCategoria");
    formCategoria.onsubmit = function(e) {
        e.preventDefault();
        
        let strNombre = document.querySelector('#txtNombre').value;
        
        if(strNombre == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        
        let divLoading = document.querySelector("#divLoading");
        if(divLoading) {
            divLoading.style.display = "flex";
        }
        
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/CategoriasArchivos/setCategoria'; 
        let formData = new FormData(formCategoria);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormCategoria').modal("hide");
                    formCategoria.reset();
                    Swal.fire("Categorías", objData.msg ,"success");
                    tableCategorias.api().ajax.reload();
                } else {
                    Swal.fire("Error", objData.msg , "error");
                }
            }
            if(divLoading) {
                divLoading.style.display = "none";
            }
            return false;
        }
    }
});

function openModal() {
    document.querySelector('#idCategoria').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-success");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
    document.querySelector("#formCategoria").reset();
    $('#modalFormCategoria').modal('show');
}

function fntViewCategoria(idcategoria) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/CategoriasArchivos/getCategoria/'+idcategoria;
    request.open("GET",ajaxUrl,true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                document.querySelector("#celId").innerHTML = objData.data.id_categoria;
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
                document.querySelector("#celEstado").innerHTML = objData.data.status == 1 ? 
                    '<span class="badge text-bg-success">Activo</span>' : 
                    '<span class="badge text-bg-danger">Inactivo</span>';
                document.querySelector("#celFechaCreacion").innerHTML = objData.data.fecha_creacion;
                
                $('#modalViewCategoria').modal('show');
            } else {
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditCategoria(idcategoria) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Categoría";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-success", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/CategoriasArchivos/getCategoria/'+idcategoria;
    request.open("GET",ajaxUrl,true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                document.querySelector("#idCategoria").value = objData.data.id_categoria;
                document.querySelector("#txtNombre").value = objData.data.nombre;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                
                if(objData.data.status == 1) {
                    document.querySelector("#listStatus").value = 1;
                } else {
                    document.querySelector("#listStatus").value = 0;
                }
                
                $('#modalFormCategoria').modal('show');
            } else {
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

function fntDelCategoria(idcategoria) {
    Swal.fire({
        title: "Eliminar Categoría",
        text: "¿Realmente quiere eliminar esta categoría?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/CategoriasArchivos/delCategoria';
            let strData = "idCategoria="+idcategoria;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        Swal.fire("Eliminar", objData.msg , "success");
                        tableCategorias.api().ajax.reload();
                    } else {
                        Swal.fire("Atención", objData.msg , "error");
                    }
                }
            }
        }
    });
}