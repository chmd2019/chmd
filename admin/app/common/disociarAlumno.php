<?php
include '../../sesion_admin.php';
include '../../conexion.php';
$idGrupoAsoc = $_POST["idGrupoAsoc"];
$idAlumno = $_POST["idAlumno"];
$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

if($connection){
    //Comando de insercion
    $sql = "DELETE FROM App_grupos_especiales_alumnos WHERE id=$idGrupoAsoc";
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
