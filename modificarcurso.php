<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/modificarcurso.css">
    <meta charset="utf-8">
    <title>Modificar Curso</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if(isset($_SESSION)) {
          if(validar($_SESSION['rol']) == 0) {
            if(isset($_GET['Codi'])) {
              ?>
              <header>
                <h1 class="inicio">Modificar curso</h1>
                <a href="index.php" class="foto" ><img src="img/logo.png" alt="logo"></img></a>
                <nav class="menu">
                  <ul>
                    <li ><a class="admin" href="sortir.php">Cerrar sesión</a></li>
                    <li ><a href="cursos.php">Volver a administración de cursos</a></li>
                  </ul>
                </nav>
              </header>
              <div id="modificar">
              <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1>
              <?php
              modificarCurso($_GET['Codi']);

              ?> </div> <?php
            }
            
            else {

              echo "No se puede ejecutar la consulta";
              echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
              
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