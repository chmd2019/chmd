<?php
include '../../sesion_admin.php';
require '../../conexion.php';
$id_usuario = $_GET['id_usuario'];
$sql = mysqli_query($conexion,"SELECT nombre,tipo,responsable FROM usuarios where id='$id_usuario' limit 1");
if ($usuario =   mysqli_fetch_assoc ( $sql ) ){
  $nombre = $usuario['nombre'];
  $tipo = $usuario['tipo'];
  $responsable = $usuario['responsable'];
}
$reply = json_encode(array("nombre"=> $nombre, "tipo"=>$tipo, "responsable"=>$responsable));
echo $reply;
?>
