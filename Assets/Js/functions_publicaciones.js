var tablePublicaciones;
let rowTable = "";

document.addEventListener('DOMContentLoaded', function(){
    // Cargar dependencias al iniciar
    fntGetDependencias();

    // Inicializar la tabla cuando se muestra la pestaña de tabla
    document.getElementById('tabla-tab').addEventListener('shown.bs.tab', function (e) {
        if (tablePublicaciones) {
            tablePublicaciones.api().ajax.reload();
        } else {
            initializeTable();
        }
    });

    // Inicializar la tabla al cargar la página ya que es la pestaña activa por defecto
    initializeTable();
    
    // Configurar filtros de tabla
    setupTableFilters();

    // CREAR PUBLICACIÓN
    let formPublicacion = document.querySelector("#formPublicacion");
    formPublicacion.onsubmit = function(e) {
        e.preventDefault();
        
        let strNombrePublicacion = document.querySelector('#txtNombrePublicacion').value;
        let strFechaRecibido = document.querySelector('#txtFechaRecibido').value;
        let strCorreoRecibido = document.querySelector('#txtCorreoRecibido').value;
        let strAsunto = document.querySelector('#txtAsunto').value;
        let intDependencia = document.querySelector('#listDependencia').value;
        
        if(strNombrePublicacion == '' || strFechaRecibido == '' || strCorreoRecibido == '' || 
           strAsunto == '' || intDependencia == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        
        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                return false;
            } 
        }
        
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Publicaciones/setPublicacion'; 
        let formData = new FormData(formPublicacion);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                try {
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        $('#modalFormPublicaciones').modal("hide");
                        formPublicacion.reset();
                        Swal.fire("Publicaciones", objData.msg, "success");
                        tablePublicaciones.api().ajax.reload();
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                } catch (e) {
                    console.error("Error al parsear JSON:", request.responseText);
                    Swal.fire("Error", "Ocurrió un error en el servidor", "error");
                }
            }
        }
    }
});

function setupTableFilters() {
    const btnFiltrarTabla = document.getElementById('btnFiltrarTabla');
    const btnLimpiarTabla = document.getElementById('btnLimpiarTabla');
    const btnImprimirTabla = document.getElementById('btnImprimirTabla');
    
    if (btnFiltrarTabla) {
        btnFiltrarTabla.addEventListener('click', function() {
            const fechaInicio = document.getElementById('fechaInicioTabla').value;
            const fechaFin = document.getElementById('fechaFinTabla').value;
            
            if (fechaInicio && fechaFin) {
                if (fechaInicio > fechaFin) {
                    Swal.fire('Error', 'La fecha de inicio no puede ser mayor que la fecha fin', 'error');
                    return;
                }
                filtrarTabla(fechaInicio, fechaFin);
            } else {
                Swal.fire('Error', 'Por favor seleccione ambas fechas', 'error');
            }
        });
    }
    
    if (btnLimpiarTabla) {
        btnLimpiarTabla.addEventListener('click', function() {
            document.getElementById('fechaInicioTabla').value = '';
            document.getElementById('fechaFinTabla').value = '';
            limpiarFiltrosTabla();
        });
    }
    
    if (btnImprimirTabla) {
        btnImprimirTabla.addEventListener('click', function() {
            imprimirTabla();
        });
    }
}

function filtrarTabla(fechaInicio, fechaFin) {
    if (tablePublicaciones) {
        tablePublicaciones.api().ajax.reload();
    }
}

function limpiarFiltrosTabla() {
    if (tablePublicaciones) {
        tablePublicaciones.api().ajax.reload();
    }
}

function imprimirTabla() {
    const fechaInicio = document.getElementById('fechaInicioTabla').value;
    const fechaFin = document.getElementById('fechaFinTabla').value;
    
    let titulo = 'Reporte de Publicaciones';
    if (fechaInicio && fechaFin) {
        titulo += ` (${fechaInicio} - ${fechaFin})`;
    }
    
    // Crear ventana de impresión
    const printWindow = window.open('', '_blank');
    const tableHtml = document.getElementById('tablePublicaciones').outerHTML;
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>${titulo}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { text-align: center; color: #333; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .text-center { text-align: center; }
                .badge { padding: 4px 8px; border-radius: 4px; color: white; }
                .text-bg-success { background-color: #28a745; }
                .text-bg-warning { background-color: #ffc107; color: black; }
                .text-bg-danger { background-color: #dc3545; }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <h1>${titulo}</h1>
            <p>Fecha de generación: ${new Date().toLocaleDateString('es-ES')}</p>
            ${tableHtml.replace(/class="btn[^"]*"/g, 'style="display:none"')}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 250);
}

function fntGetDependencias() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Publicaciones/getDependencias';
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let htmlOption = '<option value="">Seleccione una dependencia</option>';
            objData.forEach(function(dependencia) {
                htmlOption += '<option value="'+dependencia.dependencia_pk+'">'+dependencia.nombre+'</option>';
            });
            document.querySelector("#listDependencia").innerHTML = htmlOption;
        }
    }
}

function initializeTable() {
    tablePublicaciones = $('#tablePublicaciones').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": base_url + "/es.json"
        },
        "ajax": {
            "url": base_url + "/Publicaciones/getPublicaciones",
            "type": "POST",
            "data": function(d) {
                d.fechaInicio = document.getElementById('fechaInicioTabla')?.value || '';
                d.fechaFin = document.getElementById('fechaFinTabla')?.value || '';
            },
            "dataSrc": ""
        },
        "columns": [
            // {"data": "id_publicacion"},
            {"data": "fecha_recibido"},
            {"data": "correo_recibido"},
            {"data": "nombre_publicacion"},
            {"data": "asunto"},
            {"data": "dependencia_nombre"},
            {"data": "fecha_publicacion"},
            {
                "data": "respuesta_envio",
                "render": function(data, type, row) {
                    return data == 'Si' ? 
                        '<span class="badge text-bg-success">Si</span>' : 
                        '<span class="badge text-bg-warning">No</span>';
                }
            },
            {
                "data": "status",
                "render": function(data, type, row) {
                    return data == 1 ? 
                        '<span class="badge text-bg-success">Activo</span>' : 
                        '<span class="badge text-bg-danger">Inactivo</span>';
                }
            },
            {"data": "options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success"
            }
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });
}

