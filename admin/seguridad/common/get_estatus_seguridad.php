<?php
require '../../conexion.php';

$id_permiso_alumno = $_POST['id_permiso_alumno'];

$query  = mysqli_query($conexion,"SELECT estatus_seguridad FROM  Ventana_permisos_alumnos where id='$id_permiso_alumno'");
if ($r  = mysqli_fetch_array($query) ){
    $estatus_seguridad = $r['estatus_seguridad'];
    $reply= array ("estatus_seguridad"=> $estatus_seguridad );
    echo json_encode($reply);
  }
?>
