<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();
$id_lugar_evento = $_GET['id_lugar_evento'];

$inventario = $control->obtener_inventarios_montaje($id_lugar_evento);

$respuesta = array();

while ($row = mysqli_fetch_array($inventario)) {
    array_push($respuesta, [
        "id" => $row[0],
        "lugar" => $row[1],
        "articulo" => $row[2],
        "inventario" => $row[3],
        "disponible" => $row[4],
    ]);
}

echo json_encode($respuesta);

