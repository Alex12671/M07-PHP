<?php

//funcion básica de conexión a base de datos, devuelve un objeto mysql con la conexión
function conectar() {
    
    try {
        $servername = "localhost";
        $database = "infobdn";
        $username = "root";
        $conn = mysqli_connect($servername, $username,"", $database);
        return $conn;
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al conectar a la base de datos</p>"; 
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    }

    
}

//función a la que se le pasa nombre de usuario y password para validar en base de datos, no devuelve nada
function loginAdmin($username,$password) {
    try {
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
            echo "<p class=fallo >Las credenciales son incorrectas</p>";
            echo "<meta http-equiv=refresh content='2; url=login_admin.php'>";
        }
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    }
    

}

//recibe email,usuario y rol de formulario, valida con base de datos y crea las variables de sesión pertinentes
function login($email,$password,$rol) {

    try {
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
                echo "<p class=fallo >Las credenciales son incorrectas</p>";
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
                echo "<p class=fallo >Las credenciales son incorrectas</p>";
                echo "<meta http-equiv=refresh content='2; url=index.php'>";
            }

        }
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    }
    
    
    
}

//funcion que devuelve un valor o otro dependiendo del rol
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

//funcion que recoge todos los valores de formulario y los introduce a base de datos
function registrar($dni,$email,$nom,$cognoms,$edat,$password) {

    try {
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
                mysqli_query($conn,$query);
                echo "Usuario registrado correctamente";
                echo "<meta http-equiv=refresh content='2; url=index.php'>";


            } 
            else {

                echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
                echo '<meta http-equiv="refresh" content="2;url=index.php" />';
        
            }
        }
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    }
    

    
}

//funcion que recibe parámetros de formulario y crea nueva entrada en la base de datos
function añadirCurso($nom,$descripcio,$hores_duracio,$data_inici,$data_final,$dni) {
    
    try {
        $conn = conectar();
        $query = "INSERT INTO cursos VALUES (DEFAULT,'$nom','$descripcio','$hores_duracio','$data_inici','$data_final','$dni','1')";
        mysqli_query($conn,$query); 
        echo "<p class=exito>Curso añadido correctamente</p>";
        echo "<meta http-equiv=refresh content='2; url=cursos.php'>";

    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=cursos.php" />';
    }
    
    
}

//funcion que recibe código y estado del curso y modifica su activación
function borrarCurso($codi,$estado) {
    try {
        $conn = conectar();
        if ($estado == 1) {
    
            $query = "UPDATE cursos SET Activado = '0' WHERE Codi = '$codi'";
            mysqli_query($conn,$query);
            echo "<p class=exito>Curso desactivado con éxito</p>";
            echo "<meta http-equiv=refresh content='2; url=cursos.php'>";

        }
        else if ($estado == 0) {
    
            $query = "UPDATE cursos SET Activado = '1' WHERE Codi = '$codi'";
            mysqli_query($conn,$query);
        
                echo "<p class=exito>Curso activado con éxito</p>";
                echo "<meta http-equiv=refresh content='2 url=cursos.php'>";
        }
    } catch(Exception $ex) {
        echo "<p class=errorsql1>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=cursos.php" />';
    }

    
    
    
}

//funcion que recibe el código del curso y modifica sus datos
function modificarCurso($codi) {
    try {
        $conn = conectar();
        if(isset($_POST['DNI'])) {

            foreach($_POST as $field_name => $value) {

                if($value != "") {

                    $query = "UPDATE cursos SET $field_name = '$value' WHERE Codi = '$codi'";   
                    mysqli_query($conn,$query);

                }
        
            }  
            echo "<p class=modificar>Datos modificados correctamente</p>";
            echo "<meta http-equiv=refresh content='2; url=cursos.php'>";

        }


        else {
            $query = "SELECT * FROM cursos WHERE Codi = '$codi'";
            $result = mysqli_query($conn,$query);
            $curso = mysqli_fetch_array($result,MYSQLI_ASSOC);

            ?>
            <form  id="modify" method="POST" >
                <label for="Nom">Nom: 
                <input disabled type="text" id="modify" name="Nom" placeholder = "<?php echo $curso['Nom']; ?>" ><br/>
                <label for="Descripcio">Descripció: 
                <input type="text" id="modify" name="Descripcio" placeholder = "<?php echo $curso['Descripcio']; ?>" ><br/>
                <label for="Hores_Duracio">Hores duració: 
                <input type="text" id="modify" name="Hores_Duracio" placeholder = "<?php echo $curso['Hores_Duracio']; ?>" ><br/>
                <label for="Data_Inici">Data inici: 
                <input type="text" id="modify" name="Data_Inici" onfocus="(this.type='date')" placeholder = "<?php echo $curso['Data_Inici']; ?>" ><br/>
                <label for="Data_Final">Data final: 
                <input type="text" id="modify" name="Data_Final"  onfocus="(this.type='date')" placeholder = "<?php echo $curso['Data_Final']; ?>" ><br/>
                <label for="DNI">DNI: 
                <select name="DNI" id="modify" required >
                    <option selected disabled value="">Selecciona un profesor</option>
                    <?php
                    listarProfesores();
                    ?>
                </select>
                <button type="submit">Modificar</input>
            </form>
                    <?php
        }  
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=cursos.php" />';
    }
      
    
}
  

