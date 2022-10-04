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

function loginAdmin($username,$password) {

    $conn = conectar();
    $query = "SELECT * FROM admin WHERE Password = '".md5($password)."'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) == 1) {
        $credenciales = mysqli_fetch_row($result);
        if(md5($password) == $credenciales[1] && $username == $credenciales[0]) {

            $_SESSION['nombre'] = $username;
            $_SESSION['rol'] = 0;
            echo "<meta http-equiv=refresh content='0; url=administracion.php'>";
        }
            
    }
    else {
        echo "Las credenciales son incorrectas";
        echo "<meta http-equiv=refresh content='2; url=login_admin.php'>";
    }

}


function login($email,$password,$rol) {

    $conn = conectar();
    if($rol == "profesor") {
        $query = "SELECT * FROM professors WHERE Email = '$email' AND Password = '".md5($password)."'";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) == 1) {
            $credenciales = mysqli_fetch_row($result);
            $_SESSION['nombre'] = $credenciales[2];
            $_SESSION['email'] = $email; 
            $_SESSION['rol'] = 1;
            echo "<meta http-equiv=refresh content='0; url=inicioprofesores.php'>";
            
            
        }
        else {
            echo "Las credenciales son incorrectas";
            echo "<meta http-equiv=refresh content='2; url=index.php'>";
        }

    }
    else {

        $query = "SELECT * FROM alumnes WHERE Email = '$email' AND Password = '".md5($password)."'";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) == 1) {
            $credenciales = mysqli_fetch_row($result);
            $_SESSION['nombre'] = $credenciales[2];
            $_SESSION['email'] = $email; 
            $_SESSION['rol'] = 2;
            echo "<meta http-equiv=refresh content='0; url=inicioalumnos.php'>";
            
            
        }
        else {
            echo "Las credenciales son incorrectas";
            echo "<meta http-equiv=refresh content='2; url=index.php'>";
        }

    }
    
    
}

function validar($rol) {
    //rol 0 es admin, rol 1 es profesor, rol 2 es alumno
    if($rol == 0) {

        return 0;

    }
    else if($rol == 1) {

        return 1 ;

    }
    else if($rol == 2) {

        return 2;

    }
    
    
}

function registrar($dni,$email,$nom,$cognoms,$edat,$password) {

    $conn = conectar();
    
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

            $query = "INSERT INTO alumnes VALUES ('$dni','$email','$nom','$cognoms','$edat','$destination','".md5($password)."')"; 
        
            if(!mysqli_query($conn,$query)) {
                    
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=login.php" />';
                    
            }    
            else {

                echo "Usuario registrado correctamente";
                echo "<meta http-equiv=refresh content='2; url=index.php'>";

            }

        } 
        else {

            echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
            echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    
        }
    }
    

    
}

function añadirCurso($nom,$descripcio,$hores_duracio,$data_inici,$data_final,$dni) {
    
    $conn = conectar();
    $query = "INSERT INTO cursos VALUES (DEFAULT,'$nom','$descripcio','$hores_duracio','$data_inici','$data_final','$dni','1')"; 

    if(!mysqli_query($conn,$query)) {
          
        echo "Fallo al realizar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=cursos.php" />';
        
    } 
    else {

        echo "Curso añadido correctamente";
        echo "<meta http-equiv=refresh content='2; url=cursos.php'>";

    }
    
}

function borrarCurso($codi,$estado) {
    $conn = conectar();
    if ($estado == 1) {

        $query = "UPDATE cursos SET Activado = '0' WHERE Codi = '$codi'";

        if(!mysqli_query($conn,$query)) {
          
            echo "Fallo al realizar la consulta";
            echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
            
        }
        else {
    
            echo "Curso desactivado con éxito";
            echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
    
        } 
    }
    else if ($estado == 0) {

        $query = "UPDATE cursos SET Activado = '1' WHERE Codi = '$codi'";

        if(!mysqli_query($conn,$query)) {
          
            echo "Fallo al realizar la consulta";
            echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
            
        }
        else {
    
            echo "Curso activado con éxito";
            echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
    
        } 
    }
    
    
    
}

