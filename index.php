<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="login.css">
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
  </head>
    <body>
    <nav class="menu">
      <ul>
        <li><a href="registro.php">Regístrate aquí</a></li>
        <li><a href="login_admin.php">Acceder a administración</a></li>
      </ul>

    <?php
    if(isset($_POST['nombre'])) {
        include("funciones.php");
        login($_POST['nombre'],$_POST['passwd']);
    }
    else{?>
      <form  id="login" method="POST" class="login">
        <label for="nombre">Email: 
        <input type="email" id="login" name="nombre"><br/>
        <label for="passwd">Contraseña: 
        <input type="password" id="login" name="passwd"><br/>
        <label for="alumno">Alumno 
        <input type="radio" id="alumno" name="rol" value="alumno">
        <label for="profesor">Profesor 
        <input type="radio" id="profesor" name="rol" value="profesor"><br/>
        <input type="submit" value="Entrar"></input><br/>
      </form>
  <?php
    }
    ?>
    </body>
</html>