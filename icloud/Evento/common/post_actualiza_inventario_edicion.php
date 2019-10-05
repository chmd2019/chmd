<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/vendor/autoload.php";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$fecha_montaje = $_POST['fecha_montaje'];
$hora_inicial = $_POST['hora_inicial'];
$hora_final = $_POST['hora_final'];
$coleccion_inventario = $_POST['coleccion_inventario'];
$id_montaje = $_POST['id_montaje'];
$data = array("actualiza_inventarios" => ["push" => true, "token" => $token]);
//horarios segun disponibilidad establecida, 2 horas antes de la hora inicial y 2 posterior a la hora final
if ($hora_inicial == "00:00:00" || $hora_inicial == "01:00:00") {
    $hora_min = $hora_inicial;
} else {
    $hora_min = date("H:i:s", strtotime($hora_inicial . "-7200 seconds"));
}
if ($hora_final == "22:00:00" || $hora_final == "23:00:00") {
    $hora_max = $hora_final;
} else {
    $hora_max = date("H:i:s", strtotime($hora_final . "+7199 seconds"));
}
$respuesta = null;
foreach ($coleccion_inventario as $value) {
    for ($index = 0; $index < intval($value['cantidad']); $index++) {
        $respuesta = $control->actualizar_inventario_asignado_edicion($id_montaje, $value['id'], $fecha_montaje, $hora_inicial, $hora_final, $hora_min, $hora_max, 1);
    }
}

$timestamp_inventario = mysqli_fetch_array($control->obtener_ultimo_timestamp_inventario($respuesta))[0];

foreach ($coleccion_inventario as $value) {
    $control->asignar_ocupacion_articulos($id_montaje, $fecha_montaje, $value['id'], null, null, $value['cantidad'], $value['faltante'], true, $timestamp_inventario);
}

echo json_encode($respuesta > 0 ? array("respuesta"=>true, "timestamp_inventario"=> $timestamp_inventario):null);
