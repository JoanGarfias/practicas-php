document.addEventListener("DOMContentLoaded", function () {
    let formulario = document.querySelector("#formularioFechas");
    formulario.addEventListener("submit", function(event){
        let fecha_inicio = document.querySelector("#fecha_inicio").value;
        let fecha_corte = document.querySelector("#fecha_corte").value;
        let fInicioFormato = new Date(fecha_inicio);
        let fCorteFormato = new Date(fecha_corte);

        if(!fInicioFormato || !fCorteFormato){
            alert("Por favor, complete ambas fechas.");
            event.preventDefault();
        }
        else{
            if(fInicioFormato > fCorteFormato){
                alert("La fecha de inicio no puede ser mayor que la fecha de corte");
                event.preventDefault();
            }
            else{
                window.location.href = `buscador/buscadorCitas.php?fecha_inicio=${encodeURIComponent(fecha_inicio)}&fecha_corte=${encodeURIComponent(fecha_corte)}`;
            }
        }
    })

});