<?php
// Verificar si los datos fueron enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $edad = htmlspecialchars($_POST['edad']);
    $pais = htmlspecialchars($_POST['pais']);

    // Mostrar los resultados
    echo "<h2>Datos recibidos</h2>";
    echo "<p><strong>Nombre:</strong> $nombre</p>";
    echo "<p><strong>Edad:</strong> $edad</p>";
    echo "<p><strong>País:</strong> $pais</p>";
} else {
    echo "No se han recibido datos";
}
?>
