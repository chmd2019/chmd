<?php

include_once './ControlEspecial.php';

$control = new ControlEspecial();

$id_permiso = $_POST['id_permiso'];
$id_alumno = $_POST['id_alumno'];

$cancelado = $control->cancela_inscripcion_evento_alumno($id_permiso, $id_alumno);
if ($cancelado) {
    echo json_encode(true);
    return;
}
echo json_encode(false);
return;
?>

