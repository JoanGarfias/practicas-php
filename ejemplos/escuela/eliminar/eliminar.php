<?php
    include('../conexion.php');
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

    <?php
        $id_f = isset($_GET['id_f']) ? htmlspecialchars($_GET['id_f']) : null;

        $eliminado = $con->query("delete from futbolistas where id_f = '$id_f'");
        if($con->affected_rows){
            echo "Se elimino el dato correctamente";
        }
        else{
            echo "No se encontro el futbolista";
        }
        $con->close();
    ?>
</body>
</html>