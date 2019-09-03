<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$hora_inicial =  $_GET['horario_evento'];
$hora_final = $_GET['horario_final_evento'];
$id_lugar = $_GET['id_lugar'];
$fecha_montaje = $_GET['fecha_montaje'];
$id_evento = $_GET['id_evento'];

if (isset($_GET['edicion_montaje'])) {
    $disponibilidad = $control->consulta_disponibilidad_lugar_edicion($hora_inicial, $hora_final, $id_lugar, $fecha_montaje);   
    echo json_encode(mysqli_fetch_array($disponibilidad)[0]);
    return;
}
$disponibilidad = $control->consulta_disponibilidad_lugar($hora_inicial, $hora_final, $id_lugar, $fecha_montaje);                       

echo json_encode(mysqli_fetch_array($disponibilidad)[0]);