let tableSeguimientoContrato;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){
    tableSeguimientoContrato = $('#tableSeguimientoContrato').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "./es.json"
        },
        "ajax": {
            "url": " " + base_url + "/SeguimientoContrato/getContratos",
            "dataSrc": ""
        },
        "columns": [
            { "data": "objeto_contrato" },
            { "data": "fecha_inicio" },
            { "data": "fecha_terminacion" },
            { "data": "valor_total_contrato" },
            { "data": "liquidacion" },
            { "data": "estado" },
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

    if (document.querySelector("#formSeguimientoContrato")) {
        let formSeguimientoContrato = document.querySelector("#formSeguimientoContrato");
        formSeguimientoContrato.onsubmit = function(e) {
            e.preventDefault();
            // All fields are required based on modal
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/SeguimientoContrato/setContrato';
            let formData = new FormData(formSeguimientoContrato);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        $('#modalFormSeguimientoContrato').modal("hide");
                        formSeguimientoContrato.reset();
                        Swal.fire("Seguimiento de Contrato", objData.msg, "success");
                        tableSeguimientoContrato.api().ajax.reload();
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                }
            }
        }
    }
}, false);

function fntViewContrato(id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getContrato/' + id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let estado = objData.data.estado == 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                document.querySelector("#celObjetoContrato").innerHTML = objData.data.objeto_contrato;
                document.querySelector("#celFechaInicio").innerHTML = objData.data.fecha_inicio;
                document.querySelector("#celFechaTerminacion").innerHTML = objData.data.fecha_terminacion;
                document.querySelector("#celPlazoMeses").innerHTML = objData.data.plazo_meses;
                document.querySelector("#celValorTotalContrato").innerHTML = objData.data.valor_total_contrato;
                document.querySelector("#celDiaCorteInforme").innerHTML = objData.data.dia_corte_informe;
                document.querySelector("#celObservacionesEjecucion").innerHTML = objData.data.observaciones_ejecucion;
                document.querySelector("#celEvidenciadoSecop").innerHTML = objData.data.evidenciado_secop;
                document.querySelector("#celFechaVerificacion").innerHTML = objData.data.fecha_verificacion;
                document.querySelector("#celLiquidacion").innerHTML = '$' + parseFloat(objData.data.liquidacion).toFixed(2);
                document.querySelector("#celEstado").innerHTML = estado;
                $('#modalViewContrato').modal('show');
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    }
}

function fntEditContrato(element, id) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Contrato";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-warning", "btn-warning");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/SeguimientoContrato/getContrato/' + id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#id").value = objData.data.id;
                document.querySelector("#objeto_contrato").value = objData.data.objeto_contrato;
                document.querySelector("#fecha_inicio").value = objData.data.fecha_inicio;
                document.querySelector("#fecha_terminacion").value = objData.data.fecha_terminacion;
                document.querySelector("#plazo_meses").value = objData.data.plazo_meses;
                document.querySelector("#valor_total_contrato").value = objData.data.valor_total_contrato;
                document.querySelector("#dia_corte_informe").value = objData.data.dia_corte_informe;
                document.querySelector("#observaciones_ejecucion").value = objData.data.observaciones_ejecucion;
                document.querySelector("#evidenciado_secop").value = objData.data.evidenciado_secop;
                document.querySelector("#fecha_verificacion").value = objData.data.fecha_verificacion;
                document.querySelector("#liquidacion").value = objData.data.liquidacion;
            }
        }
        $('#modalFormSeguimientoContrato').modal('show');
    }
}

function fntDelContrato(id) {
    Swal.fire({
        title: "Eliminar Contrato",
        text: "¿Realmente quiere eliminar el Contrato?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/SeguimientoContrato/delContrato';
            let strData = "id=" + id;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminar!", objData.msg, "success");
                        tableSeguimientoContrato.api().ajax.reload();
                    } else {
                        Swal.fire("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function openModal() {
    rowTable = "";
    document.querySelector('#id').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-warning");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Contrato";
    document.querySelector("#formSeguimientoContrato").reset();
    $('#modalFormSeguimientoContrato').modal('show');
} 