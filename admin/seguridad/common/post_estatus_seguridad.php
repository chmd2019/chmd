<?php
require '../../conexion.php';

$id_permiso_alumno = $_POST['id_permiso_alumno'];

$query  = mysqli_query($conexion,"SELECT estatus_seguridad FROM  Ventana_permisos_alumnos where id='$id_permiso_alumno'");
if ($r  = mysqli_fetch_array($query) ){
    $estatus_seguridad = $r['estatus_seguridad'];

    switch ($estatus_seguridad) {
      case '0': $estatus_seguridad ='2';
      break;
      case '1': $estatus_seguridad  = '2';
        // pendiente...
        break;
        case '2': $estatus_seguridad  = '1';
          // autorizado...
          break;

      default:

        $estatus_seguridad  = '2';
        // code...
        break;
    }
$sql = "UPDATE Ventana_permisos_alumnos SET estatus_seguridad= '$estatus_seguridad' WHERE id='$id_permiso_alumno'";
$res =  mysqli_query($conexion, $sql);
$reply= array ("estatus"=>$res, "estatus_seguridad"=> $estatus_seguridad );

echo json_encode($reply);
}

 ?>
