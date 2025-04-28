<?php
include '../conexion.php';

// Obtener la fecha de las citas desde la URL
$fecha = $_GET['fecha'] ?? null;

if (!$fecha) {
    die("Fecha no proporcionada.");
}

    // Consulta SQL
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
    WHERE agenda.fecha = ?
    GROUP BY agenda.id_a, empleado_servicio.id_serv
    ORDER BY empleado_servicio.hora ASC;
    ";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $fecha);
$stmt->execute();
$result = $stmt->get_result();

// Organizar datos por cliente
$citasPorCliente = [];
while ($row = $result->fetch_assoc()) {
    $clienteId = $row['id_a'];
    if (!isset($citasPorCliente[$clienteId])) {
        $citasPorCliente[$clienteId] = [
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
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas para <?php echo htmlspecialchars($fecha); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Citas para <?php echo htmlspecialchars($fecha); ?></h1>
    <?php if (empty($citasPorCliente)): ?>
        <p>No hay citas programadas para esta fecha.</p>
    <?php else: ?>
        <div class="citas">
            <?php foreach ($citasPorCliente as $cliente): ?>
                <div class="cliente" onclick="toggleCita(this)">
                    <div class="resumen">
                        <h2><?php echo htmlspecialchars($cliente['cliente']); ?></h2>
                        <p>Contacto: <?php echo htmlspecialchars($cliente['contacto']); ?></p>
                        <p>Hora: <?php echo htmlspecialchars($cliente['servicios'][0]['hora']); ?></p>
                    </div>
                    <div class="detalles">
                        <p>Fecha: <?php echo htmlspecialchars($cliente['fecha']); ?></p>
                        <p>Notas: <?php echo nl2br(htmlspecialchars($cliente['notas'])); ?></p>
                        <p>Importe total: $<?php echo htmlspecialchars($cliente['importe_total']); ?></p>
                        <h3>Servicios:</h3>
                        <ul>
                            <?php foreach ($cliente['servicios'] as $servicio): ?>
                                <li>
                                    Servicio: <?php echo htmlspecialchars($servicio['servicio']); ?> <br>
                                    Hora: <?php echo htmlspecialchars($servicio['hora']); ?> <br>
                                    Importe: $<?php echo htmlspecialchars($servicio['importe_servicio']); ?> <br>
                                    Empleado: <?php echo htmlspecialchars($servicio['empleados']); ?>
                                </li>
                                <hr>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <button onclick="window.location.href='../index.php'">Regresar</button>

    <script src="script.js"></script>
</body>
</html>
