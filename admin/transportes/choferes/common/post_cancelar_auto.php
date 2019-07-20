<?php
include '../conexion.php';
$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
/** Configuracion Previa **/

if ($connection  && isset($_POST['id_auto'])){
  $id_auto = $_POST['id_auto'];
  $sql = "DELETE FROM Ventana_autos WHERE idcarro ='$id_auto'";
   mysqli_set_charset($connection, 'utf8');
   mysqli_query($connection, $sql);

  echo 1;
  return;
}

echo  0;
?>
