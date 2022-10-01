<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="alumnos.css">
    <meta charset="utf-8">
    <title>Panel de control alumnos</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validar($_SESSION['rol']) == 2) {
            echo "Bienvenido ".$_SESSION['nombre']."!";
            ?>
              <br/><a href="sortir.php">Sortir de la sessió</a>
              <br/><a href="cursos_matriculados.php">Veure el llistat de cursos matriculats</a>
            <?php
            listarCursosDisponibles($_SESSION['email']);
            //listarCursosMatriculados($_SESSION['email']);
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