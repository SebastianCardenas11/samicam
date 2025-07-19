let tableArchivos;
let rowTable = "";
let permisosUsuario = { r: false, w: false, u: false, d: false };

document.addEventListener('DOMContentLoaded', function(){

    // Obtener permisos del usuario al cargar la página
    obtenerPermisosUsuario().then(function(permisos) {
        permisosUsuario = permisos;
    }).catch(function(error) {
        console.error(error);
    });

    tableArchivos = $('#tableArchivos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Archivos/getArchivos",
            "dataSrc":""
        },
        "columns":[
            {"data":"id"},
            {"data":"nombre"},
            {"data":"descripcion"},
            {"data":"categoria"},
            {"data":"extension"},
            {"data":"fecha_creacion"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    // Cargar el explorador de archivos
    cargarExplorador();
    
    // Cargar categorías para el filtro
    cargarCategorias();
    
    // Cargar pestañas de categorías
    cargarPestanasCategoria();

    // Formulario para agregar/editar archivo
    let formArchivo = document.querySelector("#formArchivo");
    formArchivo.onsubmit = function(e) {
        e.preventDefault();
        
        let strNombre = document.querySelector('#txtNombre').value;
        let fileInput = document.querySelector('#fileArchivo');
        
        if(strNombre == '' || fileInput.files.length === 0) {
            Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        
        // Validar extensión del archivo
        let archivo = fileInput.files[0];
        let extension = archivo.name.split('.').pop().toLowerCase();
        let extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif'];
        let extensionesProhibidas = ['php', 'exe', 'js', 'html', 'htm'];
        
        if (extensionesProhibidas.includes(extension)) {
            Swal.fire("Error", "Tipo de archivo no permitido por seguridad.", "error");
            return false;
        }
        
        if (!extensionesPermitidas.includes(extension)) {
            Swal.fire("Error", "Solo se permiten archivos: " + extensionesPermitidas.join(', '), "error");
            return false;
        }
        
        let divLoading = document.querySelector("#divLoading");
        if(divLoading) {
            divLoading.style.display = "flex";
        }
        
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Archivos/setArchivo'; 
        let formData = new FormData(formArchivo);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormArchivo').modal("hide");
                    formArchivo.reset();
                    Swal.fire("Archivos", objData.msg ,"success");
                    tableArchivos.api().ajax.reload();
                    // Actualizar explorador después de subir archivo
                    setTimeout(function() {
                        actualizarPermisosYRecargar();
                    }, 1000);
                } else {
                    Swal.fire("Error", objData.msg , "error");
                }
            }
            if(divLoading) {
                divLoading.style.display = "none";
            }
            return false;
        }
    }

    // Buscador de archivos
    document.querySelector('#searchInput').addEventListener('keypress', function(e) {
        if(e.key === 'Enter') {
            fntSearchArchivo();
        }
    });
});

function cargarCategorias() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Archivos/getSelectCategorias';
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            document.querySelector('#listCategoria').innerHTML = request.responseText;
            document.querySelector('#listCategoriaFilter').innerHTML = '<option value="0">Todas las categorías</option>' + request.responseText;
        }
    }
}

function obtenerPermisosUsuario() {
    return new Promise((resolve, reject) => {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Archivos/getPermisosUsuario';
        request.open("GET", ajaxUrl, true);
        request.send();
        
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                permisosUsuario = JSON.parse(request.responseText);
                resolve(permisosUsuario);
            } else if(request.readyState == 4 && request.status !== 200) {
                console.error('Error al obtener permisos:', request.status, request.statusText);
                reject('Error al obtener permisos');
            }
        }
    });
}

