// Funciones para el Manual de Usuario SAMICAM
let manualSearchResults = [];

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar funcionalidades del manual
    inicializarManual();
    
    // Configurar eventos de búsqueda
    configurarBusqueda();
    
    // Configurar eventos de descarga
    configurarDescargas();
    
    // Configurar eventos de feedback
    configurarFeedback();
});

function inicializarManual() {
    console.log('Manual de Usuario SAMICAM inicializado');
    
    // Resaltar sección activa en el menú
    resaltarSeccionActiva();
    
    // Configurar tooltips
    configurarTooltips();
    
    // Configurar navegación suave
    configurarNavegacionSuave();
}

function configurarBusqueda() {
    // Buscador en tiempo real
    const searchInput = document.getElementById('manualSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const termino = this.value.trim();
            if (termino.length >= 3) {
                buscarEnManual(termino);
            } else {
                ocultarResultadosBusqueda();
            }
        });
    }
}

function buscarEnManual(termino) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ManualUsuario/buscarManual';
    let formData = new FormData();
    formData.append('termino', termino);
    
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                mostrarResultadosBusqueda(objData.data);
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    }
}

function mostrarResultadosBusqueda(resultados) {
    const resultadosContainer = document.getElementById('searchResults');
    if (!resultadosContainer) return;
    
    if (resultados.length === 0) {
        resultadosContainer.innerHTML = '<p class="text-gray-500 p-4">No se encontraron resultados</p>';
        resultadosContainer.classList.remove('hidden');
        return;
    }
    
    let html = '<div class="p-4">';
    html += '<h4 class="font-medium text-gray-800 mb-3">Resultados de búsqueda:</h4>';
    
    resultados.forEach(resultado => {
        html += `
            <div class="mb-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer" 
                 onclick="navegarASeccion('${resultado.url}')">
                <h5 class="font-medium text-blue-600">${resultado.titulo}</h5>
                <p class="text-sm text-gray-600">${resultado.contenido}</p>
                <span class="text-xs text-gray-500">Sección: ${resultado.seccion}</span>
            </div>
        `;
    });
    
    html += '</div>';
    resultadosContainer.innerHTML = html;
    resultadosContainer.classList.remove('hidden');
}

function ocultarResultadosBusqueda() {
    const resultadosContainer = document.getElementById('searchResults');
    if (resultadosContainer) {
        resultadosContainer.classList.add('hidden');
    }
}

function configurarDescargas() {
    // Descargar PDF
    const btnPDF = document.getElementById('descargarPDF');
    if (btnPDF) {
        btnPDF.addEventListener('click', function() {
            descargarManual('pdf');
        });
    }
    
    // Descargar DOCX
    const btnDOCX = document.getElementById('descargarDOCX');
    if (btnDOCX) {
        btnDOCX.addEventListener('click', function() {
            descargarManual('docx');
        });
    }
    
    // Descargar capturas
    const btnCapturas = document.getElementById('descargarCapturas');
    if (btnCapturas) {
        btnCapturas.addEventListener('click', function() {
            descargarCapturas();
        });
    }
}

function descargarManual(formato) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ManualUsuario/descargar' + formato.toUpperCase();
    
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                Swal.fire("Descarga", objData.msg, "info");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    }
}

function descargarCapturas() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ManualUsuario/obtenerCapturas';
    
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                mostrarModalCapturas(objData.data);
            } else {
                Swal.fire("Error", "No se pudieron obtener las capturas", "error");
            }
        }
    }
}

function mostrarModalCapturas(capturas) {
    let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
    
    capturas.forEach(captura => {
        html += `
            <div class="border rounded-lg p-4">
                <h5 class="font-medium text-gray-800 mb-2">${captura.modulo}</h5>
                <img src="Assets/images/manual/${captura.imagen}" 
                     alt="${captura.descripcion}" 
                     class="w-full h-32 object-cover rounded mb-2"
                     onerror="this.src='Assets/images/sin-imagen.png'">
                <p class="text-sm text-gray-600">${captura.descripcion}</p>
                <button onclick="descargarImagen('${captura.imagen}')" 
                        class="mt-2 bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                    Descargar
                </button>
            </div>
        `;
    });
    
    html += '</div>';
    
    Swal.fire({
        title: 'Capturas de Pantalla',
        html: html,
        width: '800px',
        showConfirmButton: false,
        showCloseButton: true
    });
}

