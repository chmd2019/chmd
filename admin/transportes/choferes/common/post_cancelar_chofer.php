<?php
include '../../../conexion.php';
$connection = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($connection, $db );
$tildes = $connection->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
/** Configuracion Previa **/

if ($connection && isset($_POST['id_chofer'])){
  $id_chofer = $_POST['id_chofer'];
  $sql = "UPDATE usuarios SET estatus = 4 WHERE id ='$id_chofer'";
  mysqli_set_charset($connection, 'utf8');
  mysqli_query($connection, $sql);

  echo 1;
  return;
}

echo 0;
?>
