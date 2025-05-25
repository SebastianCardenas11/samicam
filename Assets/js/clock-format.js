// Función para formatear la hora en formato 12 horas (AM/PM)
function formatTime12Hours() {
    const now = new Date();
    let hours = now.getHours();
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    
    hours = hours % 12;
    hours = hours ? hours : 12; // la hora '0' debe ser '12'
    const formattedHours = hours.toString().padStart(2, '0');
    
    // Formatear fecha
    const days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    const day = days[now.getDay()];
    const date = now.getDate();
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    
    // Actualizar elementos del DOM si existen
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = `${formattedHours}:${minutes}:${seconds} ${ampm}`;
    }
    
    const dateElement = document.getElementById('current-date');
    if (dateElement) {
        dateElement.textContent = `${day}, ${date} de ${month} de ${year}`;
    }
}

// Actualizar cada segundo
document.addEventListener('DOMContentLoaded', function() {
    // Ejecutar inmediatamente
    formatTime12Hours();
    
    // Actualizar cada segundo
    setInterval(formatTime12Hours, 1000);
});