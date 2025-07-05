let tablePracticantes;
let rowTable = "";
var divLoading;
document.addEventListener(
  "DOMContentLoaded",
  function () {
    divLoading = document.querySelector("#divLoading");
    tablePracticantes = $('#tablePracticantes').dataTable({
      "aProcessing": true,
      "aServerSide": true,
      "language": {
        "url": base_url + "/Assets/js/es.json"
      },
      "ajax": {
        "url": " " + base_url + "/Practicantes/getPracticantes",
        "dataSrc": ""
      },
      "columns": [
        { "data": "nombre_completo" },
        { "data": "numero_identificacion" },
        { "data": "arl" },
        { "data": "edad" },
        { "data": "sexo" },
        { "data": "dependencia" },
        { "data": "tipo_contrato" },
        { "data": "formacion_academica" },
        { "data": "programa_estudio" },
        { "data": "institucion_educativa" },
        { "data": "fecha_ingreso" },
        { "data": "fecha_salida" },
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
            "columns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
          }
        }, {
          "extend": "pdfHtml5",
          "text": "<i class='fas fa-file-pdf'></i> PDF",
          "titleAttr": "Exportar a PDF",
          "className": "btn btn-danger",
          "exportOptions": {
            "columns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
          }
        }
      ],
      "resonsieve": "true",
      "bDestroy": true,
      "iDisplayLength": 10,
      "order": [[0, "desc"]]
    });

    if (document.querySelector("#formPracticante")) {
      let formPracticante = document.querySelector("#formPracticante");
      formPracticante.onsubmit = function (e) {
        e.preventDefault();
        let strCorreo = document.querySelector("#txtCorreoPracticante").value;
        let strNombre = document.querySelector("#txtNombrePracticante").value;
        let strIdentificacion = document.querySelector("#txtIdentificacionPracticante").value;
        let strArl = document.querySelector("#txtArlPracticante").value;
        let intEdad = document.querySelector("#txtEdadPracticante").value;
        let strSexo = document.querySelector("#txtSexoPracticante").value;
        let strTelefono = document.querySelector("#txtTelefonoPracticante").value;
        let strDireccion = document.querySelector("#txtDireccionPracticante").value;
        let intDependencia = document.querySelector("#txtDependenciaPracticante").value;
        let strCargoHacer = document.querySelector("#txtCargoHacerPracticante").value;
        let strFechaIngreso = document.querySelector("#txtFechaIngreso").value;
        let strFechaSalida = document.querySelector("#txtFechaSalida").value;
        let intContratoPracticante = document.querySelector("#txtContratoPracticante").value;
        let strFormacionAcademica = document.querySelector("#txtFormacionAcademica").value;
        let strProgramaEstudio = document.querySelector("#txtProgramaEstudio").value;
        let strInstitucionEducativa = document.querySelector("#txtInstitucionEducativa").value;
        let intStatus = document.querySelector("#listStatus").value;

        if (
          strCorreo == "" ||
          strNombre == "" ||
          strIdentificacion == "" ||
          strArl == "" ||
          intEdad == "" ||
          strSexo == "" ||
          strTelefono == "" ||
          strDireccion == "" ||
          intDependencia == "" ||
          strCargoHacer == "" ||
          strFechaIngreso == "" ||
          strFechaSalida == "" ||
          intContratoPracticante == "" ||
          strFormacionAcademica == "" ||
          strProgramaEstudio == "" ||
          strInstitucionEducativa == ""
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
        let ajaxUrl = base_url + "/Practicantes/setPracticante";
        let formData = new FormData(formPracticante);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              $("#modalFormPracticante").modal("hide");
              formPracticante.reset();
              Swal.fire("Practicantes", objData.msg, "success");
              tablePracticantes.api().ajax.reload();
            } else {
              Swal.fire("Error", objData.msg, "error");
            }
          }
          if (divLoading) divLoading.style.display = "none";
          return false;
        };
      };
    }
  },
  false
);

