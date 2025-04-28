<?php
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientName = $_POST['clientName'];
    $contact = $_POST['contact'];
    $notes = $_POST['notes'];
    $fecha = $_POST['fecha']; // Asegúrate de que este campo se envíe
    $importe_total = $_POST['totalAmount'];
    $servicios = json_decode($_POST['servicios'], true);
    $empleados = json_decode($_POST['empleados'], true);
    $horas = json_decode($_POST['horas'], true);
    $importes = json_decode($_POST['importes'], true);

    // Validación de datos
    if (empty($clientName) || empty($fecha) || empty($servicios)) {
        die("Error: Faltan datos obligatorios.");
    }

    // Insertar la cita en la tabla 'agenda'
    $sql = "INSERT INTO agenda (nombre_cliente, contacto, notas, importe_total, fecha)
            VALUES ('$clientName', '$contact', '$notes', '$importe_total', '$fecha')";
    if ($conn->query($sql) === TRUE) {
        $id_a = $conn->insert_id; // ID de la cita recién creada

        // Insertar datos en la tabla de relación empleado-servicio
        foreach ($servicios as $key => $id_serv) {
            $hora = $horas[$key];
            $importe = $importes[$key];
            $empleadosAsignados = $empleados[$key]; // Array de IDs de empleados

            foreach ($empleadosAsignados as $id_emp) {
                $sql = "INSERT INTO empleado_servicio (id_a, id_emp, id_serv, hora, importe, metodo_pago)
                        VALUES ('$id_a', '$id_emp', '$id_serv', '$hora', '$importe', 'Efectivo')"; // Cambia 'Efectivo' si el método de pago es dinámico
                if (!$conn->query($sql)) {
                    echo "Error al insertar empleado-servicio: " . $conn->error;
                }
            }
        }

        echo "Cita registrada exitosamente.";
    } else {
        echo "Error al registrar la cita: " . $conn->error;
    }
}

$conn->close();
?>
