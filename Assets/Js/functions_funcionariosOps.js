let tableFuncionarios;
let rowTable = "";
var divLoading;
document.addEventListener(
  "DOMContentLoaded",
  function () {
    divLoading = document.querySelector("#divLoading");
    tableFuncionarios = $('#tableFuncionariosOps').dataTable({
      "aProcessing": true,
      "aServerSide": false,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
      },
      "ajax": {
        "url": " " + base_url + "/funcionariosOps/getFuncionarios",
        "dataSrc": function(json) {
          if (!json) {
            console.error("Respuesta vacía del servidor");
            return [];
          }
          if (typeof json === 'string') {
            try {
              json = JSON.parse(json);
            } catch (e) {
              console.error("Error al parsear JSON:", e);
              return [];
            }
          }
          return json || [];
        },
        "error": function(xhr, error, thrown) {
          console.error("Error en la petición AJAX:", error);
          return [];
        }
      },
      "columns": [
        { "data": "numero_contrato", "defaultContent": "" },
        { "data": "nombre_contratista", "defaultContent": "" },
        { "data": "identificacion_contratista", "defaultContent": "" },
        { 
          "data": "objeto", 
          "defaultContent": "",
          "render": function(data) {
            if (!data) return "";
            return data.length > 39 ? data.substring(0, 39) + "..." : data;
          }
        },
        { 
          "data": "valor_contrato",
          "defaultContent": "0.00",
          "render": function(data) {
            if (!data) return '$ 0.00';
            return '$ ' + (typeof data === 'number' ? data.toFixed(2) : data);
          }
        },
        { "data": "fecha_inicio", "defaultContent": "" },
        { 
          "data": "dias_restantes",
          "render": function(data, type, row) {
            let diasNum = row.dias_restantes_num;
            let clase = '';
            if (diasNum !== null && !isNaN(diasNum)) {
              if (diasNum > 31) {
                clase = 'badge text-bg-success';
              } else if (diasNum > 0) {
                clase = 'badge text-bg-warning';
              } else {
                clase = 'badge text-bg-danger';
              }
            } else {
              clase = 'badge text-bg-secondary';
            }
            return '<span class="' + clase + '">' + data + '</span>';
          }
        },
        { "data": "estado_contrato", "defaultContent": "" },
        { "data": "options", "defaultContent": "" }
      ],
      'dom': "<'row mb-3 align-items-center'<'col-auto'l><'col-auto ml-auto'f>>" +
             "<'row'<'col-12'B>>" +
             "<'row'<'col-12'tr>>" +
             "<'row'<'col-md-5'i><'col-md-7'p>>",
      'buttons': [
        {
          "extend": "excelHtml5",
          "text": "<i class='fas fa-file-excel'></i> Excel",
          "titleAttr": "Exportar a Excel",
          "className": "btn btn-success mt-3",
          "exportOptions": { 
            "columns": [ 0, 1, 2, 3, 4, 5, 6 ] 
          }
        },
        {
          "extend": "pdfHtml5",
          "text": "<i class='fas fa-file-pdf'></i> PDF",
          "titleAttr": "Exportar a PDF",
          "className": "btn btn-danger mt-3",
          "exportOptions": { 
            "columns": [ 0, 1, 2, 3, 4, 5, 6 ] 
          },
          "customize": function(doc) {
            doc.styles.tableHeader.alignment = 'left';
            doc.styles.tableHeader.fontSize = 10;
            doc.defaultStyle.fontSize = 9;
            doc.defaultStyle.alignment = 'left';
            doc.content[1].table.widths = ['auto', 'auto', 'auto', '*', 'auto', 'auto', 'auto'];
          }
        }
      ],
      "responsive": true,
      "bDestroy": true,
      "iDisplayLength": 10,
      "order": [[0, "desc"]],
      "initComplete": function(settings, json) {
        if (!json || json.length === 0) {
          console.log("No se encontraron datos");
        }
      }
    });

    // Evento para mostrar la imagen seleccionada
    if (document.querySelector("#foto")) {
      let foto = document.querySelector("#foto");
      foto.onchange = function (e) {
        let uploadFoto = document.querySelector("#foto").value;
        let fileimg = document.querySelector("#foto").files;
        let nav = window.URL || window.webkitURL;
        let contactAlert = document.querySelector('#form_alert');
        if (uploadFoto != '') {
          let type = fileimg[0].type;
          let name = fileimg[0].name;
          if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
            if (contactAlert) {
              contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
            }
            if (document.querySelector('#img_funcionario')) {
              document.querySelector('#img_funcionario').src = '';
            }
            if (document.querySelector('.delPhoto')) {
              document.querySelector('.delPhoto').classList.add("notBlock");
            }
            foto.value = "";
            return false;
          } else {
            if (contactAlert) {
              contactAlert.innerHTML = '';
            }
            if (document.querySelector('#img_funcionario')) {
              document.querySelector('#img_funcionario').src = nav.createObjectURL(this.files[0]);
            }
            if (document.querySelector('#foto_remove')) {
              document.querySelector('#foto_remove').value = 0;
            }
          }
        }
      }
    }

    // Formulario de funcionario OPS
    if (document.querySelector("#formFuncionariosOps")) {
      let formFuncionariosOps = document.querySelector("#formFuncionariosOps");
      formFuncionariosOps.onsubmit = function (e) {
        e.preventDefault();

        // Validar campos requeridos
        let camposRequeridos = {
          'nombre_contratista': 'Nombre del Contratista',
          'identificacion_contratista': 'Identificación del Contratista',
          'numero_contrato': 'Número de Contrato',
          'objeto': 'Objeto del Contrato',
          'valor_contrato': 'Valor del Contrato',
          'estado_contrato': 'Estado del Contrato'
        };

        let camposFaltantes = [];
        for (let campo in camposRequeridos) {
          let elemento = document.querySelector(`#${campo}`);
          if (!elemento || !elemento.value.trim()) {
            camposFaltantes.push(camposRequeridos[campo]);
          }
        }

        if (camposFaltantes.length > 0) {
          Swal.fire("Error", "Por favor complete los siguientes campos obligatorios","error");
          return false;
        }

        // Validar correo electrónico si se proporciona
        let correo = document.querySelector("#correo_electronico");
        if (correo && correo.value.trim() !== "") {
          let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(correo.value.trim())) {
            Swal.fire("Error", "El correo electrónico no tiene un formato válido", "error");
            return false;
          }
        }

        // Validar valor del contrato
        let valorContrato = document.querySelector("#valor_contrato");
        if (valorContrato && valorContrato.value.trim() !== "") {
          if (isNaN(parseFloat(valorContrato.value))) {
            Swal.fire("Error", "El valor del contrato debe ser un número válido", "error");
            return false;
          }
        }

        // Mostrar loading
        if (divLoading) {
          divLoading.style.display = "flex";
        }

        let formData = new FormData(formFuncionariosOps);
        
        

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/funcionariosOps/setFuncionario';
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4) {
            if (divLoading) {
              divLoading.style.display = "none";
            }
            if (request.status == 200) {
              try {
                let objData = JSON.parse(request.responseText);
                
                
                if (objData.status) {
                  $('#modalFormFuncionariosOps').modal("hide");
                  formFuncionariosOps.reset();
                  Swal.fire("Éxito", objData.msg, "success");
                  tableFuncionarios.api().ajax.reload();
                } else {
                  Swal.fire("Error", objData.msg, "error");
                }
              } catch (error) {
                console.error("Error al parsear respuesta:", error);
                Swal.fire("Error", "Error al procesar la respuesta del servidor", "error");
              }
            } else {
              console.error("Error de servidor:", request.status);
              Swal.fire("Error", "Error en la comunicación con el servidor: " + request.status, "error");
            }
          }
        };
      };
    }
  },
  false
);

