document.addEventListener("DOMContentLoaded", function () {
    const scheduleAppointmentBtn = document.getElementById("scheduleAppointment");
    const appointmentModal = document.getElementById("appointmentModal");
    const closeModal = document.querySelector(".close");
    const appointmentForm = document.getElementById("appointmentForm");
    const serviceTable = document.getElementById("serviceTable").querySelector("tbody");
    const servicesSelect = document.getElementById("services");
    const totalAmountSpan = document.getElementById("totalAmount");
    const selectedDate = document.getElementById("selectedDate");

    // Objeto para almacenar qué empleados están asignados a qué servicio
    const assignedEmployees = {};

    let employees = [];

    // Cargar empleados desde la base de datos a través de una petición AJAX
    function loadEmployees() {
        fetch('obtenerEmpleados.php')
            .then(response => response.json())
            .then(data => {
                employees = data;
                initEmployees(employees);
            })
            .catch(error => console.error('Error al cargar empleados:', error));
    }

    // Función para inicializar los empleados en el sistema
    function initEmployees(emps) {
        // Cargar empleados disponibles en la UI o hacer otro tipo de inicialización si es necesario
        console.log('Empleados cargados:', emps);
    }

    // Abrir el modal
    scheduleAppointmentBtn.addEventListener("click", function () {
        

        let diaSeleccionado = copiarFecha(selectedDay);
        diaSeleccionado.month++;
        diaSeleccionado = formatDate(diaSeleccionado) +'T00:00:00';
        const fechaSel = new Date(diaSeleccionado);
        const hoy = new Date();
        const fechaActual = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());

        console.log("fechaSel: ", fechaSel);
        console.log("fechaActual: ", fechaActual);

        if(fechaSel < fechaActual){
            alert("No se puede agendar una fecha anterior a hoy");
        }
        else{
            appointmentModal.style.display = "block";
            selectedDate.textContent = `${fechaSel.toLocaleDateString()}`;
        }
    });

    // Cerrar el modal
    closeModal.addEventListener("click", function () {
        appointmentModal.style.display = "none";
    });

    // Al seleccionar servicios, actualizamos la tabla
    servicesSelect.addEventListener("change", function () {
        updateServiceTable();
    });

    function updateServiceTable() {
        const selectedOptions = Array.from(servicesSelect.selectedOptions);
    
        console.log("opciones seleccionadas: " + selectedOptions);
    
        selectedOptions.forEach(option => {
            // Verificar si el servicio ya está en la tabla
            const existingRow = serviceTable.querySelector(`tr[data-service-id="${option.value}"]`);
            if (existingRow) {
                console.log("Este servicio ya ha sido agregado, se omite.");
                return; // Si ya está, no hacer nada
            }
    
            // Eliminar la opción seleccionada de la lista
            option.setAttribute("disabled", "true");
    
            // Crear una nueva fila en la tabla para este servicio
            const serviceRow = document.createElement("tr");
            serviceRow.setAttribute("data-service-id", option.value);
    
            console.log("Opcion a buscar: ", option);
            const serviceName = option.dataset.serviceName;
    
            // Crear los campos de "Asignados" y "Disponibles"
            const attendantsDiv = document.createElement("div");
            attendantsDiv.classList.add("attendants-container");
    
            const assignedDiv = document.createElement("div");
            assignedDiv.classList.add("assigned");
            assignedDiv.innerHTML = "<strong>Asignados</strong>";
            const assignedAttendantsSelect = document.createElement("select");
            assignedAttendantsSelect.setAttribute("multiple", "multiple");
            assignedAttendantsSelect.classList.add("attendants-assigned");
            assignedDiv.appendChild(assignedAttendantsSelect);
    
            const availableDiv = document.createElement("div");
            availableDiv.classList.add("available");
            availableDiv.innerHTML = "<strong>Disponibles</strong>";
            const availableAttendantsSelect = document.createElement("select");
            availableAttendantsSelect.setAttribute("multiple", "multiple");
            availableAttendantsSelect.classList.add("attendants-available");
            availableDiv.appendChild(availableAttendantsSelect);
    
            attendantsDiv.appendChild(assignedDiv);
            attendantsDiv.appendChild(availableDiv);
    
            // Insertar los campos en la fila de la tabla
            serviceRow.innerHTML = `
                <td>${serviceName}</td>
                <td></td>
                <td><input type="number" placeholder="Importe" class="amount"></td>
                <td><input type="time" placeholder="Hora" class="time"></td>
                <td><button type="button" class="remove-service"><i class="fas fa-trash"></i></button></td>
            `;
    
            serviceRow.querySelector("td:nth-child(2)").appendChild(attendantsDiv);
            serviceTable.appendChild(serviceRow);
    
            // Agregar el listener para el evento 'input' en el campo de importe
            const amountInput = serviceRow.querySelector(".amount");
            amountInput.addEventListener("input", function () {
                updateTotalAmount();
            });
    
            // Función para cargar los empleados disponibles y asignados
            loadEmployeesForService(serviceRow, availableAttendantsSelect, assignedAttendantsSelect);
    
            // Hacer disponible el select de "Asignados" solo si hay empleados asignados
            availableAttendantsSelect.addEventListener("change", function () {
                const selectedEmployees = Array.from(availableAttendantsSelect.selectedOptions).map(option => option.value);
                selectedEmployees.forEach(empId => {
                    // Agregar al select de asignados
                    const employee = employees.find(emp => emp.id == empId);
                    const option = document.createElement("option");
                    option.value = employee.id;
                    option.textContent = employee.name;
                    assignedAttendantsSelect.appendChild(option);
    
                    // Remover de disponibles
                    option.disabled = false;
                    availableAttendantsSelect.querySelector(`option[value='${empId}']`).remove();
    
                    // Asignar al servicio
                    if (!assignedEmployees[empId]) {
                        assignedEmployees[empId] = [];
                    }
                    assignedEmployees[empId].push(serviceRow.getAttribute("data-service-id"));
                });
    
                updateTotalAmount();
            });
    
            // Función para remover empleados de los asignados
            assignedAttendantsSelect.addEventListener("click", function (event) {
                if (event.target.tagName === "OPTION") {
                    const option = event.target;
                    const empId = option.value;
    
                    // Remover el empleado de asignados
                    assignedEmployees[empId] = assignedEmployees[empId].filter(serviceId => serviceId !== serviceRow.getAttribute("data-service-id"));
                    
                    // Volver a agregar el empleado a la lista de disponibles
                    const availableOption = document.createElement("option");
                    availableOption.value = empId;
                    availableOption.textContent = option.textContent;
                    availableAttendantsSelect.appendChild(availableOption);
    
                    // Eliminar de la lista de asignados
                    option.remove();
    
                    // Volver a habilitar la opción en la lista de disponibles
                    availableOption.disabled = false;
    
                    updateTotalAmount();
                }
            });
        });
    
        updateTotalAmount();
    }
    

    // Cargar empleados disponibles y asignados a un servicio
    function loadEmployeesForService(serviceRow, availableSelect, assignedSelect) {
        const serviceId = serviceRow.getAttribute("data-service-id");

        // Limpiar listas de empleados
        availableSelect.innerHTML = '';
        assignedSelect.innerHTML = '';

        // Cargar empleados disponibles
        employees.forEach(employee => {
            if (!assignedEmployees[employee.id] || !assignedEmployees[employee.id].includes(serviceId)) {
                const option = document.createElement("option");
                option.value = employee.id;
                option.textContent = employee.name;
                availableSelect.appendChild(option);
            } else {
                const option = document.createElement("option");
                option.value = employee.id;
                option.textContent = employee.name;
                assignedSelect.appendChild(option);
            }
        });
    }

    // Función para eliminar un servicio de la tabla y devolverlo a la lista
    serviceTable.addEventListener("click", function (event) {
        if (event.target && event.target.classList.contains("remove-service")) {
            const row = event.target.closest("tr");
            const serviceId = row.getAttribute("data-service-id");
            
            // Eliminar empleados asignados de la lista de asignados
            const attendantsSelect = row.querySelector(".attendants-assigned");
            const attendants = Array.from(attendantsSelect.selectedOptions).map(option => option.value);

            attendants.forEach(empId => {
                const index = assignedEmployees[empId].indexOf(serviceId);
                if (index > -1) {
                    assignedEmployees[empId].splice(index, 1);
                }
            });

            // Regresar el servicio a la lista
            const option = Array.from(servicesSelect.options).find(opt => opt.value === serviceId);
            if (option) {
                option.removeAttribute("disabled");
            }

            // Eliminar la fila de la tabla
            row.remove();

            updateTotalAmount();
        }
    });

    // Función para actualizar el importe total
    function updateTotalAmount() {
        let totalAmount = 0;

        // Iterar por cada fila de la tabla y sumar los importes
        const rows = serviceTable.querySelectorAll("tr");
        rows.forEach(row => {
            const amountInput = row.querySelector(".amount");
            if (amountInput) {
                totalAmount += parseFloat(amountInput.value) || 0;
            }
        });

        // Actualizar el total
        totalAmountSpan.textContent = `$${totalAmount}`;
    }

    // Enviar el formulario
    appointmentForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const selectedServices = [];
        const rows = serviceTable.querySelectorAll("tr");
        console.log("Inicio mostrado de row")
        console.log(rows);
        console.log("----------");

        if(rows.length === 0){
            event.preventDefault();
            alert("ERROR: No hay servicios seleccionados");
        }
        else{
            rows.forEach(row => {
                const serviceName = row.querySelector("td").textContent;
                const serviceID = row.dataset.serviceId;
                console.log("Servicio : " + serviceName + serviceID);
    
    
                const attendantsSelect = row.querySelector(".attendants-assigned");
            
                if (!attendantsSelect) {
                    console.error("No se encontró la clase attendants-assigned en esta fila:", row);
                    return;
                }
                console.log("Fila en iteración: ", row);
            
                // Obtener todas las opciones dentro del <select>
                const empleadosAsignados = attendantsSelect.querySelectorAll("option");
            
                // Extraer los valores de las opciones
                const attendants = Array.from(empleadosAsignados).map(option => option.value);
                const amount = row.querySelector(".amount").value;
                const time = row.querySelector(".time").value;
                // Añadir al arreglo de servicios seleccionados
                selectedServices.push({ serviceID, attendants, amount, time });

                console.log("Empleados asignados: ", attendants);
                console.log("Validacion de monto isNan: ", amount==="");
                console.log("Validacion time:", time=='');
                console.log("Amount<=0", amount<=0);

                if(attendants.length === 0 || amount==="" || time=='' || amount<=0){
                    event.preventDefault();
                    alert("Hay datos faltantes.");
                }
            });
                    // Crear arrays 
                    const servicios = selectedServices.map(service => service.serviceID);
                    const empleados = selectedServices.map(service => service.attendants);
                    const horas = selectedServices.map(service => service.time);
                    const importes = selectedServices.map(service => service.amount);

                    let diaSeleccionado = copiarFecha(selectedDay);
                    diaSeleccionado.month++;
                    diaSeleccionado = formatDate(diaSeleccionado);
                        // Crear un objeto FormData para enviar los datos
                    const formData = new FormData(appointmentForm);
                    formData.append('servicios', JSON.stringify(servicios));
                    formData.append('empleados', JSON.stringify(empleados));
                    formData.append('horas', JSON.stringify(horas));
                    formData.append('importes', JSON.stringify(importes));
                    formData.append('fecha', diaSeleccionado); // Agregar la fecha al FormData
                
                    // Obtener el valor del total y eliminar el símbolo "$"
                    let totalAmount = totalAmountSpan.textContent.replace('$', '').replace(',', ''); // Eliminar el símbolo y cualquier coma
                    totalAmount = parseFloat(totalAmount); // Convertir a número decimal
                    formData.append('totalAmount', totalAmount); // Agregar la fecha al FormData
                // Enviar los datos al servidor
                fetch('registrarCita/registrarCita.php', {
                method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    alert("Cita agendada correctamente.");
                    appointmentModal.style.display = "none";
                    // Refrescar la página
                    location.reload();
                })
                .catch(error => {
                console.error('Error al registrar la cita:', error);
                });
        }
    });

    // Cargar los empleados al cargar la página
    loadEmployees();
});
