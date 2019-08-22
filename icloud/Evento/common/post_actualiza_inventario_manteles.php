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
        'd71baadb1789d7f0cd64', '4544b5a6cd6ebc153ad7', '840812', $options
);

$fecha_montaje = $_POST['fecha_montaje'];
$hora_inicial = $_POST['hora_inicial'];
$hora_final = $_POST['hora_final'];
$coleccion_manteles = $_POST['coleccion_manteles'];
$token = $_POST['token'];
$data = array("actualizar_manteles" => ["push" => true, "token" => $token, "id_lugar" => $id_lugar]);
//horarios segun disponibilidad establecida, 2 horas antes de la hora inicial y 2 posterior a la hora final
$hora_min = date("H:i:s", strtotime($hora_inicial . "-7200 seconds"));
$hora_max = date("H:i:s", strtotime($hora_final . "+7199 seconds"));
$ultimo_id_conexion = null;

foreach ($coleccion_manteles as $value) {
    for ($index = 0; $index < intval($value['cantidad']); $index++) {
        $ultimo_id_conexion = $control->actualizar_mantel_asignado($value['id'], $fecha_montaje, $hora_inicial, $hora_final, $hora_min, $hora_max, 1);
    }
    if ($ultimo_id_conexion != null){
        $control->actualiza_mantel_asignado_suma($value['id'], $value['cantidad']);
    }
}

$timestamp = $control->obtener_ultimo_timestamp_inventario_manteles($ultimo_id_conexion);
$timestamp = mysqli_fetch_array($timestamp);

if ($ultimo_id_conexion != null) {
    echo json_encode(
            array("respuesta" => true,
                "timestamp" => $timestamp[0]));
    $pusher->trigger('canal_manteles', 'actualiza_manteles', $data);
    return;
}
echo json_encode(false);
return;