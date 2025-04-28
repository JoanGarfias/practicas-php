<?php
include 'conexion.php';
function registrarUsuario($correo, $contrasena, $con) {
    $sqlVerificar = $con->prepare("SELECT correo FROM usuarios WHERE correo = ?");
    $sqlVerificar->bind_param("s", $correo);
    $sqlVerificar->execute();
    $resultado = $sqlVerificar->get_result();

    if ($resultado->num_rows > 0) {
        echo "El correo ya está registrado.";
        return false;
    }

    // Hashear la contraseña
    $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

    // Insertar el usuario en la base de datos
    $sqlInsertar = $con->prepare("INSERT INTO usuarios (correo, contrasena) VALUES (?, ?)");
    $sqlInsertar->bind_param("ss", $correo, $contrasenaHash);

    if ($sqlInsertar->execute()) {
        echo "Usuario registrado exitosamente.";
        return true;
    } else {
        echo "Error al registrar el usuario: " . $con->error;
        return false;
    }
    echo "Hola";
}

function logearUsuario($correo, $contrasena, $con) {
    $sqlBuscar = $con->prepare("SELECT id, contrasena FROM usuarios WHERE correo = ?");
    $sqlBuscar->bind_param("s", $correo);
    $sqlBuscar->execute();
    $resultado = $sqlBuscar->get_result();

    if ($resultado->num_rows === 0) {
        echo "Correo o contraseña incorrectos.";
        return false;
    }

    $usuario = $resultado->fetch_assoc();
    $idUsuario = $usuario['id'];
    $hashGuardado = $usuario['contrasena'];

    if (password_verify($contrasena, $hashGuardado)) {
        $nuevoToken = bin2hex(random_bytes(32)); // Token aleatorio de 64 caracteres
        $sqlActualizarToken = $con->prepare("UPDATE usuarios SET token_sesion = ? WHERE id = ?");
        $sqlActualizarToken->bind_param("si", $nuevoToken, $idUsuario);
        $sqlActualizarToken->execute();

        // Crear la cookie de sesión
        setcookie("sesion_usuario", $nuevoToken, time() + 600, "/", "", false, true); // Cookie válida por 10 minutos

        echo "Inicio de sesión exitoso. Bienvenido.";
        return true;
    } else {
        echo "Correo o contraseña incorrectos.";
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'registrar') {
            echo "Quieres registrar" . '<br>';
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            registrarUsuario($correo, $contrasena, $con);
        } elseif ($_POST['accion'] === 'login') {
            echo "Quieres logear" . '<br>';
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            logearUsuario($correo, $contrasena, $con);
        }
        else{
            echo "No hay operacion correcta";
        }
    }
}
?>
