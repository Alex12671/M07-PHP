<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/cursos_matriculados.css">
    <meta charset="utf-8">
    <title>Panel de control alumnos</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validar($_SESSION['rol']) == 2) {
            ?>
            <header>
              <h1 class="matriculaInicio">Cursos matriculados</h1>
              <a href="index.php" class="foto" ><img class="logo" src="img/logo.png" alt="logo"></img></a>
              <nav class="menu">
                <ul>
                  <li><a href="sortir.php">Cerrar sesión</a></li>
                  <li><a href="inicioalumnos.php">Volver a página de inicio</a></li>
                </ul>
              </nav>
            </header>
            <div id="tablaMatricula">
            <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1><?php
            listarCursosMatriculados($_SESSION['email']);
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