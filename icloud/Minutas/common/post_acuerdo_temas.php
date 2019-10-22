<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
$acuerdos = htmlspecialchars(trim($_POST['acuerdos']));
$id_tema = htmlspecialchars(trim($_POST['id_tema']));
$id_minuta = htmlspecialchars(trim($_POST['id_minuta']));
$res = mysqli_fetch_array($controlMinutas->guardar_acuerdo_tema($acuerdos, $id_minuta, $id_tema))[0];
if (strlen($res) > 0) {
    echo json_encode(array("res" => true, "acuerdos" => $res));
    return;
}
echo json_encode(array("res" => false));
