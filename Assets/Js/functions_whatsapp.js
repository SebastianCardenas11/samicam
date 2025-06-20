document.addEventListener('DOMContentLoaded', function() {
    cargarHistoricoCompleto();
    document.getElementById('btn-buscar').addEventListener('click', function() {
        buscarEnHistorico();
    });
    document.getElementById('busqueda-termino').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            buscarEnHistorico();
        }
    });
    function cargarHistoricoCompleto() {
        const request = new XMLHttpRequest();
        const ajaxUrl = base_url + '/WhatsApp/verHistorico';
        const fecha = new Date();
        const fechaStr = formatDate(fecha);
        document.getElementById('archivo-contenido').innerHTML =
            '<span class="timestamp">[' + fechaStr + ']</span> ' +
            '<span class="command">$</span> <span class="path">cat /logs/whatsapp_log.txt</span>\n' +
            '<span class="info">Cargando mensajes de WhatsApp...</span>';
        request.open('GET', ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                const fecha = new Date();
                const fechaStr = formatDate(fecha);
                let contenido = '<span class="timestamp">[' + fechaStr + ']</span> ' +
                               '<span class="command">$</span> <span class="path">cat /logs/whatsapp_log.txt</span>\n\n';
                let formattedContent = objData.contenido;
                if (formattedContent.trim() === '') {
                    formattedContent = '<span class="info">No hay mensajes de WhatsApp disponibles.</span>';
                } else {
                    formattedContent = formattedContent.replace(/\[([\d\-\s:]+)\]/g, function(match, p1) {
                        return '<span class="timestamp">[' + p1 + ']</span>';
                    });
                    formattedContent = formattedContent.replace(/(Usuario:\s*[^|]+)/g, '<span class="user">$1</span>');
                    formattedContent = formattedContent.replace(/(Mensaje:\s*[^
]+)/g, '<span class="message">$1</span>');
                }
                contenido += formattedContent;
                document.getElementById('archivo-contenido').innerHTML = contenido;
                document.getElementById('archivo-contenido').scrollTop = 0;
            }
        };
    }
    function buscarEnHistorico() {
        const termino = document.getElementById('busqueda-termino').value.trim();
        if (termino === '') {
            cargarHistoricoCompleto();
            return;
        }
        const request = new XMLHttpRequest();
        const ajaxUrl = base_url + '/WhatsApp/buscarEnHistorico';
        const formData = new FormData();
        formData.append('termino', termino);
        const fecha = new Date();
        const fechaStr = formatDate(fecha);
        document.getElementById('archivo-contenido').innerHTML =
            '<span class="timestamp">[' + fechaStr + ']</span> ' +
            '<span class="command">$</span> <span class="path">grep -i "' + termino + '" /logs/whatsapp_log.txt</span>\n' +
            '<span class="info">Buscando "' + termino + '" en los mensajes...</span>';
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                const objData = JSON.parse(request.responseText);
                const fecha = new Date();
                const fechaStr = formatDate(fecha);
                let contenido = '<span class="timestamp">[' + fechaStr + ']</span> ' +
                               '<span class="command">$</span> <span class="path">grep -i "' + termino + '" /logs/whatsapp_log.txt</span>\n\n';
                let formattedContent = objData.contenido;
                if (formattedContent.trim() === '') {
                    formattedContent = '<span class="highlight">No se encontraron coincidencias para "' + termino + '"</span>';
                } else {
                    const regex = new RegExp('(' + termino + ')', 'gi');
                    formattedContent = formattedContent.replace(regex, '<span class="highlight">$1</span>');
                    formattedContent = formattedContent.replace(/\[([\d\-\s:]+)\]/g, function(match, p1) {
                        return '<span class="timestamp">[' + p1 + ']</span>';
                    });
                    formattedContent = formattedContent.replace(/(Usuario:\s*[^|]+)/g, '<span class="user">$1</span>');
                    formattedContent = formattedContent.replace(/(Mensaje:\s*[^
]+)/g, '<span class="message">$1</span>');
                }
                contenido += formattedContent;
                document.getElementById('archivo-contenido').innerHTML = contenido;
                document.getElementById('archivo-contenido').scrollTop = 0;
            }
        };
    }
    function formatDate(dateObj) {
        let hours = dateObj.getHours();
        const minutes = dateObj.getMinutes().toString().padStart(2, '0');
        const seconds = dateObj.getSeconds().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        const formattedHours = hours.toString().padStart(2, '0');
        const year = dateObj.getFullYear();
        const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
        const day = dateObj.getDate().toString().padStart(2, '0');
        return `${year}-${month}-${day} ${formattedHours}:${minutes}:${seconds} ${ampm}`;
    }
}); 