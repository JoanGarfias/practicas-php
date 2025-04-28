<?php
include 'conexion.php';

header('Content-Type: application/json');
$empleados = [];

// Comprobar conexión
if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Ejecutar la consulta
$empleados_query = "SELECT id_emp, nombre, apellido_p FROM empleado";
$empleados_result = $conn->query($empleados_query);

if ($empleados_result) {
    if ($empleados_result->num_rows > 0) {
        while ($row = $empleados_result->fetch_assoc()) {
            $empleados[] = [
                'id' => $row['id_emp'],
                'name' => trim($row['nombre'] . ' ' . $row['apellido_p'])
            ];
        }
    }
} else {
    echo json_encode(['error' => 'Error en la consulta SQL']);
    exit;
}

echo json_encode($empleados);
exit;
?>
