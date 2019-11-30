<?php
include '../../sesion_admin.php';
include '../../conexion.php';
$idAlumno = $_POST["idAlumno"];
$grupo =  $_POST["cboGrupoEsp"];
$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

if($connection){
    //Comando de insercion
    $sql = "INSERT INTO App_grupos_especiales_alumnos(alumno_id,grupo_id,created_at,updated_at) VALUES('$idAlumno','$grupo',CURDATE(),CURDATE())";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
      die("error:" . mysqli_error($connection));
      echo "No se insertó ". mysqli_error($connection);
      $isgood=false;
    }else{
        header("Location: ../PGrupoEspAsociarAlumno.php?idAlumno=$idAlumno");  
    }

}

?>
