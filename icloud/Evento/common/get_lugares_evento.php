<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$lugares = $control->obtener_lugares_evento();
$respuesta = array();

while ($row = mysqli_fetch_array($lugares)) {
    array_push($respuesta, ["id"=>$row[0],"descripcion"=>$row[1],"patio"=>$row[2]]);
}

echo json_encode($respuesta);