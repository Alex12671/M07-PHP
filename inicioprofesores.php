<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Panel de control admin</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validar($_SESSION['rol']) == 1) {
            echo "Bienvenido ".$_SESSION['nombre']."!";
            ?>
              <br/><a href="sortir.php">Sortir de la sessió</a>
              <a href="cursos.php">Administrar cursos</a>
              <a href="profesores.php">Administrar profesores</a>
            <?php
          }
          else {
            echo "Solo los profesores pueden ver esta página";
            echo "<meta http-equiv=refresh content='2; url=inicioprofesores.php'>";
          }
        }
        else {
          echo "Debes iniciar sesión primero!";
          echo "<meta http-equiv=refresh content='2; url=index.php'>";
        }
    ?>
    </body>
</html>