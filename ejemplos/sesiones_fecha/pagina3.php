<?php
    session_start();
    include 'protector_accesstime.php';
    print("Esta es la pagina 3 </br>");
    print("<div><a href=\"index.php\">Clic para volver al inicio</a>");
    session_destroy();
?>