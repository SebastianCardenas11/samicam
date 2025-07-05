let tableUsuarios; 
let rowTable = "";
var divLoading;
document.addEventListener('DOMContentLoaded', function(){
    divLoading = document.querySelector("#divLoading");

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
            {"data":"roles_asignados"},
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

    // Cargar roles al inicio
    fntRolesUsuario();
    fntCargarRolesAdicionales();
    
    // Configurar el botón para mostrar/ocultar contraseña
    if(document.querySelector("#btnTogglePassword")){
        document.querySelector("#btnTogglePassword").addEventListener("click", function(){
            const passwordInput = document.querySelector("#txtContrasenaUsuario");
            const icon = this.querySelector("i");
            
            if(passwordInput.type === "text"){
                passwordInput.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        });
    }

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
            
            // Validar contraseña solo en modo creación
            if(intIdeUsuario == '' || intIdeUsuario == 0) {
                let strContrasena = document.querySelector('#txtContrasenaUsuario').value;
                if(strContrasena == '') {
                    Swal.fire("Atención", "La contraseña es obligatoria para crear un usuario." , "error");
                    return false;
                }
            }
            
            // Obtener roles adicionales seleccionados
            let rolesAdicionales = [];
            document.querySelectorAll('input[name="txtRolesAdicionales[]"]:checked').forEach(function(checkbox) {
                rolesAdicionales.push(checkbox.value);
            });
            
            // Agregar roles adicionales al FormData
            let formData = new FormData(formUsuario);
            rolesAdicionales.forEach(function(rol) {
                formData.append('txtRolesAdicionales[]', rol);
            });
            
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            if(divLoading) divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/setUsuario'; 
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableUsuarios.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1 ? 
                            '<span class="badge text-bg-success">Activo</span>' : 
                            '<span class="badge text-bg-danger">Inactivo</span>';
                            rowTable.cells[1].textContent =  strCorreoUsuario;
                            rowTable.cells[2].textContent = document.querySelector("#txtRolUsuario").selectedOptions[0].text;
                            rowTable.cells[3].innerHTML = htmlStatus;
                            rowTable = "";
                        }
                        $('#modalFormUsuario').modal("hide");
                        formUsuario.reset();
                        Swal.fire("Usuario", objData.msg ,"success");
                        setTimeout(() => {
                            location.reload()
                        }, 500);
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                if(divLoading) divLoading.style.display = "none";
                return false;
            }
        }
    }

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
            }
        }
    }
}

// NUEVA FUNCIÓN: Cargar roles adicionales como checkboxes
function fntCargarRolesAdicionales(){
    let ajaxUrl = base_url+'/Roles/getSelectRoles';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let rolesContainer = document.querySelector('#rolesAdicionalesContainer');
            if(rolesContainer) {
                rolesContainer.innerHTML = '';
                
                // Parsear la respuesta HTML para obtener las opciones
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = request.responseText;
                let options = tempDiv.querySelectorAll('option');
                
                options.forEach(function(option) {
                    if(option.value && option.value != '') {
                        let checkboxDiv = document.createElement('div');
                        checkboxDiv.className = 'form-check form-check-inline';
                        checkboxDiv.innerHTML = `
                            <input class="form-check-input" type="checkbox" 
                                   name="txtRolesAdicionales[]" 
                                   value="${option.value}" 
                                   id="rol_${option.value}">
                            <label class="form-check-label" for="rol_${option.value}">
                                ${option.textContent}
                            </label>
                        `;
                        rolesContainer.appendChild(checkboxDiv);
                    }
                });
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
                
                // Mostrar roles adicionales si existen
                if(objData.data.roles && objData.data.roles.length > 0) {
                    let rolesHtml = objData.data.roles.map(rol => 
                        `<span class="badge text-bg-info me-1">${rol.nombrerol}</span>`
                    ).join('');
                    document.querySelector("#celRolesAdicionales").innerHTML = rolesHtml;
                } else {
                    document.querySelector("#celRolesAdicionales").innerHTML = 
                        '<span class="text-muted">Sin roles adicionales</span>';
                }
                
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
    document.querySelector('#btnActionForm').classList.replace("btn-success", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    
    document.querySelector('#divContrasena').style.display = 'block';
    document.querySelector('#txtContrasenaUsuario').removeAttribute('required');
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Usuarios/getUsuario/'+ideusuario;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector('#ideUsuario').value = objData.data.ideusuario;
                document.querySelector('#txtCorreoUsuario').value = objData.data.correo;
                document.querySelector('#txtNombresUsuario').value = objData.data.nombres;
                document.querySelector('#txtRolUsuario').value = objData.data.rolid;
                document.querySelector('#listStatus').value = objData.data.status;
                
                // Marcar roles adicionales si existen
                if(objData.data.roles_ids && objData.data.roles_ids.length > 0) {
                    // Desmarcar todos primero
                    document.querySelectorAll('input[name="txtRolesAdicionales[]"]').forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                    
                    // Marcar los roles que tiene el usuario
                    objData.data.roles_ids.forEach(function(rolId) {
                        let checkbox = document.querySelector(`input[name="txtRolesAdicionales[]"][value="${rolId}"]`);
                        if(checkbox) {
                            checkbox.checked = true;
                        }
                    });
                }
                
                $('#modalFormUsuario').modal('show');
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

function fntDelInfo(ideusuario){
    Swal.fire({
        icon: "warning",
        title: "¿Está seguro de eliminar el Usuario?",
        text: "Una vez eliminado no se podrá recuperar",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
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
                        Swal.fire("Eliminado!", objData.msg, "success");
                        tableUsuarios.api().ajax.reload();
                    } else {
                        Swal.fire("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function openModal()
{
    document.querySelector('#ideUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-success");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    document.querySelector('#divContrasena').style.display = 'block';
    document.querySelector('#txtContrasenaUsuario').setAttribute('required', 'required');
    
    // Desmarcar todos los checkboxes de roles adicionales
    document.querySelectorAll('input[name="txtRolesAdicionales[]"]').forEach(function(checkbox) {
        checkbox.checked = false;
    });
    
    $('#modalFormUsuario').modal('show');
}