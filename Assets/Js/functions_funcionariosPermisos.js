let tableFuncionarios;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener(
  "DOMContentLoaded",
  function () {
    tableFuncionarios = $('#tableFuncionarios').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "./es.json"
        },
        "ajax":{
            "url": " "+base_url+"/funcionariosPermisos/getFuncionarios",
            "dataSrc":""
        },
        "columns":[
            { "data": "nombre_completo" },
            { "data": "nm_identificacion" },
            { "data": "cargo_nombre" },
            { "data": "dependencia_nombre" },
            { "data": "permisos_fk" },
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
    base_url + "/funcionariosPermisos/getFuncionario/" +idefuncionario;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      console.log(request.responseText);
      let objData = JSON.parse(request.responseText);
        
      if (objData.status) {
        let estadoFuncionario =
         
        document.querySelector("#celIdeFuncionario").innerHTML =
          objData.data.idefuncionario;
       
        document.querySelector("#celNombresFuncionario").innerHTML =
          objData.data.nombre_completo;
        
        document.querySelector("#celCargoFuncionario").innerHTML =
          objData.data.cargo_nombre;
        document.querySelector("#celDependenciaFuncionario").innerHTML =
          objData.data.dependencia_nombre;
        
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