<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/inicioprofesores.css">
    <meta charset="utf-8">
    <title>Panel de control profesores</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validar($_SESSION['rol']) == 1) {
            
            if(isset($_GET['Codi'])) {
              ?>
              <header>
                <h1 class="inicio">Listado de alumnos</h1>
                <a href="index.php" class="foto" ><img class="logo" src="img/logo.png" alt="logo"></img></a>
                <nav class="menu">
                  <ul>
                    <li><a href="sortir.php">Cerrar sesión</a></li>
                    <li><a href="inicioprofesores.php">Volver a listado de cursos</a></li>
                  </ul>
                </nav>
              </header>
              <div id="tabla">
              <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1>
              <div id="cursos"><?php
              listarAlumnos($_SESSION['email'],$_GET['Codi']);
              ?></div><?php
            }
            else {
              ?>
              <header>
                <h1 class="inicio">Listado de cursos</h1>
                <a href="index.php" class="foto" ><img class="logo" src="img/logo.png" alt="logo"></img></a>
                <nav class="menu">
                  <ul>
                    <li><a href="sortir.php">Cerrar sesión</a></li>
                  </ul>
                </nav>
              </header>
              <div id="tabla">
              <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1>
              <div id="cursos"><?php
              mostrarCursosProfesor($_SESSION['email']);
              ?></div><?php
            }
            
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