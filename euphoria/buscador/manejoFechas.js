document.addEventListener("DOMContentLoaded", function () {
    const contenedorCitas = document.querySelector("#contenedorCitas");
    const avanzarBtn = document.querySelector("#Avanzar");
    const retrocederBtn = document.querySelector("#Retroceder");
    const citasTitulo = document.querySelector("#citasTitulo");
    console.log(fechaInicio);
    console.log(fechaCorte);
    let fechaSeleccionada = new Date(fechaInicio);
    let citas = Object.values(citasJSON);
    console.log(citasJSON);
    // Variables globales
    let idCitaAEliminar = null; // ID de la cita a eliminar


    // Función para mostrar la ventana de confirmación
    function mostrarConfirmacionEliminar(idCita) {
        idCitaAEliminar = idCita; // Guardar el ID de la cita a eliminar
        console.log("El ID de la cita a eliminar es: " + idCitaAEliminar);
        const confirmacionEliminacion = document.getElementById('confirmacionEliminar');
        confirmacionEliminacion.style.display = 'flex'; // Mostrar la ventana de confirmación
    }

    // Función para ocultar la ventana de confirmación
    function ocultarConfirmacionEliminar() {
        const confirmacionEliminacion = document.getElementById('confirmacionEliminar');
        confirmacionEliminacion.style.display = 'none'; // Ocultar la ventana
    }

    // Función para eliminar la cita
    function eliminarCita() {
        console.log("Estas queriendo eliminar una cita");
        console.log("Ya se actualizo 2");

        if (idCitaAEliminar) {
            fetch('eliminarCita.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_cita=${idCitaAEliminar}`
            })
            .then(response => response.text()) // Cambia a `response.text()` para ver la respuesta como texto
            .then(data => {
                console.log("Respuesta del servidor:", data);  // Verifica qué estás recibiendo aquí
                try {
                    const jsonData = JSON.parse(data); // Intenta convertir la respuesta en JSON
                    if (jsonData.success) {
                        alert('Cita eliminada con éxito.');
                        // Actualizar la vista o eliminar la cita del DOM
                        const citaElement = document.querySelector(`[data-id="${idCitaAEliminar}"]`);
                        if (citaElement) {
                            citaElement.remove();
                        }
                    } else {
                        alert('Hubo un problema al eliminar la cita: ' + (jsonData.error || 'Error desconocido'));
                    }
                } catch (error) {
                    console.error("Error al procesar la respuesta:", error);
                    alert('Hubo un error en la conexión.');
                }
            })
            .catch(error => {
                console.error("Error en la conexión:", error);
                alert('Hubo un error en la conexión.');
            });
            

            ocultarConfirmacionEliminar(); // Cerrar la ventana después de eliminar
        }
    }

    // Manejar clic en el botón de "Eliminar"
    document.getElementById('confirmarEliminar').addEventListener('click', eliminarCita);

    // Manejar clic en el botón de "Cancelar"
    document.getElementById('cancelarEliminar').addEventListener('click', ocultarConfirmacionEliminar);



    // Función para cambiar la fecha seleccionada
    function changeDate(dia) {
        // Avanzar o retroceder un día
        console.log(fechaSeleccionada);
        let nuevaFechaSeleccionada = new Date(fechaSeleccionada);
        console.log("nueva fecha" + nuevaFechaSeleccionada);
        nuevaFechaSeleccionada.setDate(nuevaFechaSeleccionada.getDate() + dia);
        console.log("nueva fecha" + nuevaFechaSeleccionada);
        if(nuevaFechaSeleccionada > fechaCorte){
            alert("ERROR: Se ha llegado a la fecha de corte, ya no hay datos cargados");
        }
        else{
            if(nuevaFechaSeleccionada < fechaInicio){
                alert("ERROR: Se ha llegado a la fecha de inicio, ya no hay datos cargados");
            }
            else{
                fechaSeleccionada = nuevaFechaSeleccionada; 
                console.log(fechaSeleccionada);
            }
        }
        // Actualizar las citas que deben mostrarse para la nueva fecha
        mostrarCitas(fechaSeleccionada);
    }

    // Función para mostrar las citas del día seleccionado
    function mostrarCitas(fecha) {

        console.log(citas);
        

        // Filtrar las citas que corresponden a la fecha seleccionada
        const fechaStr = fecha.toISOString().split('T')[0]; // Formato YYYY-MM-DD
        citasTitulo.innerHTML = '';
        citasTitulo.innerHTML = 'Citas de ' + fechaStr;
        console.log(fechaStr);
        const citasDelDia = citas.filter(cliente => cliente.fecha == fechaStr);

        const contenedorCitas = document.querySelector(".citas");
        contenedorCitas.innerHTML = ''; // Limpiar el contenedor de citas

        if (citasDelDia.length === 0) {
            contenedorCitas.innerHTML = `<p>No hay citas programadas para ${fechaStr}.</p>`;
        } else {
            citasDelDia.forEach(cliente => {
                // Generar el HTML para mostrar las citas del cliente
                console.log("Cliente", cliente);
                const clienteHTML = `
                    <div class="cliente" data-id="${cliente.id_a}">
                        <div class="resumen">
                            <h3>${cliente.cliente}</h3>
                            <p class="contacto">Contacto: ${cliente.contacto}</p>
                            <p class="hora">Hora: ${cliente.servicios[0].hora}</p>
                        </div>
                        <div class="detalles">
                            <p>Fecha: ${cliente.fecha}</p>
                            <p>Notas: ${cliente.notas}</p>
                            <p>Importe total: $${cliente.importe_total}</p>
                            <h4>Servicios:</h4>
                            <ul>
                                ${cliente.servicios.map(servicio => `
                                    <li>
                                        Servicio: ${servicio.servicio}<br>
                                        Hora: ${servicio.hora}<br>
                                        Importe: $${servicio.importe_servicio}<br>
                                        Método de pago: ${servicio.metodo_pago}<br>
                                        Empleados: ${servicio.empleados}
                                    </li>
                                `).join('')}
                            </ul>
                            <button class="eliminarCita" data-id="${cliente.id_a}">Eliminar Cita</button> <!-- Botón de eliminar -->
                        </div>
                    </div>
                `;
                contenedorCitas.innerHTML += clienteHTML;
            });

        // Delegación de eventos para manejar clics en cualquier botón "Eliminar Cita"
        contenedorCitas.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('eliminarCita')) {
                const idCita = event.target.getAttribute('data-id');
                mostrarConfirmacionEliminar(idCita);
            }
        });

        }
    }

    avanzarBtn.addEventListener('click', function(){
        changeDate(1);
    });

    retrocederBtn.addEventListener('click', function(){
        changeDate(-1);
    });
    


    // Mostrar las citas del día inicial al cargar
    mostrarCitas(fechaSeleccionada);
});