function openModal() {
    document.querySelector('#idPublicacion').value = "";
    document.querySelector('.modal-title').innerHTML = "Nueva Publicación";
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#formPublicacion').reset();
    $('#modalFormPublicaciones').modal('show');
}

function fntEditInfo(idpublicacion) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Publicación";
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Publicaciones/getPublicacion/'+idpublicacion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                    document.querySelector("#idPublicacion").value = objData.data.id_publicacion;
                    document.querySelector("#txtNombrePublicacion").value = objData.data.nombre_publicacion;
                    document.querySelector("#txtFechaRecibido").value = objData.data.fecha_recibido;
                    document.querySelector("#txtCorreoRecibido").value = objData.data.correo_recibido;
                    document.querySelector("#txtAsunto").value = objData.data.asunto;
                    document.querySelector("#listDependencia").value = objData.data.dependencia_fk;
                    document.querySelector("#txtFechaPublicacion").value = objData.data.fecha_publicacion;
                    document.querySelector("#listRespuestaEnvio").value = objData.data.respuesta_envio;
                    document.querySelector("#txtEnlacePublicacion").value = objData.data.enlace_publicacion;
                    document.querySelector("#listStatus").value = objData.data.status;

                    $('#modalFormPublicaciones').modal('show');
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            } catch (e) {
                console.error("Error al parsear JSON:", request.responseText);
                Swal.fire("Error", "Ocurrió un error en el servidor", "error");
            }
        }
    }
}

function fntViewInfo(idpublicacion) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Publicaciones/getPublicacion/'+idpublicacion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            try {
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                    let estado = objData.data.status == 1 ? 
                    '<span class="badge text-bg-success">Activo</span>' : 
                    '<span class="badge text-bg-danger">Inactivo</span>';
                    
                    document.querySelector("#celId").innerHTML = objData.data.id_publicacion;
                    document.querySelector("#celNombrePublicacion").innerHTML = objData.data.nombre_publicacion;
                    document.querySelector("#celFechaRecibido").innerHTML = objData.data.fecha_recibido;
                    document.querySelector("#celCorreoRecibido").innerHTML = objData.data.correo_recibido;
                    document.querySelector("#celAsunto").innerHTML = objData.data.asunto;
                    document.querySelector("#celDependencia").innerHTML = objData.data.dependencia_nombre;
                    document.querySelector("#celFechaPublicacion").innerHTML = objData.data.fecha_publicacion;
                    
                    // Mostrar respuesta de envío con badge
                    let respuestaEnvio = objData.data.respuesta_envio == 'Si' ? 
                        '<span class="badge text-bg-success">Si</span>' : 
                        '<span class="badge text-bg-warning">No</span>';
                    document.querySelector("#celRespuestaEnvio").innerHTML = respuestaEnvio;
                    
                    // Hacer el enlace clicable en el modal de vista
                    if(objData.data.enlace_publicacion) {
                        let url = objData.data.enlace_publicacion;
                        if(!url.match(/^https?:\/\//i)) {
                            url = 'https://' + url;
                        }
                        document.querySelector("#celEnlacePublicacion").innerHTML = `<a href="${url}" target="_blank" class="a-link text-break">${objData.data.enlace_publicacion}</a>`;
                    } else {
                        document.querySelector("#celEnlacePublicacion").innerHTML = '';
                    }
                    
                    document.querySelector("#celEstado").innerHTML = estado;
                    $('#modalViewPublicacion').modal('show');
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            } catch (e) {
                console.error("Error al parsear JSON:", request.responseText);
                Swal.fire("Error", "Ocurrió un error en el servidor", "error");
            }
        }
    }
}

function fntDelInfo(idpublicacion) {
    Swal.fire({
        title: "Eliminar Publicación",
        text: "¿Realmente quiere eliminar esta publicación?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Publicaciones/delPublicacion';
            let strData = "idPublicacion="+idpublicacion;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    try {
                        let objData = JSON.parse(request.responseText);
                        if(objData.status) {
                            Swal.fire("Eliminar", objData.msg, "success");
                            tablePublicaciones.api().ajax.reload();
                        } else {
                            Swal.fire("Atención", objData.msg, "error");
                        }
                    } catch (e) {
                        console.error("Error al parsear JSON:", request.responseText);
                        Swal.fire("Error", "Ocurrió un error en el servidor", "error");
                    }
                }
            }
        }
    });
}