<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Añadir profesor</title>
  </head>
    <body>

    <?php
    include("funciones.php");
    if(isset($_SESSION)) {
        if(validar($_SESSION['rol']) == 0) {
          if(isset($_POST['Nom'])) {
            añadirProfesor($_POST['DNI'],$_POST['Email'],$_POST['Nom'],$_POST['Cognoms'],$_POST['Titol_Academic'],$_POST['Password']);
            }
            else{
            
              ?>
            <h1>Añadir un nuevo profesor</h1>
            <form  id="prof" method="POST" enctype="multipart/form-data" >
            <label for="DNI">DNI: 
                <input type="text" id="prof" name="DNI" pattern="[0-9]{8}[A-Z]{1}" required>
                <label for="Email">Email: 
                <input type="email" id="Email" name="Email" required><br/>
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