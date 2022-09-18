<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
  </head>
    <body>

    <?php
    if(isset($_POST['nombre'])) {
        include("funciones.php");
        login($_POST['nombre'],$_POST['passwd']);
    }
    else{?>
      <form  id="login" method="POST" >
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
      <a href="registro.php">Regístrate aquí</a><br/>
      <a href="login_admin.php">Acceder a administración</a>
  <?php
    }
    ?>
    </body>
</html>