<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Login admin</title>
  </head>
    <body>

    <?php
    if(isset($_POST['nombre'])) {
        include("funciones.php");
        login($_POST['nombre'],$_POST['passwd']);
    }
    else{?>
      <form  id="login" method="POST" >
        <label for="nombre">Nombre: 
        <input type="text" id="login" name="nombre"><br/>
        <label for="passwd">Contraseña: 
        <input type="password" id="login" name="passwd">
        <input type="submit" value="Entrar"></input>
      </form>
  <?php
    }
    ?>
    </body>
</html>