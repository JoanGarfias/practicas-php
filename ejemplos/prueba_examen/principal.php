<?php
function imprimir_futbolistas(){
    include 'conexion.php';
    // Preparar y ejecutar la consulta
    $con = $mysqli->prepare("SELECT id_f, nombre, apellido, ciudad FROM futbolistas");
    $con->execute();
    $result = $con->get_result();
    $futbolistas = $result->fetch_all(MYSQLI_ASSOC);

    // Generar la tabla
    echo '<table border="1">';
    echo '<thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Ciudad</th>
            </tr>
        </thead>';
    echo '<tbody>';

    foreach ($futbolistas as $futbolista) {
        echo '<tr value="' . $futbolista['id_f'] . '">
                <td>' . $futbolista['id_f'] . '</td>
                <td>' . $futbolista['nombre'] . '</td>
                <td>' . $futbolista['apellido'] . '</td>
                <td>' . $futbolista['ciudad'] . '</td>
                <td>' . '<button class="editar" type="button" value="'. $futbolista['id_f'] . '">Editar</td>
            </tr>';
    }

    echo '</tbody>';
    echo '</table>';
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenido al sistema de futbolistas!</h1>

    <?php imprimir_futbolistas()?>
        
    <script>
    document.querySelectorAll('.editar').forEach(button => {
        button.addEventListener('click', function() {
            const id_f = this.value;
            window.location.href = `editarFutbolista.php?id_f=${id_f}`;
        });
    });

    </script>

</body>
</html>