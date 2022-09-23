<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Login</title>
  </head>
    <body>

    <?php
    include("funciones.php");
    if($_SESSION) {
        if(validaradmin() == 1) {
          if(isset($_POST['Nom'])) {
            añadirProfesor($_POST);
            }
            else{
                echo "Hola ".$_SESSION['nombre']."!";
              ?>
            <form  id="prof" method="POST" enctype="multipart/form-data" >
            <label for="DNI">DNI: 
                <input type="text" id="prof" name="DNI" pattern="[0-9]{8}[A-Z]{1}" required>
                <label for="Nom">Nom: 
                <input type="text" id="prof" name="Nom" required><br/>
                <label for="Cognoms">Cognoms: 
                <input type="text" id="prof" name="Cognoms" required>
                <label for="Titol_Academic">Titol Academic: 
                <input type="text" id="prof" name="Titol_Academic" required><br/>
                <label for="Foto">Foto: 
                <input type="file" id="Foto" name="Foto" accept=".png, .jpg, .jpeg"  required>
                <label for="passwd">Password: 
                <input type="password" id="prof" name="Password" required><br/>

                <input type="submit" value="Entrar"></input>
            </form><?php
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