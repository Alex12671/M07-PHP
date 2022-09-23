<?php

function conectar() {
    $servername = "localhost";
    $database = "infobdn";
    $username = "root";
    $conn = mysqli_connect($servername, $username,"", $database);
    if (!$conn) {
        die("Falló la conexión a base de datos: " . mysqli_connect_error());
    }

    return $conn;
}

function login($username,$password) {
    $conn = conectar();
    
  
    $query = "SELECT * FROM admin WHERE Password = '".md5($password)."'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) == 1) {
        $credenciales = mysqli_fetch_row($result);
        if(md5($password) == $credenciales[1] && $username == $credenciales[0]) {

            $_SESSION['nombre'] = $username;
            $_SESSION['passwd'] = $password; 
            $_SESSION['rol'] = "admin";
            echo "<meta http-equiv=refresh content='0; url=administracion.php'>";
        }
        
    }
    else {
        echo "Las credenciales son incorrectas";
        echo "<meta http-equiv=refresh content='2; url=login_admin.php'>";
    }
    
}

function validaradmin() {
    
    if($_SESSION['rol'] == "admin") {
        return 1;
    }
    else {
        return 0;
    }
    
    
}

function registrar($dades) {
    $conn = conectar();
    foreach($dades as $field_name => $value) {
      
        if($field_name == "DNI") {

            $dni = $value;
            $query = "INSERT INTO alumnes($field_name) VALUES ('$value')";

            if(!mysqli_query($conn,$query)) {
            
                echo "Fallo al realizar la consulta";
                echo '<meta http-equiv="refresh" content="2;url=login.php" />';
                
            } 

        }
        
        else if($field_name == "Password") {

            $query = "UPDATE alumnes SET $field_name = '".md5($value)."' WHERE DNI = '$dni'";
          
            if(!mysqli_query($conn,$query)) {
            
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=login.php" />';
            
            } 

        }

        else {
  
          $query = "UPDATE alumnes SET $field_name = '$value' WHERE DNI = '$dni'";
          
          if(!mysqli_query($conn,$query)) {
          
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=login.php" />';
            
          } 

        }
  
        
    } 
    
    $filename = $_FILES['Foto']['name'];
    $destination = 'alumnes/'.$filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $_FILES['Foto']['tmp_name'];
    $size = $_FILES['Foto']['size'];

    if ($_FILES['Foto']['size'] > 16000000) { // Tamaño maximo = 16MB
        echo "<p class=fallo>El archivo es muy grande!</p>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    } 
    else {
            
        if (move_uploaded_file($file, $destination)) {

            $query = "UPDATE alumnes SET Foto = '$destination' WHERE DNI = '$dni'";
        
            if(!mysqli_query($conn,$query)) {
                    
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=login.php" />';
                    
            }

            

        } 
        else {

            echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
            echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    
        }
    }
    echo "Usuario registrado correctamente";
    echo "<meta http-equiv=refresh content='2; url=index.php'>";
    
}

function añadirCurso($form) {
    $conn = conectar();
    foreach($form as $field_name => $value) {
      
        if($field_name == "Nom") {
        $nom = $value;
        $query = "INSERT INTO cursos($field_name) VALUES ('$value')";
        }
        
        else {
  
          $query = "UPDATE cursos SET $field_name = '$value' WHERE Nom = '$nom'";
          
        }
  
        if(!mysqli_query($conn,$query)) {
          
          echo "Fallo al realizar la consulta";
          echo '<meta http-equiv="refresh" content="2;url=cursos.php" />';
          
        } 
    }  
    echo "Datos introducidos correctamente";
    echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
}

function borrarCurso($codi) {
    $conn = conectar();
    $query = "UPDATE cursos SET Activado = '0' WHERE Codi = '$codi'";
    if(!mysqli_query($conn,$query)) {
          
        echo "Fallo al realizar la consulta";
        echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
        
    }
    else {

        echo "Curso borrado con éxito";
        echo "<meta http-equiv=refresh content='2; url=cursos.php'>";

    } 
    
}

function modificarCurso($codi) {
    $conn = conectar();
    if(isset($_POST['Nom'])) {

        foreach($_POST as $field_name => $value) {

            if($value != "") {

                $query = "UPDATE cursos SET $field_name = '$value' WHERE Codi = '$codi'";   
    
                if(!mysqli_query($conn,$query)) {
                
                echo "Fallo al realizar la consulta";
                echo '<meta http-equiv="refresh" content="2;url=cursos.php" />';
                
                } 

            }
    
        }  
        echo "Datos modificados correctamente";
        echo "<meta http-equiv=refresh content='2; url=cursos.php'>";

    }


    else {
        $query = "SELECT * FROM cursos WHERE Codi = '$codi'";
        $result = mysqli_query($conn,$query);
        if(!$result) {
            
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=cursos.php" />';
            
        }
        else {

            $curso = mysqli_fetch_array($result,MYSQLI_ASSOC);

        } 
    ?>
    <form  id="modify" method="POST" >
                <label for="Nom">Nom: 
                <input type="text" id="modify" name="Nom" placeholder = "<?php echo $curso['Nom']; ?>" ><br/>
                <label for="Descripcio">Descripció: 
                <input type="text" id="modify" name="Descripcio" placeholder = "<?php echo $curso['Descripcio']; ?>" >
                <label for="Hores_Duracio">Hores duració: 
                <input type="text" id="modify" name="Hores_Duracio" placeholder = "<?php echo $curso['Hores_Duracio']; ?>" ><br/>
                <label for="Data_Inici">Data inici: 
                <input type="text" id="modify" name="Data_Inici" onfocus="(this.type='date')" placeholder = "<?php echo $curso['Data_Inici']; ?>" >
                <label for="Data_Final">Data final: 
                <input type="text" id="modify" name="Data_Final"  onfocus="(this.type='date')" placeholder = "<?php echo $curso['Data_Final']; ?>" ><br/>
                <label for="DNI">DNI: 
                <select name="DNI" id="modify" placeholder = "<?php echo $curso['DNI']; ?>"  >
                    <?php
                    listarProfesores();
                    ?>
                </select>
                <input type="submit" value="Entrar"></input>
            </form>
            <?php
            }    
    
}
  


function mostrarColumnasCursos() {
    $conn = conectar();
    $query = "SHOW COLUMNS FROM cursos";
          $result = $conn->query($query);
          if (!$result) {
            echo "Fallo al ejecutar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=admin.php" />';
        }
        else {
          echo "<table cellspacing=0>";
            while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
                if($array['Field'] != "Activado") {

                    echo "<th>".$array['Field']."</th>"; 

                }
                
            }  
            echo "<th>Modificar</th>";
            echo "<th>Eliminar</th>";
        }
}

