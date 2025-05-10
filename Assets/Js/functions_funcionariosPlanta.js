let tableFuncionarios;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener(
  "DOMContentLoaded",
  function () {
    tableFuncionarios = $("#tableFuncionarios").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "./es.json",
      },
      ajax: {
        url: " " + base_url + "/FuncionariosPlanta/getFuncionarios",
        dataSrc: "",
      },
      columns: [
        { data: "nombre_completo" },
        { data: "nm_identificacion" },
        { data: "cargo_fk" },
        { data: "dependencia_fk" },
        { data: "correo_elc" },
        { data: "status" },
        { data: "options" },
      ],
      dom: "lBfrtip",
      buttons: [
        {
          extend: "excelHtml5",
          text: "<i class='fas fa-file-excel'></i> Excel",
          titleAttr: "Exportar a Excel",
          className: "btn btn-success mt-3",
        },
        {
          extend: "pdfHtml5",
          text: "<i class='fas fa-file-pdf'></i> PDF",
          titleAttr: "Exportar a PDF",
          className: "btn btn-danger mt-3",
        },
      ],
      responsive: "true",
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
    });

    if (document.querySelector("#formFuncionario")) {
      let formFuncionario = document.querySelector("#formFuncionario");
      formFuncionario.onsubmit = function (e) {
        e.preventDefault();

        // Captura de campos
        var intIdeFuncionario = document.querySelector("#ideFuncionario").value;
        let strCorreoFuncionario = document.querySelector(
          "#txtCorreoFuncionario"
        ).value;
        let strNombresFuncionario = document.querySelector(
          "#txtNombreFuncionario"
        ).value;
        // let strVacacionesFuncionario = document.querySelector('#VacacionesFuncionario').value;
        let strIdentificacion = document.querySelector(
          "#txtIdentificacionFuncionario"
        ).value;
        let strCelular = document.querySelector("#txtCelularFuncionario").value;
        let strDireccion = document.querySelector(
          "#txtDireccionFuncionario"
        ).value;
        let strFechaIngreso = document.querySelector(
          "#txtFechaIngresoFuncionario"
        ).value;
        let strHijos = document.querySelector("#txtHijosFuncionario").value;
        let strNombresHijos = document.querySelector(
          "#txtNombresHijosFuncionario"
        ).value;
        let strSexo = document.querySelector("#txtSexoFuncionario").value;
        let strLugarResidencia = document.querySelector(
          "#txtLugarResidenciaFuncionario"
        ).value;
        let intEdad = document.querySelector("#txtEdadFuncionario").value;
        let strEstadoCivil = document.querySelector(
          "#txtEstadoCivilFuncionario"
        ).value;
        let strReligion = document.querySelector(
          "#txtReligionFuncionario"
        ).value;
        let strFormacionAcademica = document.querySelector(
          "#txtFormacionFuncionario"
        ).value;
        let strContrato = document.querySelector("#txtContrato").value;
        let strNombreFormacion = document.querySelector(
          "#txtNombreFormacion"
        ).value;
      
        

        if (
          strCorreoFuncionario === "" ||
          strNombresFuncionario === "" ||
          strIdentificacion === "" ||
          strCelular === "" ||
          strDireccion === "" ||
          strFechaIngreso === "" ||
          strSexo === "" ||
          strLugarResidencia === "" ||
          intEdad === "" ||
          strEstadoCivil === "" ||
          strReligion === "" ||
          strFormacionAcademica === "" ||
          strContrato === "" ||
          strNombreFormacion === ""
        ) {
          Swal.fire(
            "Atención",
            "Todos los campos deben ser completados.",
            "error"
          );
          return false;
        }
        if (strCelular.length !== 10) {
            Swal.fire("Atención", "El número de celular debe tener 10 dígitos.", "error");
            return false;
          }
        if (strCelular.length !== 10) {
            Swal.fire("Atención", "El número de celular debe tener 10 dígitos.", "error");
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

        divLoading.style.display = "flex";
        let request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/funcionariosPlanta/setFuncionario";
        let formData = new FormData(formFuncionario);

        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText);
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              if (rowTable == "") {
                tableFuncionarios.api().ajax.reload();
              } else {
                let htmlStatus =
                  intStatus == 1
                    ? '<span class="badge text-bg-success">Activo</span>'
                    : '<span class="badge text-bg-danger">Inactivo</span>';

                rowTable.cells[1].textContent = strCorreoFuncionario;
                rowTable.cells[3].innerHTML = htmlStatus;
                rowTable = "";
              }

              $("#modalFormFuncionario").modal("hide");
              formFuncionario.reset();
              Swal.fire("Funcionario", objData.msg, "success");
            } else {
              Swal.fire("Error", objData.msg, "error");
            }
          }
          divLoading.style.display = "none";
          return false;
        };
      };
    }
    
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
      // console.log(request.responseText);
      let objData = JSON.parse(request.responseText);
        
      if (objData.status) {
        let estadoFuncionario =
          objData.data.status == 1
            ? '<span class="badge text-bg-success">Activo</span>'
            : '<span class="badge text-bg-danger">Inactivo</span>';

            let fechaIngreso = new Date(objData.data.fecha_ingreso);
            let fechaActual = new Date();
            
            let diferenciaTiempo = fechaActual - fechaIngreso; 
            let diasPasados = diferenciaTiempo / (1000 * 60 * 60 * 24); 
            
            let vacacionesFuncionario = "";
            
            if (diasPasados >= 1095) { 
              vacacionesFuncionario =
                '<span class="badge text-bg-success">3 periodos cumplidos</span>';
            } else if (diasPasados >= 730) { 
              vacacionesFuncionario =
                '<span class="badge text-bg-success">2 periodos cumplidos</span>';
            } else if (diasPasados >= 365) {
              vacacionesFuncionario =
                '<span class="badge text-bg-success">Cumplidas</span>';
            } else {
              vacacionesFuncionario =
                '<span class="badge text-bg-danger">No cumplidas</span>';
            }
            

        document.querySelector("#celIdeFuncionario").innerHTML =
          objData.data.idefuncionario;
        document.querySelector("#celCorreoFuncionario").innerHTML =
          objData.data.correo_elc;
        document.querySelector("#celNombresFuncionario").innerHTML =
          objData.data.nombre_completo;
        document.querySelector("#celEstadoFuncionario").innerHTML =
          estadoFuncionario;
        document.querySelector("#celIdentificacionFuncionario").innerHTML =
          objData.data.nm_identificacion;
        document.querySelector("#celCargoFuncionario").innerHTML =
          objData.data.cargo_fk;
        document.querySelector("#celDependenciaFuncionario").innerHTML =
          objData.data.dependencia_fk;
        document.querySelector("#celCelularFuncionario").innerHTML =
          objData.data.celular;
        document.querySelector("#celDireccionFuncionario").innerHTML =
          objData.data.direccion;
        document.querySelector("#celFechaIngresoFuncionario").innerHTML =
          objData.data.fecha_ingreso;
        document.querySelector("#celVacacionesFuncionario").innerHTML =
          vacacionesFuncionario;
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
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "headerUpdate");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";
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
          objData.data.cargo_fk;
        document.querySelector("#celDependenciaFuncionario").innerHTML =
          objData.data.dependencia_fk;
        document.querySelector("#celCelularFuncionario").innerHTML =
          objData.data.celular;
        document.querySelector("#celDireccionFuncionario").innerHTML =
          objData.data.direccion;
        document.querySelector("#celFechaIngresoFuncionario").innerHTML =
          objData.data.fecha_ingreso;
        document.querySelector("#celVacacionesFuncionario").innerHTML =
          objData.data.vacaciones;
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
        document.querySelector("#celNombreFormacio").innerHTML =
          objData.data.nombre_formacion;

        // ESTADO ACTIVO O INACTIVO
        if (objData.data.status == 1) {
          document.querySelector("#listStatus").value = 1;
        } else {
          document.querySelector("#listStatus").value = 2;
        }
      }
    }
    $("#modalFormFuncionario").modal("show");
  };
}

function fntDelInfo(ideFuncionario) {
  Swal.fire({
    title: "Eliminar la Asignación",
    text: "¿Estás seguro?",
    imageUrl: "Assets/images/iconos/eliminar.png",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    cancelButtonColor: "#00A6FF",
    confirmButtonText: "Eliminar",
    cancelButtonText: "Cancelar",
    closeOnConfirm: false,
    closeOnCancel: true,
  }).then((result) => {
    if (result.isConfirmed) {
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/funcionariosPlanta/delFuncionario";
      let strData = "ideFuncionario=" + ideFuncionario;
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

document.addEventListener("DOMContentLoaded", function () {
  console.log("La página está completamente cargada");
  var myModal = new bootstrap.Modal(
    document.getElementById("modalFormFuncionario")
  );
  // myModal.show();
});

function openModal() {
  rowTable = "";
  document.querySelector("#ideFuncionario").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("headerUpdate", "headerRegister");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#titleModal").innerHTML = "Nuevo Funcionario";
  document.querySelector("#formFuncionario").reset();
  $("#modalFormFuncionario").modal("show");
}
