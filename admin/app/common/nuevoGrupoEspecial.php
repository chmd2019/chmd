<?php
include '../../sesion_admin.php';
include '../../conexion.php';
$grupo = $_POST["grupo"];
$descrip = $_POST["descrip"];
$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); 

if($connection){
    //Comando de insercion
    $sql = "INSERT INTO App_grupos_especiales(grupo,descripcion,created_at) VALUES('$grupo','$descrip',CURDATE())";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
      die("error:" . mysqli_error($connection));
      echo "No se insertó ". mysqli_error($connection);
      $isgood=false;
    }else{
        header("Location: ../PGruposEspeciales.php");  
    }

}

?>