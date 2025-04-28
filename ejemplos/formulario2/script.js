function validarFormulario() {
    let isValid = true;

    // Validar el nombre
    const nombre = document.getElementById('nombre');
    const errorNombre = document.getElementById('error-nombre');

    if (nombre.value.trim() === '') {
        errorNombre.textContent = 'Por favor, ingresa tu nombre.';
        isValid = false;
        nombre.classList.add('input-error');
    } else {
        errorNombre.textContent = '';
        nombre.classList.remove('input-error');
    }

    // Validar edad
    const edad = document.getElementById('edad');
    const errorEdad = document.getElementById('error-edad');
    if (edad.value < 15 || edad.value > 99) {
        errorEdad.textContent = 'La edad debe estar entre 15 y 99 años.';
        isValid = false;
        edad.classList.add('input-error');
    } else {
        errorEdad.textContent = '';
        edad.classList.remove('input-error');
    }

    // Validar calificación (radio buttons)
    const calificacion = document.querySelector('input[name="calificacion"]:checked');
    const errorCalificacion = document.getElementById('error-calificacion');
    if (!calificacion) {
        errorCalificacion.textContent = 'Selecciona tu calificación.';
        isValid = false;
        const radios = document.getElementsByName('calificacion');
        radios.forEach(radio => radio.classList.add('input-error'));
    } else {
        errorCalificacion.textContent = '';
        const radios = document.getElementsByName('calificacion');
        radios.forEach(radio => radio.classList.remove('input-error'));
    }

    // Validar comentarios
    const comentarios = document.getElementById('comentarios');
    const errorComentarios = document.getElementById('error-comentarios');
    if (comentarios.value.trim() === '') {
        errorComentarios.textContent = 'Por favor, agrega tus comentarios.';
        isValid = false;
        comentarios.classList.add('input-error');
    } else {
        errorComentarios.textContent = '';
        comentarios.classList.remove('input-error');
    }

    return isValid;  // Solo se envía si todos los campos son válidos
}

// Asignar la validación en tiempo real para mejorar la UX
document.querySelectorAll('input, textarea, select').forEach(element => {
    element.addEventListener('input', () => {
        element.classList.remove('input-error');
        element.classList.add('input-valid');
    });
});
