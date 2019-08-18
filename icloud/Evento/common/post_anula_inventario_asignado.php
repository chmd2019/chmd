<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";
$control = new ControlEvento();
$timestamp = $_POST['timestamp'];
$coleccion_inventario = $_POST['coleccion_inventario'];
$anulado = $control->anular_inventario_asignado($timestamp);
if ($anulado) {
    foreach ($coleccion_inventario as $value) {
        $control->actualiza_inventario_asignado_resta($value['id'], $value['cantidad']);
    }
    echo json_encode(true);
}