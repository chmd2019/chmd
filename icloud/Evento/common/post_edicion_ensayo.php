<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/vendor/autoload.php";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$id_ensayo = $_POST['id_ensayo'];
$cantidad_personal = $_POST['cantidad_personal'];
$fecha_ensayo = $_POST['fecha_ensayo'];
$fecha_ensayo_formateada = $_POST['fecha_ensayo_formateada'];
$hora_inicial_ensayo = $_POST['hora_inicial_ensayo'];
$hora_final_ensayo = $_POST['hora_final_ensayo'];
$requerimientos_ensayo = $_POST['requerimientos_ensayo'];
$n_ensayo = $_POST['n_ensayo'];
$id_montaje = $_POST['id_montaje'];

if ($hora_inicial_ensayo == "00:00:00" || $hora_inicial_ensayo == "01:00:00") {
    $hora_min = $hora_inicial_ensayo;
} else {
    $hora_min = date("H:i:s", strtotime($hora_inicial_ensayo . "-3600 seconds"));
}
if ($hora_final_ensayo == "22:00:00" || $hora_final_ensayo == "23:00:00") {
    $hora_max = $hora_final_ensayo;
} else {
    $hora_max = date("H:i:s", strtotime($hora_final_ensayo . "+3599 seconds"));
}

$res = $control->actualizar_ensayo($id_ensayo, $fecha_ensayo, $hora_inicial_ensayo, $hora_final_ensayo, $requerimientos_ensayo);
foreach ($cantidad_personal as $value) {
    $res_personal_eliminar = $control->eliminar_personal_edicion_ensayo($id_montaje, $value['id']);
    for ($index = 1; $index <= $value['cantidad']; $index++) {
        $res_personal = $control->actualizar_personal_ensayo($id_montaje, $value['id'], $fecha_ensayo_formateada, $hora_inicial_ensayo, $hora_final_ensayo, $hora_min, $hora_max, $n_ensayo);
    }
}
if ($res && $res_personal_eliminar && $res_personal) {
    echo json_encode(true);
    return;
}
echo json_encode(false);

