<?php
    include '../conexion.php';
    include('../check_sesion.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de futbolistas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
            color: white;
            border-radius: 3px;
        }
        .btn-create {
            background-color: #4CAF50;
        }
        .btn-edit {
            background-color: #2196F3;
        }
        .btn-delete {
            background-color: #f44336;
        }
    </style>
</head>
<body>

    <!-- Botón para crear un nuevo futbolista -->
    <a href="../crear/solicitud.php" class="btn btn-create">Crear futbolista</a>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Ciudad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $fuchos = $con->query('SELECT id_f, nombre, apellido, ciudad FROM futbolistas');
                $fuchos_array = $fuchos->fetch_all(MYSQLI_ASSOC);
                foreach($fuchos_array as $fucho) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fucho['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($fucho['apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($fucho['ciudad']) . "</td>";
                    echo "<td>
                            <a href='../modificar/solicitud.php?id_f=" . urlencode($fucho['id_f']) . "' class='btn btn-edit'>Editar</a>
                            <a href='../eliminar/eliminar.php?id_f=" . urlencode($fucho['id_f']) . "' class='btn btn-delete'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }

                $con->close();
            ?>
        </tbody>
    </table>

</body>
</html>