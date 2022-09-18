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
          echo "Hola ".$_SESSION['nombre']."!";
          if(isset($_POST['Nom'])) {
            añadirCurso($_POST);
            }
            else{?>
            <form  id="login" method="POST" >
                <label for="Nom">Nom: 
                <input type="text" id="login" name="Nom" required><br/>
                <label for="Descripcio">Descripció: 
                <input type="text" id="login" name="Descripcio" required>
                <label for="Hores_Duracio">Hores duració: 
                <input type="text" id="login" name="Hores_Duracio" required><br/>
                <label for="Data_Inici">Data inici: 
                <input type="date" id="login" name="Data_Inici" required>
                <label for="Data_Final">Data final: 
                <input type="date" id="login" name="Data_Final" required><br/>
                <label for="DNI">DNI: 
                <select name="DNI" id="login" required>
                    <?php
                    listarProfesores();
                    ?>
                </select>
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