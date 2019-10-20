<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
$id_tema = $_GET['id_tema'];

echo json_encode(mysqli_fetch_array($controlMinutas->consulta_acuerdo($id_tema))[0]);