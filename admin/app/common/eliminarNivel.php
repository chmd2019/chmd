<?php
include '../../sesion_admin.php';
include '../../conexion.php';
$idNivel = $_POST["id"];
$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

if($connection){
    //Comando de insercion
    $sql = "DELETE FROM Catalogo_nivel WHERE id=$idNivel";
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

?>