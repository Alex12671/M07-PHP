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
        if(isset($_SESSION)) {
          if(validar($_SESSION['rol']) == 0) {
            if(isset($_GET['id'])) {

              echo"<h1>Modificar profesor existente</h1>";
              modificarProfesor($_GET['id']);

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