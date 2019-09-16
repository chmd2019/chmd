<?php

include_once './ControlEspecial.php';
$control = new ControlEspecial();
$id_alumno = htmlspecialchars($_POST['id_alumno']);
$id_permiso = htmlspecialchars($_POST['id_permiso']);
$res = $control->cancelar_alumno_x_alumno($id_permiso, $id_alumno);
echo json_encode($id_alumno);
?>
