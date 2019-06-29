<?php
require 'conexion.php';
$id_permiso = $_GET['id'];
//alumnos
$array_alumnos= array();
$alumnos= mysqli_query($conexion,"SELECT * FROM Ventana_permisos_alumnos where id_permiso='$id_permiso'");
while($id_alumno = mysqli_fetch_assoc ( $alumnos ) ){
  $alu=$id_alumno['id_alumno'];
  //Consulto la base de datos
  $alumnos2 = mysqli_query($conexion, "SELECT nombre, grupo, grado FROM alumnoschmd WHERE id=$alu");
  while ($alumno = mysqli_fetch_assoc( $alumnos2 ) ){
     $nombre = $alumno['nombre'];
     $grupo = $alumno['grupo'];
     $grado = $alumno['grado'];
     // dento de alumnos nombre|grado|grupo.
     array_push($array_alumnos, "$nombre|$grupo|$grado");
  }
}
$set_alumnos = implode('!', $array_alumnos);

#texto

echo $set_alumnos;
 ?>
