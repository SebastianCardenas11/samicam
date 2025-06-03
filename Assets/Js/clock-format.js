function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    
    // Formato de 24 horas
    const timeString = `${hours}:${minutes}:${seconds}`;
    
    // Actualizar el elemento del reloj si existe
    const clockElement = document.getElementById('clock');
    if (clockElement) {
        clockElement.textContent = timeString;
    }
}

// Actualizar el reloj cada segundo
setInterval(updateClock, 1000);

// Actualizar inmediatamente al cargar la página
document.addEventListener('DOMContentLoaded', updateClock); 