<?php
require '../../conexion.php';
$id_permiso = $_GET['id'];
//alumnos
$array_alumnos= array();
$alumnos= mysqli_query($conexion,"SELECT id_alumno,hora_salida, hora_regreso, regresa, estatus  FROM Ventana_permisos_alumnos where id_permiso='$id_permiso'");
while($id_alumno = mysqli_fetch_assoc ( $alumnos ) ){
  $alu=$id_alumno['id_alumno'];
  $hora_salida = $id_alumno['hora_salida'];
  $hora_regreso=$id_alumno['hora_regreso'];
  $regresa= $id_alumno['regresa'];
  $estatus= $id_alumno['estatus'];
  //Consulto la base de datos
  $alumnos2 = mysqli_query($conexion, "SELECT nombre,nivel FROM alumnoschmd WHERE id=$alu limit 1;");
  if ($alumno = mysqli_fetch_assoc( $alumnos2 ) ){
     $nombre = $alumno['nombre'];
     $nivel = $alumno['nivel'];
     // dento de alumnos nombre|grado|grupo.
  }
  array_push($array_alumnos, "$nombre|$hora_salida|$hora_regreso|$regresa|$estatus|$nivel");
}
$set_alumnos = implode('!', $array_alumnos);

#texto

echo $set_alumnos;
 ?>
