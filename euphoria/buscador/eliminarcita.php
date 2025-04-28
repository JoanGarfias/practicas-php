<?php
include '../conexion.php';

header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON

if (isset($_POST['id_cita'])) {
    $idCita = $_POST['id_cita'];

    // Eliminar la cita de la base de datos
    $query = "DELETE FROM agenda WHERE id_a = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta']);
        exit;
    }
    
    $stmt->bind_param('i', $idCita);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al ejecutar la consulta']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID de cita no proporcionado']);
}
?>
