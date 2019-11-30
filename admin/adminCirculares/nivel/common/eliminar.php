<?php


include '../../../conexion.php';

$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

$idnivel = $_GET["id"];

if($connection){
    //Comando de insercion
    $sql = "DELETE FROM Catalogo_nivel WHERE id=$idnivel";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
      die("error:" . mysqli_error($connection));
      echo "No se borró ". mysqli_error($connection);
      $isgood=false;
    }else{
        header("Location: ../PNivel.php");  
    }

}