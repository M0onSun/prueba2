// Validación de formulario de usuario
document.querySelector('form')?.addEventListener('submit', function(e) {
    const password = document.getElementById('password');
    if (password && (password.value.length < 6 || password.value.length > 10*)) {
        e.preventDefault();
        password.focus();
        alert('La contraseña debe tener entre 6 y 10 caracteres');
        return false;
    }

    const email = document.getElementById('email');
    if (email && !/^\S+@\S+\.\S+$/.test(email.value)) {
        e.preventDefault();
        email.focus();
        alert('Ingrese un correo electrónico válido');
        return false;
    }
});

// Mostrar mensajes flash
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.classList.add('fade-out');
        setTimeout(() => alert.remove(), 1000);
    });
}, 3000);