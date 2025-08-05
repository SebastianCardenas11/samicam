let tableEquipos;
let tableSeleccionEquipos;
let currentEquipoId = null;
let currentEquipoTipo = null;

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
            {"data": "options"}
        ],
        "responsive": true,
        "destroy": true,
        "pageLength": 10,
        "order": [[0, "asc"]]
    });
});

function fntViewEquipo(idequipo, tipo) {
    currentEquipoId = idequipo;
    currentEquipoTipo = tipo;
    
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
                document.querySelector("#celFechaRegistro").innerHTML = formatDate(data.fecha_registro);
                
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
                
                fntCargarMantenimientos(idequipo, tipo);
                $('#modalViewEquipo').modal('show');
            } else {
                Swal.fire("Error", objData.msg, "error");
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

function fntNuevoMantenimiento() {
    if (document.querySelector('#modalSeleccionEquipo')) {
        $('#modalViewEquipo').modal('hide');
        fntCargarEquiposSeleccion();
        $('#modalSeleccionEquipo').modal('show');
    }
}

function fntCargarEquiposSeleccion() {
    let tbody = document.querySelector('#tableSeleccionEquipos tbody');
    if (!tbody) return;
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/HojaVidaEquipos/getEquipos';
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            tbody.innerHTML = '';
            
            objData.forEach(function(equipo) {
                let row = '<tr><td>' + equipo.tipo + '</td><td>' + equipo.numero_equipo + '</td><td>' + equipo.marca + '</td><td>' + equipo.modelo + '</td><td>' + equipo.estado + '</td><td><button class="btn btn-primary btn-sm" onclick="fntSeleccionarEquipo(' + equipo.id + ', \'' + equipo.tipo + '\')">Seleccionar</button></td></tr>';
                tbody.innerHTML += row;
            });
        }
    }
}

function fntSeleccionarEquipo(idEquipo, tipoEquipo) {
    if (!document.querySelector('#modalMantenimiento')) return;
    
    $('#modalSeleccionEquipo').modal('hide');
    
    let idEquipoInput = document.getElementById('idEquipoMantenimiento');
    let tipoEquipoInput = document.getElementById('tipoEquipoMantenimiento');
    let fechaInput = document.getElementById('fechaMantenimiento');
    
    if (idEquipoInput) idEquipoInput.value = idEquipo;
    if (tipoEquipoInput) tipoEquipoInput.value = tipoEquipo;
    if (fechaInput) fechaInput.value = new Date().toISOString().split('T')[0];
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/HojaVidaEquipos/getCurrentUser';
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let tecnicoInput = document.getElementById('tecnicoServicio');
                if (tecnicoInput) tecnicoInput.value = objData.user;
            }
        }
    }
    
    $('#modalMantenimiento').modal('show');
}

function fntCargarMantenimientos(idEquipo, tipoEquipo) {
    let tbody = document.querySelector('#tbodyMantenimientos');
    if (!tbody) return;
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/HojaVidaEquipos/getMantenimientos?id=' + idEquipo + '&tipo=' + encodeURIComponent(tipoEquipo);
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            tbody.innerHTML = '';
            
            if (objData && objData.length > 0) {
                objData.forEach(function(mantenimiento) {
                    let row = '<tr><td>' + formatDate(mantenimiento.fecha_mantenimiento) + '</td><td>' + mantenimiento.estacion_trabajo + '</td><td>' + mantenimiento.nombre_usuario + '<br><small class="text-muted">' + mantenimiento.cedula_usuario + '</small></td><td>' + mantenimiento.tipo_dispositivo + '</td><td><small>' + mantenimiento.error_reportado + '</small></td><td><small>' + mantenimiento.acciones_realizadas + '</small></td><td>' + mantenimiento.tecnico_servicio + '</td></tr>';
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay mantenimientos registrados</td></tr>';
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    let formMantenimiento = document.getElementById('formMantenimiento');
    if (formMantenimiento) {
        formMantenimiento.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/HojaVidaEquipos/setMantenimiento';
            
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Mantenimiento", objData.msg, "success");
                        $('#modalMantenimiento').modal('hide');
                        formMantenimiento.reset();
                        
                        if (currentEquipoId && currentEquipoTipo) {
                            fntCargarMantenimientos(currentEquipoId, currentEquipoTipo);
                        }
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                }
            }
        });
    }
});

function fntPdfMantenimientos() {
    let url = base_url + '/HojaVidaEquipos/generarPdfMantenimientos';
    window.open(url, '_blank');
}