function generarBotonesCarta(archivo, permisos = null) {
    // Si no se pasan permisos, usar los globales
    let permisosActuales = permisos || permisosUsuario;
    let botones = '';
    
    // Botón de ver
    if (permisosActuales.r) {
        botones += `<button class="btn btn-sm btn-info" onclick="fntViewArchivo(${archivo.id})">
            <i class="far fa-eye"></i>
        </button>`;
    }
    
    // Botón de descargar
    if (permisosActuales.r) {
        botones += `<a class="btn btn-sm btn-primary" href="${base_url}/uploads/archivos/${archivo.archivo}" download="${archivo.nombre}.${archivo.extension}">
            <i class="bi bi-download"></i>
        </a>`;
    }
    
    // Botón de eliminar
    if (permisosActuales.d) {
        botones += `<button class="btn btn-sm btn-danger" onclick="fntDelArchivo(${archivo.id})">
            <i class="bi bi-trash-fill"></i>
        </button>`;
    }
    
    return botones;
}

function cargarPestanasCategoria() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/CategoriasArchivos/getCategorias';
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let tabsHTML = '<li class="nav-item"><a class="nav-link active" id="todos-tab" data-bs-toggle="tab" href="#todos" role="tab" aria-controls="todos" aria-selected="true">Todos</a></li>';
            let contentHTML = '<div class="tab-pane fade show active" id="todos" role="tabpanel" aria-labelledby="todos-tab"><div class="row mt-3" id="fileExplorer"></div></div>';
            
            objData.forEach(function(categoria) {
                if(categoria.status == '<span class="badge text-bg-success">Activo</span>') {
                    let idTab = 'categoria-' + categoria.id_categoria;
                    tabsHTML += `<li class="nav-item">
                        <a class="nav-link" id="${idTab}-tab" data-bs-toggle="tab" href="#${idTab}" role="tab" aria-controls="${idTab}" aria-selected="false">${categoria.nombre}</a>
                    </li>`;
                    
                    contentHTML += `<div class="tab-pane fade" id="${idTab}" role="tabpanel" aria-labelledby="${idTab}-tab">
                        <div class="row mt-3" id="fileExplorer-${categoria.id_categoria}"></div>
                    </div>`;
                }
            });
            
            document.querySelector('#myTab').innerHTML = tabsHTML;
            document.querySelector('#myTabContent').innerHTML = contentHTML;
            
            // Cargar archivos para cada categoría
            cargarExplorador();
            objData.forEach(function(categoria) {
                if(categoria.status == '<span class="badge text-bg-success">Activo</span>') {
                    cargarArchivosPorCategoria(categoria.id_categoria);
                }
            });
            
            // Inicializar eventos de las pestañas
            let tabElems = document.querySelectorAll('a[data-bs-toggle="tab"]');
            tabElems.forEach(function(tabElem) {
                tabElem.addEventListener('shown.bs.tab', function (event) {
                    let targetId = event.target.getAttribute('href').substring(1);
                    if(targetId.startsWith('categoria-')) {
                        let categoriaId = targetId.split('-')[1];
                        cargarArchivosPorCategoria(categoriaId);
                    } else if(targetId === 'todos') {
                        cargarExplorador();
                    }
                });
            });
        }
    }
}

