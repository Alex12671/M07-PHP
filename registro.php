<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet">
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
  </head>
    <body>
      <?php
        if(isset($_POST['mail'])) {
          include("funciones.php");
          registrar($_POST);
        }
        else {?>
      <form  id="login" method="POST" >
        <label for="DNI">DNI: 
        <input type="text" id="login" name="DNI" pattern="[0-9]{8}[A-Z]" required><br/>
        <label for="Nom">Nom: 
        <input type="text" id="login" name="Nom" required><br/>
        <label for="Cognoms">Cognoms: 
        <input type="text" id="login" name="Cognoms" required><br/>
        <label for="Edat">Edat: 
        <input type="text" id="login" name="Edat" required><br/>
        <label for="Foto">Foto: 
        <input type="file" id="login" name="Foto" ><br/>
        <label for="Email">Email: 
        <input type="email" id="login" name="Email" required><br/>
        <label for="passwd">Contraseña: 
        <input type="password" id="login" name="passwd" required><br/>
        
        <input type="submit" value="Registrarse"></input><br/>
      </form>
      <a href="index.php">Volver a la página de login</a>
    <?php
      }
    ?>
    </body>
</html>