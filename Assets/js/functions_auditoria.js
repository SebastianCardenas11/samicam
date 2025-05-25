document.addEventListener('DOMContentLoaded', function() {
    // Variables globales para almacenar la ruta actual
    let currentAnio = '';
    let currentMes = '';
    let currentArchivo = '';

    // Evento para expandir/colapsar carpetas de años
    document.querySelectorAll('.folder-toggle').forEach(function(element) {
        element.addEventListener('click', function() {
            const anio = this.getAttribute('data-anio');
            const mesContainer = document.getElementById('meses-' + anio);
            
            // Cambiar icono de carpeta
            const folderIcon = this.querySelector('i');
            
            if (mesContainer.style.display === 'none') {
                // Expandir y cargar meses
                mesContainer.style.display = 'block';
                folderIcon.classList.remove('fa-folder');
                folderIcon.classList.add('fa-folder-open');
                
                // Cargar meses solo si no se han cargado antes
                if (mesContainer.children.length === 0) {
                    cargarMeses(anio, mesContainer);
                }
            } else {
                // Colapsar
                mesContainer.style.display = 'none';
                folderIcon.classList.remove('fa-folder-open');
                folderIcon.classList.add('fa-folder');
            }
        });
    });

    // Función para cargar los meses de un año
    function cargarMeses(anio, container) {
        const request = new XMLHttpRequest();
        const ajaxUrl = base_url + '/Auditoria/getMesesDirectorio';
        const formData = new FormData();
        
        formData.append('anio', anio);
        
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                let html = '';
                
                if (objData.length > 0) {
                    objData.forEach(function(mes) {
                        html += `<li class="folder-item">
                                    <span class="folder-toggle-mes" data-anio="${anio}" data-mes="${mes}">
                                        <i class="fas fa-folder"></i> ${mes}
                                    </span>
                                    <ul class="folder-content archivos-container" id="archivos-${anio}-${mes}" style="display: none;"></ul>
                                </li>`;
                    });
                } else {
                    html = '<li>No hay registros</li>';
                }
                
                container.innerHTML = html;
                
                // Agregar eventos a los nuevos elementos
                document.querySelectorAll('.folder-toggle-mes').forEach(function(element) {
                    element.addEventListener('click', function() {
                        const anio = this.getAttribute('data-anio');
                        const mes = this.getAttribute('data-mes');
                        const archivosContainer = document.getElementById('archivos-' + anio + '-' + mes);
                        
                        // Cambiar icono de carpeta
                        const folderIcon = this.querySelector('i');
                        
                        if (archivosContainer.style.display === 'none') {
                            // Expandir y cargar archivos
                            archivosContainer.style.display = 'block';
                            folderIcon.classList.remove('fa-folder');
                            folderIcon.classList.add('fa-folder-open');
                            
                            // Cargar archivos solo si no se han cargado antes
                            if (archivosContainer.children.length === 0) {
                                cargarArchivos(anio, mes, archivosContainer);
                            }
                        } else {
                            // Colapsar
                            archivosContainer.style.display = 'none';
                            folderIcon.classList.remove('fa-folder-open');
                            folderIcon.classList.add('fa-folder');
                        }
                    });
                });
            }
        };
    }

    // Función para cargar los archivos de un mes
    function cargarArchivos(anio, mes, container) {
        const request = new XMLHttpRequest();
        const ajaxUrl = base_url + '/Auditoria/getArchivosDirectorio';
        const formData = new FormData();
        
        formData.append('anio', anio);
        formData.append('mes', mes);
        
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                let html = '';
                
                if (objData.length > 0) {
                    objData.forEach(function(archivo) {
                        html += `<li class="file-item" data-anio="${anio}" data-mes="${mes}" data-archivo="${archivo}">
                                    <i class="fas fa-file-alt"></i> ${archivo}
                                </li>`;
                    });
                } else {
                    html = '<li>No hay archivos</li>';
                }
                
                container.innerHTML = html;
                
                // Agregar eventos a los nuevos elementos
                document.querySelectorAll('.file-item').forEach(function(element) {
                    element.addEventListener('click', function() {
                        // Remover clase activa de todos los archivos
                        document.querySelectorAll('.file-item').forEach(item => {
                            item.classList.remove('active');
                        });
                        
                        // Agregar clase activa al archivo seleccionado
                        this.classList.add('active');
                        
                        // Obtener datos del archivo
                        const anio = this.getAttribute('data-anio');
                        const mes = this.getAttribute('data-mes');
                        const archivo = this.getAttribute('data-archivo');
                        
                        // Guardar ruta actual
                        currentAnio = anio;
                        currentMes = mes;
                        currentArchivo = archivo;
                        
                        // Mostrar contenido del archivo
                        verContenidoArchivo(anio, mes, archivo);
                        
                        // Mostrar botón de descarga
                        document.getElementById('btn-descargar').style.display = 'block';
                    });
                });
            }
        };
    }

    // Función para ver el contenido de un archivo
    function verContenidoArchivo(anio, mes, archivo) {
        const request = new XMLHttpRequest();
        const ajaxUrl = base_url + '/Auditoria/verArchivo';
        const formData = new FormData();
        
        formData.append('anio', anio);
        formData.append('mes', mes);
        formData.append('archivo', archivo);
        
        // Mostrar indicador de carga con estilo de terminal
        const fecha = new Date();
        const fechaStr = fecha.toISOString().replace('T', ' ').substring(0, 19);
        document.getElementById('archivo-contenido').innerHTML = 
            '<span class="timestamp">[' + fechaStr + ']</span> ' +
            '<span class="command">$</span> <span class="path">cat /logs/' + anio + '/' + mes + '/' + archivo + '</span>\n' +
            '<span class="info">Cargando contenido del archivo...</span>';
        
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                
                // Actualizar título y contenido con estilo de terminal
                document.getElementById('archivo-titulo').innerHTML = '<i class="fas fa-terminal me-2"></i>Archivo: ' + archivo;
                
                // Formatear el contenido como salida de terminal
                const fecha = new Date();
                const fechaStr = fecha.toISOString().replace('T', ' ').substring(0, 19);
                
                let contenido = '<span class="timestamp">[' + fechaStr + ']</span> ' +
                               '<span class="command">$</span> <span class="path">cat /logs/' + anio + '/' + mes + '/' + archivo + '</span>\n\n';
                
                // Formatear el contenido para mejor legibilidad
                let formattedContent = objData.contenido;
                
                // Resaltar fechas y horas
                formattedContent = formattedContent.replace(/(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})/g, '<span class="timestamp">$1</span>');
                
                // Resaltar errores
                formattedContent = formattedContent.replace(/(ERROR|CRITICAL|FATAL|EXCEPTION|FAIL)/gi, '<span class="error">$1</span>');
                
                // Resaltar advertencias
                formattedContent = formattedContent.replace(/(WARNING|WARN|ALERT)/gi, '<span class="warning">$1</span>');
                
                // Resaltar información
                formattedContent = formattedContent.replace(/(INFO|NOTICE|DEBUG)/gi, '<span class="info">$1</span>');
                
                // Resaltar éxitos
                formattedContent = formattedContent.replace(/(SUCCESS|OK|COMPLETED)/gi, '<span class="success">$1</span>');
                
                contenido += formattedContent;
                
                document.getElementById('archivo-contenido').innerHTML = contenido;
                
                // Hacer scroll al inicio para mejor experiencia de usuario
                const preElement = document.getElementById('archivo-contenido');
                preElement.scrollTop = 0;
            }
        };
    }

    // Evento para el botón de descarga
    document.getElementById('btn-descargar').addEventListener('click', function() {
        if (currentAnio && currentMes && currentArchivo) {
            window.location.href = base_url + '/Auditoria/descargarArchivo?anio=' + currentAnio + '&mes=' + currentMes + '&archivo=' + currentArchivo;
        }
    });
});