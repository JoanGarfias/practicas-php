<?php
    include('conexion.php');
    include('../check_sesion.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar consulta</title>
</head>
<body>

    <form action="eliminar.php" method="POST">
        <label for="nombre">Ingrese el nombre del futbolista a eliminar</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>
    </form>

</body>
</html>