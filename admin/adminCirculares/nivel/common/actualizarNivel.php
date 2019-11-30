<?php


include '../../../conexion.php';

$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

$nivel = $_POST["nnivel"];
$id = $_POST["id"];
if($connection){
    //Comando de insercion
    $sql = "UPDATE Catalogo_nivel SET nivel='$nivel' WHERE id=$id";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
      die("error:" . mysqli_error($connection));
      echo "No se insertó ". mysqli_error($connection);
      $isgood=false;
    }else{
        header("Location: ../PNivel.php");  
    }

}