//función que dibuja las columnas de los cursos
function mostrarColumnasCursos() {
    try {
        $conn = conectar();
        $query = "SHOW COLUMNS FROM cursos";
        $result = mysqli_query($conn,$query);
        echo "<table cellspacing=0>";
        echo "<thead>";
        while($array = $result-> fetch_array(MYSQLI_ASSOC)) {

            if($array['Field'] != "Activado") {

                echo "<th>".$array['Field']."</th>"; 

            }
            
        }      
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=administracion.php" />';
    }
    
}

//función que recoge información de la base de datos para mostrar cursos
function mostrarCursos() {
    try {
        $conn = conectar();
        mostrarColumnasCursos();
        echo "<th>Modificar</th>";
        echo "<th>Act./Desact.</th>";
        echo "</thead>";
        $query = "SELECT * FROM cursos ORDER BY Codi";
        $result = mysqli_query($conn,$query);
        echo "<tbody>";
        while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
        
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
            else if($field_name == "Data_Inici") {
                $fechaInicio = date("d/m/Y", strtotime($array["Data_Inici"]));
                echo "<td>$fechaInicio</td>";
               
            }
            else if($field_name == "Data_Final") {
                $fechaFinal = date("d/m/Y", strtotime($array["Data_Final"]));
                echo "<td>$fechaFinal</td>";
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

    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=administracion.php" />';
    }
    
}
  
//función que recoge datos de la base de datos para listar profesores
function listarProfesores() {
    try {
        $conn = conectar();
        $query = "SELECT DNI,Nom,Cognoms FROM professors WHERE Activado = 1";
        $result = mysqli_query($conn,$query);
        while($dni = mysqli_fetch_array($result,MYSQLI_NUM)) {

            echo "<option value=".$dni[0].">".$dni[0]." - ".$dni[1]." ".$dni[2]."</option>";

        }
        
        
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=cursos.php" />';
    }
    
}


function mostrarColumnasProfesores() {
    try {
        $conn = conectar();
        $query = "SHOW COLUMNS FROM professors";
        $result = mysqli_query($conn,$query);
        echo "<table cellspacing=0>";
        while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
            if($array['Field'] != "Password" && $array['Field'] != "Activado") {

                echo "<th>".$array['Field']."</th>"; 

            }
            
        }  
        echo "<th>Modificar</th>";
        echo "<th>Act./Desact.</th>";
            
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=administracion.php" />';
    }
    
}

//función sin parámetros, recoge información de la tabla profesores y los muestra
function mostrarProfesores() {
    try {
        $conn = conectar();
        $query = "SELECT * FROM professors ORDER BY Nom";
        mostrarColumnasProfesores();
        echo "</thead>"; 
        $result = mysqli_query($conn,$query);
        echo "<tbody>";
        while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
            
            echo "<tr>"; 
            foreach ($array as $field_name => $value) {
                if($field_name != "Password") {

                    if($field_name == "Foto") {
                        
                        echo "<td><img src=".$array['Foto']." alt=".$array['Foto']." style='width:50px;height:40px;'></img></td>";

                    }
                    else if($field_name == "Activado") {
                        
                        if($value == 1) {

                            $src = "img/tick.png";
                            $class = "activado";

                        }
                        else if($value == 0) {

                            $src = "img/cross.png";
                            $class = "desactivado";
                        }

                    }
                    else {

                        echo "<td>$value</td>";

                    }

                }
                
            }
            echo"<td><a href='modificarprofesor.php?id=".$array['DNI']."&estado=".$array['Activado']."'><img src='img/pencil.png' alt='Modificar' style='width:42px;height:42px;'></a></td>";
            echo"<td class=$class><a href='borrarprofesor.php?id=".$array['DNI']."&estado=".$array['Activado']."'><img src=$src alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
            
        }
        echo "</tbody>";
        echo "</table>";  
        
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=administracion.php" />';
    }
          
}


