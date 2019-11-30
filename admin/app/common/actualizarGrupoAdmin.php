<?php
include '../../sesion_admin.php';
include '../../conexion.php';
$descrip = $_POST["descrip"];
$grupo =  $_POST["grupo"];
$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 


$grupo = $_POST["grupo"];
$descripcion = $_POST["descrip"];
$id = $_POST["id"];
if($connection){
    //Comando de insercion
    $sql = "UPDATE App_grupos_administrativos SET grupo='$grupo', descripcion='$descripcion', updated_at=CURDATE() WHERE id=$id";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
      die("error:" . mysqli_error($connection));
      echo "No se insertó ". mysqli_error($connection);
      $isgood=false;
    }else{
        header("Location: ../PGruposAdministrativos.php");  
    }

}