function fntViewInfo(id) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/funcionariosOps/getFuncionario/" + id;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        // Llenar todos los campos del modal de visualización OPS
        const data = objData.data;
        const set = (id, val) => {
          const el = document.querySelector(`#${id}`);
          if (el) el.innerHTML = val ?? '';
        };
        set('view_nombre_contratista', data.nombre_contratista);
        set('view_identificacion_contratista', data.identificacion_contratista);
        set('view_sexo', data.sexo);
        set('view_edad', data.edad);
        set('view_direccion_domicilio', data.direccion_domicilio);
        set('view_telefono_contacto', data.telefono_contacto);
        set('view_correo_electronico', data.correo_electronico);
        set('view_entidad_bancaria', data.entidad_bancaria);
        set('view_tipo_cuenta', data.tipo_cuenta);
        set('view_numero_cuenta_bancaria', data.numero_cuenta_bancaria);
        set('view_anio', data.anio);
        set('view_nit', data.nit);
        set('view_nombre_entidad', data.nombre_entidad);
        set('view_numero_contrato', data.numero_contrato);
        set('view_fecha_firma_contrato', data.fecha_firma_contrato);
        set('view_numero_proceso', data.numero_proceso);
        set('view_forma_contratacion', data.forma_contratacion);
        set('view_codigo_banco_proyecto', data.codigo_banco_proyecto);
        set('view_linea_estrategia', data.linea_estrategia);
        set('view_fuente_recurso', data.fuente_recurso);
        set('view_objeto', data.objeto);
        set('view_fecha_inicio', data.fecha_inicio);
        set('view_dias_restantes', data.dias_restantes);
        set('view_plazo_contrato', data.plazo_contrato);
        set('view_valor_contrato', data.valor_contrato);
        set('view_clase_contrato', data.clase_contrato);
        set('view_estado_contrato', data.estado_contrato);
        set('view_numero_disp_presupuestal', data.numero_disp_presupuestal);
        set('view_fecha_disp_presupuestal', data.fecha_disp_presupuestal);
        set('view_valor_disp_presupuestal', data.valor_disp_presupuestal);
        set('view_numero_registro_presupuestal', data.numero_registro_presupuestal);
        set('view_fecha_registro_presupuestal', data.fecha_registro_presupuestal);
        set('view_valor_registro_presupuestal', data.valor_registro_presupuestal);
        set('view_cod_rubro', data.cod_rubro);
        set('view_rubro', data.rubro);
        set('view_fuente_financiacion', data.fuente_financiacion);
        set('view_asignado_interventor', data.asignado_interventor);
        set('view_unidad_ejecucion', data.nombre_dependencia);
        set('view_nombre_interventor', data.nombre_interventor);
        set('view_identificacion_interventor', data.identificacion_interventor);
        set('view_tipo_vinculacion_interventor', data.tipo_vinculacion_interventor);
        set('view_fecha_aprobacion_garantia', data.fecha_aprobacion_garantia);
        set('view_anticipo_contrato', data.anticipo_contrato);
        set('view_valor_pagado_anticipo', data.valor_pagado_anticipo);
        set('view_fecha_pago_anticipo', data.fecha_pago_anticipo);
        set('view_numero_adiciones', data.numero_adiciones);
        set('view_valor_total_adiciones', data.valor_total_adiciones);
        set('view_numero_prorrogas', data.numero_prorrogas);
        set('view_tiempo_prorrogas', data.tiempo_prorrogas);
        set('view_numero_suspensiones', data.numero_suspensiones);
        set('view_tiempo_suspensiones', data.tiempo_suspensiones);
        set('view_valor_total_pagos', data.valor_total_pagos);
        set('view_fecha_terminacion', data.fecha_terminacion);
        set('view_fecha_acta_liquidacion', data.fecha_acta_liquidacion);
        set('view_observaciones', data.observaciones);
        set('view_proviene_recurso_reactivacion', data.proviene_recurso_reactivacion);
        // Mostrar el modal
        $('#modalViewFuncionarioOps').modal('show');
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  }
}

