<?php
include 'conexion.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


// Obtener servicios
$servicios_query = "SELECT id_serv, nombre FROM servicio ORDER BY nombre";
$servicios_result = $conn->query($servicios_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EUPHORIA AGENDA</title>
    <link rel="icon" href="icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <!-- Barra principal -->
<div class="main-bar">
    <h2 class="main-titulo">AGENDA VIRTUAL DE EUPHORIA</h2>
</div>

<div class="main-container">
    <!-- Calendario -->
    <div class="calendar-container">
        <div class="calendar-header">
            <button id="prevMonth">&lt;</button>
            <h2 id="currentMonthYear"></h2>
            <button id="nextMonth">&gt;</button>
        </div>
        <div class="calendar-grid" id="calendar">
            <!-- Days will be populated here dynamically -->
        </div>
    </div>

    <!-- Botones -->
    <div class="buttons-container">
        <button id="scheduleAppointment" class="Agendar">Agendar cita</button>
        <button id="viewAppointments" class="VerCitas">Ver citas del día</button>
        <button class="buscadorCitas">Buscador de citas</button>
    </div>
</div>


<!-- Modal (Ventana emergente) -->
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Agendar Cita</h2>
        <form id="appointmentForm" method="POST" action="submit">
            <p id="selectedDate" name="fecha"></p>
            
            <label for="clientName">Nombre de la clienta:</label>
            <input type="text" id="clientName" name="clientName" required>

            <label for="services">Servicios:</label>
            <select id="services" name="services[]" multiple required>
                <?php
                // Mostrar los servicios como opciones
                while($row = $servicios_result->fetch_assoc()) {
                    echo '<option value="' . $row['id_serv'] . '" data-service-name="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
                }
                ?>
            </select>

            <h3>Servicios Seleccionados:</h3>
            <table id="serviceTable">
                <thead>
                    <tr>
                        <th>Nombre del servicio</th>
                        <th>Atienden</th>
                        <th>Importe</th>
                        <th>Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se agregarán los servicios seleccionados -->
                </tbody>


            </table>
            
            <label for="contact">Contacto:</label>
            <input type="text" id="contact" name="contact" required>

            <label for="notes">Notas:</label>
            <textarea id="notes" name="notes"></textarea>

            <div>
                <label for="totalAmount">Importe total: </label>
                <span id="totalAmount" name="totalAmount">$0</span>
            </div>

            <button type="submit" id="submitAppointment">Agendar</button>
        </form>
    </div>
</div>

<script src="calendario.js"></script>
<script src="modals.js"></script>
<script src="verCitasBtn.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
