<?php
/* Produccion
$host = "132.148.43.14";
$usuario = "sistemas";
$password = "S4st3m4s2019.";
$db = "chmd_sistemas";
*/

$host = "72.167.210.176";
$usuario = "icloud";
$password = "Icloud2019.";
$db = "icloud";

// $password = "";
// $db = "escuela";
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'");
date_default_timezone_set('America/Mexico_city');
?>