function fntViewInfo(idepracticante) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Practicantes/getPracticante/" + idepracticante;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        let objPracticante = objData.data;
        
        document.querySelector("#viewNombre").innerHTML = objPracticante.nombre_completo;
        document.querySelector("#viewIdentificacion").innerHTML = objPracticante.numero_identificacion;
        document.querySelector("#viewArl").innerHTML = objPracticante.arl;
        document.querySelector("#viewEdad").innerHTML = objPracticante.edad;
        document.querySelector("#viewSexo").innerHTML = objPracticante.sexo;
        document.querySelector("#viewCorreo").innerHTML = objPracticante.correo_electronico;
        document.querySelector("#viewTelefono").innerHTML = objPracticante.telefono;
        document.querySelector("#viewDireccion").innerHTML = objPracticante.direccion;
        document.querySelector("#viewDependencia").innerHTML = objPracticante.dependencia_nombre;
        document.querySelector("#viewCargoHacer").innerHTML = objPracticante.cargo_hacer;
        document.querySelector("#viewFechaIngreso").innerHTML = objPracticante.fecha_ingreso;
        document.querySelector("#viewFechaSalida").innerHTML = objPracticante.fecha_salida;
        document.querySelector("#viewTipoContrato").innerHTML = objPracticante.tipo_contrato;
        document.querySelector("#viewFormacionAcademica").innerHTML = objPracticante.formacion_academica;
        document.querySelector("#viewProgramaEstudio").innerHTML = objPracticante.programa_estudio;
        document.querySelector("#viewInstitucionEducativa").innerHTML = objPracticante.institucion_educativa;
        
        $("#modalViewPracticante").modal("show");
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

function fntEditInfo(element, idepracticante) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Practicantes/getPracticante/" + idepracticante;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        let objPracticante = objData.data;
        
        document.querySelector("#titleModal").innerHTML = "Actualizar Practicante";
        document.querySelector("#btnActionForm").innerHTML = '<i class="bi bi-check-lg me-2"></i>Actualizar';
        document.querySelector("#idePracticante").value = objPracticante.idepracticante;
        document.querySelector("#txtNombrePracticante").value = objPracticante.nombre_completo;
        document.querySelector("#txtIdentificacionPracticante").value = objPracticante.numero_identificacion;
        document.querySelector("#txtArlPracticante").value = objPracticante.arl;
        document.querySelector("#txtEdadPracticante").value = objPracticante.edad;
        document.querySelector("#txtSexoPracticante").value = objPracticante.sexo;
        document.querySelector("#txtCorreoPracticante").value = objPracticante.correo_electronico;
        document.querySelector("#txtTelefonoPracticante").value = objPracticante.telefono;
        document.querySelector("#txtDireccionPracticante").value = objPracticante.direccion;
        document.querySelector("#txtDependenciaPracticante").value = objPracticante.dependencia_fk;
        document.querySelector("#txtCargoHacerPracticante").value = objPracticante.cargo_hacer;
        document.querySelector("#txtFechaIngreso").value = objPracticante.fecha_ingreso;
        document.querySelector("#txtFechaSalida").value = objPracticante.fecha_salida;
        document.querySelector("#txtContratoPracticante").value = objPracticante.contrato_practicante_fk;
        document.querySelector("#txtFormacionAcademica").value = objPracticante.formacion_academica;
        document.querySelector("#txtProgramaEstudio").value = objPracticante.programa_estudio;
        document.querySelector("#txtInstitucionEducativa").value = objPracticante.institucion_educativa;
        document.querySelector("#listStatus").value = objPracticante.status;
        
        $("#modalFormPracticante").modal("show");
      } else {
        Swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

function fntDelInfo(idepracticante) {
  Swal.fire({
    title: "¿Está seguro de eliminar el practicante?",
    text: "¡No es posible cambiar está acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/Practicantes/delPracticante";
      let strData = "idePracticante=" + idepracticante;
      request.open("POST", ajaxUrl, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.send(strData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
            Swal.fire("Eliminado!", objData.msg, "success");
            tablePracticantes.api().ajax.reload();
          } else {
            Swal.fire("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

function openModal() {
  document.querySelector("#idePracticante").value = "";
  document.querySelector(".modal-header").classList.remove("headerUpdate");
  document.querySelector(".modal-header").classList.add("headerRegister");
  document.querySelector("#titleModal").innerHTML = "Nuevo Practicante";
  document.querySelector("#btnActionForm").innerHTML = '<i class="bi bi-check-lg me-2"></i>Guardar';
  document.querySelector("#formPracticante").reset();
  $("#modalFormPracticante").modal("show");
} 