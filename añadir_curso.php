<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Añadir Curso</title>
  </head>
    <body>

    <?php
    include("funciones.php");
    if(isset($_SESSION)) {
        if(validar($_SESSION['rol']) == 0) {
          if(isset($_POST['Nom'])) {
            añadirCurso($_POST);
            }
            else {
              ?>
              <h1>Añadir un nuevo curso</h1>
            <form  id="addCurso" method="POST" >
                <label for="Nom">Nom: 
                <input type="text" id="addCurso" name="Nom" required><br/>
                <label for="Descripcio">Descripció: 
                <input type="text" id="addCurso" name="Descripcio" required>
                <label for="Hores_Duracio">Hores duració: 
                <input type="text" id="addCurso" name="Hores_Duracio" required><br/>
                <label for="Data_Inici">Data inici: 
                <input type="date" id="addCurso" name="Data_Inici" required >
                <label for="Data_Final">Data final: 
                <input type="date" id="addCurso" name="Data_Final" required ><br/>
                <label for="DNI">DNI: 
                <select name="DNI" id="addCurso" required>
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