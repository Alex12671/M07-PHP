<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/administracion.css">
    <meta charset="utf-8">
    <title>Panel de control admin</title>
  </head>
    <body>
    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validar($_SESSION['rol']) == 0) {
          ?>  
          <header>
            <h1 class="inicio">Panel de administración</h1>
            <a href="index.php" class="foto" ><img src="img/logo.png" alt="logo"></img></a>
            <nav class="menu">
              <ul>
                <li ><a class="admin" href="sortir.php">Cerrar sesión</a></li>
              </ul>
            </nav>
          </header>
          <div id="panelAdmin">
                <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1>
                <div id="botones">
                  <a class="cursos" href="cursos.php">Administrar cursos</a>
                  <a class="profesores" href="profesores.php">Administrar profesores</a>
                </div>
              </div>
            <?php
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