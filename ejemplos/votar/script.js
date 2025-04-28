function validarFormulario() {
    var radios = document.getElementsByName('rdVoto');
    var seleccionado = false;
    
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            seleccionado = true;
            break;
        }
    }

    if (!seleccionado) {
        alert('Por favor, selecciona un equipo antes de votar.');
        return false;
    }
    return true;
}