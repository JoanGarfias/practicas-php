<?php
    include '../conexion.php';
    include('../check_sesion.php');
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar un futbolista</title>
</head>

<h1>Crear un futbolista</h1>

<body>

    <?php
        $id_f = isset($_GET['id_f']) ? htmlspecialchars($_GET['id_f']) : null;
        $datos_sql = $con->query("select id_f, nombre, apellido, ciudad from futbolistas where id_f = '$id_f'");
        $datos = $datos_sql->fetch_all(MYSQLI_ASSOC);

        if(!$datos){
            echo "No hay datos asociados con ese ID de futbolista";
            exit;
        }
        $dato = $datos[0];

    ?>

    <form action="modificar.php" method="GET">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre_nuevo" value="<?php echo htmlspecialchars($dato['nombre']); ?>">

        <br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido_nuevo" value="<?php echo htmlspecialchars($dato['apellido']); ?>">

        <br><br>

        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad_nuevo" value="<?php echo htmlspecialchars($dato['ciudad']); ?>">
        
        <br><br>

         <!-- Campo oculto para enviar el ID -->
        <input type="hidden" name="id_f" value="<?php echo htmlspecialchars($dato['id_f']); ?>">


        <button type="submit">Actualizar</button>
    </form>
    

    <?php
        $con->close();
    ?>
</body>
</html>