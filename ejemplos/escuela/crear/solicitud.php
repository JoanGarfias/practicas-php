<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar un futbolista</title>
</head>

<h1>Crear un futbolista</h1>

<body>

    <form action="registrar.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre"></input>

        <br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido"></input>

        <br><br>

        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad"></input>
        
        <br><br>

        <button type="submit">Crear</button>
    </form>
    
</body>
</html>