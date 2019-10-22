<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
//datos de sesion
$id_tema = $_POST['id_tema'];
$res = $controlMinutas->preparar_nuevo_tema_pendiente($id_tema);
if ($res > 0) {
    echo json_encode(intval($id_tema));
}