function cargarArchivosPorCategoria(idCategoria) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Archivos/getArchivosPorCategoria/'+idCategoria;
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let fileExplorer = document.querySelector('#fileExplorer-'+idCategoria);
            let html = '';
            
            // Asegurar que los permisos estén cargados antes de generar las cartas
            obtenerPermisosUsuario().then(function(permisos) {
                if(objData.length > 0) {
                    objData.forEach(function(archivo) {
                        let icono = getIconoArchivo(archivo.extension);
                        html += `
                        <div class="col-md-2 col-sm-4 col-6 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <div class="file-icon mb-3">
                                        <i class="${icono}" style="font-size: 4rem;"></i>
                                    </div>
                                    <h6 class="card-title text-truncate" title="${archivo.nombre}">${archivo.nombre}</h6>
                                    <p class="card-text small text-muted">${archivo.extension.toUpperCase()}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    ${generarBotonesCarta(archivo, permisos)}
                                </div>
                            </div>
                        </div>
                        `;
                    });
                } else {
                    html = '<div class="col-12 text-center"><p>No hay archivos en esta categoría</p></div>';
                }
                
                fileExplorer.innerHTML = html;
            }).catch(function(error) {
                console.error('Error al cargar permisos:', error);
                // Si hay error, mostrar archivos sin botones de eliminar
                if(objData.length > 0) {
                    objData.forEach(function(archivo) {
                        let icono = getIconoArchivo(archivo.extension);
                        html += `
                        <div class="col-md-2 col-sm-4 col-6 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <div class="file-icon mb-3">
                                        <i class="${icono}" style="font-size: 4rem;"></i>
                                    </div>
                                    <h6 class="card-title text-truncate" title="${archivo.nombre}">${archivo.nombre}</h6>
                                    <p class="card-text small text-muted">${archivo.extension.toUpperCase()}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <button class="btn btn-sm btn-info" onclick="fntViewArchivo(${archivo.id})">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <a class="btn btn-sm btn-primary" href="${base_url}/uploads/archivos/${archivo.archivo}" download="${archivo.nombre}.${archivo.extension}">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                } else {
                    html = '<div class="col-12 text-center"><p>No hay archivos en esta categoría</p></div>';
                }
                
                fileExplorer.innerHTML = html;
            });
        }
    }
}

function cargarExplorador() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Archivos/getArchivos';
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let fileExplorer = document.querySelector('#fileExplorer');
            let html = '';
            
            // Asegurar que los permisos estén cargados antes de generar las cartas
            obtenerPermisosUsuario().then(function(permisos) {
                objData.forEach(function(archivo) {
                    let icono = getIconoArchivo(archivo.extension);
                    html += `
                    <div class="col-md-2 col-sm-4 col-6 mb-4">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="file-icon mb-3">
                                    <i class="${icono}" style="font-size: 4rem;"></i>
                                </div>
                                <h6 class="card-title text-truncate" title="${archivo.nombre}">${archivo.nombre}</h6>
                                <p class="card-text small text-muted">${archivo.extension.toUpperCase()}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                ${generarBotonesCarta(archivo, permisos)}
                            </div>
                        </div>
                    </div>
                    `;
                });
                
                fileExplorer.innerHTML = html;
            }).catch(function(error) {
                console.error('Error al cargar permisos:', error);
                // Si hay error, mostrar archivos sin botones de eliminar
                objData.forEach(function(archivo) {
                    let icono = getIconoArchivo(archivo.extension);
                    html += `
                    <div class="col-md-2 col-sm-4 col-6 mb-4">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="file-icon mb-3">
                                    <i class="${icono}" style="font-size: 4rem;"></i>
                                </div>
                                <h6 class="card-title text-truncate" title="${archivo.nombre}">${archivo.nombre}</h6>
                                <p class="card-text small text-muted">${archivo.extension.toUpperCase()}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <button class="btn btn-sm btn-info" onclick="fntViewArchivo(${archivo.id})">
                                    <i class="far fa-eye"></i>
                                </button>
                                <a class="btn btn-sm btn-primary" href="${base_url}/uploads/archivos/${archivo.archivo}" download="${archivo.nombre}.${archivo.extension}">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                });
                
                fileExplorer.innerHTML = html;
            });
        }
    }
}

function getIconoArchivo(extension) {
    extension = extension.toLowerCase();
    switch(extension) {
        case 'pdf':
            return 'bi bi-file-earmark-pdf-fill text-danger';
        case 'doc':
        case 'docx':
            return 'bi bi-file-earmark-word-fill text-primary';
        case 'xls':
        case 'xlsx':
            return 'bi bi-file-earmark-excel-fill text-success';
        case 'ppt':
        case 'pptx':
            return 'bi bi-file-earmark-ppt-fill text-warning';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'bi bi-file-earmark-image-fill text-info';
        case 'txt':
            return 'bi bi-file-earmark-text-fill text-secondary';
        default:
            return 'bi bi-file-earmark-fill text-secondary';
    }
}

