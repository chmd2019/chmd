<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();

$nuevo_tema = $_POST['nuevo_tema'];
$nuevo_acuerdo = $_POST['nuevo_acuerdo'];
$id_minuta = $_POST['id_minuta'];
$id_comite = $_POST['id_comite'];

$res = $controlMinutas->adicionar_nuevo_tema($nuevo_tema, $id_comite, $id_minuta,$nuevo_acuerdo);
echo json_encode($res);