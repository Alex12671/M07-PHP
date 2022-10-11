<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/modificarprofesor.css">
    <meta charset="utf-8">
    <title>Modificar profesor</title>
  </head>
    <body>

    <?php
        include("funciones.php");
        if(isset($_SESSION)) {
          if(validar($_SESSION['rol']) == 2) {
            ?>
            <header>
                <h1 class="inicio">Modificar profesor</h1>
                <a href="index.php" class="foto" ><img src="img/logo.png" alt="logo"></img></a>
                <nav class="menu">
                  <ul>
                    <li ><a class="admin" href="sortir.php">Cerrar sesión</a></li>
                    <li ><a href="inicioalumnos.php">Volver a panel principal</a></li>
                  </ul>
                </nav>
              </header>
              <div id="modificar">
              <h1 class="bienvenida" >Bienvenido <?php echo $_SESSION['nombre'];?>!</h1>
              <?php

                $conn = conectar();
                $email = $_SESSION['email'];
                if(isset($_POST['Nom'])) {
                    
                    foreach($_POST as $field_name => $value) {
            
                        if($value != "") {
                
                            $query = "UPDATE alumnes SET $field_name = '$value' WHERE Email = '$email'";   
                    
                            if(!mysqli_query($conn,$query)) {
                                
                                echo "Fallo al realizar la consulta";
                                echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';
                                
                            } 
                
                        }
                    
                    }
            
                    if(isset($_POST['Foto'])) {
            
                        if(is_uploaded_file ($_FILES['Foto']['tmp_name'])) {
            
                            $filename = $_FILES['Foto']['name'];
                            $destination = 'professors/'.$filename;
                            $extension = pathinfo($filename, PATHINFO_EXTENSION);
                            $file = $_FILES['Foto']['tmp_name'];
                            $size = $_FILES['Foto']['size'];
                        
                            if ($_FILES['Foto']['size'] > 16000000) { // Tamaño maximo = 16MB
                                echo "<p class=fallo>El archivo es muy grande!</p>";
                                echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                            } 
                            else {
                                    
                                if (move_uploaded_file($file, $destination)) {
                                    $query = "UPDATE alumnes SET Foto = '$destination' WHERE Email = '$email'";
                                
                                    if(!mysqli_query($conn,$query)) {
                                            
                                    echo "<p class=fallomodificar>Fallo al realizar la consulta</p>";
                                    echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';
                                            
                                    }
                        
                                } 
                                else {
                        
                                    echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
                                    echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                            
                                }
                            } 
                
                        }
            
                    }
                    echo "<p class=modificar>Datos modificados correctamente</p>";
                    echo "<meta http-equiv=refresh content='2; url=inicioalumnos.php'>";
                    
            
                    
            
                }
            
            
                else {
                    $query = "SELECT * FROM alumnes WHERE Email = '$email'";
                    $result = mysqli_query($conn,$query);
                    if(!$result) {
                        
                        echo "Fallo al realizar la consulta";
                        
                    }
                    else {
            
                        $alumno = mysqli_fetch_array($result,MYSQLI_ASSOC);
            
                    } 
                ?>
                <script src="ModificarFoto.js"></script>
                <form  id="modify" method="POST" enctype="multipart/form-data" >
                    <label for="DNI">DNI: 
                        <input disabled type="text" id="modify" name="DNI" placeholder = "<?php echo $alumno['DNI']; ?>" ><br/>
                    <label for="Email">Email: 
                        <input disabled type="email" id="modify" name="Email" placeholder = "<?php echo $alumno['Email']; ?>" ><br/>
                    <label for="Nom">Nom: 
                        <input type="text" id="modify" name="Nom" placeholder = "<?php echo $alumno['Nom']; ?>" ><br/>
                    <label for="Cognoms">Cognoms: 
                        <input type="text" id="modify" name="Cognoms" placeholder = "<?php echo $alumno['Cognoms']; ?>" ><br/>
                    <label for="Edat">Edat: 
                        <input type="text" id="modify" name="Edat" placeholder = "<?php echo $alumno['Edat']; ?>" ><br/>
                    <label for="mod_foto">Modificar: 
                        <input type="checkbox" id="Foto" name="Foto" onclick="modificarFoto()" ><br/>
                    Foto actual: <img src="<?php echo $alumno['Foto']; ?>" style='width:50px;height:40px;'></img><br/>
                        <div id="divFoto"></div>
                        <button type="submit">Modificar</button>
                    </form>
                
                        
                        <?php
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