<?php
	//var_dump($POST);
	include('conexion.php');
	$voto = $_POST['rdVoto'];
	$ip_usuario = $_SERVER['REMOTE_ADDR'];
	$nav_usuario = $_SERVER['HTTP_USER_AGENT'];
	$sql = "INSERT INTO voto (fecha,equipo,ip,navegador) VALUES (curdate(), '{$voto}', '{$ip_usuario}', '$nav_usuario')";
	mysqli_query($con, $sql);
?>
<html>
	<head>
	</head>
	<body>
		<center>
			<h1></h1>
			<a href="./">Continuar</a>
		</center>
	</body>
</html>