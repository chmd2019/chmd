<?php
require '../../conexion.php';
$nfamilia = $_GET['nfamilia'];
$array_padres= array();
$sql = mysqli_query ( $conexion," SELECT nombre,correo,tipo FROM usuarios WHERE numero='$nfamilia' " );
  while ( $dato = mysqli_fetch_assoc ( $sql ) ){
    $tipo= $dato['tipo'];
    if ($tipo!='7') {// tipo = 7 indica q es chofer
      $nombre_padres= $dato['nombre'];
      $correo_padres= $dato['correo'];
      array_push($array_padres,"$nombre_padres|$correo_padres|$tipo");
    }
  }
$set_padres = implode('!', $array_padres);
#texto
echo $set_padres;
 ?>
