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
            { "data": "imagen" },
            { "data": "nombre_completo" },
            { "data": "nm_identificacion" },
            { "data": "cargo_nombre" },
            { "data": "dependencia_nombre" },
            { "data": "permisos" },
            { "data": "options" }
        ]
    });
    
    // Cargar los motivos de permisos al iniciar
    fntGetMotivosPermisos();
  },
  false
);

function fntGetMotivosPermisos() {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/funcionariosPermisos/getMotivosPermisos";
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        let htmlOptions = '<option value="">Seleccione un motivo</option>';
        objData.data.forEach(function(item) {
          htmlOptions += `<option value="${item.id}">${item.motivo}</option>`;
        });
        document.querySelector("#listMotivoPermiso").innerHTML = htmlOptions;
      }
    }
  };
}

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
        
        // Mostrar la imagen del funcionario
        document.querySelector("#celImagenFuncionario").src = objData.data.url_imagen;

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
        
        // Establecer fecha mínima como hoy
        let today = new Date();
        let localISOTime = new Date(today.getTime() - (today.getTimezoneOffset() * 60000)).toISOString().split('T')[0];
        document.querySelector("#txtFechaPermiso").setAttribute("min", localISOTime);
        document.querySelector("#txtFechaPermiso").value = localISOTime;
        
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
          document.querySelector("#permisosMesInfo").innerHTML = "Permisos utilizados este mes: " + objData.data.permisos_mes_actual + "/3";
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
        
        // Mostrar imagen del funcionario
        document.querySelector("#imgFuncionarioHistorial").src = objData.data.url_imagen;
        
        // Guardar el ID del funcionario para el botón de PDF
        document.querySelector("#btnGenerarPDF").setAttribute("data-id", idefuncionario);
        
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
                let fechaFormateada = new Date(item.fecha_permiso + "T12:00:00").toLocaleDateString();
                htmlHistorial += `<tr>
                  <td>${fechaFormateada}</td>
                  <td>${item.motivo}</td>
                  <td class="text-success">${item.estado}</td>
                  <td>
                    <button class="btn btn-primary btn-sm" onclick="generarPermisoPDF(${item.id_permiso})" title="Descargar PDF">
                      <i class="bi bi-file-pdf"></i>
                    </button>
                  </td>
                </tr>`;
              });
              document.querySelector("#tableHistorialPermisos").innerHTML = htmlHistorial;
            } else {
              htmlHistorial = `<tr><td colspan="4" class="text-center">No hay permisos registrados</td></tr>`;
              document.querySelector("#tableHistorialPermisos").innerHTML = htmlHistorial;
            }
            
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
    let motivoPermiso = document.querySelector('#listMotivoPermiso').value;
    
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
  
  // Botón para generar PDF
  document.querySelector("#btnGenerarPDF").addEventListener('click', function() {
    generarPDF();
  });
});

function generarPDF() {
  // Obtener el ID del funcionario directamente del botón
  let idFuncionario = document.querySelector("#btnGenerarPDF").getAttribute("data-id");
  
  if (idFuncionario) {
    // Redirigir a la URL para generar el PDF
    window.open(base_url + '/funcionariosPermisos/generarPDF/' + idFuncionario, '_blank');
  } else {
    Swal.fire("Error", "No se pudo identificar el funcionario para generar el PDF", "error");
  }
}

function generarPermisoPDF(idPermiso) {
  if (idPermiso) {
    // Redirigir a la URL para generar el PDF del permiso individual
    window.open(base_url + '/funcionariosPermisos/generarPermisoPDF/' + idPermiso, '_blank');
  } else {
    Swal.fire("Error", "No se pudo identificar el permiso para generar el PDF", "error");
  }
}