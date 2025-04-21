// Obtener los elementos
const signInButton = document.getElementById('signIn');
const signUpButton = document.getElementById('signUp');
const container = document.querySelector('.container');

// Agregar los eventos de clic a los botones
signInButton.addEventListener('click', () => {
    container.classList.remove('right-panel-active'); // Muestra el formulario de inicio de sesión
});

signUpButton.addEventListener('click', () => {
    container.classList.add('right-panel-active'); // Muestra el formulario de registro
});
