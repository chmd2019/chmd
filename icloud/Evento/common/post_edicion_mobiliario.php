<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$id_montaje = $_POST['id_montaje'];
$id_articulo = $_POST['id_articulo'];
$cantidad = intval($_POST['cantidad']);
$fecha_montaje_simple = $_POST['fecha_montaje_simple'];
$hora_inicial = $_POST['hora_inicial'];
$hora_final = $_POST['hora_final'];

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

$res = null;

$control->edicion_mobiliario_eliminar($id_montaje, $id_articulo);
$control->edicion_mobiliario_eliminar_tb_evento_articulos_asignados($id_montaje, $id_articulo);

for ($index = 1; $index <= $cantidad; $index++) {
    $res = $control->edicion_mobiliario($id_articulo, $id_montaje, $fecha_montaje_simple, $hora_inicial, $hora_final, 
        $hora_min, $hora_max);
}

echo json_encode($id_articulo);