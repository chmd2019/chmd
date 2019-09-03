<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/vendor/autoload.php";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$options = array(
    'cluster' => 'us3',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    'd71baadb1789d7f0cd64',
    '4544b5a6cd6ebc153ad7',
    '840812',
    $options
);

$fecha_montaje = $_POST['fecha_montaje'];
$hora_inicial = $_POST['hora_inicial'];
$hora_final = $_POST['hora_final'];
$coleccion_inventario = $_POST['coleccion_inventario'];
$token = $_POST['token'];
$data = array("actualiza_inventarios" => ["push" => true, "token" => $token]);
//horarios segun disponibilidad establecida, 2 horas antes de la hora inicial y 2 posterior a la hora final
if ($hora_inicial == "00:00:00" || $hora_inicial == "01:00:00") {
    $hora_min = $hora_inicial;
}else{
    $hora_min = date("H:i:s", strtotime($hora_inicial . "-7200 seconds"));
}
if ($hora_final == "22:00:00" || $hora_final == "23:00:00") {
    $hora_max = $hora_final;
}else{
    $hora_max = date("H:i:s", strtotime($hora_final . "+7199 seconds"));
}
$ultimo_id_conexion = null;

foreach ($coleccion_inventario as $value) {
    for ($index = 0; $index < intval($value['cantidad']); $index++) {
        $ultimo_id_conexion = $control->actualizar_inventario_asignado($value['id'], $fecha_montaje, $hora_inicial, $hora_final, $hora_min, $hora_max, 1);
    }
    if ($ultimo_id_conexion != null) {
        $control->actualiza_inventario_asignado_suma($value['id'], $value['cantidad']);
    }
}

$timestamp = $control->obtener_ultimo_timestamp_inventario($ultimo_id_conexion);
$timestamp = mysqli_fetch_array($timestamp);

if ($ultimo_id_conexion != null) {
    echo json_encode(
        array("respuesta" => true,
                "timestamp" => $timestamp[0])
    );
    $pusher->trigger('canal_inventario', 'actualiza_inventarios', $data);
    return;
}
echo json_encode(false);
return;
