<?php
    // Configuración de la conexión
    $host = 'localhost'; // Host local para XAMPP
    $db_name = 'bd_prog_web'; // Nombre de tu base de datos
    $username = 'root'; // Usuario predeterminado de XAMPP
    $password = ''; // Contraseña predeterminada para root en XAMPP es vacía
    $port = 3306; // Puerto predeterminado para MySQL en XAMPP

    // Intentar conexión
    $con = mysqli_connect($host, $username, $password, $db_name, $port);

    // Verificar la conexión
    if (!$con) {
        die("Error de conexión: " . mysqli_connect_error());
    }
?>
