<?php
require "./ControlCirculares.php";
$controlCirculares = new ControlCirculares();

if ($controlCirculares->cancelar_circular($_POST['id_circular']) > 0) {
    echo json_encode(true);
    return;
} else {
    echo json_encode(false);
}
