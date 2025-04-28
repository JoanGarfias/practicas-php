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
        function esNuloOVacio(...$variables) {
            foreach ($variables as $variable) {
                if ($variable === null || trim($variable) === '') {
                    echo "La variable " . $variable . "es invalida" . '<br>';
                    return true;
                }
            }
            return false;
        }

        
        $id_f = isset($_GET['id_f']) ? htmlspecialchars($_GET['id_f']) : null;
        $nombre_nuevo = isset($_GET['nombre_nuevo']) ? htmlspecialchars($_GET['nombre_nuevo']) : null;
        $apellido_nuevo = isset($_GET['apellido_nuevo']) ? htmlspecialchars($_GET['apellido_nuevo']) : null;
        $ciudad_nuevo = isset($_GET['ciudad_nuevo']) ? htmlspecialchars($_GET['ciudad_nuevo']) : null;

        if (!esNuloOVacio($id_f, $nombre_nuevo, $apellido_nuevo, $ciudad_nuevo)) {
            $stmt = $con->prepare("UPDATE futbolistas SET nombre = ?, apellido = ?, ciudad = ? WHERE id_f = ?");
            $stmt->bind_param("sssi", $nombre_nuevo, $apellido_nuevo, $ciudad_nuevo, $id_f);
            
            if ($stmt->execute()) {
                echo "El futbolista se modificó correctamente";
            } else {
                echo "No se pudo modificar el futbolista";
            }
            $stmt->close();
        } else {
            echo "Los datos recibidos no son válidos";
        }
        
        $con->close();
    ?>
</body>
</html>