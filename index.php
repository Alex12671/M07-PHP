<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/login.css">
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
  </head>
    <body>
        <header>
          <h1 class="inicio">Página de inicio</h1>
        <img src="img/logo.png" alt="logo"></img>
        <nav class="menu">
          <ul>
            
            <li class="admin"><a href="login_admin.php">Acceder a administración</a></li>
          </ul>
        </nav>
      </header>
    <?php
    if(isset($_POST['rol'])) {
        include("funciones.php");
        login($_POST['email'],$_POST['passwd'],$_POST['rol']);
    }
    else{?>
      <div id="formularioLogin">
       <h1 class="tituloForm">InfoBDN</h1>
        <form  id="login" method="POST" class="login">
          <br/>
            <input type="email" id="email" name="email" placeholder="Ingresa el email" required><br/>
            
            <input type="password" id="passwd" name="passwd" placeholder="Ingresa la contraseña" required><br/>

            <label for="alumno">Alumno 
              <input type="radio" id="alumno" name="rol" value="alumno" required>

            <label for="profesor">Profesor 
              <input type="radio" id="profesor" name="rol" value="profesor" required><br/>

            <button type="submit" >Iniciar sesión</button>
            <a class="registro" href="registro.php">Regístrate aquí</a>
        </form> 
      </div>
  <?php
    }
    ?>
    </body>
</html>