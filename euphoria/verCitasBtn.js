document.addEventListener("DOMContentLoaded", () => {
    // Seleccionar los elementos del DOM
    const verCitasBtn = document.querySelector(".VerCitas");
    const buscadorBtn = document.querySelector(".buscadorCitas");


    buscadorBtn.addEventListener("click", () => {
        let diaSeleccionado = copiarFecha(selectedDay);
        diaSeleccionado.month++;
        diaSeleccionado = formatDate(diaSeleccionado);
        console.log(diaSeleccionado);
        window.location.href = `buscador/buscadorCitas.php?fecha_inicio=${encodeURIComponent(diaSeleccionado)}&fecha_corte=${encodeURIComponent(diaSeleccionado)}`;
    });

    // Manejar el clic en el botón "Ver citas"
    verCitasBtn.addEventListener("click", () => {
        let diaSeleccionado = copiarFecha(selectedDay);
        diaSeleccionado.month++;
        diaSeleccionado = formatDate(diaSeleccionado);
        if (!diaSeleccionado) {
            alert("Por favor, selecciona una fecha para ver las citas.");
            return;
        }

        // Redirigir a la página de citas con la fecha como parámetro
        window.location.href = `verCitas/verCitas.php?fecha=${encodeURIComponent(diaSeleccionado)}`;
    });

});