function fntViewArchivo(idarchivo) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Archivos/getArchivo/'+idarchivo;
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                let archivo = objData.data;
                document.querySelector("#celId").innerHTML = archivo.id;
                document.querySelector("#celNombre").innerHTML = archivo.nombre;
                document.querySelector("#celDescripcion").innerHTML = archivo.descripcion;
                document.querySelector("#celCategoria").innerHTML = archivo.categoria;
                document.querySelector("#celTipo").innerHTML = archivo.extension.toUpperCase();
                document.querySelector("#celFecha").innerHTML = archivo.fecha_creacion;
                
                let filePreview = document.querySelector("#filePreview");
                let extension = archivo.extension.toLowerCase();
                let rutaArchivo = base_url + '/uploads/archivos/' + archivo.archivo;
                
                // Configurar botón de descarga
                document.querySelector("#btnDownload").setAttribute("href", rutaArchivo);
                document.querySelector("#btnDownload").setAttribute("download", archivo.nombre + "." + archivo.extension);
                
                // Mostrar vista previa según tipo de archivo
                if(['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                    filePreview.innerHTML = `<img src="${rutaArchivo}" class="img-fluid" style="max-height: 300px;">`;
                } else if(extension === 'pdf') {
                    filePreview.innerHTML = `<iframe src="${rutaArchivo}" width="100%" height="400" frameborder="0"></iframe>`;
                } else {
                    let icono = getIconoArchivo(extension);
                    filePreview.innerHTML = `
                        <div class="text-center">
                            <i class="${icono}" style="font-size: 120px;"></i>
                            <p class="mt-3">Vista previa no disponible para este tipo de archivo</p>
                        </div>
                    `;
                }
                
                $('#modalViewArchivo').modal('show');
            } else {
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
}

