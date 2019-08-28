<?php
include_once './ControlChoferes.php';
$control = new ControlChoferes();
$id = htmlspecialchars($_POST['id_chofer']);
if ($control->renovar_chofer($id)) {
    echo true;
    return;
}
echo false;
?>
