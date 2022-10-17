<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/listadoalumnos.css">
    <meta charset="utf-8">
    <title>Panel de control profesores</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if($_SESSION) {
            if(isset($_GET['codi'])) {
                if(validar($_SESSION['rol']) == 1) {
                    ?>
                    <header>
                    <h1 class="inicio">Listado de alumnos de <?php echo "".$_GET['nombre'].""; ?></h1>
                    <a href="index.php" class="foto" ><img class="logo" src="img/logo.png" alt="logo"></img></a>
                    <nav class="menu">
                        <ul>
                        <li><a href="sortir.php">Cerrar sesión</a></li>
                        <li><a href="inicioprofesores.php">Volver a cursos</a></li>
                        </ul>
                    </nav>
                    </header>
                    <div id="tabla">
                    <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1><?php
                    listarAlumnos($_SESSION['email'],$_GET['codi']);
                }
                else {
                    echo "Solo los profesores pueden ver esta página";
                    echo "<meta http-equiv=refresh content='2; url=index.php'>";
                }
            }
            else {
                echo "Lo sentimos, no está autorizado a ver esta pàgina.";
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