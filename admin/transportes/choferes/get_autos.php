<?php
require '../../conexion.php';
$nfamilia = $_GET['nfamilia'];
$array_autos= array();
$sql = mysqli_query ( $conexion, "SELECT * from tarjeton_automoviles where idfamilia=$nfamilia and estatus=2 limit 2" );
  while ( $auto = mysqli_fetch_assoc ( $sql ) ){
    $marca= $auto['marca'];
    $submarca= $auto['submarca'];
    $modelo= $auto['modelo'];
    $color= $auto['color'];
    $placa= $auto['placa'];
    $tarjeton = $auto['idtarjeton'];

    array_push($array_autos,"$marca|$modelo|$color|$placa|$tarjeton|$submarca");
  }
$set_autos = implode('!', $array_autos);
#texto
echo $set_autos;
 ?>
