<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="alumnos.css">
    <meta charset="utf-8">
    <title>Panel de control alumnos</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if($_SESSION) {
          if(validar($_SESSION['rol']) == 1 ) {
            if(isset($_POST['nota'])) {

                ponerNota($_GET['codi'],$_GET['id'],$_POST['nota']);

            }
            else {

            ?>
            <form  id="ponerNota" method="POST">
            <br/>
            <input type="number" id="nota" name="nota" placeholder="Ingresa la nota" min="0" max="10" step="0.1" required><br/>
            <button type="submit" >Poner nota</button><br/>
            <?php

            }
          }
          else {
            echo "Solo los profesores pueden ver esta página";
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