let tableFuncionarios;
let rowTable = "";
document.addEventListener(
  "DOMContentLoaded",
  function () {
    tableFuncionarios = $('#tableFuncionarios').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "./es.json"
        },
        "ajax": {
            "url": " " + base_url + "/funcionariosPermisos/getFuncionarios",
            "dataSrc": ""
        },
        "columns": [
            { "data": "nombre_completo" },
            { "data": "nm_identificacion" },
            { "data": "cargo_nombre" },
            { "data": "dependencia_nombre" },
            { "data": "permisos" },
            { "data": "options" }
        ]
    });
  },
  false
);

function fntViewInfo(idefuncionario) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl =
    base_url + "/funcionariosPermisos/getFuncionario/" + idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
        
      if (objData.status) {
        document.querySelector("#celIdeFuncionario").innerHTML = objData.data.idefuncionario;
        document.querySelector("#celNombresFuncionario").innerHTML = objData.data.nombre_completo;
        document.querySelector("#celCargoFuncionario").innerHTML = objData.data.cargo_nombre;
        document.querySelector("#celDependenciaFuncionario").innerHTML = objData.data.dependencia_nombre;
        document.querySelector("#celPermisosMes").innerHTML = objData.data.permisos_mes_actual + "/3";

        $("#modalViewFuncionario").modal("show");
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

function fntPermitInfo(idefuncionario) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl =
    base_url + "/funcionariosPermisos/getFuncionario/" + idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
        
      if (objData.status) {
        document.querySelector("#idFuncionario").value = objData.data.idefuncionario;
        document.querySelector("#txtNombreFuncionario").value = objData.data.nombre_completo;
        document.querySelector("#permisosUsados").innerHTML = objData.data.permisos_mes_actual;
        
        // Establecer fecha mínima como hoy
        let today = new Date();
        let dd = String(today.getDate()).padStart(2, '0');
        let mm = String(today.getMonth() + 1).padStart(2, '0');
        let yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.querySelector("#txtFechaPermiso").setAttribute("min", today);
        document.querySelector("#txtFechaPermiso").value = today;
        
        // Verificar si ya usó los 3 permisos
        if (objData.data.permisos_mes_actual >= 3) {
          document.querySelector("#btnActionForm").disabled = true;
          document.querySelector("#permisosMesInfo").classList.remove("alert-info");
          document.querySelector("#permisosMesInfo").classList.add("alert-danger");
          document.querySelector("#permisosMesInfo").innerHTML = "El funcionario ya ha utilizado los 3 permisos permitidos para este mes.";
        } else {
          document.querySelector("#btnActionForm").disabled = false;
          document.querySelector("#permisosMesInfo").classList.remove("alert-danger");
          document.querySelector("#permisosMesInfo").classList.add("alert-info");
          document.querySelector("#permisosMesInfo").innerHTML = "Permisos utilizados este mes: <span id='permisosUsados'>" + objData.data.permisos_mes_actual + "</span>/3";
        }

        $("#modalFormPermiso").modal("show");
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

function fntViewHistorial(idefuncionario) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  
  // Primero obtenemos los datos del funcionario
  let ajaxUrl = base_url + "/funcionariosPermisos/getFuncionario/" + idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      
      if (objData.status) {
        document.querySelector("#funcionarioHistorial").innerHTML = "Funcionario: " + objData.data.nombre_completo;
        
        // Ahora obtenemos el historial de permisos
        let requestHistorial = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrlHistorial = base_url + "/funcionariosPermisos/getHistorialPermisos/" + idefuncionario;
        
        requestHistorial.open("GET", ajaxUrlHistorial, true);
        requestHistorial.send();
        requestHistorial.onreadystatechange = function () {
          if (requestHistorial.readyState == 4 && requestHistorial.status == 200) {
            let objDataHistorial = JSON.parse(requestHistorial.responseText);
            let htmlHistorial = "";
            
            if (objDataHistorial.status) {
              objDataHistorial.data.forEach(function(item) {
                let fechaFormateada = new Date(item.fecha_permiso).toLocaleDateString();
                htmlHistorial += `<tr>
                  <td>${fechaFormateada}</td>
                  <td>${item.motivo}</td>
                  <td>${item.estado}</td>
                </tr>`;
              });
            } else {
              htmlHistorial = `<tr><td colspan="3" class="text-center">No hay permisos registrados</td></tr>`;
            }
            
            document.querySelector("#tableHistorialPermisos").innerHTML = htmlHistorial;
            $("#modalHistorialPermisos").modal("show");
          }
        };
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

document.addEventListener('DOMContentLoaded', function() {
  // Formulario para crear permiso
  let formPermiso = document.querySelector("#formPermiso");
  formPermiso.addEventListener('submit', function(e) {
    e.preventDefault();
    
    let idFuncionario = document.querySelector('#idFuncionario').value;
    let fechaPermiso = document.querySelector('#txtFechaPermiso').value;
    let motivoPermiso = document.querySelector('#txtMotivoPermiso').value;
    
    if (idFuncionario == '' || fechaPermiso == '' || motivoPermiso == '') {
      Swal.fire("Error", "Todos los campos son obligatorios", "error");
      return false;
    }
    
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/funcionariosPermisos/setPermiso';
    let formData = new FormData(formPermiso);
    
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function() {
      if (request.readyState == 4 && request.status == 200) {
        let objData = JSON.parse(request.responseText);
        
        if (objData.status) {
          $('#modalFormPermiso').modal("hide");
          formPermiso.reset();
          Swal.fire("Permisos", objData.msg, "success");
          tableFuncionarios.api().ajax.reload();
        } else {
          Swal.fire("Error", objData.msg, "error");
        }
      }
    }
  });
});