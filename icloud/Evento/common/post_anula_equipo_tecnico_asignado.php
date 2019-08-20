<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";
$control = new ControlEvento();
$timestamp = $_POST['timestamp'];
$coleccion_equipo_tecnico = $_POST['coleccion_equipo_tecnico'];
$anulado = $control->anular_equipo_tecnico_asignado($timestamp);
if ($anulado) {
    foreach ($coleccion_equipo_tecnico as $value) {
        $control->actualiza_equipo_tecnico_asignado_resta($value['id'], $value['cantidad']);
    }
    echo json_encode(true);
    return;
}
echo json_encode(false);
return;