//función que recoge datos de formulario y crea nueva entrada en base de datos
function añadirProfesor($dni,$email,$nom,$cognoms,$titol,$password) {
    try {
        $conn = conectar();
        $filename = $_FILES['Foto']['name'];
        $destination = 'professors/'.$filename;
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file = $_FILES['Foto']['tmp_name'];
        $size = $_FILES['Foto']['size'];

        if ($_FILES['Foto']['size'] > 16000000) { // Tamaño maximo = 16MB
            echo "<p class=fallo>El archivo es muy grande!</p>";
            echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
        } 
        else {
                
            if (move_uploaded_file($file, $destination)) {

                $query = "INSERT INTO professors VALUES ('$dni','$email','$nom','$cognoms','$titol','$destination','".md5($password)."','1')";
                mysqli_query($conn,$query);
                echo "<p class=añadir>Profesor añadido correctamente</p>";
                echo "<meta http-equiv=refresh content='2; url=profesores.php'>";

                
                

            } 
            else {

                echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
                echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
        
            }
        }
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
    }
        
}


//función que recibe dni y estado de profesor, modifica el estado 
function borrarProfesor($dni,$estado) {
    try {
        $conn = conectar();
        if ($estado == 1) {

            $query = "UPDATE professors SET Activado = '0' WHERE DNI = '$dni'";
            mysqli_query($conn,$query);
            echo "<p class=exito>Profesor desactivado con éxito</p>";
            echo "<meta http-equiv=refresh content='2; url=profesores.php'>";
    
        }
        else if ($estado == 0) {

            $query = "UPDATE professors SET Activado = '1' WHERE DNI = '$dni'";
            mysqli_query($conn,$query);
            echo "<p class=exito>Profesor activado con éxito</p>";
            echo "<meta http-equiv=refresh content='2; url=profesores.php'>";
        
        }
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
    }
    

}

//función que recibe el nombre de un buscador y genera búsqueda en la base de datos
function buscarCursos($nombre) {
    try {
        $conn = conectar();
        $query = "SELECT * FROM cursos WHERE Nom LIKE '$nombre%'";
        $result = $conn->query($query);
        
        if (mysqli_num_rows($result) != 0) {
            mostrarColumnasCursos();
            echo "<th>Modificar</th>";
            echo "<th>Act./Desact.</th>";
            echo "</thead>";
            echo "<tbody>";
            while($array = $result-> fetch_array(MYSQLI_ASSOC)) {
            
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
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=administracion.php" />';
    }
    
}

//función que recibe el nombre de un buscador y genera búsqueda en la base de datos
function buscarProfesores($nombre) {
    try {
        $conn = conectar();
        $query = "SELECT * FROM professors WHERE Nom LIKE '$nombre%'";
        $result = $conn->query($query);
        if (mysqli_num_rows($result) != 0) {

            mostrarColumnasProfesores();
            echo "</thead>";
            echo "<tbody>";
            while($array = $result-> fetch_array(MYSQLI_ASSOC)) {

                echo "<tr>"; 
                foreach ($array as $field_name => $value) {

                    if($field_name != "Password") {

                        if($field_name == "Foto") {
                                
                            echo "<td><img src=".$array['Foto']." alt=".$array['Foto']." style='width:50px;height:40px;'></img></td>";

                        }

                        else if($field_name == "Activado") {

                            if($value == 1) {

                                $src = "img/tick.png";
                                $class = "activado";

                            }
                            else if($value == 0) {

                                $src = "img/cross.png";
                                $class = "desactivado";
                            }

                        }
                        else {

                            echo "<td>$value</td>";

                        }

                    }
                        
                }

                echo"<td><a href='modificarprofesor.php?id=".$array['DNI']."'><img src='img/pencil.png' alt='Modificar' style='width:42px;height:42px;'></a></td>";
                echo"<td class=$class><a href='borrarprofesor.php?id=".$array['DNI']."'><img src=$src alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
                    
                }

                echo "</tbody>";
                echo "</table>";  

        }

        else {

            echo "No hay resultados para esta búsqueda :(";

        }
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=administracion.php" />';
    }
    
}

//función que llama a la modificación de un profesor con su dni
function modificarProfesor($dni) {
    try {
        $conn = conectar();
    
        if(isset($_POST['Nom'])) {

            foreach($_POST as $field_name => $value) {

                if($value != "") {
        
                    $query = "UPDATE professors SET $field_name = '$value' WHERE DNI = '$dni'";   
                    mysqli_query($conn,$query);
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
                            $query = "UPDATE professors SET Foto = '$destination' WHERE DNI = '$dni'";
                            mysqli_query($conn,$query);
                        } 
                        else {
                
                            echo "<p class=fallo>Hubo un fallo al subir el archivo.</p>";
                            echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                    
                        }
                    } 
        
                }

            }
            echo "<p class=modificar>Datos modificados correctamente</p>";
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
                <input type="text" id="modify" name="Nom" placeholder = "<?php echo $profesor['Nom']; ?>" ><br/>
            <label for="Cognoms">Cognoms: 
                <input type="text" id="modify" name="Cognoms" placeholder = "<?php echo $profesor['Cognoms']; ?>" ><br/>
            <label for="Titol_Academic">Titol Acadèmic: 
                <input type="text" id="modify" name="Titol_Academic" placeholder = "<?php echo $profesor['Titol_Academic']; ?>" ><br/>
            <label for="mod_foto">Modificar: 
                <input type="checkbox" id="Foto" name="Foto" onclick="modificarFoto()" ><br/>
            Foto actual: <img src="<?php echo $profesor['Foto']; ?>" style='width:50px;height:40px;'></img><br/>
                <div id="divFoto"></div>
                <button type="submit">Modificar</button>
            </form>
        
                
                <?php
                }
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=profesores.php" />';
    }
        
    
}

