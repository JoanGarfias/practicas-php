<?php

// Configuración de cabeceras HTTP
header('Content-Type: application/json');

if (isset($_GET['url'])) {
    $urlImagen = filter_var($_GET['url'], FILTER_VALIDATE_URL);

    if ($urlImagen) {
        echo json_encode([
            'status'   => true,
            'imageUrl' => $urlImagen
        ]);
    } else {
        echo json_encode([
            'status'   => false,
            'message'  => 'URL no válida proporcionada.'
        ]);
    }
} else {
    echo json_encode([
        'status'   => false,
        'message'  => 'Falta la URL en la solicitud.'
    ]);
}
?>
