<?php
    require 'funcs/conexion.php';
    require 'funcs/funcs.php';

    session_start();
    if(isset($_SESSION["id_usuario"])){
        header("location: inicio.php");
    }

    $errores = array();

    if(!empty($_POST)){
        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $password = $mysqli->real_escape_string($_POST['password']);

        if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1){
            $errores[] = "Todos los campos son obligatorios";
        }

        if(!usuarioExiste($usuario) && !emailExiste($usuario)){
            $errores[] = "El correo asociado a $usuario no existe";
        }

        if(count($errores) == 0){
            $logeo = login($usuario, $password);
            if($logeo !== "LOGIN"){
                $errores[] = "Los campos no son correctos";
            }
            else{
                header("location: inicio.php");
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Bootstrap/css/bootstrap-theme.min.css">
    <script src="Bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
        <div id="loginbox" style="margin-top: 50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Iniciar sesi&oacute;n</div>
                </div>
            </div>

            <div style="padding-top: 30px;" class="panel-body">
                <div style="display: none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                <form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="usuario" type="text" class="form-control" name="usuario" value="" placeholder="usuario o email" required> 
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="text" class="form-control" name="password" placeholder="password" required> 
                    </div>

                    <div style="margin-bottom: 10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <button id="btn-login" type="submit" class="btn btn-success">Iniciar Sesi&oacute;n</a>
                        </div>    
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 control">
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                No tiene una cuenta! <a href="registro.php">Registrate aquí</a>
                            </div>
                        </div>    
                    </div>

                    <?php echo resultBlock($errores); ?> 

                </form> 

            </div>
        </div> 
    </div>
</body>
</html>