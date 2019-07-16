<?php
require '../conexion.php';
$nfamilia = $_GET['nfamilia'];
$array_autos= array();
$sql = mysqli_query ( $conexion, "SELECT * from Ventana_autos where idfamilia=$nfamilia limit 2" );
  while ( $auto = mysqli_fetch_assoc ( $sql ) ){
    $marca= $auto['marca'];
    $modelo= $auto['modelo'];
    $color= $auto['color'];
    $placa= $auto['placas'];

    array_push($array_autos,"$marca|$modelo|$color|$placa");
  }
$set_autos = implode('!', $array_autos);
#texto
echo $set_autos;
 ?>
