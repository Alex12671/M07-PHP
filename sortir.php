<?php
    session_start();
?>
    <!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/login.css">
    <meta charset="utf-8">
    <title>Añadir Curso</title> 
  </head>
    <body>

    <?php
        if($_SESSION) {
            session_destroy();
            echo "<p class=salir>Sessió destruida amb èxit</p>";
            echo "<meta http-equiv=refresh content='2; url=index.php'>";
        }
        else {
            echo "No estás autoritzat a veure aquesta pàgina";
            echo "<meta http-equiv=refresh content='2; url=index.php'>";
        }
        ?>
    </body>
</html>