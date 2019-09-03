<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$hora_inicial = $_GET['hora_inicial'];
$hora_final = $_GET['hora_final'];
$fecha_consulta = $_GET['fecha_consulta'];
$id_montaje = $_GET['id_montaje'];

$res = array();

if (isset($_GET['mobiliario'])) {
    $data = $control->consulta_disponibilidad_mobiliario($hora_inicial, $hora_final, $fecha_consulta, $id_montaje);
    while ($row = mysqli_fetch_array($data)) {
        array_push($res, ["id_articulo" => $row[0], "disponibilidad" => $row[1]]);
    }
    echo json_encode($res);
    return;
}

if (isset($_GET['manteles'])){
    $data = $control->consulta_disponibilidad_manteles($hora_inicial, $hora_final, $fecha_consulta, $id_montaje);
    while ($row = mysqli_fetch_array($data)) {
        array_push($res, ["id_articulo" => $row[0], "disponibilidad" => $row[1]]);
    }
    echo json_encode($res);
    return;
}
