<?php

	$pi = "3.1416";
	$radius = 5;

	$circunferencia = $pi * ($radius * $radius);

	echo "Circunferencia es: $circunferencia <br>";


	echo "a: [" . (20>9) . "]<br>";
	echo "b: [" . (5 == 6) + 0 . "]<br>";
	echo "c: [" . (1 == 0) . "]<br>";
	echo "d: [" . (1 != 1) . "]<br>";
	echo "e: [" . (1 < 2) . "]<br>";

	var_dump($circunferencia);

	echo "<br>";

	//Condicionales
	$page = "Noticias";

	//IF
	if ($page == "Inicio") echo "Has seleccionado inicio";
	if ($page == "Catalogo") echo "Has seleccionado catalogo";
	if ($page == "Noticias") echo "Has seleccionado noticias";
	if ($page == "Contacto") echo "Has seleccionado contacto";

	echo "<br>";

	//SWITCH

	switch($page){
		case "Inicio":
			echo "Has seleccionado inicio";
		break;
		case "Catalogo":
			echo "Has seleccionado catalogo";
		break;
		case "Noticias":
			echo "Has seleccionado noticias";
		break;
		case "Contacto":
			echo "Has seleccionado contacto";
		break;
	}

	echo "<br>";

	//WHILE
	$cont = 0;
	while ($cont <= 100){
		echo $cont . " ";
		$cont++;
	}
	echo "<br><br><br>";

	//FOR
	for($cont = 0; $cont <= 100; $cont++){
		echo $cont . " ";
	}

	echo "<br><br><br>";

	//FUNCIONES
	phpinfo();
	//VARIABLES LOCALES
	//VARIABLES GLOBALES
	//ARREGLOS	

?>