function modificarCurso($codi) {
    $conn = conectar();
    if(isset($_POST['DNI'])) {

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
                <input disabled type="text" id="modify" name="Nom" placeholder = "<?php echo $curso['Nom']; ?>" ><br/>
                <label for="Descripcio">Descripció: 
                <input type="text" id="modify" name="Descripcio" placeholder = "<?php echo $curso['Descripcio']; ?>" >
                <label for="Hores_Duracio">Hores duració: 
                <input type="text" id="modify" name="Hores_Duracio" placeholder = "<?php echo $curso['Hores_Duracio']; ?>" ><br/>
                <label for="Data_Inici">Data inici: 
                <input type="text" id="modify" name="Data_Inici" onfocus="(this.type='date')" placeholder = "<?php echo $curso['Data_Inici']; ?>" >
                <label for="Data_Final">Data final: 
                <input type="text" id="modify" name="Data_Final"  onfocus="(this.type='date')" placeholder = "<?php echo $curso['Data_Final']; ?>" ><br/>
                <label for="DNI">DNI: 
                <select name="DNI" id="modify"  >
                    <option selected disabled value="">Selecciona un profesor</option>
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
          echo "<thead>";
            while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
                if($array['Field'] != "Activado") {

                    echo "<th>".$array['Field']."</th>"; 

                }
                
            }  
            
            
        }
}

function mostrarCursos() {
    $conn = conectar();
    mostrarColumnasCursos();
    echo "<th>Modificar</th>";
    echo "<th>Act./Desact.</th>";
    echo "</thead>";
    $query = "SELECT * FROM cursos ORDER BY Codi";
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

            if ($field_name == "Activado") {

                if($value == '1') {

                    $src = 'img/tick.png';
                    $class = "activado";
                }
                else {

                    $src = 'img/cross.png';
                    $class = "desactivado";

                }
            }
            else {

                echo "<td>$value</td>";
                

            }
            
        }
        echo"<td><a href='modificarcurso.php?Codi=".$array['Codi']."&estado=".$array['Activado']."'><img src='img/pencil.png' alt='Modificar' style='width:42px;height:42px;'></a></td>";
        echo"<td class=$class><a href='borrarcurso.php?Codi=".$array['Codi']."&estado=".$array['Activado']."'><img src=$src alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
        
        }
        echo "</tbody>";
        echo "</table>";  
    }
}
  
function listarProfesores() {
    $conn = conectar();
    $query = "SELECT DNI,Nom,Cognoms FROM professors WHERE Activado = 1";
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
            echo "<th>Act./Desact.</th>";
        }
}

function mostrarProfesores() {
          $conn = conectar();
          mostrarColumnasProfesores();
          echo "</thead>";
          $query = "SELECT * FROM professors ORDER BY Nom";
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
                    if($field_name != "Password") {

                        if($field_name == "Foto") {
                            
                            echo "<td><img src=".$array['Foto']." alt=".$array['Foto']." style='width:50px;height:40px;'></img></td>";

                        }
                        else if($field_name == "Activado") {
                            if($value == '1') {

                                $src = 'img/tick.png';

                            }
                            else {

                                $src = 'img/cross.png';

                            }

                        }
                        else {

                            echo "<td>$value</td>";

                        }

                    }
                    
                }
                echo"<td><a href='modificarprofesor.php?id=".$array['DNI']."&estado=".$array['Activado']."'><img src='img/pencil.png' alt='Modificar' style='width:42px;height:42px;'></a></td>";
                echo"<td><a href='borrarprofesor.php?id=".$array['DNI']."&estado=".$array['Activado']."'><img src=$src alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
                
              }
              echo "</tbody>";
              echo "</table>";  
          }
}


function añadirProfesor($dni,$email,$nom,$cognoms,$titol,$password) {

    $conn = conectar();
    
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

            $query = "INSERT INTO professors VALUES ('$dni','$email','$nom','$cognoms','$titol','$destination','".md5($password)."','1')";
            
            if(!mysqli_query($conn,$query)) {
                    
            echo "Fallo al realizar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
                    
            }
            else {

                echo "Profesor añadido correctamente";
                echo "<meta http-equiv=refresh content='2; url=profesores.php'>";

            }
            

        } 
        else {

            echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
            echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    
        }
    }
    

    
}


