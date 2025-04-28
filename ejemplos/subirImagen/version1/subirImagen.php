<?php
header('Content-Type: application/json');

// Definir las claves de la API de ImgBB
$apiKey = '2c79d8a7e650f2eab106cb4cc7a2b0d4';

// Obtener la imagen desde el formulario o algún parámetro
if (isset($_POST['imageBase64'])) {
    // La imagen ya está en base64, la subimos a ImgBB
    $imageBase64 = $_POST['imageBase64'];

    // URL de la API de ImgBB para cargar la imagen
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

    // Decodificar la respuesta JSON
    $result = json_decode($response, true);

    // Verificar si la carga fue exitosa
    if (isset($result['data']['url'])) {
        // Devolver la URL de la imagen cargada
        echo json_encode(['url' => $result['data']['url']]);
    } else {
        echo json_encode(['error' => 'Error al subir la imagen: ' . $result['error']['message']]);
    }
} else {
    echo json_encode(['error' => 'No se recibió imagen']);
}
?>
