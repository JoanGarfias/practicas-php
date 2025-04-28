document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signupform');

    form.addEventListener('submit', function(event) {
        const nombre = form.nombre.value.trim();
        const usuario = form.usuario.value.trim();
        const password = form.password.value;
        const conPassword = form.con_password.value;
        const email = form.email.value.trim();

        let errorMessage = '';

        if (!nombre) {
            errorMessage += 'El campo Nombre es obligatorio.\n';
        }

        if (!usuario) {
            errorMessage += 'El campo Usuario es obligatorio.\n';
        }

        if (!password) {
            errorMessage += 'El campo Password es obligatorio.\n';
        } else if (password.length < 8) {
            errorMessage += 'El Password debe tener al menos 8 caracteres.\n';
        }

        if (password !== conPassword) {
            errorMessage += 'Las contraseñas no coinciden.\n';
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            errorMessage += 'El campo Email es obligatorio.\n';
        } else if (!emailRegex.test(email)) {
            errorMessage += 'El Email no tiene un formato válido.\n';
        }

        if (errorMessage) {
            event.preventDefault();
            alert(errorMessage);
        }
    });
});
