<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Modificar profesor</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validaradmin() == 1) {
            echo "<h1>Modificar un profesor existente</h1>";
            modificarProfesor($_GET['id']);
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