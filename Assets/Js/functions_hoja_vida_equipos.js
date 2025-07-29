let tableEquipos;

document.addEventListener('DOMContentLoaded', function(){
    tableEquipos = $('#tableEquipos').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": base_url + "/HojaVidaEquipos/getEquipos",
            "dataSrc": ""
        },
        "columns": [
            {"data": "tipo"},
            {"data": "numero_equipo"},
            {"data": "marca"},
            {"data": "modelo"},
            {"data": "estado"},
            {"data": "dependencia"},
            {"data": "options"}
        ],
        "responsive": true,
        "destroy": true,
        "pageLength": 10,
        "order": [[0, "asc"]]
    });
});

function fntViewEquipo(idequipo, tipo) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/HojaVidaEquipos/getEquipo?id=' + idequipo + '&tipo=' + encodeURIComponent(tipo);
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let data = objData.data;
                
                document.querySelector("#celTipo").innerHTML = data.tipo;
                document.querySelector("#celNumero").innerHTML = data.numero_equipo;
                document.querySelector("#celMarca").innerHTML = data.marca;
                document.querySelector("#celModelo").innerHTML = data.modelo;
                document.querySelector("#celSerial").innerHTML = data.serial || 'N/A';
                document.querySelector("#celEstado").innerHTML = data.estado;
                document.querySelector("#celDisponibilidad").innerHTML = data.disponibilidad;
                document.querySelector("#celDependencia").innerHTML = data.dependencia || 'N/A';
                // Campo oficina removido - no existe en la BD
                document.querySelector("#celFechaRegistro").innerHTML = formatDate(data.fecha_registro);
                
                // Mostrar campos específicos según el tipo
                if (data.tipo === 'PC Torre' || data.tipo === 'Portátil' || data.tipo === 'Todo en Uno') {
                    document.querySelector("#especsComputadora").style.display = 'block';
                    document.querySelector("#especsImpresora").style.display = 'none';
                    
                    document.querySelector("#celRam").innerHTML = (data.ram || 'N/A') + (data.velocidad_ram ? ' - ' + data.velocidad_ram : '');
                    document.querySelector("#celProcesador").innerHTML = (data.procesador || 'N/A') + (data.velocidad_procesador ? ' - ' + data.velocidad_procesador : '');
                    document.querySelector("#celDiscoDuro").innerHTML = (data.disco_duro || 'N/A') + (data.capacidad ? ' - ' + data.capacidad : '');
                    document.querySelector("#celSistemaOperativo").innerHTML = data.sistema_operativo || 'N/A';
                } else if (data.tipo === 'Impresora') {
                    document.querySelector("#especsComputadora").style.display = 'none';
                    document.querySelector("#especsImpresora").style.display = 'block';
                    
                    document.querySelector("#celConsumible").innerHTML = data.consumible || 'N/A';
                } else {
                    document.querySelector("#especsComputadora").style.display = 'none';
                    document.querySelector("#especsImpresora").style.display = 'none';
                }
                
                $('#modalViewEquipo').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntPdfEquipo(idequipo, tipo) {
    let url = base_url + '/HojaVidaEquipos/generarPdf?id=' + idequipo + '&tipo=' + encodeURIComponent(tipo);
    window.open(url, '_blank');
}

function fntPdfTodos() {
    let url = base_url + '/HojaVidaEquipos/generarPdfTodos';
    window.open(url, '_blank');
}

function formatDate(dateString) {
    let date = new Date(dateString);
    let day = String(date.getDate()).padStart(2, '0');
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let year = date.getFullYear();
    return day + '/' + month + '/' + year;
}