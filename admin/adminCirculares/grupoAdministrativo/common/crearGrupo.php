<?php


include '../../../conexion.php';

$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

$grupo = $_POST["grupo"];
$descripcion = $_POST["descrip"];
if($connection){
    //Comando de insercion
    $sql = "INSERT INTO App_grupos_administrativos(grupo,descripcion,created_at,updated_at) VALUES('$grupo','$descripcion',CURDATE(),CURDATE())";
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