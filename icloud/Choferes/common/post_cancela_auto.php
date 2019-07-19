<?php
include_once './ControlChoferes.php';
$control = new ControlChoferes();
$id = htmlspecialchars($_POST['id_auto']);
if ($control->cancelar_auto($id)) {
    echo true;
    return;
}
echo false;
?>