function borrarProfesor($dni,$estado) {
    $conn = conectar();
    if ($estado == 1) {

        $query = "UPDATE professors SET Activado = '0' WHERE DNi = '$dni'";

        if(!mysqli_query($conn,$query)) {
          
            echo "Fallo al realizar la consulta";
            echo "<meta http-equiv=refresh content='2; url=profesores.php'>";
            
        }
        else {
    
            echo "Profesor desactivado con éxito";
            echo "<meta http-equiv=refresh content='2; url=profesores.php'>";
    
        } 
    }
    else if ($estado == 0) {

        $query = "UPDATE professors SET Activado = '1' WHERE DNI = '$dni'";

        if(!mysqli_query($conn,$query)) {
          
            echo "Fallo al realizar la consulta";
            echo "<meta http-equiv=refresh content='2; url=profesores.php'>";
            
        }
        else {
    
            echo "Profesor activado con éxito";
            echo "<meta http-equiv=refresh content='2; url=profesores.php'>";
    
        } 
    }

}


function buscarCursos($nombre) {
    $conn = conectar();
    $query = "SELECT * FROM cursos WHERE Nom LIKE '$nombre%'";
    $result = $conn->query($query);
    if (!$result) {
        echo "Fallo al ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=admin.php" />';
    }
    else if (mysqli_num_rows($result) != 0) {
        mostrarColumnasCursos();
        echo "<th>Modificar</th>";
        echo "<th>Act./Desact.</th>";
        echo "</thead>";
        while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
          echo "<tbody>";
          echo "<tr>"; 
          foreach ($array as $field_name => $value) {
            
            if($field_name != "Activado") {

                echo "<td>$value</td>";

            }
            else {

                if($value == 1) {

                    $src = "img/tick.png";
                    $class = "activado";
                }
                else if($value == 0) {

                    $src = "img/cross.png";
                    $class = "desactivado";

                }

            }
            
              
          }

          echo"<td><a href='modificarcurso.php?Codi=".$array['Codi']."'><img src='img/pencil.png' alt='Modificar' style='width:42px;height:42px;'></a></td>";
          echo"<td class=$class ><a  href='borrarcurso.php?Codi=".$array['Codi']."&estado=".$array['Activado']."'><img src=$src alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
          
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
    $query = "SELECT * FROM professors WHERE Nom LIKE '$nombre%'";
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

                if($field_name != "Password") {

                    if($field_name == "Foto") {
                            
                        echo "<td><img src=".$array['Foto']." alt=".$array['Foto']." style='width:50px;height:40px;'></img></td>";

                    }

                    else if($field_name == "Activado") {

                        if($value == 1) {

                            $src = "img/tick.png";

                        }
                        else if($value == 0) {

                            $src = "img/cross.png";

                        }

                    }
                    else {

                        echo "<td>$value</td>";

                    }

                }
                    
            }

            echo"<td><a href='modificarprofesor.php?id=".$array['DNI']."'><img src='img/pencil.png' alt='Modificar' style='width:42px;height:42px;'></a></td>";
            echo"<td><a href='borrarprofesor.php?id=".$array['DNI']."'><img src=$src alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
                
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

            $profesor = mysqli_fetch_array($result,MYSQLI_ASSOC);

        } 
    ?>
    <script src="ModificarFoto.js"></script>
    <form  id="modify" method="POST" enctype="multipart/form-data" >
        <label for="DNI">DNI: 
            <input disabled type="text" id="modify" name="DNI" placeholder = "<?php echo $profesor['DNI']; ?>" ><br/>
        <label for="Email">Email: 
            <input disabled type="email" id="modify" name="Email" placeholder = "<?php echo $profesor['Email']; ?>" ><br/>
        <label for="Nom">Nom: 
            <input type="text" id="modify" name="Nom" placeholder = "<?php echo $profesor['Nom']; ?>" >
        <label for="Cognoms">Cognoms: 
            <input type="text" id="modify" name="Cognoms" placeholder = "<?php echo $profesor['Cognoms']; ?>" ><br/>
        <label for="Titol_Academic">Titol Acadèmic: 
            <input type="text" id="modify" name="Titol_Academic" placeholder = "<?php echo $profesor['Titol_Academic']; ?>" >
        <label for="mod_foto">Modificar: 
            <input type="checkbox" id="Foto" name="Foto" onclick="modificarFoto()" >
        Foto actual: <img src="<?php echo $profesor['Foto']; ?>" style='width:50px;height:40px;'></img><br/>
            <div id="divFoto"></div>
            <input type="submit" value="Modificar"></input>
        </form>
    
            
            <?php
            }    
    
}


