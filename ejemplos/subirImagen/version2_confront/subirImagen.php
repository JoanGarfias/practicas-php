<?php
if (isset($_FILES['image'])) {
    // Tu clave de API de ImgBB
    $apiKey = '2c79d8a7e650f2eab106cb4cc7a2b0d4';

    // Ruta temporal del archivo subido
    $imageTemp = $_FILES['image']['tmp_name'];

    // Lee el archivo y conviértelo a base64
    $imageBase64 = base64_encode(file_get_contents($imageTemp));

    // URL de la API de ImgBB
    $url = 'https://api.imgbb.com/1/upload';

    // Datos para enviar a la API
    $data = [
        'key' => $apiKey,
        'image' => $imageBase64,
    ];

    // Configuración de la solicitud cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Ejecuta la solicitud y obtiene la respuesta
    $response = curl_exec($ch);
    curl_close($ch);

    // Decodifica la respuesta JSON
    $result = json_decode($response, true);

    // Verifica si la carga fue exitosa
    if (isset($result['data']['url'])) {
        echo json_encode(['url' => $result['data']['url']]);
    } else {
        echo json_encode(['error' => 'Error al subir la imagen: ' . $result['error']['message']]);
    }
} else {
    echo json_encode(['error' => 'No se seleccionó ninguna imagen.']);
}
?>
