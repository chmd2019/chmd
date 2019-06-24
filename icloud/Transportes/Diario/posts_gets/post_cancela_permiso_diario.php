<?php
include_once './Control_dia.php';
$control = new Control_dia();
$id = htmlspecialchars($_POST['id_permiso_diario']);
if ($respuesta = $control->cancela_permiso_diario($id)) {
    echo true;
    return;
}
echo false;
?>