//función que recibe el email de la sesión activa, lista los cursos del alumno
function listarCursosDisponibles($email) {
    try {
        $conn = conectar();
        $query = "SELECT Codi,Nom,Descripcio,Hores_Duracio,Data_Inici,Data_Final FROM cursos WHERE Activado = 1";
        $result = mysqli_query($conn,$query);
        $today = date("Y-m-d");
        echo "<div class=cursos>";
        while($array = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            echo "<table cellspacing=0>";
            echo "<tbody>";
            $fechaInicio = date("d/m/Y", strtotime($array["Data_Inici"]));
            $fechaFinal = date("d/m/Y", strtotime($array["Data_Final"]));
            echo "<tr>"; 
            echo "<td class=nombre>".$array['Nom']."</td>";
            echo "</tr>";
            echo "<tr>"; 
            echo "<td>".$array['Descripcio']."</td>";
            echo "</tr>";
            echo "<tr>"; 
            echo "<td>Hores totals: ".$array['Hores_Duracio']."</td>";
            echo "</tr>";
            echo "<tr>"; 
            echo "<td>Data Inici - Final: $fechaInicio - $fechaFinal</td>";
            echo "</tr>";  

            $query = "SELECT DNI FROM alumnes WHERE Email = '$email'"; 
            $row = mysqli_fetch_row(mysqli_query($conn,$query));
            $dni = $row[0];
            $query = "SELECT * FROM matricula WHERE DNI = '$dni' AND Codi = '".$array['Codi']."' ";
            if(mysqli_num_rows(mysqli_query($conn,$query)) == 0) {

                if($array['Data_Inici'] > $today) {
                    echo "<td class=info> <a href=matricularse.php?codi=".$array['Codi']." > <img src='img/matricula.png' style='width:42px;height:42px;'> </img></a>Matrículate ahora </td>";
                } 
                else {
                    echo "<td class=info>El curso ya ha comenzado</td>";
                }
                
            }
            else if(mysqli_num_rows(mysqli_query($conn,$query)) == 1) {

                if($array['Data_Final'] > $today) {
                    echo "<td> <a href=desmatricularse.php?codi=".$array['Codi']." > <img src='img/cross.png' style='width:42px;height:42px;'> </img></a>Desmatricularse </td>";
                }
                else {
                    echo "<td class=info>Curso finalizado.</td>";
                }

            }
        }
        echo "</div>";
            
        echo "</tbody>";
        echo "</table>";  
    
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    }
    
}