function mostrarCursos() {
          $conn = conectar();
          mostrarColumnasCursos();
          echo "</thead>";
          $query = "SELECT * FROM cursos WHERE Activado = '1' ORDER BY Codi";
          $result = $conn->query($query);
          if (!$result) {
              echo "Fallo al ejecutar la consulta";
              echo '<meta http-equiv="refresh" content="2;url=admin.php" />';
          }
          else {
              while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
                echo "<tbody>";
                echo "<tr>"; 
                foreach ($array as $field_name => $value) {
                    if($field_name != "Activado") {

                        echo "<td>$value</td>";

                    }
                    
                }
                echo"<td><a href='modificarcurso.php?Codi=".$array['Codi']."'><img src='img/pencil.jpg' alt='Modificar' style='width:42px;height:42px;'></a></td>";
                echo"<td><a href='borrarcurso.php?Codi=".$array['Codi']."'><img src='img/cross.jpg' alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
                
              }
              echo "</tbody>";
              echo "</table>";  
          }
}
  
function listarProfesores() {
    $conn = conectar();
    $query = "SELECT DNI,Nom,Cognoms FROM professors";
    $result = mysqli_query($conn,$query);
    if(!$result) {
          
        echo "Fallo al realizar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
        
      }
    
    else {
        while($dni = mysqli_fetch_array($result,MYSQLI_NUM)) {

            echo "<option value=".$dni[0].">".$dni[0]." - ".$dni[1]." ".$dni[2]."</option>";

        }
        
    }
}

