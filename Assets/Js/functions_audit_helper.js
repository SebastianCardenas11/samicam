/**
 * Archivo auxiliar para registrar accesos a módulos en la auditoría
 * Este archivo debe ser incluido en el footer_admin.php
 */

// Función para registrar acceso al módulo en auditoría
function registrarAccesoModulo(modulo) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/auditoria/registrarAccesoJS';
    let formData = new FormData();
    formData.append('modulo', modulo);
    
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    console.log("Registrando acceso al módulo: " + modulo);
}

// Detectar la página actual y registrar el acceso correspondiente
document.addEventListener('DOMContentLoaded', function() {
    // Obtener la URL actual
    const currentUrl = window.location.href;
    
    // Registrar acceso según la URL
    if (currentUrl.includes('/cargos')) {
        registrarAccesoModulo('Cargos');
    } else if (currentUrl.includes('/vacaciones')) {
        registrarAccesoModulo('Vacaciones');
    } else if (currentUrl.includes('/vacaciones')) {
        registrarAccesoModulo('Vacaciones');
    } else if (currentUrl.includes('/funcionariosviaticos')) {
        registrarAccesoModulo('Viáticos');
    } else if (currentUrl.includes('/tareas')) {
        registrarAccesoModulo('Tareas');
    }
    
    // Registrar acceso cuando se hace clic en enlaces de navegación
    const navLinks = document.querySelectorAll('a[href*="/cargos"], a[href*="/vacaciones"], a[href*="/viaticos"], a[href*="/archivos"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href.includes('/cargos')) {
                registrarAccesoModulo('Cargos');
            } else if (href.includes('/vacaciones')) {
                registrarAccesoModulo('Vacaciones');
            } else if (href.includes('/funcionariosviaticos')) {
                registrarAccesoModulo('Viáticos');
            } else if (href.includes('/tareas')) {
                registrarAccesoModulo('Tareas');
            } else if (href.includes('/archivos')) {
                registrarAccesoModulo('Archivos');
            }
        });
    });
});