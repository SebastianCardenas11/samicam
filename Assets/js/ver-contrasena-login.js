document.getElementById('togglePassword').addEventListener('click', function () {
    const password = document.getElementById('txtPassword');
    const icon = document.getElementById('eyeIcon');
    const isPassword = password.type === 'password';
    password.type = isPassword ? 'text' : 'password';
    icon.classList.toggle('bi-eye', !isPassword);
    icon.classList.toggle('bi-eye-slash', isPassword);
});
