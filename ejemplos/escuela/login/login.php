<?php
    include '../conexion.php';
?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logear usuario</title>
</head>
<body>
    <form method="POST" action="../auth.php">
        <input type="hidden" name="accion" value="login">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>

</body>
</html>