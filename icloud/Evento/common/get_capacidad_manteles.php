<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();
$id_lugar_evento = $_GET['id_lugar'];
$fecha_evento = $_GET['fecha_montaje_simple'];
$horario_evento = $_GET['horario_evento'];
$horario_final_evento = $_GET['horario_final_evento'];

$equipo_tecnico = $control->obtener_capacidad_manteles($id_lugar_evento, $horario_evento, $horario_final_evento, $fecha_evento);
$respuesta = array();

while ($row = mysqli_fetch_array($equipo_tecnico)) {
    array_push($respuesta, [
        "id" => $row[0],
        "articulo" => $row[1],
        "capacidad" => $row[2],
        "asignado" => $row[3],
        "disponible" => $row[4],
        "ruta_img" => $row[5]
    ]);
}

echo json_encode($respuesta);  