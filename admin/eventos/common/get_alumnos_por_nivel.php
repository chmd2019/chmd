<?php
include '../../sesion_admin.php';
require '../../conexion.php';
$id_nivel = $_GET['nivel'];
$id_permiso = $_GET['id_permiso'];

$query = mysqli_query($conexion,"SELECT COUNT(*) as nalumnos
FROM Ventana_permisos_alumnos vpa
INNER JOIN alumnoschmd ac ON ac.id = vpa.id_alumno and ac.id_nivel = '$id_nivel'
WHERE vpa.id_permiso='$id_permiso'");

if ($usuario =   mysqli_fetch_assoc ( $query ) ){
  $nalumnos = $usuario['nalumnos'];
}
$reply = json_encode(array("nalumnos"=> $nalumnos));
echo $reply;
 ?>
