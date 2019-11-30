<?php
include '../../conexion.php';

$id_permiso = $_POST['id_permiso'];
$id_alumno = $_POST['id_alumno'];

$sql = "DELETE FROM Ventana_permisos_alumnos WHERE id_permiso ='$id_permiso' && id_alumno = '$id_alumno'";

$cancelado = mysqli_query($conexion, $sql);
if ($cancelado) {
    echo json_encode( array("estatus"=>true));
    return;
}
echo json_encode(array("estatus"=>false));
return;
?>
