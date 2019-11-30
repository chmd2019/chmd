<?php

require "./ControlCirculares.php";

$controlCirculares = new ControlCirculares();

if ($controlCirculares->actualizar_estado_circular($_POST['estatus'], $_POST['id_circular']) > 0) {
    echo json_encode(true);
    return;
} else {
    echo json_encode(false);
}
