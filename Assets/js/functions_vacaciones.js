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
            "url": " " + base_url + "/vacaciones/getFuncionarios",
            "dataSrc": ""
        },
        "columns": [
            { "data": "nombre_completo" },
            { "data": "nm_identificacion" },
            { "data": "cargo_nombre" },
            { "data": "fecha_ingreso" },
            { "data": "anos_servicio" },
            { "data": "periodos_disponibles" },
            { "data": "options" }
        ]
    });
    
    // Actualizar estado de vacaciones al cargar la página
    actualizarEstadoVacaciones();
  },
  false
);

// Función para actualizar el estado de las vacaciones
function actualizarEstadoVacaciones() {
    if (typeof base_url !== 'undefined') {
        let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/vacaciones/actualizarEstadoVacaciones';
        
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                console.log("Estado de vacaciones actualizado");
                // Recargar la tabla para mostrar los cambios
                if (typeof tableFuncionarios !== 'undefined') {
                    tableFuncionarios.api().ajax.reload(null, false);
                }
            }
        }
    }
}

function fntViewInfo(idefuncionario) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl =
    base_url + "/vacaciones/getFuncionario/" + idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
        
      if (objData.status) {
        document.querySelector("#celIdeFuncionario").innerHTML = objData.data.idefuncionario;
        document.querySelector("#celNombresFuncionario").innerHTML = objData.data.nombre_completo;
        document.querySelector("#celIdentificacion").innerHTML = objData.data.nm_identificacion;
        document.querySelector("#celCargoFuncionario").innerHTML = objData.data.cargo_nombre;
        document.querySelector("#celDependenciaFuncionario").innerHTML = objData.data.dependencia_nombre;
        document.querySelector("#celFechaIngreso").innerHTML = objData.data.fecha_ingreso;
        document.querySelector("#celAnosServicio").innerHTML = objData.data.anos_servicio;
        document.querySelector("#celPeriodosDisponibles").innerHTML = objData.data.periodos_disponibles;

        $("#modalViewFuncionario").modal("show");
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

function fntVacacionesInfo(idefuncionario) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl =
    base_url + "/vacaciones/getFuncionario/" + idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
        
      if (objData.status) {
        document.querySelector("#idFuncionario").value = objData.data.idefuncionario;
        document.querySelector("#txtNombreFuncionario").value = objData.data.nombre_completo;
        
        // Establecer fecha mínima como hoy usando formato ISO para evitar problemas de zona horaria
        let today = new Date();
        let localISOTime = new Date(today.getTime() - (today.getTimezoneOffset() * 60000)).toISOString().split('T')[0];
        document.querySelector("#txtFechaInicio").setAttribute("min", localISOTime);
        document.querySelector("#txtFechaInicio").value = localISOTime;
        
        // Calcular fecha fin por defecto (15 días después)
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + 15);
        let localISOEndTime = new Date(endDate.getTime() - (endDate.getTimezoneOffset() * 60000)).toISOString().split('T')[0];
        document.querySelector("#txtFechaFin").setAttribute("min", localISOTime);
        document.querySelector("#txtFechaFin").value = localISOEndTime;
        document.querySelector("#txtFechaFin").setAttribute("min", today);
        document.querySelector("#txtFechaFin").value = defaultEndDate;
        
        // Mostrar períodos disponibles
        document.querySelector("#periodosDisponibles").innerHTML = objData.data.periodos_disponibles;
        
        // Limitar opciones de períodos según disponibilidad
        let selectPeriodo = document.querySelector("#listPeriodo");
        selectPeriodo.innerHTML = '<option value="">Seleccione un período</option>';
        
        for (let i = 1; i <= Math.min(3, objData.data.periodos_disponibles); i++) {
            selectPeriodo.innerHTML += `<option value="${i}">${i} Período${i > 1 ? 's' : ''}</option>`;
        }

        $("#modalFormVacaciones").modal("show");
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
  let ajaxUrl = base_url + "/vacaciones/getFuncionario/" + idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      
      let objData = JSON.parse(request.responseText);
      
      if (objData.status) {
        document.querySelector("#funcionarioHistorial").innerHTML = "Funcionario: " + objData.data.nombre_completo;
        
        // Guardar el ID del funcionario para el botón de PDF
        document.querySelector("#btnGenerarPDF").setAttribute("data-id", idefuncionario);
        
        // Ahora obtenemos el historial de vacaciones
        let requestHistorial = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrlHistorial = base_url + "/vacaciones/getHistorialVacaciones/" + idefuncionario;
        
        requestHistorial.open("GET", ajaxUrlHistorial, true);
        requestHistorial.send();
        requestHistorial.onreadystatechange = function () {
          if (requestHistorial.readyState == 4 && requestHistorial.status == 200) {
            let objDataHistorial = JSON.parse(requestHistorial.responseText);
            let htmlHistorial = "";
            
            if (objDataHistorial.status) {
              objDataHistorial.data.forEach(function(item) {
                // Corregir el problema de zona horaria en la visualización de fechas
                let fechaInicioObj = new Date(item.fecha_inicio);
                let fechaFinObj = new Date(item.fecha_fin);
                
                // Ajustar para mostrar la fecha correcta
                fechaInicioObj.setDate(fechaInicioObj.getDate() + 1);
                fechaFinObj.setDate(fechaFinObj.getDate() + 1);
                
                let fechaInicio = fechaInicioObj.toLocaleDateString();
                let fechaFin = fechaFinObj.toLocaleDateString();
                let btnCancelar = '';
                
                if (item.estado === 'Aprobado') {
                  btnCancelar = `<button class="btn btn-danger btn-sm" onclick="fntCancelarVacaciones(${item.id_vacaciones})" title="Cancelar"><i class="bi bi-x-circle"></i></button>`;
                }
                
                // Verificar si la fecha de fin ya pasó para mostrar como cumplida
                let fechaFinDate = new Date(item.fecha_fin);
                fechaFinDate.setDate(fechaFinDate.getDate() + 1); // Ajustar para compensar el problema de zona horaria
                let hoy = new Date();
                hoy.setHours(0, 0, 0, 0);
                fechaFinDate.setHours(0, 0, 0, 0);
                
                // Aplicar clase de estilo según el estado y texto a mostrar
                let estadoClass = '';
                let estadoTexto = item.estado;
                
                if (item.estado === 'Cumplidas' || (item.estado === 'Aprobado' && fechaFinDate <= hoy)) {
                  estadoClass = 'text-success fw-bold';
                  estadoTexto = 'Cumplida';
                } else if (item.estado === 'Cancelado') {
                  estadoClass = 'text-danger';
                }
                
                htmlHistorial += `<tr>
                  <td>${fechaInicio}</td>
                  <td>${fechaFin}</td>
                  <td>${item.periodo}</td>
                  <td><span class="${estadoClass}">${estadoTexto}</span></td>
                  <td>${btnCancelar}</td>
                </tr>`;
              });
              document.querySelector("#tableHistorialVacaciones").innerHTML = htmlHistorial;
            } else {
              htmlHistorial = `<tr><td colspan="5" class="text-center">No hay vacaciones registradas</td></tr>`;
              document.querySelector("#tableHistorialVacaciones").innerHTML = htmlHistorial;
            }
            
            $("#modalHistorialVacaciones").modal("show");
          }
        };
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

function fntCancelarVacaciones(idVacaciones) {
  Swal.fire({
    title: "¿Cancelar Vacaciones?",
    text: "¿Está seguro de cancelar estas vacaciones? Esta acción devolverá los períodos al funcionario.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, cancelar",
    cancelButtonText: "No, regresar"
  }).then((result) => {
    if (result.isConfirmed) {
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = base_url + '/vacaciones/cancelarVacaciones';
      let formData = new FormData();
      formData.append('idVacaciones', idVacaciones);
      
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
          let objData = JSON.parse(request.responseText);
          
          if (objData.status) {
            // Cerrar el modal actual
            $("#modalHistorialVacaciones").modal("hide");
            
            Swal.fire("Vacaciones", objData.msg, "success");
            
            // Recargar la tabla
            tableFuncionarios.api().ajax.reload();
          } else {
            Swal.fire("Error", objData.msg, "error");
          }
        }
      }
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  // Formulario para registrar vacaciones
  let formVacaciones = document.querySelector("#formVacaciones");
  formVacaciones.addEventListener('submit', function(e) {
    e.preventDefault();
    
    let idFuncionario = document.querySelector('#idFuncionario').value;
    let fechaInicio = document.querySelector('#txtFechaInicio').value;
    let fechaFin = document.querySelector('#txtFechaFin').value;
    let periodo = document.querySelector('#listPeriodo').value;
    
    if (idFuncionario == '' || fechaInicio == '' || fechaFin == '' || periodo == '') {
      Swal.fire("Error", "Todos los campos son obligatorios", "error");
      return false;
    }
    
    // Convertir fechas para comparación
    let fechaInicioObj = new Date(fechaInicio);
    let fechaFinObj = new Date(fechaFin);
    
    // Ajustar zona horaria para evitar problemas con las fechas
    fechaInicioObj.setHours(12, 0, 0, 0);
    fechaFinObj.setHours(12, 0, 0, 0);
    
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/vacaciones/setVacaciones';
    let formData = new FormData(formVacaciones);
    
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function() {
      if (request.readyState == 4 && request.status == 200) {
        let objData = JSON.parse(request.responseText);
        
        if (objData.status) {
          $('#modalFormVacaciones').modal("hide");
          formVacaciones.reset();
          Swal.fire("Vacaciones", objData.msg, "success");
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
  
  // Validar fechas
  document.querySelector("#txtFechaInicio").addEventListener('change', function() {
    let fechaInicio = this.value;
    document.querySelector("#txtFechaFin").setAttribute("min", fechaInicio);
    
    // Si la fecha fin es anterior a la nueva fecha inicio, actualizar fecha fin
    let fechaFin = document.querySelector("#txtFechaFin").value;
    if (fechaFin < fechaInicio) {
      // Calcular fecha 15 días después
      let endDate = new Date(fechaInicio + "T12:00:00");
      endDate.setDate(endDate.getDate() + 15);
      let endDD = String(endDate.getDate()).padStart(2, '0');
      let endMM = String(endDate.getMonth() + 1).padStart(2, '0');
      let endYYYY = endDate.getFullYear();
      let newEndDate = endYYYY + '-' + endMM + '-' + endDD;
      document.querySelector("#txtFechaFin").value = newEndDate;
    }
  });
});

function generarPDF() {
  // Obtener el ID del funcionario directamente del botón
  let idFuncionario = document.querySelector("#btnGenerarPDF").getAttribute("data-id");
  
  if (idFuncionario) {
    try {
      // Redirigir a la URL para generar el PDF
      window.open(base_url + '/vacaciones/generarPDF/' + idFuncionario, '_blank');
    } catch (error) {
      console.error("Error al generar PDF:", error);
      Swal.fire("Error", "Hubo un problema al generar el PDF. Por favor, intente nuevamente.", "error");
    }
  } else {
    Swal.fire("Error", "No se pudo identificar el funcionario para generar el PDF", "error");
  }
}