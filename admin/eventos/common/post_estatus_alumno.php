<?php
require '../../conexion.php';
$idpermiso_alumno = $_POST['id_permiso_alumno'];
$estatus= $_POST['estatus'];
//alumnos
$isgood=true;
$sql="UPDATE Ventana_permisos_alumnos SET estatus='$estatus' WHERE id= '$idpermiso_alumno';";
$insertar = mysqli_query($conexion, $sql);
if (!$insertar) {
  die("error:" . mysqli_error($conexion));
  //    echo "Registro fallido";
  $isgood=false;
}
echo $isgood;

 ?>
