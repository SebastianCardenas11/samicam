let tableFuncionarios;
let rowTable = "";
var divLoading;
document.addEventListener(
  "DOMContentLoaded",
  function () {
    divLoading = document.querySelector("#divLoading");
    tableFuncionarios = $('#tableFuncionarios').dataTable({
      "aProcessing": true,
      "aServerSide": true,
      "language": {
        "url": base_url + "/Assets/js/es.json"
      },
      "ajax": {
        "url": base_url + "/FuncionariosPlanta/getFuncionarios",
        "dataSrc": ""
      },
      "columns": [
        { "data": "idefuncionario" },
        { "data": "nombre_completo" },
        { "data": "nm_identificacion" },
        { "data": "cargo" },
        { "data": "dependencia" },
        { "data": "contrato" },
        { "data": "correo_elc" },
        { "data": "tiempo_laborado" },
        { "data": "status" },
        { "data": "options" }
      ],
      "columnDefs": [
        { 'className': "textcenter", "targets": [0] },
        { 'className': "textright", "targets": [0] },
        { 'className': "textcenter", "targets": [0] }
      ],
      'dom': 'lBfrtip',
      'buttons': [
         {
          "extend": "excelHtml5",
          "text": "<i class='fas fa-file-excel'></i> Excel",
          "titleAttr": "Exportar a Excel",
          "className": "btn btn-success",
          "exportOptions": {
            "columns": [0, 1, 2, 3, 4, 5]
          }
        }, {
          "extend": "pdfHtml5",
          "text": "<i class='fas fa-file-pdf'></i> PDF",
          "titleAttr": "Exportar a PDF",
          "className": "btn btn-danger",
          "exportOptions": {
            "columns": [0, 1, 2, 3, 4, 5]
          }
        }
      ],
      "responsive": "true",
      "bDestroy": true,
      "iDisplayLength": 10,
      "order": [[0, "desc"]]
    });

    if (document.querySelector("#formFuncionario")) {
      let formFuncionario = document.querySelector("#formFuncionario");
      formFuncionario.onsubmit = function (e) {
        e.preventDefault();
        let strCorreo = document.querySelector("#txtCorreoFuncionario").value;
        let strNombre = document.querySelector("#txtNombreFuncionario").value;
        let strIdentificacion = document.querySelector("#txtIdentificacionFuncionario").value;
        let strCelular = document.querySelector("#txtCelularFuncionario").value;
        let strDireccion = document.querySelector("#txtDireccionFuncionario").value;
        let strFechaIngreso = document.querySelector("#txtFechaIngresoFuncionario").value;
        let strHijos = document.querySelector("#txtHijosFuncionario").value;
        let strNombresHijos = document.querySelector("#txtNombresHijosFuncionario").value;
        let strSexo = document.querySelector("#txtSexoFuncionario").value;
        let strLugarResidencia = document.querySelector("#txtLugarResidenciaFuncionario").value;
        let strEdad = document.querySelector("#txtEdadFuncionario").value;
        let strEstadoCivil = document.querySelector("#txtEstadoCivilFuncionario").value;
        let strReligion = document.querySelector("#txtReligionFuncionario").value;
        let strFormacion = document.querySelector("#txtFormacionFuncionario").value;
        let strNombreFormacion = document.querySelector("#txtNombreFormacion").value;
        let intCargo = document.querySelector("#txtCargoFuncionario").value;
        let intDependencia = document.querySelector("#txtDependenciaFuncionario").value;
        let intContrato = document.querySelector("#txtContrato").value;
        let intStatus = document.querySelector("#listStatus").value;
        
        // Nuevos campos opcionales
        let strLugarExpedicion = document.querySelector("#txtLugarExpedicion") ? document.querySelector("#txtLugarExpedicion").value : '';
        let strLibretaMilitar = document.querySelector("#txtLibretaMilitar") ? document.querySelector("#txtLibretaMilitar").value : '';
        let strActoAdministrativo = document.querySelector("#txtActoAdministrativo") ? document.querySelector("#txtActoAdministrativo").value : '';
        let strFechaActoNombramiento = document.querySelector("#txtFechaActoNombramiento") ? document.querySelector("#txtFechaActoNombramiento").value : '';
        let strNoActaPosesion = document.querySelector("#txtNoActaPosesion") ? document.querySelector("#txtNoActaPosesion").value : '';
        let strFechaActaPosesion = document.querySelector("#txtFechaActaPosesion") ? document.querySelector("#txtFechaActaPosesion").value : '';
        let strTiempoLaborado = document.querySelector("#txtTiempoLaborado") ? document.querySelector("#txtTiempoLaborado").value : '';
        let strCodigo = document.querySelector("#txtCodigo") ? document.querySelector("#txtCodigo").value : '';
        let strGrado = document.querySelector("#txtGrado") ? document.querySelector("#txtGrado").value : '';

        let strFechaNacimiento = document.querySelector("#txtFechaNacimiento") ? document.querySelector("#txtFechaNacimiento").value : '';
        let strLugarNacimiento = document.querySelector("#txtLugarNacimiento") ? document.querySelector("#txtLugarNacimiento").value : '';
        let strRh = document.querySelector("#txtRh") ? document.querySelector("#txtRh").value : '';
        let strTitulo = document.querySelector("#txtTitulo") ? document.querySelector("#txtTitulo").value : '';
        let strTarjetaProfesional = document.querySelector("#txtTarjetaProfesional") ? document.querySelector("#txtTarjetaProfesional").value : '';
        let strOtrosEstudios = document.querySelector("#txtOtrosEstudios") ? document.querySelector("#txtOtrosEstudios").value : '';
        let strCuentaNo = document.querySelector("#txtCuentaNo") ? document.querySelector("#txtCuentaNo").value : '';
        let strBanco = document.querySelector("#txtBanco") ? document.querySelector("#txtBanco").value : '';
        let strEps = document.querySelector("#txtEps") ? document.querySelector("#txtEps").value : '';
        let strAfp = document.querySelector("#txtAfp") ? document.querySelector("#txtAfp").value : '';
        let strAfc = document.querySelector("#txtAfc") ? document.querySelector("#txtAfc").value : '';
        let strArl = document.querySelector("#txtArl") ? document.querySelector("#txtArl").value : '';
        let strSindicalizado = document.querySelector("#txtSindicalizado") ? document.querySelector("#txtSindicalizado").value : '';
        let strMadreCabezaHogar = document.querySelector("#txtMadreCabezaHogar") ? document.querySelector("#txtMadreCabezaHogar").value : '';
        let strPrepensionado = document.querySelector("#txtPrepensionado") ? document.querySelector("#txtPrepensionado").value : '';

        if (
          strCorreo == "" ||
          strNombre == "" ||
          strIdentificacion == "" ||
          strCelular == "" ||
          strDireccion == "" ||
          strFechaIngreso == "" ||
          strHijos == "" ||
          strSexo == "" ||
          strLugarResidencia == "" ||
          strEdad == "" ||
          strEstadoCivil == "" ||
          strReligion == "" ||
          strFormacion == "" ||
          strNombreFormacion == "" ||
          intCargo == "" ||
          intDependencia == "" ||
          intContrato == ""
        ) {
          Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
          return false;
        }

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) {
          if (elementsValid[i].classList.contains("is-invalid")) {
            Swal.fire(
              "Atención",
              "Por favor verifique los campos en rojo.",
              "error"
            );
            return false;
          }
        }
        if (divLoading) divLoading.style.display = "flex";
        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/funcionariosPlanta/setFuncionario";
        let formData = new FormData(formFuncionario);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              $("#modalFormFuncionario").modal("hide");
              formFuncionario.reset();
              Swal.fire("Funcionarios", objData.msg, "success");
              tableFuncionarios.api().ajax.reload();
            } else {
              Swal.fire("Error", objData.msg, "error");
            }
          }
          if (divLoading) divLoading.style.display = "none";
          return false;
        };
      };
    }

    // Formulario para importar Excel
    if (document.querySelector("#formImportarExcel")) {
      let formImportarExcel = document.querySelector("#formImportarExcel");
      formImportarExcel.onsubmit = function (e) {
        e.preventDefault();
        
        let archivo = document.querySelector("#archivo_excel").files[0];
        
        if(!archivo) {
          Swal.fire("Error", "Por favor seleccione un archivo Excel", "error");
          return false;
        }
        
        let formData = new FormData();
        formData.append('archivo_excel', archivo);
        
        if (divLoading) {
          divLoading.style.display = "flex";
        }
        
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/ImportarFuncionarios/importarDesdeExcel';
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        
        request.onreadystatechange = function() {
          if(request.readyState == 4) {
            if (divLoading) {
              divLoading.style.display = "none";
            }

            if(request.status == 200) {
              try {
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                  const modal = bootstrap.Modal.getInstance(document.getElementById('modalImportarExcel'));
                  modal.hide();
                  formImportarExcel.reset();
                  Swal.fire("Éxito", objData.msg, "success");
                  tableFuncionarios.api().ajax.reload();
                } else {
                  let errorMsg = objData.msg;
                  if(objData.errores && objData.errores.length > 0) {
                    errorMsg = '<ul style="text-align: left; margin-top: 10px;">';
                    objData.errores.forEach(error => {
                      errorMsg += `<li>${error}</li>`;
                    });
                    errorMsg += '</ul>';
                    Swal.fire({
                      icon: 'warning',
                      title: 'No se pudieron importar algunos registros',
                      html: errorMsg,
                      confirmButtonText: 'Entendido'
                    });
                  } else {
                    Swal.fire("Error", errorMsg, "error");
                  }
                }
              } catch (error) {
                Swal.fire({
                  icon: 'error',
                  title: 'Error en la respuesta del servidor',
                  text: 'No se pudo procesar la respuesta del servidor.'
                });
              }
            } else {
              Swal.fire("Error", "Error en la petición al servidor", "error");
            }
          }
          return false;
        }
      };
    }

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
            contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
            if (document.querySelector('#img_funcionario')) {
              document.querySelector('#img_funcionario').src = '';
            }
            document.querySelector('.delPhoto').classList.add("notBlock");
            foto.value = "";
            return false;
          } else {
            contactAlert.innerHTML = '';
            const imgFuncionario = document.querySelector('#img_funcionario');
            if (imgFuncionario) {
              imgFuncionario.src = nav.createObjectURL(this.files[0]);
            }
            if (document.querySelector('#foto_remove')) {
              document.querySelector('#foto_remove').value = 0;
            }
          }
        }
      }
    }
  },
  false
);

