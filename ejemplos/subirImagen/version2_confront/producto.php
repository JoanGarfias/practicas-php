<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Producto</title>
</head>
<body>

    <h1>Ver Producto</h1>

    <div id="producto">
        <!-- Aquí se mostrará la imagen del producto -->
    </div>

    <script>
        // Intentamos cargar la URL desde el LocalStorage
        const imagenUrl = localStorage.getItem('productoImagen');

        // Si la URL de la imagen existe en LocalStorage, la mostramos
        if (imagenUrl) {
            document.getElementById('producto').innerHTML = `<img src="${imagenUrl}" alt="Producto" style="width:300px; height:auto;">`;
            console.log("Encontre la imagen en almacen local");
        } else {
            // Si no la encontramos, la solicitamos desde la API de ImgBB
            console.log("No la encontre, tendré que consultar a la API");
            fetch('obtenerImagen.php')  // Realizamos la consulta a la API
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        // Guardamos la URL en LocalStorage para la próxima vez
                        localStorage.setItem('productoImagen', data.url);
                        document.getElementById('producto').innerHTML = `<img src="${data.url}" alt="Producto" style="width:300px; height:auto;">`;
                    } else {
                        document.getElementById('producto').innerHTML = "No se pudo obtener la imagen.";
                    }
                })
                .catch(error => {
                    document.getElementById('producto').innerHTML = "Error al cargar la imagen.";
                });
        }
    </script>

</body>
</html>
