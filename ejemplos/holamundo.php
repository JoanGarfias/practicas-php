<?php
//Hola mundo
echo "Hola mundo\n";

/* Las variables no tiene un tipo, php es un lenguaje no tipado*/
$variable = "Joan";
echo $variable;

/*Concatenar strings con (.) */

echo "\n" . $variable . " Pablo \n";

echo "Tipo de dato de la variable de nombre: variable\n";
echo gettype($variable) . "\n";


$a = 2;
$b = 3;
echo "a+b = " . $a+$b;

/*TIPOS DE DATOS
INTEGER
DOUBLE
BOOLEAN
STRING
LISTAS
*/

/*LISTAS*/
$lista = [$variable, $a, $b];
echo "\n\nLISTAS: \n";


/* INSERTAR EN LISTAS */

array_push($lista, 2);
array_push($lista, true);
array_push($lista, "Potaxio");

echo "Valor : Tipo";
echo $lista[0] . " : " . gettype($lista[0]) . "\n";
echo $lista[1] . " : " . gettype($lista[1]) . "\n";
echo $lista[2] . " : " . gettype($lista[2]) . "\n";
echo $lista[3] . " : " . gettype($lista[3]) . "\n";
echo $lista[4] . " : " . gettype($lista[4]) . "\n";
echo $lista[5] . " : " . gettype($lista[5]) . "\n";
echo "\n";

/*IMPRIMIR UN ARREGLO*/
print_r($lista);

/*DICCIONARIOS*/
$my_string = "Hola";
$my_int = 3;
$my_bool = true;
$midiccionario = array("string" => $my_string, "int" => $my_int, "bool" => $my_bool);
echo gettype($midiccionario);
print_r($midiccionario);

/*CONSTANTES*/
const pi = 3.1416;
echo "\n" . pi;

?>