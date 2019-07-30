<?php
include_once './ControlEspecial.php';
$control = new ControlEspecial();
$id = htmlspecialchars($_POST['id_permiso']);
if ($control->cancela_inscripcion_evento($id)) {
    echo true;
    return;
}
echo false;
?>
