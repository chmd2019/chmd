<?php
require '../../conexion.php';
$id_permiso = $_GET['id'];
//alumnos
$array_alumnos= array();
$alumnos= mysqli_query($conexion,"SELECT * FROM Ventana_permisos_alumnos where id_permiso='$id_permiso'");
while($id_alumno = mysqli_fetch_assoc ( $alumnos ) ){
  $id_permiso_alumno=$id_alumno['id'];
  $alu= $id_alumno['id_alumno'];
  $estatus = $id_alumno['estatus'];
  $estatus_seguridad= $id_alumno['estatus_seguridad'];
  //Consulto la base de datos
  $alumnos2 = mysqli_query($conexion, "SELECT nombre, grupo, grado, id_nivel FROM alumnoschmd WHERE id=$alu");
  while ($alumno = mysqli_fetch_assoc( $alumnos2 ) ){
     $nombre = $alumno['nombre'];
     $grupo = $alumno['grupo'];
     $grado = $alumno['grado'];
     $nivel = $alumno['id_nivel'];
     //dento de alumnos nombre|grado|grupo.
     array_push($array_alumnos, "$nombre|$grupo|$grado|$id_permiso_alumno|$estatus|$nivel|$estatus_seguridad");
  }
}
$set_alumnos = implode('!', $array_alumnos);

#texto

echo $set_alumnos;
 ?>
