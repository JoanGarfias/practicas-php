<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_COOKIE['sesion_usuario'])) {
    include 'conexion.php';

    $token = $_COOKIE['sesion_usuario'];
    $sqlValidar = $con->prepare("SELECT id FROM usuarios WHERE token_sesion = ?");
    $sqlValidar->bind_param("s", $token);
    $sqlValidar->execute();
    $resultado = $sqlValidar->get_result();

    if ($resultado->num_rows === 0) {
        setcookie("sesion_usuario", "", time() - 3600, "/", "", false, true); // Eliminar la cookie
        session_destroy();
        header("Location: ../login/login.php");
        exit();
    }
} else {
    header("Location: ../login/login.php");
    exit();
}
?>
