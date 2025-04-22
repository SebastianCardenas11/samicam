// Bloquea zoom con Ctrl + scroll
window.addEventListener('wheel', function(e) {
    if (e.ctrlKey) {
        e.preventDefault();
    }
}, { passive: false });

// Bloquea zoom con Ctrl + + / - / =
window.addEventListener('keydown', function(e) {
    if (e.ctrlKey && (e.key === '+' || e.key === '-' || e.key === '=')) {
        e.preventDefault();
    }
});
