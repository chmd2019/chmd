<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
$id_tema = $_GET['id_tema'];

$consulta = $controlMinutas->consulta_acuerdo($id_tema);
$acuerdos = array();
while ($row = mysqli_fetch_array($consulta)) {
    array_push($acuerdos, ["acuerdos" => $row[0], "conteo" => $row[2]]);
}
echo json_encode($acuerdos);
