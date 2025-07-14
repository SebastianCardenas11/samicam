let tableFuncionarios;
let rowTable = "";
let intervaloReloj;
let permisosDiarios = 0;
let maxPermisosDiarios = 5;

document.addEventListener(
  "DOMContentLoaded",
  function () {
    // Inicializar el reloj y contador de permisos
    iniciarReloj();
    cargarPermisosDiarios();
    
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
            { "data": "permisos_especiales" },
            { "data": "options" }
        ]
    });
    
    // Cargar los motivos de permisos al iniciar
    fntGetMotivosPermisos();
  },
  false
);

// Función para cargar los permisos diarios de hoy
function cargarPermisosDiarios() {
    // Obtener la fecha de hoy en formato YYYY-MM-DD
    let today = new Date();
    let fechaHoy = today.toISOString().split('T')[0];
    
    // Hacer una petición para obtener los permisos de hoy
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/funcionariosPermisos/getPermisosPorFecha/' + fechaHoy;
    
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    permisosDiarios = parseInt(objData.total);
                    maxPermisosDiarios = parseInt(document.getElementById('permisosDisponibles').getAttribute('data-max') || 5);
                   
                    actualizarInterfazPermisos();
                }
            } catch (error) {
                console.error('Error al procesar la respuesta:', error);
            }
        }
    };
}

// Función para actualizar la interfaz de permisos
function actualizarInterfazPermisos() {
    try {
        const permisosDisponibles = maxPermisosDiarios - permisosDiarios;
        const porcentaje = (permisosDiarios / maxPermisosDiarios) * 100;
        
     
        // Actualizar contadores
        document.getElementById('permisosDisponibles').textContent = permisosDisponibles;
        document.getElementById('permisosUsados').textContent = permisosDiarios;
        
        // Actualizar barra de progreso
        const barraProgreso = document.getElementById('barraProgreso');
        const textoProgreso = document.getElementById('textoProgreso');
        
        if (barraProgreso && textoProgreso) {
            barraProgreso.style.width = porcentaje + '%';
            barraProgreso.setAttribute('aria-valuenow', permisosDiarios);
            textoProgreso.textContent = `${permisosDiarios}/${maxPermisosDiarios}`;
            
            // Cambiar color de la barra según el progreso
            if (porcentaje >= 80) {
                barraProgreso.className = 'progress-bar bg-danger';
            } else if (porcentaje >= 60) {
                barraProgreso.className = 'progress-bar bg-warning';
            } else {
                barraProgreso.className = 'progress-bar bg-success';
            }
        }
    } catch (error) {
        console.error('Error al actualizar la interfaz:', error);
    }
}