function listarCursosDisponibles($email) {

    $conn = conectar();
    mostrarColumnasCursos();
    echo "<th>Matricularse/Darse de baja</th>";
    echo "</thead>";
    $today = date("Y-m-d");
    $query = "SELECT * FROM cursos WHERE Data_Inici > '$today' AND Activado = 1";
    $result = mysqli_query($conn,$query);
    if (!$result) {
        echo "Fallo al ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';
    }
    else {
        while($array = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            echo "<tbody>";
            echo "<tr>"; 
            foreach ($array as $field_name => $value) {

                if($field_name == "Foto") {

                    $src = 'img/cross.png';

                }
                
                else if ($field_name != "Activado") {

                    echo "<td>$value</td>";

                }
                
            }

            $query = "SELECT DNI FROM alumnes WHERE Email = '$email'"; 
            $row = mysqli_fetch_row(mysqli_query($conn,$query));
            $dni = $row[0];
            $query = "SELECT * FROM matricula WHERE DNI = '$dni' AND Codi = '".$array['Codi']."' ";
            if(mysqli_num_rows(mysqli_query($conn,$query)) == 0) {

                echo "<td> <a href=matricularse.php?codi=".$array['Codi']." > <img src='img/matricula.png' style='width:42px;height:42px;'> </img></a> </td>";

            }
            else if(mysqli_num_rows(mysqli_query($conn,$query)) == 1) {

                echo "<td> <a href=desmatricularse.php?codi=".$array['Codi']." > <img src='img/cross.png' style='width:42px;height:42px;'> </img></a> </td>";

            }
        }
            
        echo "</tbody>";
        echo "</table>";  
    }
    
    

}

function matricularse($codi,$email) {

    $conn = conectar();
    $query = "SELECT DNI FROM alumnes WHERE Email = '$email'";

    $result = mysqli_query($conn,$query);
    if(!$result) {

        echo "No se ha podido ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';

    }
    else {
        
        //recogemos la fila que sale para tener el dni
        $row = mysqli_fetch_row($result);
        $query = "INSERT INTO matricula VALUES('".$row[0]."','$codi')";

        if(!mysqli_query($conn,$query)) {

            echo "No se ha podido ejecutar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';
    
        }
        else {

            echo "Has sido matriculado correctamente";
            echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';

        }
    }
    


}

function desmatricularse($codi,$email) {

    $conn = conectar();
    $query = "SELECT DNI FROM alumnes WHERE Email = '$email'";

    $result = mysqli_query($conn,$query);
    if(!$result) {

        echo "No se ha podido ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';

    }
    else {
        
        //recogemos la fila que sale para tener el dni
        $row = mysqli_fetch_row($result);
        $query = "DELETE FROM matricula WHERE DNI = '".$row[0]."' AND Codi = '$codi' ";
        
        if(!mysqli_query($conn,$query)) {
            
            echo "No se ha podido ejecutar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';
    
        }
        else {

            echo "Has sido dado de baja correctamente";
            echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';

        }
    }
    


}

