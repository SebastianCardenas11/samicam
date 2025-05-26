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
        "url": "./es.json"
      },
      "ajax": {
        "url": " " + base_url + "/funcionariosPlanta/getFuncionarios",
        "dataSrc": ""
      },
      "columns": [
        { "data": "imagen" },
        { "data": "nombre_completo" },
        { "data": "nm_identificacion" },
        { "data": "cargo_nombre" },
        { "data": "dependencia_nombre" },
        { "data": "contrato_nombre" },
        { "data": "correo_elc" },
        { "data": "status" },
        { "data": "options" }
      ],


      // 'dom': 'lBfrtip',
      'dom': "<'row mb-3 align-items-center'<'col-auto'l><'col-auto ml-auto'f>>" +
        "<'row'<'col-12'B>>" +
        "<'row'<'col-12'tr>>" +
        "<'row'<'col-md-5'i><'col-md-7'p>>",





      'buttons': [
        {
          "extend": "excelHtml5",
          "text": "<i class='fas fa-file-excel'></i> Excel",
          "titleAttr": "Exportar a Excel",
          "className": "btn btn-success mt-3"
        }, {
          "extend": "pdfHtml5",
          "text": "<i class='fas fa-file-pdf'></i> PDF",
          "titleAttr": "Exportar a PDF",
          "className": "btn btn-danger mt-3"
        }

      ],
      "responsive": "true",
      "bDestroy": true,
      "iDisplayLength": 10,
      "order": [[1, "desc"]]
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
        
        let archivo = document.querySelector("#archivo_excel").value;
        if (archivo == "") {
          Swal.fire("Atención", "Seleccione un archivo Excel.", "error");
          return false;
        }
        
        // Verificar extensión
        let extension = archivo.substring(archivo.lastIndexOf('.'));
        if (extension != '.xlsx' && extension != '.xls') {
          Swal.fire("Atención", "El archivo debe ser Excel (.xlsx o .xls)", "error");
          return false;
        }
        
        if (divLoading) divLoading.style.display = "flex";
        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/funcionariosPlanta/importarExcel";
        let formData = new FormData(formImportarExcel);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              $("#modalImportarExcel").modal("hide");
              formImportarExcel.reset();
              Swal.fire("Importación Exitosa", objData.msg, "success");
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
            document.querySelector('#img_funcionario').src = nav.createObjectURL(this.files[0]);
            document.querySelector('#foto_remove').value = 0;
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
        document.querySelector("#celIdeFuncionario").innerHTML =
          objData.data.idefuncionario;
        document.querySelector("#celCorreoFuncionario").innerHTML =
          objData.data.correo_elc;
        document.querySelector("#celNombresFuncionario").innerHTML =
          objData.data.nombre_completo;
        document.querySelector("#celIdentificacionFuncionario").innerHTML =
          objData.data.nm_identificacion;
        document.querySelector("#celCargoFuncionario").innerHTML =
          objData.data.cargo_nombre;
        document.querySelector("#celDependenciaFuncionario").innerHTML =
          objData.data.dependencia_nombre;
        document.querySelector("#celContrato").innerHTML =
          objData.data.contrato_nombre;
        document.querySelector("#celCelularFuncionario").innerHTML =
          objData.data.celular;
        document.querySelector("#celDireccionFuncionario").innerHTML =
          objData.data.direccion;
        document.querySelector("#celFechaIngresoFuncionario").innerHTML =
          objData.data.fecha_ingreso;
        document.querySelector("#celHijosFuncionario").innerHTML =
          objData.data.hijos;
        document.querySelector("#celNombresHijosFuncionario").innerHTML =
          objData.data.nombres_de_hijos;
        document.querySelector("#celSexoFuncionario").innerHTML =
          objData.data.sexo;
        document.querySelector("#celLugarResidenciaFuncionario").innerHTML =
          objData.data.lugar_de_residencia;
        document.querySelector("#celEdadFuncionario").innerHTML =
          objData.data.edad;
        document.querySelector("#celEstadoCivilFuncionario").innerHTML =
          objData.data.estado_civil;
        document.querySelector("#celReligionFuncionario").innerHTML =
          objData.data.religion;
        document.querySelector("#celFormacionAcademica").innerHTML =
          objData.data.formacion_academica;
        document.querySelector("#celNombreFormacion").innerHTML =
          objData.data.nombre_formacion;
        document.querySelector("#celEstadoFuncionario").innerHTML =
          objData.data.status == 1
            ? '<span class="badge text-bg-success">Activo</span>'
            : '<span class="badge text-bg-danger">Inactivo</span>';

        // Mostrar la imagen del funcionario
        document.querySelector("#celImagenFuncionario").src = objData.data.url_imagen;

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
    if (request.readyState == 4 && request.status == 200) {
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
        document.querySelector("#txtEdadFuncionario").value = objData.data.edad;
        document.querySelector("#txtEstadoCivilFuncionario").value =
          objData.data.estado_civil;
        document.querySelector("#txtReligionFuncionario").value =
          objData.data.religion;
        document.querySelector("#txtFormacionFuncionario").value =
          objData.data.formacion_academica;
        document.querySelector("#txtNombreFormacion").value =
          objData.data.nombre_formacion;
        document.querySelector("#listStatus").value = objData.data.status;

        // Mostrar la imagen actual
        if (document.querySelector('#foto_actual')) {
          document.querySelector('#foto_actual').value = objData.data.imagen;
        }
        if (document.querySelector('#img_funcionario')) {
          document.querySelector('#img_funcionario').src = objData.data.url_imagen;
        }
      }
    }
    $("#modalFormFuncionario").modal("show");
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
  $("#modalImportarExcel").modal("show");
}