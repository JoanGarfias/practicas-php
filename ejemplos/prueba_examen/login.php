<?php
    include 'conexion.php';
    global $mysqli;

    if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){ //Puso sus credenciales
        $usuario = $_SERVER['PHP_AUTH_USER'];
        $pass = $_SERVER['PHP_AUTH_PW'];
        $con = $mysqli->prepare("SELECT correo, contrasena FROM usuarios where correo = ? LIMIT 1");
        $con->bind_param("s", $usuario);
        $con->execute();
        $con->store_result();

        $token = bin2hex(random_bytes(16));

        if ($con->num_rows()) {
            $con->bind_result($correo_bd, $pass_bd);
            $con->fetch();

            if(password_verify($pass, $pass_bd)){
                echo "Usuario autenticado. Redirigiendo a principal.php...";
                $con = $mysqli->prepare("UPDATE usuarios SET token_sesion = ? WHERE correo = ?");
                $con->bind_param("ss", $token, $usuario);
                $con->execute();
                setcookie("session_token", $token, time() + 3600, "/");
                header('Location: principal.php');
                exit();
            } 
            else{
                header('WWW-Authenticate: Basic realm="Restricted Section"');
                header('HTTP/1.0 401 Unauthorized');
                die ("Por favor, ingresa tu correo y contraseña");
            }
        }
        else{
            echo "No existe la cuenta";
        }
        
    }
    else{
        header('WWW-Authenticate: Basic realm="Restricted Section"');
        header('HTTP/1.0 401 Unauthorized');
        die ("Por favor, ingresa tu correo y contraseña");
    }

?>