function mostrarColumnasProfesores() {
    $conn = conectar();
    $query = "SHOW COLUMNS FROM professors";
          $result = $conn->query($query);
          if (!$result) {
            echo "Fallo al ejecutar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=admin.php" />';
        }
        else {
          echo "<table cellspacing=0>";
            while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
                if($array['Field'] != "Password" && $array['Field'] != "Activado") {

                    echo "<th>".$array['Field']."</th>"; 

                }
                
            }  
            echo "<th>Modificar</th>";
            echo "<th>Eliminar</th>";
        }
}

function mostrarProfesores() {
          $conn = conectar();
          mostrarColumnasProfesores();
          echo "</thead>";
          $query = "SELECT * FROM professors WHERE Activado = '1' ORDER BY Nom";
          $result = $conn->query($query);
          if (!$result) {
              echo "Fallo al ejecutar la consulta";
              echo '<meta http-equiv="refresh" content="2;url=admin.php" />';
          }
          else {
              while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
                echo "<tbody>";
                echo "<tr>"; 
                foreach ($array as $field_name => $value) {
                    if($field_name != "Password" && $field_name != "Activado") {

                        if($field_name == "Foto") {
                            
                            echo "<td><img src=".$array['Foto']." alt=".$array['Foto']." style='width:50px;height:40px;'></img></td>";

                        }

                        else {

                            echo "<td>$value</td>";

                        }

                    }
                    
                }
                echo"<td><a href='modificarprofesor.php?id=".$array['DNI']."'><img src='img/pencil.jpg' alt='Modificar' style='width:42px;height:42px;'></a></td>";
                echo"<td><a href='borrarprofesor.php?id=".$array['DNI']."'><img src='img/cross.jpg' alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
                
              }
              echo "</tbody>";
              echo "</table>";  
          }
}


function añadirProfesor($form) {
    $conn = conectar();
    foreach($form as $field_name => $value) {
        if($field_name == "DNI") {

            $dni = $value;
            $query = "INSERT INTO professors($field_name) VALUES ('$value')";

            if(!mysqli_query($conn,$query)) {
                
                echo "Fallo al realizar la consulta";
                echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
                
            }
        }


        else if($field_name == "Password") {

            $query = "UPDATE professors SET $field_name = '".md5($value)."' WHERE DNI = '$dni'";
          
            if(!mysqli_query($conn,$query)) {
            
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
            
            } 

        }


        else {
  
          $query = "UPDATE professors SET $field_name = '$value' WHERE DNI = '$dni'";
          
          if(!mysqli_query($conn,$query)) {
          
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
            
          } 

        }
  
        
    } 
    
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

            echo "<p class=exito>Archivo subido con éxito</p>";
            $query = "UPDATE professors SET Foto = '$destination' WHERE DNI = '$dni'";
        
            if(!mysqli_query($conn,$query)) {
                    
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
                    
            }

            

        } 
        else {

            echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
            echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    
        }
    }
    

    echo "Datos introducidos correctamente";
    echo "<meta http-equiv=refresh content='2; url=profesores.php'>";
}


function borrarProfesor($dni) {
    $conn = conectar();
    $query = "UPDATE professors SET Activado = '0' WHERE DNI = '$dni'";
    if(!mysqli_query($conn,$query)) {
          
        echo "Fallo al realizar la consulta";
        echo "<meta http-equiv=refresh content='2; url=profesores.php'>";
        
    }
    else {

        echo "Profesor borrado con éxito";
        echo "<meta http-equiv=refresh content='2; url=profesores.php'>";

    } 

}


function buscarCursos($nombre) {
    $conn = conectar();
    $query = "SELECT * FROM cursos WHERE Nom LIKE '$nombre%' AND Activado = '1'";
    $result = $conn->query($query);
    if (!$result) {
        echo "Fallo al ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=admin.php" />';
    }
    else if (mysqli_num_rows($result) != 0) {
        mostrarColumnasCursos();
        echo "</thead>";
        while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
          echo "<tbody>";
          echo "<tr>"; 
          foreach ($array as $field_name => $value) {
            
            if($field_name != "Activado") {

                echo "<td>$value</td>";

            }
            
              
          }

          echo"<td><a href='modificarcurso.php?Codi=".$array['Codi']."'><img src='img/pencil.jpg' alt='Modificar' style='width:42px;height:42px;'></a></td>";
          echo"<td><a href='borrarcurso.php?Codi=".$array['Codi']."'><img src='img/cross.jpg' alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
          
        }
        echo "</tbody>";
        echo "</table>";  
    }

    else {

        echo "No hay resultados para esta búsqueda :(";

    }
}

