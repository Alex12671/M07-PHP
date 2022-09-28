<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="profesores.css">
    <meta charset="utf-8">
    <title>Profesores</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if(isset($_SESSION)) {
          if(validar($_SESSION['rol']) == 0) {
            echo "Hola ".$_SESSION['nombre']."!";
            if(isset($_POST['Buscar'])) {
              ?>
              <br/><a href="sortir.php">Sortir de la sessió</a><br/>
              <a href="añadir_curso.php">Añadir un nuevo profesor</a><br/>
              <a href="administracion.php">Volver al panel de control</a><br/>
              <form id="buscar" method="POST">
              <input type="text" id="buscar" name="Buscar">
              <input type="submit" value="Buscar"></input>
            </form>
            <?php
              buscarProfesores($_POST['Buscar']);

            }
            else {
            ?>
              <br/><a href="sortir.php">Sortir de la sessió</a><br/>
              <a href="añadir_profesor.php">Añadir un nuevo profesor</a><br/>
              <a href="administracion.php">Volver al panel de control</a><br/>
              <form id="buscar" method="POST">
                <input type="text" id="buscar" name="Buscar">
                <input type="submit" value="Buscar"></input>
              </form>
            <?php
            mostrarProfesores();
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