function fntEditInfo(element, id) {
  rowTable = element.parentNode.parentNode.parentNode;
  document.querySelector("#titleModal").innerHTML = "Actualizar Funcionario OPS";
  document.querySelector("#btnActionForm").classList.replace("btn-success", "btn-warning");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/funcionariosOps/getFuncionario/" + id;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        const data = objData.data;
        const set = (id, val) => {
          const el = document.querySelector(`#${id}`);
          if (el) el.value = val ?? '';
        };
        set('idFuncionario', data.id);
        set('anio', data.anio);
        set('nit', data.nit);
        set('nombre_entidad', data.nombre_entidad);
        set('numero_contrato', data.numero_contrato);
        set('fecha_firma_contrato', data.fecha_firma_contrato);
        set('numero_proceso', data.numero_proceso);
        set('forma_contratacion', data.forma_contratacion);
        set('codigo_banco_proyecto', data.codigo_banco_proyecto);
        set('linea_estrategia', data.linea_estrategia);
        set('fuente_recurso', data.fuente_recurso);
        set('nombre_contratista', data.nombre_contratista);
        set('identificacion_contratista', data.identificacion_contratista);
        set('sexo', data.sexo);
        set('edad', data.edad);
        set('direccion_domicilio', data.direccion_domicilio);
        set('telefono_contacto', data.telefono_contacto);
        set('correo_electronico', data.correo_electronico);
        set('entidad_bancaria', data.entidad_bancaria);
        set('tipo_cuenta', data.tipo_cuenta);
        set('numero_cuenta_bancaria', data.numero_cuenta_bancaria);
        set('numero_disp_presupuestal', data.numero_disp_presupuestal);
        set('fecha_disp_presupuestal', data.fecha_disp_presupuestal);
        set('valor_disp_presupuestal', data.valor_disp_presupuestal);
        set('numero_registro_presupuestal', data.numero_registro_presupuestal);
        set('fecha_registro_presupuestal', data.fecha_registro_presupuestal);
        set('valor_registro_presupuestal', data.valor_registro_presupuestal);
        set('cod_rubro', data.cod_rubro);
        set('rubro', data.rubro);
        set('fuente_financiacion', data.fuente_financiacion);
        set('objeto', data.objeto);
        set('fecha_inicio', data.fecha_inicio);
        set('plazo_contrato', data.plazo_contrato);
        set('valor_contrato', data.valor_contrato);
        set('clase_contrato', data.clase_contrato);
        set('estado_contrato', data.estado_contrato);
        set('asignado_interventor', data.asignado_interventor);
        set('unidad_ejecucion', data.nombre_dependencia);
        set('nombre_interventor', data.nombre_interventor);
        set('identificacion_interventor', data.identificacion_interventor);
        set('tipo_vinculacion_interventor', data.tipo_vinculacion_interventor);
        set('fecha_aprobacion_garantia', data.fecha_aprobacion_garantia);
        set('anticipo_contrato', data.anticipo_contrato);
        set('valor_pagado_anticipo', data.valor_pagado_anticipo);
        set('fecha_pago_anticipo', data.fecha_pago_anticipo);
        set('numero_adiciones', data.numero_adiciones);
        set('valor_total_adiciones', data.valor_total_adiciones);
        set('numero_prorrogas', data.numero_prorrogas);
        set('tiempo_prorrogas', data.tiempo_prorrogas);
        set('numero_suspensiones', data.numero_suspensiones);
        set('tiempo_suspensiones', data.tiempo_suspensiones);
        set('valor_total_pagos', data.valor_total_pagos);
        set('fecha_terminacion', data.fecha_terminacion);
        set('fecha_acta_liquidacion', data.fecha_acta_liquidacion);
        set('observaciones', data.observaciones);
        set('proviene_recurso_reactivacion', data.proviene_recurso_reactivacion);
        $('#modalFormFuncionariosOps').modal('show');
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  }
}

function fntDelInfo(id) {
  Swal.fire({
    title: "Eliminar Funcionario OPS",
    text: "¿Realmente quiere eliminar este funcionario OPS?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "No, cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/funcionariosOps/delFuncionario";
      let strData = "idFuncionario=" + id;
      request.open("POST", ajaxUrl, true);
      request.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
      );
      request.send(strData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
            Swal.fire("Eliminado", "El funcionario OPS ha sido eliminado", "success");
            tableFuncionarios.api().ajax.reload();
          } else {
            Swal.fire("Error", objData.msg, "error");
          }
        }
      };
    }
  });
}

function openModal() {
    document.querySelector('#formFuncionariosOps').reset();
    document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-success");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Funcionario OPS";
    $('#modalFormFuncionariosOps').modal('show');
}