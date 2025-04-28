<?php
    // Configuración de la conexión
    $host = 'bln37dromqtnumpniyon-mysql.services.clever-cloud.com';
    $db_name = 'bln37dromqtnumpniyon';
    $username = 'uj2vmn3zavkexx9x';
    $password = 'Tp4u1vikAgfvVctvrFHd'; // Reemplaza 'tu_contraseña' con la contraseña real proporcionada
    $port = 3306;

    // Intentar conexión
    $con = mysqli_connect($host, $username, $password, $db_name, $port);

    // Verificar la conexión
    if (!$con) {
        die("Error de conexión: " . mysqli_connect_error());
    } else {
        echo "Conexión exitosa a la base de datos.";
    }
?>
