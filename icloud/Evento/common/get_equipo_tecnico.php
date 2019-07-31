<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$equipo_tecnico = $control->obtener_equipo_tecnico();
$respuesta = array();

while ($row = mysqli_fetch_array($equipo_tecnico)) {
    array_push($respuesta, [
        "id" => $row[0],
        "articulo" => $row[1],
        "inventario" => $row[2],
        "asignado" => $row[3],
        "disponible" => $row[4]
    ]);
}

echo json_encode($respuesta);