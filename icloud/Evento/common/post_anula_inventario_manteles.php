<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";
$control = new ControlEvento();
$timestamp = $_POST['timestamp'];
$coleccion_manteles = $_POST['coleccion_manteles'];
$anulado = $control->anular_inventario_manteles_asignado($timestamp);
if ($anulado) {
    foreach ($coleccion_manteles as $value) {
        $control->actualiza_mantel_asignado_resta($value['id'], $value['cantidad']);
    }
    echo json_encode(true);
}