<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/modificarcurso.css">
    <meta charset="utf-8">
    <title>Borrar curso</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if(isset($_SESSION)) {
          if(validar($_SESSION['rol']) == 0) {
            if(isset($_GET['Codi'])) {

              borrarCurso($_GET['Codi'],$_GET['estado']);

            }
            else {

              echo "No se puede ejecutar la consulta";
              echo "<meta http-equiv=refresh content='2; url=profesores.php'>";

            }
            
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