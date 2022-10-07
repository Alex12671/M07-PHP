<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/añadir_profesor.css">
    <meta charset="utf-8">
    <title>Añadir profesor</title> 
  </head>
    <body>

    <?php
    include("funciones.php");
    if(isset($_SESSION)) {
        if(validar($_SESSION['rol']) == 0) {
          ?>
          <header>
          <h1 class="inicio">Añadir nuevo profesor</h1>
          <a href="index.php" class="foto" ><img src="img/logo.png" alt="logo"></img></a>
          <nav class="menu">
            <ul> 
              <li><a href="sortir.php">Cerrar sesión</a></li>
              <li><a href="profesores.php">Volver a administración de profesores</a></li>
            </ul>
          </nav>
        </header>
          <div id="añadir">
          <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1><?php
          if(isset($_POST['Nom'])) {
            añadirProfesor($_POST['DNI'],$_POST['Email'],$_POST['Nom'],$_POST['Cognoms'],$_POST['Titol_Academic'],$_POST['Password']);
            }
            else{
            
              ?>
            <form  id="prof" method="POST" enctype="multipart/form-data" >
                <input type="text" id="DNI" name="DNI" pattern="[0-9]{8}[A-Z]{1}" placeholder="DNI" required><br/>
                <input type="email" id="Email" name="Email" placeholder="Email" required><br/>
                <input type="text" id="Nom" name="Nom" placeholder="Nom" required>
                <input type="text" id="Cognoms" name="Cognoms" placeholder="Cognoms" required><br/>
                <input type="text" id="Titol_Academic" name="Titol_Academic" placeholder="Titol_Academic" required><br/>
                <input type="file" id="Foto" name="Foto" accept=".png, .jpg, .jpeg" placeholder="Foto"  required>
                <input type="password" id="Password" name="Password" placeholder="Password" required><br/>

                <button type="submit" >Añadir</button>
            </form>
            </div><?php
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