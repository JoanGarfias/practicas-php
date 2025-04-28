<?php
include '../conexion.php';

// Obtener la fecha de inicio y la fecha de corte desde el formulario
$fechaInicio = $_GET['fecha_inicio'] ?? null;
$fechaCorte = $_GET['fecha_corte'] ?? null;


// Obtener la fecha actual (por defecto si no se elige una fecha)
$fechaSeleccionada = $_POST['fecha_seleccionada'] ?? ($fechaInicio ? $fechaInicio : date('Y-m-d'));

// Validar que las fechas de inicio y corte sean válidas
if ($fechaInicio && $fechaCorte && strtotime($fechaInicio) > strtotime($fechaCorte)) {
    die("ERROR: La fecha de inicio no puede ser posterior a la fecha de corte.");
}

// Si no se ha elegido fecha de inicio, establecerla por defecto
if (!$fechaInicio) {
    echo "ERROR: No hubo fecha de inicio";
    $fechaInicio = $fechaSeleccionada;
}

// Consulta SQL para obtener las citas dentro del rango de fechas
$query = "
    SELECT
        agenda.id_a AS id_a, 
        agenda.nombre_cliente AS cliente, 
        agenda.contacto AS contacto, 
        agenda.notas AS notas, 
        agenda.importe_total AS importe_total, 
        agenda.fecha AS fecha, 
        empleado_servicio.importe AS importe_servicio, 
        empleado_servicio.metodo_pago AS metodo_pago, 
        empleado_servicio.hora AS hora, 
        servicio.nombre AS servicio,
        GROUP_CONCAT(empleado.nombre ORDER BY empleado.nombre ASC) AS empleados
    FROM agenda
    JOIN empleado_servicio ON agenda.id_a = empleado_servicio.id_a
    JOIN empleado ON empleado_servicio.id_emp = empleado.id_emp
    JOIN servicio ON empleado_servicio.id_serv = servicio.id_serv
    WHERE agenda.fecha BETWEEN ? AND ?
    GROUP BY agenda.id_a
    ORDER BY agenda.fecha ASC, empleado_servicio.hora ASC;
";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $fechaInicio, $fechaCorte);
$stmt->execute();
$result = $stmt->get_result();

// Organizar datos por cliente
$i = 0;
$citasPorCliente = [];
while ($row = $result->fetch_assoc()) {
    $clienteId = $i;
    if (!isset($citasPorCliente[$clienteId])) {
        $citasPorCliente[$clienteId] = [
            'id_a' => $row['id_a'],
            'cliente' => $row['cliente'],
            'contacto' => $row['contacto'],
            'notas' => $row['notas'],
            'importe_total' => $row['importe_total'],
            'fecha' => $row['fecha'],
            'servicios' => []
        ];
    }
    $citasPorCliente[$clienteId]['servicios'][] = [
        'servicio' => $row['servicio'],
        'hora' => $row['hora'],
        'importe_servicio' => $row['importe_servicio'],
        'metodo_pago' => $row['metodo_pago'],
        'empleados' => $row['empleados']
    ];
    $i++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Citas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Buscador de Citas</h1>

    <!-- Formulario para ingresar fechas de inicio y corte -->
    <form method="GET" id="formularioFechas">
        <button type="button" id="regresarInicio" onclick="window.location.href='../index.php';">Regresar al inicio</button>

        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo htmlspecialchars($fechaInicio); ?>" required>
        
        <label for="fecha_corte">Fecha de corte:</label>
        <input type="date" name="fecha_corte" id="fecha_corte" value="<?php echo htmlspecialchars($fechaCorte); ?>" required>

        <button type="submit">Buscar</button>
    </form>

    <br>

    <!-- Botones para cambiar de fecha -->
    <div class="navigation">
        <button id="Retroceder">Retroceder</button>
        <button id="Avanzar">Avanzar</button>
    </div>

    <!-- Mostrar las citas del día seleccionado -->
    <h2 id="citasTitulo"></h2>

    <div class="contenedor">
        <!-- Este es el contenedor donde se mostrarán las citas -->
        <div class="citas">


        </div>
        <!-- Ventana de confirmación para eliminar la cita -->
        <div id="confirmacionEliminar" class="confirmacion-eliminar">
            <div class="confirmacion-contenido">
                <h3>¿Estás seguro de que deseas eliminar esta cita?</h3>
                <p>Esta acción no se puede deshacer.</p>
                <div class="botones">
                    <button id="confirmarEliminar">Eliminar</button>
                    <button id="cancelarEliminar">Cancelar</button>
            </div>
        </div>
    </div>

    </div>


    <script>
        const fechaInicio = new Date("<?php echo $fechaInicio; ?>"+'T00:00:00'); // Fecha de inicio desde PHP
        const fechaCorte = new Date("<?php echo $fechaCorte; ?>"+'T00:00:00'); // Fecha de corte desde PHP
        const citasJSON = <?php echo json_encode($citasPorCliente); ?>;
    </script>

    <script src="manejoFechas.js"></script>
    <script src="enviarFormulario.js"></script>

</body>
<?php
$conn->close();
?>

</html>
