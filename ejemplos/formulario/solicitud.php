<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo HTML y PHP</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Bienvenido</h1>
    <p>Ingresa tu nombre para recibir un saludo:</p>

    <!-- Formulario HTML -->
    <form action="respuesta.php" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required>
    
        <br><br>

        <label for="edad">Edad</label>
        <input type="number" id="edad" name="edad" required>


        <label for="pais">Pais:</label>
        <select id="pais" name="pais" required>
            <option value="">Selecciona un pais</option>
            <option value="Mexico">Mexico</option>
            <option value="España">España</option>
            <option value="Argentina">Argentina</option>
            <option value="Colombia">Colombia</option>

        </select><br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
