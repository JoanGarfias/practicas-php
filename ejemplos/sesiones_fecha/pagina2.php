<?php
    session_start();
    include 'protector_accesstime.php';
    print("Esta es la pagina 2 </br>");
    print("Estas en la aplicacion desde las " . $_SESSION['accessTime']);
    print("<div><a href=\"pagina3.php\">Clic para cerrar sesión</a>");
?>