<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/profesores.css">
    <meta charset="utf-8">
    <title>Profesores</title>
  </head>
    <body>
    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validar($_SESSION['rol']) == 0) {
            ?>
            <header>
              <h1 class="inicio">Administrar profesores</h1>
              <a href="index.php" class="foto" ><img class="logo" src="img/logo.png" alt="logo"></img></a>
              <nav class="menu">
                <ul>
                  <li><a href="sortir.php">Cerrar sesión</a></li>
                  <li><a href="administracion.php">Volver al panel de control</a></li>
                </ul>
              </nav>
            </header>
            <div id="tabla">
            <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1><?php
            if(isset($_POST['Buscar'])) {
              ?>
              <a class="añadir" href="añadir_profesor.php">Añadir un nuevo profesor</a><br/>   
              <form id="buscar" method="POST">
              <input type="text" id="buscar" name="Buscar">
              <button type="submit" class="buscar" >Buscar</button>
            </form>
            
            <?php
              buscarProfesores($_POST['Buscar']);

            }
            else {
            ?>
              <a class="añadir" href="añadir_profesor.php">Añadir un nuevo profesor</a><br/>
              <form id="buscar" method="POST">
                <input type="text" id="buscar" name="Buscar">
                <button type="submit" class="buscar" >Buscar</button>
              </form>
            <?php
            mostrarProfesores();
              ?></div><?php
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