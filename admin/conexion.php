<?php
$host = "132.148.43.14";
$usuario = "sistemas";
$password = "S4st3m4s2019.";
$db = "chmd_sistemas";
// $password = "";
// $db = "escuela";
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'");
?>