window.addEventListener(
  "load",
  function () {
    setTimeout(() => {
      // fntEditRol();
      // fntDelRol();
      // fntPermisos();
    }, 500);
  },
  false
);

function fntViewInfo(idefuncionario) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl =
    base_url + "/funcionariosPlanta/getFuncionario/" + idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      
      if (objData.status) {
        // Información Básica
        document.querySelector("#celIdeFuncionario").innerHTML =
          objData.data.idefuncionario || '-';
        document.querySelector("#celCorreoFuncionario").innerHTML =
          objData.data.correo_elc || '-';
        document.querySelector("#celNombresFuncionario").innerHTML =
          objData.data.nombre_completo || '-';
        document.querySelector("#celIdentificacionFuncionario").innerHTML =
          objData.data.nm_identificacion || '-';
        document.querySelector("#celCelularFuncionario").innerHTML =
          objData.data.celular || '-';
        document.querySelector("#celDireccionFuncionario").innerHTML =
          objData.data.direccion || '-';
        document.querySelector("#celLugarResidenciaFuncionario").innerHTML =
          objData.data.lugar_de_residencia || '-';
        document.querySelector("#celEstadoFuncionario").innerHTML =
          objData.data.status == 1
            ? '<span class="badge text-bg-success">Activo</span>'
            : '<span class="badge text-bg-danger">Inactivo</span>';

        // Información Personal
        document.querySelector("#celEdadFuncionario").innerHTML =
          objData.data.edad || '-';
        document.querySelector("#celSexoFuncionario").innerHTML =
          objData.data.sexo || '-';
        document.querySelector("#celEstadoCivilFuncionario").innerHTML =
          objData.data.estado_civil || '-';
        document.querySelector("#celReligionFuncionario").innerHTML =
          objData.data.religion || '-';
        document.querySelector("#celFechaNacimiento").innerHTML =
          objData.data.fecha_nacimiento || '-';
        document.querySelector("#celLugarNacimiento").innerHTML =
          objData.data.lugar_nacimiento || '-';
        document.querySelector("#celRh").innerHTML =
          objData.data.rh || '-';
        document.querySelector("#celLugarExpedicion").innerHTML =
          objData.data.lugar_expedicion || '-';

        // Información Familiar
        document.querySelector("#celHijosFuncionario").innerHTML =
          objData.data.hijos || '-';
        document.querySelector("#celNombresHijosFuncionario").innerHTML =
          objData.data.nombres_de_hijos || '-';
        
        // Mostrar edades de hijos formateadas
        let edadesHijos = '-';
        if (objData.data.edades_hijos) {
          const edadesStr = objData.data.edades_hijos;
          const edades = [];
          for (let i = 0; i < edadesStr.length; i += 2) {
            edades.push(parseInt(edadesStr.substr(i, 2)));
          }
          edadesHijos = edades.join(', ') + ' años';
        }
        document.querySelector("#celEdadesHijosFuncionario").innerHTML = edadesHijos;
        document.querySelector("#celLibretaMilitar").innerHTML =
          objData.data.libreta_militar || '-';
        document.querySelector("#celMadreCabezaHogar").innerHTML =
          objData.data.madre_cabeza_hogar == 1 ? 'Sí' : (objData.data.madre_cabeza_hogar == 0 ? 'No' : '-');
        document.querySelector("#celSindicalizado").innerHTML =
          objData.data.sindicalizado == 1 ? 'Sí' : (objData.data.sindicalizado == 0 ? 'No' : '-');
        document.querySelector("#celPrepensionado").innerHTML =
          objData.data.prepensionado == 1 ? 'Sí' : (objData.data.prepensionado == 0 ? 'No' : '-');

        // Información Laboral
        document.querySelector("#celCargoFuncionario").innerHTML =
          objData.data.cargo_nombre || '-';
        document.querySelector("#celDependenciaFuncionario").innerHTML =
          objData.data.dependencia_nombre || '-';
        document.querySelector("#celContrato").innerHTML =
          objData.data.contrato_nombre || '-';
        document.querySelector("#celFechaIngresoFuncionario").innerHTML =
          objData.data.fecha_ingreso || '-';
        document.querySelector("#celTiempoLaborado").innerHTML =
          objData.data.tiempo_laborado || '-';
        document.querySelector("#celNivel").innerHTML =
          objData.data.nivel || '-';
        document.querySelector("#celGrado").innerHTML =
          objData.data.grado || '-';
        document.querySelector("#celCodigo").innerHTML =
          objData.data.codigo || '-';

        // Información Administrativa
        document.querySelector("#celTipoNombramiento").innerHTML =
          objData.data.tipo_nombramiento || '-';
        document.querySelector("#celActoAdministrativo").innerHTML =
          objData.data.acto_administrativo || '-';
        document.querySelector("#celFechaActoNombramiento").innerHTML =
          objData.data.fecha_acto_nombramiento || '-';
        document.querySelector("#celNoActaPosesion").innerHTML =
          objData.data.no_acta_posesion || '-';
        document.querySelector("#celFechaActaPosesion").innerHTML =
          objData.data.fecha_acta_posesion || '-';
        document.querySelector("#celSalarioBasico").innerHTML =
          objData.data.salario_basico ? '$' + parseFloat(objData.data.salario_basico).toLocaleString() : '-';

        // Información Académica
        document.querySelector("#celFormacionAcademica").innerHTML =
          objData.data.formacion_academica || '-';
        document.querySelector("#celNombreFormacion").innerHTML =
          objData.data.nombre_formacion || '-';
        document.querySelector("#celTitulo").innerHTML =
          objData.data.titulo || '-';
        document.querySelector("#celTarjetaProfesional").innerHTML =
          objData.data.tarjeta_profesional || '-';
        document.querySelector("#celOtrosEstudios").innerHTML =
          objData.data.otros_estudios || '-';

        // Información Financiera
        document.querySelector("#celCuentaNo").innerHTML =
          objData.data.cuenta_no || '-';
        document.querySelector("#celBanco").innerHTML =
          objData.data.banco || '-';
        document.querySelector("#celSalarioBasico2").innerHTML =
          objData.data.salario_basico ? '$' + parseFloat(objData.data.salario_basico).toLocaleString() : '-';

        // Seguridad Social
        document.querySelector("#celEps").innerHTML =
          objData.data.eps || '-';
        document.querySelector("#celAfp").innerHTML =
          objData.data.afp || '-';
        document.querySelector("#celAfc").innerHTML =
          objData.data.afc || '-';
        document.querySelector("#celArl").innerHTML =
          objData.data.arl || '-';

        $("#modalViewFuncionario").modal("show");
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

function fntEditInfo(element, idefuncionario) {
  rowTable = element.parentNode.parentNode.parentNode;
  document.querySelector("#titleModal").innerHTML = "Actualizar Funcionario";
  document.querySelector("#btnActionForm").classList.replace("btn-success", "btn-warning");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/funcionariosPlanta/getFuncionario/" + idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
            document.querySelector("#ideFuncionario").value =
              objData.data.idefuncionario;
            document.querySelector("#txtCorreoFuncionario").value =
              objData.data.correo_elc;
            document.querySelector("#txtNombreFuncionario").value =
              objData.data.nombre_completo;
            document.querySelector("#txtIdentificacionFuncionario").value =
              objData.data.nm_identificacion;
            document.querySelector("#txtCargoFuncionario").value =
              objData.data.cargo_fk;
            document.querySelector("#txtDependenciaFuncionario").value =
              objData.data.dependencia_fk;
            document.querySelector("#txtContrato").value = objData.data.contrato_fk;
            document.querySelector("#txtCelularFuncionario").value =
              objData.data.celular;
            document.querySelector("#txtDireccionFuncionario").value =
              objData.data.direccion;
            document.querySelector("#txtFechaIngresoFuncionario").value =
              objData.data.fecha_ingreso;
            document.querySelector("#txtHijosFuncionario").value =
              objData.data.hijos;
            document.querySelector("#txtNombresHijosFuncionario").value =
              objData.data.nombres_de_hijos;
            document.querySelector("#txtSexoFuncionario").value = objData.data.sexo;
            document.querySelector("#txtLugarResidenciaFuncionario").value =
              objData.data.lugar_de_residencia;
            // Cargar edad - si no hay fecha de nacimiento, usar la edad directamente
            if (objData.data.fecha_nacimiento) {
              document.querySelector("#txtFechaNacimiento").value = objData.data.fecha_nacimiento;
              // Disparar evento para calcular edad automáticamente
              document.querySelector("#txtFechaNacimiento").dispatchEvent(new Event('change'));
            } else {
              // Si no hay fecha de nacimiento, cargar la edad directamente
              document.querySelector("#txtEdadFuncionario").value = objData.data.edad || '';
            }
            document.querySelector("#txtEstadoCivilFuncionario").value =
              objData.data.estado_civil;
            document.querySelector("#txtReligionFuncionario").value =
              objData.data.religion;
            document.querySelector("#txtFormacionFuncionario").value =
              objData.data.formacion_academica;
            document.querySelector("#txtNombreFormacion").value =
              objData.data.nombre_formacion;
            document.querySelector("#listStatus").value = objData.data.status;
            
            // Cargar nuevos campos si existen
            if (document.querySelector("#txtLugarExpedicion")) {
              document.querySelector("#txtLugarExpedicion").value = objData.data.lugar_expedicion || '';
            }
            if (document.querySelector("#txtNivel")) {
              document.querySelector("#txtNivel").value = objData.data.nivel || '';
            }
            if (document.querySelector("#txtSalarioBasico")) {
              document.querySelector("#txtSalarioBasico").value = objData.data.salario_basico || '';
            }
            if (document.querySelector("#txtTipoNombramiento")) {
              document.querySelector("#txtTipoNombramiento").value = objData.data.tipo_nombramiento || '';
            }
            if (document.querySelector("#txtLibretaMilitar")) {
              document.querySelector("#txtLibretaMilitar").value = objData.data.libreta_militar || '';
            }
            if (document.querySelector("#txtActoAdministrativo")) {
              document.querySelector("#txtActoAdministrativo").value = objData.data.acto_administrativo || '';
            }
            if (document.querySelector("#txtFechaActoNombramiento")) {
              document.querySelector("#txtFechaActoNombramiento").value = objData.data.fecha_acto_nombramiento || '';
            }
            if (document.querySelector("#txtNoActaPosesion")) {
              document.querySelector("#txtNoActaPosesion").value = objData.data.no_acta_posesion || '';
            }
            if (document.querySelector("#txtFechaActaPosesion")) {
              document.querySelector("#txtFechaActaPosesion").value = objData.data.fecha_acta_posesion || '';
            }
            if (document.querySelector("#txtTiempoLaborado")) {
              document.querySelector("#txtTiempoLaborado").value = objData.data.tiempo_laborado || '';
            }
            if (document.querySelector("#txtCodigo")) {
              document.querySelector("#txtCodigo").value = objData.data.codigo || '';
            }
            if (document.querySelector("#txtGrado")) {
              document.querySelector("#txtGrado").value = objData.data.grado || '';
            }

            if (document.querySelector("#txtFechaNacimiento")) {
              document.querySelector("#txtFechaNacimiento").value = objData.data.fecha_nacimiento || '';
            }
            if (document.querySelector("#txtLugarNacimiento")) {
              document.querySelector("#txtLugarNacimiento").value = objData.data.lugar_nacimiento || '';
            }
            if (document.querySelector("#txtRh")) {
              document.querySelector("#txtRh").value = objData.data.rh || '';
            }
            if (document.querySelector("#txtTitulo")) {
              document.querySelector("#txtTitulo").value = objData.data.titulo || '';
            }
            if (document.querySelector("#txtTarjetaProfesional")) {
              document.querySelector("#txtTarjetaProfesional").value = objData.data.tarjeta_profesional || '';
            }
            if (document.querySelector("#txtOtrosEstudios")) {
              document.querySelector("#txtOtrosEstudios").value = objData.data.otros_estudios || '';
            }
            if (document.querySelector("#txtCuentaNo")) {
              document.querySelector("#txtCuentaNo").value = objData.data.cuenta_no || '';
            }
            if (document.querySelector("#txtBanco")) {
              document.querySelector("#txtBanco").value = objData.data.banco || '';
            }
            if (document.querySelector("#txtEps")) {
              document.querySelector("#txtEps").value = objData.data.eps || '';
            }
            if (document.querySelector("#txtAfp")) {
              document.querySelector("#txtAfp").value = objData.data.afp || '';
            }
            if (document.querySelector("#txtAfc")) {
              document.querySelector("#txtAfc").value = objData.data.afc || '';
            }
            if (document.querySelector("#txtArl")) {
              document.querySelector("#txtArl").value = objData.data.arl || '';
            }
            if (document.querySelector("#txtSindicalizado")) {
              document.querySelector("#txtSindicalizado").value = objData.data.sindicalizado == 1 ? 'Si' : (objData.data.sindicalizado == 0 ? 'No' : '');
            }
            if (document.querySelector("#txtMadreCabezaHogar")) {
              document.querySelector("#txtMadreCabezaHogar").value = objData.data.madre_cabeza_hogar == 1 ? 'Si' : (objData.data.madre_cabeza_hogar == 0 ? 'No' : '');
            }
            if (document.querySelector("#txtPrepensionado")) {
              document.querySelector("#txtPrepensionado").value = objData.data.prepensionado == 1 ? 'Si' : (objData.data.prepensionado == 0 ? 'No' : '');
            }
            
            // Cargar edades de hijos si existen
            if (document.querySelector("#txtEdadesHijosFuncionario")) {
              document.querySelector("#txtEdadesHijosFuncionario").value = objData.data.edades_hijos || '';
            }
          } else {
            Swal.fire("Error", objData.msg, "error");
            return;
          }
        } catch (error) {
          console.error("Error al procesar la respuesta:", error);
          if (request.responseText.includes("<!DOCTYPE html>")) {
            Swal.fire("Error", "Tu sesión ha expirado. Por favor, recarga la página e inicia sesión nuevamente.", "error");
          } else {
            Swal.fire("Error", "Hubo un error al obtener los datos del funcionario", "error");
          }
          return;
        }
      } else {
        Swal.fire("Error", "Error en la petición al servidor", "error");
        return;
      }
      $("#modalFormFuncionario").modal("show");
    }
  };
}

function fntDelInfo(idefuncionario) {
  Swal.fire({
    title: "Eliminar Funcionario",
    text: "¿Realmente quiere eliminar el Funcionario?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: false,
    closeOnCancel: true,
  }).then((result) => {
    if (result.isConfirmed) {
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/funcionariosPlanta/delFuncionario";
      let strData = "ideFuncionario=" + idefuncionario;
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
            Swal.fire("Eliminar!", objData.msg, "success");
            tableFuncionarios.api().ajax.reload();
          } else {
            Swal.fire("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

function openModal() {
  document.querySelector("#ideFuncionario").value = "";
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-warning", "btn-success");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#titleModal").innerHTML = "Nuevo Funcionario";
  document.querySelector("#formFuncionario").reset();
  $("#modalFormFuncionario").modal("show");
}

function openModalImportar() {
  document.querySelector("#formImportarExcel").reset();
  const modal = new bootstrap.Modal(document.getElementById('modalImportarExcel'));
  modal.show();
}