<?php 
  //HABILITA EL INICIO DE SESIONES
  session_start();

  echo "<!DOCTYPE html>\n<html><head>";

  //INVOCAR EL ARCHIVO functions.php
  include 'functions.php';

  $userstr = ' (Guest)';

  echo "<title>$appname$userstr</title><link rel='stylesheet' " .
  "href='style.css' type='text/css'>"                     .
  "</head><body><center><canvas id='logo' width='624' "    .
  "height='96'>$appname</canvas></center>"             .
  "<div class='appname'>$appname$userstr</div>"            .
  "<script src='javascript.js'></script>";
  
  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
    //ESTE BLOQUE SE EJECUTA SIEMPRE QUE EL USUARIO ESTÁ LOGUEADO
    echo "<br ><ul class='menu'>" .
    "<li><a href='members.php?view=$user'>Home</a></li>" .
    "<li><a href='members.php'>Members</a></li>"         .
    "<li><a href='friends.php'>Friends</a></li>"         .
    "<li><a href='messages.php'>Messages</a></li>"       .
    "<li><a href='profile.php'>Edit Profile</a></li>"    .
    "<li><a href='logout.php'>Log out</a></li></ul><br>";
  }
  else{
    $loggedin = FALSE;
    //ESTE BLOQUE SE EJECUTA SI EL USUARIO NO ESTÁ LOGUEADO
    echo "<br><ul class='menu'>" .
    "<li><a href='index.php'>Home</a></li>"                .
    "<li><a href='signup.php'>Sign up</a></li>"            .
    "<li><a href='login.php'>Log in</a></li></ul><br>"     .
    "<span class='info'>&#8658; You must be logged in to " .
    "view this page.</span><br><br>";
  }
  
?>
