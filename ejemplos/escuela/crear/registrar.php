<?php
    include '../conexion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
</head>
<body>
    <?php
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellido = htmlspecialchars($_POST['apellido']);
        $ciudad = htmlspecialchars($_POST['ciudad']);

        $creado = $con->query("insert into futbolistas
                    (nombre, apellido, ciudad) values ('$nombre', '$apellido', '$ciudad')");
        // Verificar si se realizó la inserción
        if ($creado) {
            if ($con->affected_rows > 0) {
                echo "El registro fue creado exitosamente.";
            } else {
                echo "La consulta fue exitosa, pero no se afectaron filas.";
            }
        } else {
            echo "Hubo un error al registrar el futbolista: " . $con->error;
        }
        
        $con->close();
    ?>
</body>
</html>