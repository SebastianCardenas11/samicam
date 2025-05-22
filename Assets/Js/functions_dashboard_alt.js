document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el reloj y el clima
    updateClock();
    setInterval(updateClock, 1000);
    getWeather();
});

// Función para actualizar el reloj
function updateClock() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    document.getElementById('clock').innerHTML = `${hours}:${minutes}:${seconds}`;
    
    // Actualizar la fecha
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('date').innerHTML = now.toLocaleDateString('es-ES', options);
}

// Obtener el clima
function getWeather() {
    // Usar la API de OpenWeatherMap para La Jagua de Ibirico, Colombia
    const cityId = "3681797"; // ID de La Jagua de Ibirico
    fetch(`https://api.openweathermap.org/data/2.5/weather?id=${cityId}&units=metric&lang=es&appid=9f50a805aa0089a1edd1829a5db029f0`)
        .then(response => response.json())
        .then(data => {
            const weatherDiv = document.getElementById('weather');
            weatherDiv.innerHTML = `
                <div class="d-flex justify-content-center align-items-center">
                    <img src="https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png" alt="${data.weather[0].description}">
                    <div class="ms-3 text-start">
                        <h2>${Math.round(data.main.temp)}°C</h2>
                        <p class="text-capitalize">${data.weather[0].description}</p>
                        <p>La Jagua de Ibirico, Colombia</p>
                        <p>Humedad: ${data.main.humidity}%</p>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('weather').innerHTML = `
                <div class="alert alert-warning">
                    No se pudo obtener la información del clima.
                </div>
            `;
            console.error('Error al obtener el clima:', error);
        });
}