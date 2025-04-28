<!-- solicitud.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Opinión</title>
    <link rel="stylesheet" href="style.css">  
    <script src="script.js"></script>
</head>
<body>

<div class="container">
    <h2>📝 Opinión del Producto</h2>

    <form action="respuesta.php" method="POST" onsubmit="return validarFormulario()">

        <label for="nombre">Tu Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>
        <span id="error-nombre" class="error-message"></span>

        <label for="edad">Tu Edad:</label>
        <input type="number" id="edad" name="edad" min="15" max="99" placeholder="Edad" required>
        <span id="error-edad" class="error-message"></span>

        <label><strong>Calificación del Producto:</strong></label>
        <input type="radio" id="1" name="calificacion" value="1"><label for="1">⭐ 1</label>
        <input type="radio" id="2" name="calificacion" value="2"><label for="2">⭐ 2</label>
        <input type="radio" id="3" name="calificacion" value="3"><label for="3">⭐ 3</label>
        <input type="radio" id="4" name="calificacion" value="4"><label for="4">⭐ 4</label>
        <input type="radio" id="5" name="calificacion" value="5"><label for="5">⭐ 5</label>
        <span id="error-calificacion" class="error-message"></span>

        <label for="intereses">Intereses</label>
        <select id="intereses" name="intereses[]" multiple>
            <option value="Tecnología">💻 Tecnología</option>
            <option value="Moda">👗 Moda</option>
            <option value="Gadgets">🔌 Gadgets</option>
            <option value="Fitness">🏃 Fitness</option>
            <option value="Alimentos">🍲 Alimentos</option>
        </select>

        <label for="comentarios">Comentarios</label>
        <textarea id="comentarios" name="comentarios" rows="4" placeholder="Escribe tu opinión"></textarea>
        <span id="error-comentarios" class="error-message"></span>

        <input type="submit" value="Enviar Opinión" onsubmit="return validarFormulario()">
    </form>
</div>
</body>
</html>
