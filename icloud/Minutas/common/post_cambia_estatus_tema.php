<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
$estatus = htmlspecialchars(trim($_POST['estatus']));
$id_tema = htmlspecialchars(trim($_POST['id_tema']));

$res = mysqli_fetch_array($controlMinutas->actualiza_catalogo_estatus($estatus, $id_tema))[0];
if (strlen($res) > 0) {
    echo json_encode(array("res" => true, "color" => $res));
    return;
}
echo json_encode(false);