function fntSearchArchivo() {
    let busqueda = document.querySelector('#searchInput').value;
    if(busqueda == '') {
        tableArchivos.api().ajax.reload();
        cargarExplorador();
        return;
    }
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Archivos/search';
    let formData = new FormData();
    formData.append('busqueda', busqueda);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            let fileExplorer = document.querySelector('#fileExplorer');
            let html = '';
            
            // Asegurar que los permisos estén cargados antes de generar las cartas
            obtenerPermisosUsuario().then(function(permisos) {
                if(objData.length > 0) {
                    objData.forEach(function(archivo) {
                        let icono = getIconoArchivo(archivo.extension);
                        html += `
                        <div class="col-md-2 col-sm-4 col-6 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <div class="file-icon mb-3">
                                        <i class="${icono}" style="font-size: 4rem;"></i>
                                    </div>
                                    <h6 class="card-title text-truncate" title="${archivo.nombre}">${archivo.nombre}</h6>
                                    <p class="card-text small text-muted">${archivo.extension.toUpperCase()}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    ${generarBotonesCarta(archivo, permisos)}
                                </div>
                            </div>
                        </div>
                        `;
                    });
                } else {
                    html = '<div class="col-12 text-center"><p>No se encontraron archivos</p></div>';
                }
                
                fileExplorer.innerHTML = html;
                
                // Actualizar tabla
                tableArchivos.api().clear().rows.add(objData).draw();
            }).catch(function(error) {
                console.error('Error al cargar permisos:', error);
                // Si hay error, mostrar archivos sin botones de eliminar
                if(objData.length > 0) {
                    objData.forEach(function(archivo) {
                        let icono = getIconoArchivo(archivo.extension);
                        html += `
                        <div class="col-md-2 col-sm-4 col-6 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <div class="file-icon mb-3">
                                        <i class="${icono}" style="font-size: 4rem;"></i>
                                    </div>
                                    <h6 class="card-title text-truncate" title="${archivo.nombre}">${archivo.nombre}</h6>
                                    <p class="card-text small text-muted">${archivo.extension.toUpperCase()}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <button class="btn btn-sm btn-info" onclick="fntViewArchivo(${archivo.id})">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <a class="btn btn-sm btn-primary" href="${base_url}/uploads/archivos/${archivo.archivo}" download="${archivo.nombre}.${archivo.extension}">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                } else {
                    html = '<div class="col-12 text-center"><p>No se encontraron archivos</p></div>';
                }
                
                fileExplorer.innerHTML = html;
                
                // Actualizar tabla
                tableArchivos.api().clear().rows.add(objData).draw();
            });
        }
    }
}

function fntFilterByCategoria() {
    let categoriaId = document.querySelector('#listCategoriaFilter').value;
    
    if(categoriaId == 0) {
        // Mostrar todos los archivos
        tableArchivos.api().ajax.reload();
        cargarExplorador();
    } else {
        // Filtrar por categoría
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Archivos/getArchivosPorCategoria/'+categoriaId;
        request.open("GET", ajaxUrl, true);
        request.send();
        
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                let fileExplorer = document.querySelector('#fileExplorer');
                let html = '';
                
                // Asegurar que los permisos estén cargados antes de generar las cartas
                obtenerPermisosUsuario().then(function(permisos) {
                    if(objData.length > 0) {
                        objData.forEach(function(archivo) {
                            let icono = getIconoArchivo(archivo.extension);
                            html += `
                            <div class="col-md-2 col-sm-4 col-6 mb-4">
                                <div class="card h-100 text-center">
                                    <div class="card-body">
                                        <div class="file-icon mb-3">
                                            <i class="${icono}" style="font-size: 4rem;"></i>
                                        </div>
                                        <h6 class="card-title text-truncate" title="${archivo.nombre}">${archivo.nombre}</h6>
                                        <p class="card-text small text-muted">${archivo.extension.toUpperCase()}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        ${generarBotonesCarta(archivo, permisos)}
                                    </div>
                                </div>
                            </div>
                            `;
                        });
                    } else {
                        html = '<div class="col-12 text-center"><p>No hay archivos en esta categoría</p></div>';
                    }
                    
                    fileExplorer.innerHTML = html;
                    
                    // Actualizar tabla
                    tableArchivos.api().clear().rows.add(objData).draw();
                }).catch(function(error) {
                    console.error('Error al cargar permisos:', error);
                    // Si hay error, mostrar archivos sin botones de eliminar
                    if(objData.length > 0) {
                        objData.forEach(function(archivo) {
                            let icono = getIconoArchivo(archivo.extension);
                            html += `
                            <div class="col-md-2 col-sm-4 col-6 mb-4">
                                <div class="card h-100 text-center">
                                    <div class="card-body">
                                        <div class="file-icon mb-3">
                                            <i class="${icono}" style="font-size: 4rem;"></i>
                                        </div>
                                        <h6 class="card-title text-truncate" title="${archivo.nombre}">${archivo.nombre}</h6>
                                        <p class="card-text small text-muted">${archivo.extension.toUpperCase()}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <button class="btn btn-sm btn-info" onclick="fntViewArchivo(${archivo.id})">
                                            <i class="far fa-eye"></i>
                                        </button>
                                        <a class="btn btn-sm btn-primary" href="${base_url}/uploads/archivos/${archivo.archivo}" download="${archivo.nombre}.${archivo.extension}">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            `;
                        });
                    } else {
                        html = '<div class="col-12 text-center"><p>No hay archivos en esta categoría</p></div>';
                    }
                    
                    fileExplorer.innerHTML = html;
                    
                    // Actualizar tabla
                    tableArchivos.api().clear().rows.add(objData).draw();
                });
            }
        }
    }
}

function openModal() {
    document.querySelector('#idArchivo').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-success");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Archivo";
    document.querySelector("#formArchivo").reset();
    
    // Cargar categorías
    cargarCategorias();
    
    $('#modalFormArchivo').modal('show');
}

function fntDelArchivo(idarchivo) {
    Swal.fire({
        title: "Eliminar Archivo",
        text: "¿Realmente quiere eliminar este archivo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Archivos/delArchivo';
            let strData = "idArchivo="+idarchivo;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        Swal.fire("Eliminar", objData.msg , "success");
                        tableArchivos.api().ajax.reload();
                        // Actualizar explorador después de eliminar
                        setTimeout(function() {
                            actualizarPermisosYRecargar();
                        }, 1000);
                    } else {
                        Swal.fire("Atención", objData.msg , "error");
                    }
                }
            }
        }
    });
}

function actualizarPermisosYRecargar() {
    obtenerPermisosUsuario().then(function() {
        // Recargar el explorador con los nuevos permisos
        cargarExplorador();
        cargarPestanasCategoria();
    }).catch(function(error) {
        console.error('Error al actualizar permisos:', error);
    });
}