function listarCursosMatriculados($email) {

    $conn = conectar();
    $query = "SELECT DNI FROM alumnes WHERE Email = '$email'";

    $result = mysqli_query($conn,$query);
    if(!$result) {

        echo "No se ha podido ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';

    }
    else {
        
        //recogemos la fila que sale para tener el dni
        $row = mysqli_fetch_row($result);
        $query = "SELECT c.Codi,c.Nom,c.Descripcio,c.Hores_Duracio,c.Data_Inici,c.Data_Final,c.DNI FROM matricula m INNER JOIN cursos c ON m.Codi = c.Codi WHERE m.DNI = '".$row['0']."' ";
        $result = mysqli_query($conn,$query);
        if(!$result) {
            
            echo "No se ha podido ejecutar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';
    
        }
        else {

            if(mysqli_num_rows($result) == 0) {

                echo "<h2>Vaya, parece que no estás matriculado en ningún curso :(";    

            }
            else {

                mostrarColumnasCursos();
                echo "<th>Nota</th>";
                while($array = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    
                    echo "<tbody>";
                    echo "<tr>"; 
                    foreach ($array as $field_name => $value) {
    
                        if($field_name == "Foto") {
    
                            $src = 'img/cross.png';
    
                        }
                        
                        else if ($field_name != "Activado") {
    
                            echo "<td>$value</td>";
    
                        }
                        
                    }
                    if($array['Data_Final'] < date("Y-m-d")) {
                        
                        echo "<td> Prueba </td>";
        
                    }
                    else {
    
                        echo "<td> No disponible </td>";
    
                    }
                
                }
    
            }

        }
        



        
        
        
        
    }

}


//esta es para los profes xd
function listarCursos($email) {

    $conn = conectar();
    echo "<table cellspacing=0>";
    echo "<thead>";
    echo "<th>DNI</th>";
    echo "<th>Email</th>";
    echo "<th>Nom</th>";
    echo "<th>Cognoms</th>";
    echo "<th>Foto</th>";
    echo "<th>Codi Curs</th>";
    echo "<th>Nom Curs</th>";
    echo "<th>Data inici</th>";
    echo "<th>Data final</th>";
    echo "<th>Nota</th>";
    echo "</thead>";
    $query = "SELECT DNI FROM professors WHERE Email = '$email'"; 
    $result = mysqli_query($conn,$query);
    
    if (!$result) {
        
        echo "Fallo al ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=inicioprofesores.php" />';
    
    }
    else {

        $dni = mysqli_fetch_array($result,MYSQLI_NUM)[0];
        $today = date("Y-m-d");
        $query = " SELECT a.DNI,a.Email,a.Nom,a.Cognoms,a.Foto,c.Codi,c.Nom AS Nom_Curs,c.Data_Inici,c.Data_Final,m.Nota FROM alumnes a INNER JOIN matricula m ON a.DNI = m.DNI INNER JOIN cursos c ON m.Codi = c.Codi WHERE c.DNI = '$dni'";
        $result = mysqli_query($conn,$query);
        if (!$result) {
            echo "Fallo al ejecutar la consulta";
            echo '<meta http-equiv="refresh" content="2;url=inicioprofesores.php" />';
        }
        else {
            while($array = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            echo "<tbody>";
            echo "<tr>"; 
            foreach ($array as $field_name => $value) {
                
                if($field_name == "Foto") {

                    echo "<td><img src='$value' style='width:42px;height:42px;'></img></td>";

                }
                
                else if($field_name == "Nota") {


                    if($array['Data_Final'] < $today) {
                        
                        if($value == null) {

                            echo "<td> <a href=ponernota.php?codi=".$array['Codi']."&id=".$array['DNI']." > <img src='img/nota.png' style='width:30px;height:30px;'> </img></a> </td>";
        
                        }
                        else {

                            echo "<td>$value</td>";
    
                        }
        
                    }
                    
                    

                }
                else {

                    echo "<td>$value</td>";

                }
                
            }
            
            
            
            }
            echo "</tbody>";
            echo "</table>";  
        }
    }
    

}


function ponerNota($codi,$dni,$nota) {

    $conn = conectar();
    $query = "UPDATE matricula SET Nota = '$nota' WHERE DNI = '$dni' AND Codi = '$codi'";
    
    if(!mysqli_query($conn,$query)) {

        echo "Fallo al ejecutar la consulta";
        echo '<meta http-equiv="refresh" content="2;url=inicioprofesores.php" />';

    }
    else {

        echo "Nota puesta correctamente";
        echo '<meta http-equiv="refresh" content="2;url=inicioprofesores.php" />';
    }

}

?>