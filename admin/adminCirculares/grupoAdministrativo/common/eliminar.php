<?php


include '../../../conexion.php';

$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

$id = $_GET["id"];

if($connection){

    $sql = "DELETE FROM App_grupos_administrativos WHERE id=$id";
    mysqli_set_charset($connection, "utf8");
    $eliminar = mysqli_query($connection, $sql);
    if (!$eliminar) {
      die("error:" . mysqli_error($connection));
      echo "No se borró ". mysqli_error($connection);
      $isgood=false;
    }else{
        header("Location: ../PGruposAdministrativos.php");  
    }

}