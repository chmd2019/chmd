<?php
include '../../conexion.php';

if (isset ( $_POST ['remove'] )){
  $remove = $_POST['remove'];
  $id_permiso_alumno = $_POST ['id_permiso_alumno'];
  $isOk='0';

  if ($remove==1) {

    $sql = "UPDATE Ventana_permisos_alumnos SET estatus=3 WHERE id=$id_permiso_alumno LIMIT 1";
    $update=mysqli_query ( $conexion, $sql );
    if (!$update){
      //No actualizo
      die("error:" . mysqli_error($conexion));
      $isOk= '-1';
    }
/**fin */
  }
  $reply = json_encode ( array ("estatus" => $isOk) );
  echo $reply;
}
 ?>
