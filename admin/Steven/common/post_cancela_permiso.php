<?php
include_once './ControlEspecial.php';
$control = new ControlEspecial();
$id = htmlspecialchars($_POST['id_permiso']);
if ($control->cancela_permiso($id)) {
    echo true;
    return;
}
echo false;
?>
