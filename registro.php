<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Registrar</title>
  </head>
    <body>
      <?php
        if(isset($_POST['DNI'])) {
          include("funciones.php");
          registrar($_POST);
        }
        else {?>
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
        
        <input type="submit" value="Registrarse"></input><br/>
      </form>
      <a href="index.php">Volver a la página de login</a>
    <?php
      }
    ?>
    </body>
</html>