//función que recibe código de curso y email de sesión activa, genera nueva relación en base de datos
function matricularse($codi,$email) {
    try {
        $conn = conectar();
        $query = "SELECT DNI FROM alumnes WHERE Email = '$email'";
        $result = mysqli_query($conn,$query);

        //recogemos la fila que sale para tener el dni
        $row = mysqli_fetch_row($result);
        $query = "INSERT INTO matricula VALUES('".$row[0]."','$codi',NULL)";
        mysqli_query($conn,$query);
        echo '<meta http-equiv="refresh" content="0;url=inicioalumnos.php" />';
    
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    }
   
    


}

//función que recibe código de curso y email de sesión activa, borra relación en base de datos
function desmatricularse($codi,$email) {
    try {
        $conn = conectar();
        $query = "SELECT DNI FROM alumnes WHERE Email = '$email'";
        $result = mysqli_query($conn,$query);
            
            //recogemos la fila que sale para tener el dni
            $row = mysqli_fetch_row($result);
            $query = "DELETE FROM matricula WHERE DNI = '".$row[0]."' AND Codi = '$codi' ";
            mysqli_query($conn,$query);
            echo '<meta http-equiv="refresh" content="0;url=inicioalumnos.php" />';
        
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    }
    
}

//función sin parámetros, genera formulario para modificar alumno y modifica entrada existente en la base de datos
function modificarAlumno() {
    try {
        $conn = conectar();
        $email = $_SESSION['email'];
        if(isset($_POST['Nom'])) {
            
            foreach($_POST as $field_name => $value) {

                if($value != "") {
        
                    $query = "UPDATE alumnes SET $field_name = '$value' WHERE Email = '$email'";   
                    mysqli_query($conn,$query);
        
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
                            mysqli_query($conn,$query);
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
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';
    }
    
}  




//recibe email de sesión activa, accede a base de datos y lista cursos en los que hay matrícula
function listarCursosMatriculados($email) {
    try {
        $conn = conectar();
        $query = "SELECT DNI FROM alumnes WHERE Email = '$email'";
        $result = mysqli_query($conn,$query);
        
        //recogemos la fila que sale para tener el dni
        $row = mysqli_fetch_row($result);
        $query = "SELECT c.Codi,c.Nom,c.Descripcio,c.Hores_Duracio,c.Data_Inici,c.Data_Final,c.DNI,m.Nota FROM matricula m INNER JOIN cursos c ON m.Codi = c.Codi WHERE m.DNI = '".$row['0']."' ";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) == 0) {

            echo "<h2>Vaya, parece que no estás matriculado en ningún curso :(";    

        }
        else {
            echo "<div class=cursos>";
            while($array = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                echo "<table cellspacing=0>";
                echo "<tbody>";
                $fechaInicio = date("d/m/Y", strtotime($array["Data_Inici"]));
                $fechaFinal = date("d/m/Y", strtotime($array["Data_Final"]));
                echo "<tr>"; 
                echo "<td class=nombre>".$array['Nom']."</td>";
                echo "</tr>";
                echo "<tr>"; 
                echo "<td>".$array['Descripcio']."</td>";
                echo "</tr>";
                echo "<tr>"; 
                echo "<td>Hores totals: ".$array['Hores_Duracio']."</td>";
                echo "</tr>";
                echo "<tr>"; 
                echo "<td>Data Inici - Final: $fechaInicio - $fechaFinal</td>";
                echo "</tr>"; 

                if($array['Data_Final'] < date("Y-m-d")) {
                    echo "<tr>"; 
                    echo "<td>".$array['Nota']."</td>";
                    echo "</tr>"; 
                }
                else {
                    echo "<tr>"; 
                    echo "<td> No disponible </td>";
                    echo "</tr>"; 
                }
                
            
            }
            echo "</div>";

        }

        
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=inicioalumnos.php" />';
    }
    

}

//función que recibe email de profesor activo y lista sus cursos accediendo a base de datos
function listarCursosProfesor($email) {

    try {
        $conn = conectar();
        $query = "SELECT DNI FROM professors WHERE Email = '$email'"; 
        $dni = mysqli_fetch_array(mysqli_query($conn,$query),MYSQLI_NUM)[0];
        $today = date("Y-m-d");
        $query = "SELECT Codi,Nom,Descripcio,Data_Inici,Data_Final FROM cursos WHERE DNI = '$dni'";
        $result = mysqli_query($conn,$query);
        echo "<div class=cursos>";
        while($array = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            echo "<table cellspacing=0 class=curso>";
            echo "<tbody>";
            $fechaInicio = date("d/m/Y", strtotime($array["Data_Inici"]));
            $fechaFinal = date("d/m/Y", strtotime($array["Data_Final"]));
            echo "<tr>"; 
            echo "<td class=nombre>".$array['Nom']."</td>";
            echo "</tr>";
            echo "<tr>"; 
            echo "<td>".$array['Descripcio']."</td>";
            echo "</tr>";
            echo "<tr>"; 
            echo "<td>Data Inici - Final: $fechaInicio - $fechaFinal</td>";
            echo "</tr>";  
            if($array['Data_Final'] < $today) {
                    echo "<tr>";
                    echo "<td><b>Curso finalizado. Ya puedes poner notas.</b></td>";
                    echo "</tr>"; 
                

            }
            echo "<tr>";
            echo "<td><a class=enlace href=listadoalumnos.php?codi=".$array['Codi']."&nombre=".urlencode($array['Nom']).">Ver listado de alumnos</a></td>";
            echo "<tr>";
            echo "</table>";
        }   
        echo "</div";

    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
    }
    
            

        
}

//funcion que recibe email de profesor activo y código de curso y lista los alumnos de ese curso
function listarAlumnos($email,$codi) {

    

    try {
        $conn = conectar();
        $query = "SELECT DNI FROM professors WHERE Email = '$email'"; 
        $result = mysqli_query($conn,$query);
        $dni = mysqli_fetch_array($result,MYSQLI_NUM)[0];
        $today = date("Y-m-d");
        $query = " SELECT a.Nom,a.Cognoms,a.DNI,a.Foto,c.Codi,c.Data_Final,m.Nota FROM alumnes a INNER JOIN matricula m ON a.DNI = m.DNI INNER JOIN cursos c ON m.Codi = c.Codi WHERE c.DNI = '$dni' AND c.Codi = '$codi'";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) > 0) {
            echo "<div class=alumnos>";
            while($array = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                echo "<table cellspacing=0>";
                echo "<tbody>";
                
                echo "<tr>"; 
                echo "<td class='nombre'>".$array['Nom']." ".$array['Cognoms']."</td>";
                echo "<tr>"; 
                echo "<tr>"; 
                echo "<td>".$array['DNI']."</td>";
                echo "</tr>"; 
                echo "<td><img src=".$array['Foto']." style='width:100px;height:100px;'></img></td>";
                echo "</tr>"; 
                if($array['Data_Final'] < $today) {
                    if(is_null($array['Nota'])) {
                        echo "<tr>"; 
                        echo "<td>Poner nota <a href=ponernota.php?codi=".$array['Codi']."&id=".$array['DNI']." > <img src='img/nota.png' style='width:60px;height:60px;'> </img></a> </td>";
                        echo "</tr>"; 
                    }
                    else {
                        echo "<tr>"; 
                        echo "<td class=nota>Nota actual: ".$array['Nota']."</td>";
                        echo "</tr>"; 
                        echo "<tr>";
                        echo "<td>Modificar nota<a href=ponernota.php?codi=".$array['Codi']."&id=".$array['DNI']." > <img src='img/nota.png' style='width:60px;height:60px;'> </img></a></td>";
                        echo "</tr>"; 
                    }
    
                }
                else {
                    echo "<tr>"; 
                    echo "<td>Nota no disponible</td>";
                    echo "</tr>"; 
                }
                echo "</tbody>";
                echo "</table>";
            }
            echo "</div>"; 
            
        }
        else {
            echo "<p class=noresult> Vaya, parece que no hay ningún alumno inscrito todavía :(";
        }
        
        
        
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>";
        echo '<meta http-equiv="refresh" content="2;url=inicioprofesores.php" />';
    }
    
    

}

//función que recibe código de curso, dni de alumno y nota, modifica o crea nota en base de datos
function ponerNota($codi,$dni,$nota) {

    
    try {
        $conn = conectar();
        $query = "UPDATE matricula SET Nota = '$nota' WHERE DNI = '$dni' AND Codi = '$codi'";
        mysqli_query($conn,$query);
        echo "<p class=exito>Nota puesta correctamente</p>";
        echo '<meta http-equiv="refresh" content="2;url=inicioprofesores.php" />';
    } catch(Exception $ex) {
        echo "<p class=errorsql>Fallo al ejecutar la consulta</p>"; 
        echo '<meta http-equiv="refresh" content="2;url=inicioprofesores.php" />';
    }

}

?>