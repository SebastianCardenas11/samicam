document.addEventListener('DOMContentLoaded', () => {
    const saludoHolaButton = document.getElementById("saludo-hola");

    if (saludoHolaButton) {
        saludoHolaButton.addEventListener("click", () => {
            const colores = ["#FFD700", "#FFFFFF", "#003300"]; // amarillo, blanco, verde - colores de la jagua.
            for (let i = 0; i < 12; i++) {
                const hola = document.createElement("div");
                hola.textContent = "Hola :)";
                hola.className = "floating-hola";
                hola.style.color = colores[Math.floor(Math.random() * colores.length)];
                hola.style.left = Math.random() * 100 + "vw";
                hola.style.top = Math.random() * 100 + "vh";
                document.body.appendChild(hola);

                setTimeout(() => {
                    hola.remove();
                }, 2000);
            }
        });
    } else {
        console.error("No se encontró el elemento con el ID 'saludo-hola'");
    }
});