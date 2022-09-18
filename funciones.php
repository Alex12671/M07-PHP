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
    $columns = implode(', ',array_keys($dades));
    $values  = implode(', ', array_values($dades));
    echo $columns;
    $query = "INSERT INTO 'infobdn' ($columns) VALUES ($values)";
    if(mysqli_query($conn,$query)) {
        echo "Datos introducidos correctamente";
    }
    else {
        echo "Hubo un error al introducir los datos";
    }

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
          
        } 
    }  
    echo "Datos introducidos correctamente";
    echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
}

function borrarCurso($codi) {
    $conn = conectar();
    $query = "DELETE FROM cursos WHERE Codi = $codi";
    if(!mysqli_query($conn,$query)) {
          
        echo "Fallo al realizar la consulta";
        echo "<meta http-equiv=refresh content='2; url=cursos.php'>";
        
    }
    else {

        echo "Curso borrado con éxito";
        echo "<meta http-equiv=refresh content='2; url=cursos.php'>";

    } 
    
}
  


function mostrarColumnas() {
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
                echo "<th>".$array['Field']."</th>"; 
            }  
            echo "<th>Modificar</th>";
            echo "<th>Eliminar</th>";
        }
  }
  function mostrarCursos() {
          $conn = conectar();
          mostrarColumnas();
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
                    echo "<td>$value</td>";
                }
                echo"<td><a href='modificarcurso.php?Codi=".$array['Codi']."&request=modify'><img src='img/pencil.jpg' alt='Modificar' style='width:42px;height:42px;'></a></td>";
                echo"<td><a href='modificarcurso.php?Codi=".$array['Codi']."&request=erase'><img src='img/cross.jpg' alt='Borrar' style='width:42px;height:42px;'></a></td></tr>";
                
              }
              echo "</tbody>";
              echo "</table>";  
          }
  }
  
function listarProfesores() {
    $conn = conectar();
    $query = "SELECT DNI FROM professors";
    $result = mysqli_query($conn,$query);
    if(!$result) {
          
        echo "Fallo al realizar la consulta";
        
      }
    
    else {
        $dni = mysqli_fetch_row($result);
        echo "<option value=".$dni[0].">".$dni[0]."</option>";
    }
}
?>