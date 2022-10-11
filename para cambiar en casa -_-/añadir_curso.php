<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/añadir_curso.css">
    <meta charset="utf-8">
    <title>Añadir Curso</title> 
  </head>
    <body>
    
    <?php
    include("funciones.php");
    if($_SESSION) {
        if(validar($_SESSION['rol']) == 0) {
          ?>
          <header>
          <h1 class="inicio">Añadir nuevo curso</h1>
          <a href="index.php" class="foto" ><img src="img/logo.png" alt="logo"></img></a>
          <nav class="menu">
            <ul> 
              <li><a href="sortir.php">Cerrar sesión</a></li>
              <li><a href="cursos.php">Volver a administración de cursos</a></li>
            </ul>
          </nav>
        </header>
          <div id="modificar">
          <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1><?php
          if(isset($_POST['Nom'])) {
            añadirCurso($_POST['Nom'],$_POST['Descripcio'],$_POST['Hores_Duracio'],$_POST['Data_Inici'],$_POST['Data_Final'],$_POST['DNI']);
            }
            else {
              ?>
            <form  id="addCurso" method="POST" >
                <input type="text" id="Nom" name="Nom" placeholder ="Nombre" required><br/>
                <input type="text" id="Descripcio" name="Descripcio" placeholder ="Descripcio" required><br/>
                <input type="text" id="Hores_Duracio" name="Hores_Duracio" placeholder ="Hores_Duracio" required><br/>
                <input type="text" id="Data_Inici" name="Data_Inici" onfocus="(this.type='date')" placeholder ="Data_Inici" required >
                <input type="text" id="Data_Final" name="Data_Final" onfocus="(this.type='date')" placeholder ="Data_Final" required ><br/>
                <select name="DNI" id="DNI" required>
                    <?php
                    listarProfesores();
                    ?>
                </select>
                <button type="submit">Modificar</button>
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
    <script>
      var today = new Date();
      var tomorrow = new Date();
      tomorrow.setDate(today.getDate() + 1);
      dataInici = document.getElementById("Data_Inici");
      dataInici.min = today.toLocaleDateString('en-ca');
      dataFinal = document.getElementById("Data_Final");
      dataFinal.min = tomorrow.toLocaleDateString('en-ca');
    </script>
</html>