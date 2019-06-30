<?php
include_once './ControlTransportes.php';
$control = new ControlTransportes();
$id = htmlspecialchars($_POST['id_permiso']);
if ($control->cancela_permiso($id)) {
    echo true;
    return;
}
echo false;
?>
