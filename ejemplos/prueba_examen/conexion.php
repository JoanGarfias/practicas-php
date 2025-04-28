<?php
    $mysqli = new Mysqli("localhost", "root", "", "bd_prog_web");
    if($mysqli->connect_errno){
        echo "Ha ocurrido un error en la conexion a la BD";
    }
?>