let tableFuncionarios;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function () {

    tableFuncionarios = $('#tableFuncionarios').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "./es.json"
        },
        "ajax": {
            "url": " " + base_url + "/FuncionariosPlanta/getFuncionarios",
            "dataSrc": ""
        },
        "columns": [
            // { "data": "idefuncionario" },
            { "data": "nombre_completo" },
            { "data": "nm_identificacion" },
            { "data": "cargo_fk" },
            { "data": "dependencia_fk" },
            // { "data": "celular" },
            // { "data": "direccion" },
            { "data": "correo_elc" },
            // { "data": "fecha_ingreso" },
            // { "data": "vacaciones" },
            // { "data": "hijos" },
            // { "data": "nombres_de_hijos" },
            // { "data": "sexo" },
            // { "data": "lugar_de_residencia" },
            // { "data": "edad" },
            // { "data": "estado_civil" },
            // { "data": "religion" },
            // { "data": "nivel_escolar" },
            // { "data": "carrera" },
            // { "data": "especialidad" },
            // { "data": "maestria" },
            // { "data": "doctorado" },
            { "data": "status" },
            { "data": "options" }

        ],
        'dom': 'lBfrtip',
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
        "order": [[0, "desc"]]
    });



    if (document.querySelector("#formFuncionario")) {
        let formFuncionario = document.querySelector("#formFuncionario");
        formFuncionario.onsubmit = function (e) {
            e.preventDefault();
            var intIdeFuncionario = document.querySelector('#ideFuncionario').value;
            let strCorreoFuncionario = document.querySelector('#txtCorreoFuncionario').value;
            let strNombresFuncionario = document.querySelector('#txtNombresFuncionario').value;
            // $('#txtRolFuncionario').picker();
            // $('#txtRolFuncionario').picker({search : true});
            let strRolFuncionario = document.querySelector('#txtRolFuncionario').value;

            $('#listStatus').picker();
            let intStatus = document.querySelector('#listStatus').value;

            if (strCorreoFuncionario == '' || strNombresFuncionario == '' || strRolFuncionario == '') {
                Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains('is-invalid')) {
                    Swal.fire("Atención", "Por favor verifique los campos en rojo.", "error");
                    return false;
                }
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Funcionarios/setFuncionario';
            let formData = new FormData(formFuncionario);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        if (rowTable == "") {
                            tableFuncionarios.api().ajax.reload();
                            // tableFuncionarios.DataTable().ajax.reload();
                        } else {
                            htmlStatus = intStatus == 1 ?
                                '<span class="badge text-bg-success">Activo</span>' :
                                '<span class="badge text-bg-danger">Inactivo</span>';
                            // tableFuncionarios.api().ajax.reload();
                            rowTable.cells[1].textContent = strCorreoFuncionario;
                            //    rowTable.cells[2].textContent =  strRolFuncionario;
                            // rowTable.cells[2].textContent = document.querySelector("#txtRolFuncionario").selectedOptions[0].text;
                            rowTable.cells[3].innerHTML = htmlStatus;
                            rowTable = "";
                        }
                        $('#modalFormFuncionario').modal("hide");
                        formFuncionario.reset();
                        Swal.fire("Funcionario", objData.msg, "success");
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

}, false);



function fntViewInfo(idefuncionario) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/funcionariosPlanta/getFuncionario/'+idefuncionario;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            // console.log(request.responseText);
            let objData = JSON.parse(request.responseText);
            
            if (objData.status) 
                {
                    let estadoFuncionario = objData.data.status == 1
                    ? '<span class="badge text-bg-success">Activo</span>'
                    : '<span class="badge text-bg-danger">Inactivo</span>';
                    
                    document.querySelector("#celIdeFuncionario").innerHTML = objData.data.idefuncionario;
                    document.querySelector("#celCorreoFuncionario").innerHTML = objData.data.correo_elc;
                    document.querySelector("#celNombresFuncionario").innerHTML = objData.data.nombre_completo;
                    document.querySelector("#celEstadoFuncionario").innerHTML = estadoFuncionario;
                    document.querySelector("#celIdentificacionFuncionario").innerHTML = objData.data.nm_identificacion;
                    document.querySelector("#celCargoFuncionario").innerHTML = objData.data.cargo_fk;
                    document.querySelector("#celDependenciaFuncionario").innerHTML = objData.data.dependencia_fk;
                    document.querySelector("#celCelularFuncionario").innerHTML = objData.data.celular;
                    document.querySelector("#celDireccionFuncionario").innerHTML = objData.data.direccion;
                    document.querySelector("#celFechaIngresoFuncionario").innerHTML = objData.data.fecha_ingreso;
                    document.querySelector("#celVacacionesFuncionario").innerHTML = objData.data.vacaciones;
                    document.querySelector("#celHijosFuncionario").innerHTML = objData.data.hijos;
                    document.querySelector("#celNombresHijosFuncionario").innerHTML = objData.data.nombres_de_hijos;
                    document.querySelector("#celSexoFuncionario").innerHTML = objData.data.sexo;
                    document.querySelector("#celLugarResidenciaFuncionario").innerHTML = objData.data.lugar_de_residencia;
                    document.querySelector("#celEdadFuncionario").innerHTML = objData.data.edad;
                    document.querySelector("#celEstadoCivilFuncionario").innerHTML = objData.data.estado_civil;
                    document.querySelector("#celReligionFuncionario").innerHTML = objData.data.religion;
                    document.querySelector("#celNivelEscolarFuncionario").innerHTML = objData.data.nivel_escolar;
                    document.querySelector("#celCarreraFuncionario").innerHTML = objData.data.carrera;
                    document.querySelector("#celEspecialidadFuncionario").innerHTML = objData.data.especialidad;
                    document.querySelector("#celMaestriaFuncionario").innerHTML = objData.data.maestria;
                    document.querySelector("#celDoctoradoFuncionario").innerHTML = objData.data.doctorado;

                    $('#modalViewFuncionario').modal('show');
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}


function fntEditInfo(element, ideFuncionario) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Funcionario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Funcionarios/getFuncionario/' + ideFuncionario;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {

        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#ideFuncionario").value = objData.data.ideFuncionario;
                document.querySelector("#txtCorreoFuncionario").value = objData.data.correo;
                document.querySelector("#txtNombresFuncionario").value = objData.data.nombres;
                document.querySelector("#txtRolFuncionario").value = objData.data.idrol;

                // ESTADO ACTIVO O INACTIVO
                if (objData.data.status == 1) {
                    document.querySelector("#listStatus").value = 1;
                } else {
                    document.querySelector("#listStatus").value = 2;
                }

            }
        }
        $('#modalFormFuncionario').modal('show');

    }

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
        closeOnCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Funcionarios/delFuncionario';
            let strData = "ideFuncionario=" + ideFuncionario;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
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
            }
        }

    });

}

document.addEventListener('DOMContentLoaded', function () {
    console.log('La página está completamente cargada');
    var myModal = new bootstrap.Modal(document.getElementById('modalFormFuncionario'));
    // myModal.show();
});


function openModal() {
    rowTable = "";
    document.querySelector('#ideFuncionario').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Funcionario";
    document.querySelector("#formFuncionario").reset();
    $('#modalFormFuncionario').modal('show');
}