// Función para iniciar el reloj
function iniciarReloj() {
    function actualizarReloj() {
        const ahora = new Date();
        const colombiaTime = new Date(ahora.toLocaleString("en-US", {timeZone: "America/Bogota"}));
        
        // Calcular tiempo hasta medianoche (12:00 AM)
        const medianoche = new Date(colombiaTime);
        medianoche.setHours(24, 0, 0, 0);
        
        const tiempoRestante = medianoche - colombiaTime;
        
        if (tiempoRestante > 0) {
            const horas = Math.floor(tiempoRestante / (1000 * 60 * 60));
            const minutos = Math.floor((tiempoRestante % (1000 * 60 * 60)) / (1000 * 60));
            const segundos = Math.floor((tiempoRestante % (1000 * 60)) / 1000);
            
            const tiempoFormateado = `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
            
            document.getElementById('tiempoRestante').textContent = tiempoFormateado;
        } else {
            // Es medianoche, resetear permisos
            cargarPermisosDiarios();
        }
    }
    
    // Actualizar inmediatamente
    actualizarReloj();
    
    // Actualizar cada segundo
    intervaloReloj = setInterval(actualizarReloj, 1000);
}

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
      let htmlOptions = '<option value="">Seleccione un motivo</option>';
      if (objData.status && Array.isArray(objData.data)) {
        objData.data.forEach(function(item) {
          htmlOptions += `<option value="${item.id}">${item.motivo}</option>`;
        });
      }
      document.querySelector("#listMotivoPermiso").innerHTML = htmlOptions;
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
          document.querySelector("#btnActionForm").style.display = "none";
          document.querySelector("#btnPermisoEspecial").style.display = "inline-block";
          document.querySelector("#permisosMesInfo").classList.remove("alert-info");
          document.querySelector("#permisosMesInfo").classList.add("alert-warning");
          document.querySelector("#permisosMesInfo").innerHTML = "El funcionario ya ha utilizado los 3 permisos permitidos para este mes. Use el botón de Permiso Especial para casos excepcionales.";
        } else {
          document.querySelector("#btnActionForm").style.display = "inline-block";
          document.querySelector("#btnPermisoEspecial").style.display = "none";
          document.querySelector("#divPermisoEspecial").style.display = "none";
          document.querySelector("#permisosMesInfo").classList.remove("alert-warning");
          document.querySelector("#permisosMesInfo").classList.add("alert-info");
          document.querySelector("#permisosMesInfo").innerHTML = "Permisos utilizados este mes: " + objData.data.permisos_mes_actual + "/3";
        }

        // Cargar motivos de la base de datos cada vez que se abre el modal
        fntGetMotivosPermisos();
        $('#modalFormPermiso').modal('show');
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
                let tipoPermiso = item.es_permiso_especial == 1 ? 'Especial' : 'Normal';
                
                htmlHistorial += `<tr>
                  <td>${fechaFormateada}</td>
                  <td>${item.motivo}</td>
                  <td>${tipoPermiso}</td>
                  <td>${item.estado}</td>
                  <td>
                    <button class="btn btn-primary btn-sm" onclick="generarPermisoPDF(${item.id_permiso})" title="Descargar PDF">
                      <i class="bi bi-file-pdf"></i>
                    </button>
                  </td>
                </tr>`;
              });
              document.querySelector("#tableHistorialPermisos").innerHTML = htmlHistorial;
            } else {
              htmlHistorial = `<tr><td colspan="5" class="text-center">No hay permisos registrados</td></tr>`;
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
    let justificacionEspecial = document.querySelector('#txtJustificacionEspecial').value;
    
    if (idFuncionario == '' || fechaPermiso == '' || motivoPermiso == '') {
      Swal.fire("Error", "Todos los campos son obligatorios", "error");
      return false;
    }

    // Si el div de permiso especial está visible, validar la justificación
    if (document.querySelector("#divPermisoEspecial").style.display === "block" && !justificacionEspecial) {
      Swal.fire("Error", "La justificación del permiso especial es obligatoria", "error");
      return false;
    }
    
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/funcionariosPermisos/setPermiso';
    let formData = new FormData(formPermiso);
    
    // Agregar indicador de permiso especial al FormData
    if (document.querySelector("#divPermisoEspecial").style.display === "block") {
      formData.append('es_permiso_especial', '1');
    }
    
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
          // Recargar los permisos diarios para actualizar la interfaz
          cargarPermisosDiarios();
        } else {
          Swal.fire("Error", objData.msg, "error");
        }
      }
    }
  });
  
  // Formulario para permiso especial
  let formPermisoEspecial = document.querySelector("#formPermisoEspecial");
  if(formPermisoEspecial){
    formPermisoEspecial.addEventListener('submit', function(e) {
      e.preventDefault();
      
      let idFuncionario = document.querySelector('#idFuncionarioEspecial').value;
      let fechaInicio = document.querySelector('#txtFechaInicioEspecial').value;
      let fechaFin = document.querySelector('#txtFechaFinEspecial').value;
      let justificacion = document.querySelector('#listJustificacionEspecial').value;
      let otroJustificacion = document.querySelector('#txtOtroJustificacion').value;
      
      if(idFuncionario == '' || fechaInicio == '' || fechaFin == '' || justificacion == '') {
        Swal.fire("Error", "Todos los campos son obligatorios", "error");
        return false;
      }
      
      // Si seleccionó "Otro (especificar)", validar que haya especificado
      if(justificacion == 'Otro (especificar)' && otroJustificacion == '') {
        Swal.fire("Error", "Debe especificar el motivo cuando selecciona 'Otro'", "error");
        return false;
      }
      
      // Validar que la fecha de fin no sea menor que la fecha de inicio
      if(fechaFin < fechaInicio) {
        Swal.fire("Error", "La fecha de fin no puede ser menor que la fecha de inicio", "error");
        return false;
      }
      
      // Si seleccionó "Otro", usar el texto especificado, sino usar el valor del select
      let justificacionFinal = justificacion;
      if(justificacion == 'Otro (especificar)') {
        justificacionFinal = otroJustificacion;
      }
      
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = base_url + '/funcionariosPermisos/setPermisoEspecial';
      let formData = new FormData(formPermisoEspecial);
      formData.append('justificacion_final', justificacionFinal);
      
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
          let objData = JSON.parse(request.responseText);
          
          if (objData.status) {
            $('#modalPermisoEspecial').modal("hide");
            formPermisoEspecial.reset();
            document.querySelector("#divOtroJustificacion").style.display = "none";
            Swal.fire("Permisos", objData.msg, "success");
            tableFuncionarios.api().ajax.reload();
            // Recargar los permisos diarios para actualizar la interfaz
            cargarPermisosDiarios();
          } else {
            Swal.fire("Error", objData.msg, "error");
          }
        }
      }
    });
  }
  
  // Event listener para el select de justificación especial
  let selectJustificacion = document.querySelector("#listJustificacionEspecial");
  if(selectJustificacion) {
    selectJustificacion.addEventListener('change', function() {
      let divOtro = document.querySelector("#divOtroJustificacion");
      if(this.value === 'Otro (especificar)') {
        divOtro.style.display = "block";
      } else {
        divOtro.style.display = "none";
      }
    });
  }
  
  // Event listener para el botón de permiso especial
  let btnPermisoEspecial = document.querySelector("#btnPermisoEspecial");
  if(btnPermisoEspecial) {
    btnPermisoEspecial.addEventListener('click', function() {
      document.querySelector("#divPermisoEspecial").style.display = "block";
      document.querySelector("#btnActionForm").style.display = "none";
      this.style.display = "none";
    });
  }
  
  // Event listener para el botón de generar PDF
  let btnGenerarPDF = document.querySelector("#btnGenerarPDF");
  if(btnGenerarPDF) {
    btnGenerarPDF.addEventListener('click', function() {
      let idFuncionario = this.getAttribute("data-id");
      if(idFuncionario) {
        generarPDF(idFuncionario);
      }
    });
  }
});

function generarPDF(idFuncionario) {
  window.open(base_url + '/funcionariosPermisos/generarPDF/' + idFuncionario, '_blank');
}

function generarPermisoPDF(idPermiso) {
  window.open(base_url + '/funcionariosPermisos/generarPermisoPDF/' + idPermiso, '_blank');
}

function fntPermisoEspecial(idFuncionario) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl =
    base_url + "/funcionariosPermisos/getFuncionario/" + idFuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
        
      if (objData.status) {
        document.querySelector("#idFuncionarioEspecial").value = objData.data.idefuncionario;
        document.querySelector("#txtNombreFuncionarioEspecial").value = objData.data.nombre_completo;
        
        // Establecer fecha mínima como hoy
        let today = new Date();
        let localISOTime = new Date(today.getTime() - (today.getTimezoneOffset() * 60000)).toISOString().split('T')[0];
        document.querySelector("#txtFechaInicioEspecial").setAttribute("min", localISOTime);
        document.querySelector("#txtFechaFinEspecial").setAttribute("min", localISOTime);
        document.querySelector("#txtFechaInicioEspecial").value = localISOTime;
        document.querySelector("#txtFechaFinEspecial").value = localISOTime;
        
        $('#modalPermisoEspecial').modal('show');
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

// Poblar el filtro de año en estadísticas solo con años que tienen permisos
function poblarFiltroAnioEstadisticasFunc() {
    const select = document.getElementById('filtroAnioEstadisticasFunc');
    select.innerHTML = '';
    $.get(base_url + '/funcionariosPermisos/getAniosConPermisos', function(response) {
        const data = JSON.parse(response);
        data.forEach(item => {
            let opt = document.createElement('option');
            opt.value = item.anio;
            opt.textContent = item.anio;
            select.appendChild(opt);
        });
        // Si hay al menos un año, cargar los gráficos para ese año
        if(data.length > 0) {
            select.value = data[0].anio;
            cargarGraficosPermisosFunc();
        }
    });
}

// Cargar y mostrar los gráficos de estadísticas
function cargarGraficosPermisosFunc() {
    const anio = document.getElementById('filtroAnioEstadisticasFunc') ? document.getElementById('filtroAnioEstadisticasFunc').value : new Date().getFullYear();
    // Funcionarios con más permisos por mes
    $.post(base_url + '/funcionariosPermisos/getFuncionariosMasPermisosPorMes', {anio}, function(response) {
        const data = JSON.parse(response);
        const meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        let labels = meses;
        let datasets = [];
        let funcionarios = [...new Set(data.map(item => item.nombre_completo))];
        funcionarios.forEach(func => {
            let dataFunc = Array(12).fill(0);
            data.filter(item => item.nombre_completo === func).forEach(item => {
                dataFunc[item.mes - 1] = parseInt(item.total);
            });
            datasets.push({
                label: func,
                data: dataFunc,
                borderWidth: 2,
                fill: false
            });
        });
        if(window.chartPermisosPorMesFunc && typeof window.chartPermisosPorMesFunc.destroy === 'function') window.chartPermisosPorMesFunc.destroy();
        window.chartPermisosPorMesFunc = new Chart(document.getElementById('chartPermisosPorMesFunc').getContext('2d'), {
            type: 'line',
            data: { labels, datasets },
            options: { responsive: true, plugins: { legend: { display: true } } }
        });
    });
    // Cantidad de permisos por funcionario (TOP)
    $.post(base_url + '/funcionariosPermisos/getCantidadPermisosPorFuncionario', {anio}, function(response) {
        const data = JSON.parse(response);
        let labels = data.map(item => item.nombre_completo);
        let values = data.map(item => parseInt(item.total));
        // Mostrar el top 5
        let topLabels = labels.slice(0, 5);
        let topValues = values.slice(0, 5);
        if(window.chartPermisosPorFuncionarioFunc && typeof window.chartPermisosPorFuncionarioFunc.destroy === 'function') window.chartPermisosPorFuncionarioFunc.destroy();
        window.chartPermisosPorFuncionarioFunc = new Chart(document.getElementById('chartPermisosPorFuncionarioFunc').getContext('2d'), {
            type: 'bar',
            data: { labels: topLabels, datasets: [{ label: 'Permisos', data: topValues, backgroundColor: '#36a2eb' }] },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
        // Llenar la tabla TOP 5
        let html = '';
        for(let i=0; i<topLabels.length; i++) {
            html += `<tr><td>${topLabels[i]}</td><td>${topValues[i]}</td></tr>`;
        }
        document.querySelector('#tablaTop5Funcionarios tbody').innerHTML = html;
    });
    // Dependencia con más permisos
    $.post(base_url + '/funcionariosPermisos/getDependenciaMasPermisos', {anio}, function(response) {
        const data = JSON.parse(response);
        let labels = data.map(item => item.dependencia);
        let values = data.map(item => parseInt(item.total));
        if(window.chartPermisosPorDependenciaFunc && typeof window.chartPermisosPorDependenciaFunc.destroy === 'function') window.chartPermisosPorDependenciaFunc.destroy();
        window.chartPermisosPorDependenciaFunc = new Chart(document.getElementById('chartPermisosPorDependenciaFunc').getContext('2d'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Permisos', data: values, backgroundColor: '#ff6384' }] },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    });
}

// Llenar las tarjetas resumen de permisos
function cargarResumenPermisos() {
    $.get(base_url + '/funcionariosPermisos/getResumenPermisos', function(response) {
        const data = JSON.parse(response);
        document.getElementById('resumenTotalPermisos').textContent = data.total;
        document.getElementById('resumenPermisosAnio').textContent = data.anio;
        document.getElementById('resumenPermisosMes').textContent = data.mes;
        document.getElementById('resumenPermisosHoy').textContent = data.hoy;
    });
}

// Llamar al cargar el tab de estadísticas
$(document).on('shown.bs.tab', 'button[data-bs-target="#tabEstadisticasFunc"]', function () {
    poblarFiltroAnioEstadisticasFunc();
    cargarResumenPermisos();
});

// Recargar gráficos al cambiar el año
$(document).on('change', '#filtroAnioEstadisticasFunc', function() {
    cargarGraficosPermisosFunc();
});