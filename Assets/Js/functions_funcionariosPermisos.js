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
            { "data": "permisos" },
             { "data": "options" }
        ]
    });
    
  },
  false
);

;
