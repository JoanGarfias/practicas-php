<?php
    include 'conexion.php';
    global $mysqli;

    if(!empty($_POST)){

        $correo = $mysqli->real_escape_string($_POST['correo']);
        $password = $mysqli->real_escape_string($_POST['password']);
        if(!isset($correo) || !isset($password)){
            die("ERROR: Datos no validos");
            header('location: registro.php');
        }
        $con = $mysqli->prepare("SELECT correo FROM usuarios WHERE correo = ? LIMIT 1");
        $con->bind_param("s", $correo);
        $con->execute();
        $con->store_result();
        $con->fetch();

        if($con->num_rows == 0){ //El usuario no existe
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $con = $mysqli->prepare("INSERT INTO usuarios (correo, contrasena) VALUES (?,?)");
            $con->bind_param("ss", $correo, $password_hash);
            $con->execute();
            if($con->affected_rows){
                echo "Se ha realizado el registro";
                header('Location: login.php');
            }
            else{
                echo "Ha sucedido un error al realizar el registro";
            }
        }
        else{
            echo "Esa cuenta ya está registrada";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
</head>
<body>
    
    <form id="registro" method="POST" action="<?php $_SERVER['PHP_SELF']?>">
        <label>Correo electronico: </label>
        <input type="text" name="correo" required>
        <br>
        <label>Contraseña: </label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>