function buscarProfesores($nombre) {
    $conn = conectar();
    $query = "SELECT * FROM professors WHERE Nom LIKE '$nombre%' AND Activado = '1'";
    $result = $conn->query($query);
    if (!$result) {

        echo "Fallo al ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=admin.php" />';
    
    }

    else if (mysqli_num_rows($result) != 0) {

        mostrarColumnasProfesores();
        echo "</thead>";
        while($array = $result-> fetch_array(MYSQLI_ASSOC)) {

            echo "<tbody>";
            echo "<tr>"; 
            foreach ($array as $field_name => $value) {

                if($field_name != "Password" && $field_name != "Activado") {

                    if($field_name == "Foto") {
                            
                        echo "<td><img src=".$array['Foto']." alt=".$array['Foto']." style='width:50px;height:40px;'></img></td>";

                    }

                    else {

                        echo "<td>$value</td>";

                    }

                }
                    
            }

            echo"<td><a href='modificarprofesor.php?id=".$array['DNI']."'><img src='img/pencil.jpg' alt='Modificar' style='width:42px;height:42px;'></a></td>";
            echo"<td><a href='borrarprofesor.php?id=".$array['DNI']."'><img src='img/cross.jpg' alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
                
            }

            echo "</tbody>";
            echo "</table>";  

    }

    else {

        echo "No hay resultados para esta búsqueda :(";

    }
}

function modificarProfesor($dni) {
    $conn = conectar();
    
    if(isset($_POST['DNI'])) {

        foreach($_POST as $field_name => $value) {

            if($value != "") {
    
                $query = "UPDATE professors SET $field_name = '$value' WHERE DNI = '$dni'";   
        
                if(!mysqli_query($conn,$query)) {
                    
                    echo "Fallo al realizar la consulta";
                    echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
                    
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
            
                        echo "<p class=exito>Archivo subido con éxito</p>";
                        $query = "UPDATE professors SET Foto = '$destination' WHERE DNI = '$dni'";
                    
                        if(!mysqli_query($conn,$query)) {
                                
                        echo "Fallo al realizar la consulta";
                        echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
                                
                        }
            
                        
            
                    } 
                    else {
            
                        echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
                        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                
                    }
                } 
    
            }

        }
        

        echo "Datos modificados correctamente";
        echo "<meta http-equiv=refresh content='2; url=profesores.php'>";

    }


    else {
        $query = "SELECT * FROM professors WHERE DNI = '$dni'";
        $result = mysqli_query($conn,$query);
        if(!$result) {
            
            echo "Fallo al realizar la consulta";
            
        }
        else {

            $curso = mysqli_fetch_array($result,MYSQLI_ASSOC);

        } 
    ?>
    <script src="ModificarFoto.js"></script>
    <form  id="modify" method="POST" enctype="multipart/form-data" >
                <label for="DNI">DNI: 
                <input type="text" id="modify" name="DNI" placeholder = "<?php echo $curso['DNI']; ?>" ><br/>
                <label for="Nom">Nom: 
                <input type="text" id="modify" name="Nom" placeholder = "<?php echo $curso['Nom']; ?>" >
                <label for="Cognoms">Cognoms: 
                <input type="text" id="modify" name="Cognoms" placeholder = "<?php echo $curso['Cognoms']; ?>" ><br/>
                <label for="Titol_Academic">Titol Acadèmic: 
                <input type="text" id="modify" name="Titol_Academic" placeholder = "<?php echo $curso['Titol_Academic']; ?>" >
                <label for="mod_foto">Modificar: 
                <input type="checkbox" id="Foto" name="Foto" onclick="modificarFoto()" >
                Foto actual: <img src="<?php echo $curso['Foto']; ?>" style='width:50px;height:40px;'></img><br/>
                <div id="divFoto"></div>
                <input type="submit" value="Modificar"></input>
            </form>
    
            
            <?php
            }    
    
}


?>