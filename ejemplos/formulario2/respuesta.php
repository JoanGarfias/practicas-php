<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $edad = htmlspecialchars($_POST['edad']);
    $calificacion = htmlspecialchars($_POST['calificacion']);
    $intereses = isset($_POST['intereses']) ? $_POST['intereses'] : [];
    $comentarios = htmlspecialchars($_POST['comentarios']);

    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Tu Opinión</title>
    </head>
    <body>
        <h2>✅ Tu Opinión sobre el Producto</h2>";

    echo "<p><strong>Nombre:</strong> $nombre</p>";
    echo "<p><strong>Edad:</strong> $edad años</p>";
    echo "<p><strong>Calificación:</strong> ⭐$calificacion</p>";

    echo "<p><strong>Intereses:</strong> ";
    if (!empty($intereses)) {
        echo implode(", ", $intereses);
    } else {
        echo "No seleccionaste ningún interés.";
    }
    echo "</p>";

    echo "<p><strong>Comentarios:</strong> $comentarios</p>";

    echo "</body></html>";
} else {
    echo "No se recibieron datos válidos.";
}
?>
