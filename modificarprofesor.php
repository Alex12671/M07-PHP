<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/modificarprofesor.css">
    <meta charset="utf-8">
    <title>Modificar profesor</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if(isset($_SESSION)) {
          if(validar($_SESSION['rol']) == 0) {
            ?>
            <header>
                <h1 class="inicio">Modificar profesor</h1>
                <a href="index.php" class="foto" ><img src="img/logo.png" alt="logo"></img></a>
                <nav class="menu">
                  <ul>
                    <li ><a class="admin" href="sortir.php">Cerrar sesión</a></li>
                    <li ><a href="profesores.php">Volver a administración de profesores</a></li>
                  </ul>
                </nav>
              </header>
              <div id="modificar">
              <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1>
              <?php
            if(isset($_GET['id'])) {

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