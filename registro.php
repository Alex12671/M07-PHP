<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/registro.css">
    <meta charset="utf-8">
    <title>Registrar</title>
  </head>
    <body>
      <?php
        if(isset($_POST['DNI'])) {
          include("funciones.php");
          registrar($_POST['DNI'],$_POST['Email'],$_POST['Nom'],$_POST['Cognoms'],$_POST['Edat'],$_POST['Password']);
        }
        else {?>
        <header>
          <h1 class="inicio">Página de registro</h1>
          <a href="index.php" class="foto" ><img src="img/logo.png" alt="logo"></img></a>
          <nav class="menu">
            <ul> 
              <li><a href="index.php">Volver a la página de login</a></li>
            </ul>
          </nav>
        </header>
          <div id="registro">
      <form  id="login" method="POST" enctype="multipart/form-data">
        <label for="DNI">DNI: 
        <input type="text" id="login" name="DNI" pattern="[0-9]{8}[A-Z]" required><br/>
        <label for="Email">Email: 
        <input type="email" id="login" name="Email" required><br/>
        <label for="Nom">Nom: 
        <input type="text" id="login" name="Nom" required><br/>
        <label for="Cognoms">Cognoms: 
        <input type="text" id="login" name="Cognoms" required><br/>
        <label for="Edat">Edat: 
        <input type="text" id="login" name="Edat" required><br/>
        <label for="Foto">Foto: 
        <input type="file" id="Foto" name="Foto" required><br/>
        <label for="passwd">Contraseña: 
        <input type="password" id="Password" name="Password" required><br/>
        
        <button type="submit">Registrarse</button><br/>
      </form>
      
        </div>
    <?php
      }
    ?>
    </body>
</html>