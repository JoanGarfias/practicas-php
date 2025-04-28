<?php
	session_start();
    date_default_timezone_set('America/Mexico_City');
	$_SESSION['accessTime'] = date("M/d/Y g:i:sa");
	print("BIENVENIDO PAGINA DE INICIO <br/>");
	print("Estas ingresando a la aplicacion a las: " . $_SESSION['accessTime']);
	print("<div><a href=\"pagina2.php\">Clic para la siguiente pagina</a>");

?>