function descargarImagen(nombreImagen) {
    // Simular descarga de imagen
    const link = document.createElement('a');
    link.href = 'Assets/images/manual/' + nombreImagen;
    link.download = nombreImagen;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function configurarFeedback() {
    const btnFeedback = document.getElementById('enviarFeedback');
    if (btnFeedback) {
        btnFeedback.addEventListener('click', function() {
            mostrarFormularioFeedback();
        });
    }
}

function mostrarFormularioFeedback() {
    Swal.fire({
        title: 'Enviar Feedback',
        html: `
            <form id="feedbackForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Feedback</label>
                    <select id="tipoFeedback" class="w-full p-2 border rounded">
                        <option value="sugerencia">Sugerencia</option>
                        <option value="error">Error</option>
                        <option value="mejora">Mejora</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sección</label>
                    <select id="seccionFeedback" class="w-full p-2 border rounded">
                        <option value="general">General</option>
                        <option value="dashboard">Dashboard</option>
                        <option value="funcionarios">Funcionarios</option>
                        <option value="permisos">Permisos</option>
                        <option value="inventario">Inventario</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                    <textarea id="mensajeFeedback" rows="4" class="w-full p-2 border rounded" 
                              placeholder="Describa su feedback..."></textarea>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const tipo = document.getElementById('tipoFeedback').value;
            const seccion = document.getElementById('seccionFeedback').value;
            const mensaje = document.getElementById('mensajeFeedback').value;
            
            if (!mensaje.trim()) {
                Swal.showValidationMessage('Debe ingresar un mensaje');
                return false;
            }
            
            return { tipo, seccion, mensaje };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            enviarFeedback(result.value);
        }
    });
}

function enviarFeedback(datos) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ManualUsuario/enviarFeedback';
    let formData = new FormData();
    
    formData.append('tipo', datos.tipo);
    formData.append('seccion', datos.seccion);
    formData.append('mensaje', datos.mensaje);
    
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                Swal.fire("Éxito", objData.msg, "success");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    }
}

function resaltarSeccionActiva() {
    window.addEventListener('scroll', () => {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('aside a[href^="#"]');
        
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (scrollY >= (sectionTop - 200)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('bg-blue-600');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('bg-blue-600');
            }
        });
    });
}

function configurarTooltips() {
    // Configurar tooltips personalizados
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = this.getAttribute('data-tooltip');
            mostrarTooltip(this, tooltip);
        });
        
        element.addEventListener('mouseleave', function() {
            ocultarTooltip();
        });
    });
}

function mostrarTooltip(element, texto) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip-custom';
    tooltip.textContent = texto;
    tooltip.style.cssText = `
        position: absolute;
        background: #111827;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        z-index: 1000;
        pointer-events: none;
        white-space: nowrap;
    `;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
}

function ocultarTooltip() {
    const tooltip = document.querySelector('.tooltip-custom');
    if (tooltip) {
        tooltip.remove();
    }
}

function configurarNavegacionSuave() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Resaltar sección temporalmente
                target.classList.add('highlight');
                setTimeout(() => {
                    target.classList.remove('highlight');
                }, 3000);
            }
        });
    });
}

function navegarASeccion(seccion) {
    const target = document.querySelector(seccion);
    if (target) {
        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
        
        // Ocultar resultados de búsqueda
        ocultarResultadosBusqueda();
    }
}

function obtenerEstadisticasManual() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ManualUsuario/obtenerEstadisticasManual';
    
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                mostrarEstadisticas(objData.data);
            }
        }
    }
}

function mostrarEstadisticas(estadisticas) {
    Swal.fire({
        title: 'Estadísticas del Manual',
        html: `
            <div class="text-left">
                <p><strong>Total de visitas:</strong> ${estadisticas.total_visitas}</p>
                <p><strong>Sección más vista:</strong> ${estadisticas.seccion_mas_vista}</p>
                <p><strong>Tiempo promedio:</strong> ${estadisticas.tiempo_promedio}</p>
                <p><strong>Usuarios activos:</strong> ${estadisticas.usuarios_activos}</p>
            </div>
        `,
        icon: 'info'
    });
}

function obtenerVersionManual() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ManualUsuario/obtenerVersion';
    
    request.open("GET", ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                mostrarVersion(objData.data);
            }
        }
    }
}

function mostrarVersion(info) {
    Swal.fire({
        title: 'Información de Versión',
        html: `
            <div class="text-left">
                <p><strong>Versión:</strong> ${info.version}</p>
                <p><strong>Fecha de actualización:</strong> ${info.fecha_actualizacion}</p>
                <p><strong>Última revisión:</strong> ${info.ultima_revision}</p>
                <p><strong>Desarrollador:</strong> ${info.desarrollador}</p>
                <p><strong>Compatibilidad:</strong> ${info.compatibilidad}</p>
            </div>
        `,
        icon: 'info'
    });
} 