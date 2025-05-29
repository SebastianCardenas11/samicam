document.addEventListener('DOMContentLoaded', function() {
    // Cargar el histórico de auditoría al iniciar la página
    cargarHistoricoCompleto();
    
    // Evento para el botón de búsqueda
    document.getElementById('btn-buscar').addEventListener('click', function() {
        buscarEnHistorico();
    });
    
    // Evento para buscar al presionar Enter en el campo de búsqueda
    document.getElementById('busqueda-termino').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            buscarEnHistorico();
        }
    });
    
    // Evento para el botón de descarga
    document.getElementById('btn-descargar').addEventListener('click', function() {
        window.location.href = base_url + '/Auditoria/descargarHistorico';
    });

    // Función para cargar el histórico completo
    function cargarHistoricoCompleto() {
        const request = new XMLHttpRequest();
        const ajaxUrl = base_url + '/Auditoria/verHistorico';
        
        // Mostrar indicador de carga con estilo de terminal
        const fecha = new Date();
        const fechaStr = formatDate(fecha);
        document.getElementById('archivo-contenido').innerHTML = 
            '<span class="timestamp">[' + fechaStr + ']</span> ' +
            '<span class="command">$</span> <span class="path">cat /logs/historicoAuditoria.txt</span>\n' +
            '<span class="info">Cargando registros de auditoría...</span>';
        
        request.open('GET', ajaxUrl, true);
        request.send();
        
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                
                // Formatear el contenido como salida de terminal
                const fecha = new Date();
                const fechaStr = formatDate(fecha);
                
                let contenido = '<span class="timestamp">[' + fechaStr + ']</span> ' +
                               '<span class="command">$</span> <span class="path">cat /logs/historicoAuditoria.txt</span>\n\n';
                
                // Formatear el contenido para mejor legibilidad
                let formattedContent = objData.contenido;
                
                if (formattedContent.trim() === '') {
                    formattedContent = '<span class="info">No hay registros de auditoría disponibles.</span>';
                } else {
                    // Resaltar fechas y horas
                    formattedContent = formattedContent.replace(/\[([\d\-\s:]+)\]/g, function(match, p1) {
                        return '<span class="timestamp">[' + p1 + ']</span>';
                    });
                    
                    // Resaltar IDs
                    formattedContent = formattedContent.replace(/(ID:\s*\d+)/g, '<span class="info">$1</span>');
                    
                    // Resaltar usuarios
                    formattedContent = formattedContent.replace(/(Usuario:\s*[^|]+)/g, '<span class="success">$1</span>');
                    
                    // Resaltar roles
                    formattedContent = formattedContent.replace(/(Rol:\s*[^|]+)/g, '<span class="warning">$1</span>');
                    
                    // Resaltar acciones
                    formattedContent = formattedContent.replace(/(Acción:\s*[^\n]+)/g, '<span class="command">$1</span>');
                }
                
                contenido += formattedContent;
                
                document.getElementById('archivo-contenido').innerHTML = contenido;
                
                // Hacer scroll al inicio para mejor experiencia de usuario
                const preElement = document.getElementById('archivo-contenido');
                preElement.scrollTop = 0;
            }
        };
    }
    
    // Función para buscar en el histórico
    function buscarEnHistorico() {
        const termino = document.getElementById('busqueda-termino').value.trim();
        
        if (termino === '') {
            cargarHistoricoCompleto();
            return;
        }
        
        const request = new XMLHttpRequest();
        const ajaxUrl = base_url + '/Auditoria/buscarEnHistorico';
        const formData = new FormData();
        
        formData.append('termino', termino);
        
        // Mostrar indicador de carga con estilo de terminal
        const fecha = new Date();
        const fechaStr = formatDate(fecha);
        document.getElementById('archivo-contenido').innerHTML = 
            '<span class="timestamp">[' + fechaStr + ']</span> ' +
            '<span class="command">$</span> <span class="path">grep -i "' + termino + '" /logs/historicoAuditoria.txt</span>\n' +
            '<span class="info">Buscando "' + termino + '" en los registros...</span>';
        
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                
                // Formatear el contenido como salida de terminal
                const fecha = new Date();
                const fechaStr = formatDate(fecha);
                
                let contenido = '<span class="timestamp">[' + fechaStr + ']</span> ' +
                               '<span class="command">$</span> <span class="path">grep -i "' + termino + '" /logs/historicoAuditoria.txt</span>\n\n';
                
                // Formatear el contenido para mejor legibilidad
                let formattedContent = objData.contenido;
                
                if (formattedContent.trim() === '') {
                    formattedContent = '<span class="warning">No se encontraron coincidencias para "' + termino + '"</span>';
                } else {
                    // Resaltar el término buscado
                    const regex = new RegExp('(' + termino + ')', 'gi');
                    formattedContent = formattedContent.replace(regex, '<span class="highlight">$1</span>');
                    
                    // Resaltar fechas y horas
                    formattedContent = formattedContent.replace(/\[([\d\-\s:]+)\]/g, function(match, p1) {
                        return '<span class="timestamp">[' + p1 + ']</span>';
                    });
                    
                    // Resaltar IDs
                    formattedContent = formattedContent.replace(/(ID:\s*\d+)/g, '<span class="info">$1</span>');
                    
                    // Resaltar usuarios
                    formattedContent = formattedContent.replace(/(Usuario:\s*[^|]+)/g, '<span class="success">$1</span>');
                    
                    // Resaltar roles
                    formattedContent = formattedContent.replace(/(Rol:\s*[^|]+)/g, '<span class="warning">$1</span>');
                    
                    // Resaltar acciones
                    formattedContent = formattedContent.replace(/(Acción:\s*[^\n]+)/g, '<span class="command">$1</span>');
                }
                
                contenido += formattedContent;
                
                document.getElementById('archivo-contenido').innerHTML = contenido;
                
                // Hacer scroll al inicio para mejor experiencia de usuario
                const preElement = document.getElementById('archivo-contenido');
                preElement.scrollTop = 0;
            }
        };
    }

    // Función para formatear fecha en formato 12 horas
    function formatDate(dateObj) {
        let hours = dateObj.getHours();
        const minutes = dateObj.getMinutes().toString().padStart(2, '0');
        const seconds = dateObj.getSeconds().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // la hora '0' debe ser '12'
        const formattedHours = hours.toString().padStart(2, '0');
        
        const year = dateObj.getFullYear();
        const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
        const day = dateObj.getDate().toString().padStart(2, '0');
        
        return `${year}-${month}-${day} ${formattedHours}:${minutes}:${seconds} ${ampm}`;
    }
});