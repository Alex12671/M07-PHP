<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Login</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validaradmin() == 1) {
            echo "Hola ".$_SESSION['nombre']."!";
            ?>
              <br/><a href="sortir.php">Sortir de la sessió</a>
              <a href="añadir_curso.php">Añadir un nuevo curso</a>
            <?php
            mostrarCursos();
          }
          else {
            echo "Solo los administradores pueden ver esta página";
            echo "<meta http-equiv=refresh content='2; url=login_admin.php'>";
          }
        }
        else {
          echo "Debes iniciar sesión primero!";
          echo "<meta http-equiv=refresh content='2; url=login_admin.php'>";
        }
    ?>
    </body>
</html>