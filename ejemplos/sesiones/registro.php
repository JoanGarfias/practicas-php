<?php
    require 'funcs/conexion.php';
    require 'funcs/funcs.php';

    session_start();
    if(isset($_SESSION["id_usuario"])){
        header("location: inicio.php");
    }

    $errores = array();

    if(!empty($_POST)){
        $nombre = $mysqli->real_escape_string($_POST['nombre']);
        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $con_password = $mysqli->real_escape_string($_POST['con_password']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $activo = 1;
        $tipo_usuario = 2;

        if(isNull($nombre, $usuario, $password, $con_password, $email)){
            $errores[] = "Todos los campos son obligatorios";
        }
        if(!isEmail($email)){
            $errores[] = "Dirección de correo invalida";
        }
        if(!validaPassword($password, $con_password)){
            $errores[] = "Las contraseñas no coinciden";
        }
        if(usuarioExiste($usuario)){
            $errores[] = "El correo electronico $email ya existe";
        }
        if(count($errores) == 0){
            $pass_hash = hashPassword($password);
            $token = generateToken();
            $registro = registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);
            if($registro > 0){
                echo "<br><a href='index.php'>Iniciar sesión</a>";
                exit;
            }
            else{
                $errores[] = "Error al intentar registrar";
            }
        }

    }

?>



<html>
	<head>
		<title>Registro</title>
		
		<link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css" >
		<link rel="stylesheet" href="Bootstrap/css/bootstrap-theme.min.css" >
		<script src="Bootstrap/js/bootstrap.min.js" ></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	
	<body>
		<div class="container">
			<div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">Formulario de registro</div>
						
					</div>  
					
					<div class="panel-body" >
						
						<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
							
							<div class="form-group">
								<label for="nombre" class="col-md-3 control-label">Nombre:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required >
								</div>
							</div>
							
							<div class="form-group">
								<label for="usuario" class="col-md-3 control-label">Usuario</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php if(isset($usuario)) echo $usuario; ?>" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="password" placeholder="Password" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="con_password" class="col-md-3 control-label">Confirmar Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="con_password" placeholder="Confirmar Password" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="email" class="col-md-3 control-label">Email</label>
								<div class="col-md-9">
									<input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($email)) echo $email; ?>" required>
								</div>
							</div>
							
							<div class="form-group">                                      
								<div class="col-md-offset-3 col-md-9">
									<button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Registrar</button> 
								</div>
							</div>

                            <?php echo resultBlock($errores); ?> 

						</form>
					</div>
				</div>
			</div>
		</div>
	</body>

    <script src="validacionRegistro.js"></script>  

</html>													