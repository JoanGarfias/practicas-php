<?php
$servername = "boi4lt3mrbce2ryg7s0a-mysql.services.clever-cloud.com";
$username = "useofffptuitsxsg";
$password = "8PonHDRGSoA1la0wCbB0";
$dbname = "boi4lt3mrbce2ryg7s0a";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>