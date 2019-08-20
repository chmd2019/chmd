<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/vendor/autoload.php";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$fecha_montaje = $_POST['fecha_montaje'];
$horario_inicial_evento = $_POST['horario_inicial_evento'];
$horario_final_evento = $_POST['horario_final_evento'];
$personal = array($_POST['personal']);
//horarios segun disponibilidad establecida, 2 horas antes de la hora inicial y 2 posterior a la hora final
$hora_min = date("H:i:s", strtotime($horario_inicial_evento . "-7200 seconds"));
//final
$hora_max = date("H:i:s", strtotime($horario_final_evento . "+7199 seconds"));
$ensayo = $_POST['ensayo'];
//pusher (websockets)
$options = array(
    'cluster' => 'us3',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
        'd71baadb1789d7f0cd64', '4544b5a6cd6ebc153ad7', '840812', $options
);
$data['actualizar_personal'] = array("push" => true, "token" => $_POST['token']);
$pusher->trigger('canal_personal', 'actualiza_personal', $data, $_POST['socket_id']);
$personal_evento = array();
foreach ($personal[0] as $key => $value) {
    array_push($personal_evento, ["$key" => $value]);
}
$personal_montaje = $personal_evento[0];
$personal_cabina_auditorio = $personal_evento[1];
$personal_limpieza = $personal_evento[2];
$personal_vigilancia = $personal_evento[3];
$confirm = true;
foreach ($personal_montaje as $key => $value) {
    if ($value['cantidad'] > 0) {
        for ($index = 0; $index < $value['cantidad']; $index++) {
            $insert = $control->actualizar_personal_tmp($value['tipo'], $fecha_montaje, $horario_inicial_evento, $horario_final_evento, $hora_min, $hora_max, 1, $ensayo);
            if (!$insert)
                $confirm = false;
        }
    }
}
foreach ($personal_cabina_auditorio as $key => $value) {
    if ($value['cantidad'] > 0) {
        for ($index = 0; $index < $value['cantidad']; $index++) {
            $insert = $control->actualizar_personal_tmp($value['tipo'], $fecha_montaje, $horario_inicial_evento, $horario_final_evento, $hora_min, $hora_max, 1, $ensayo);
            if (!$insert)
                $confirm = false;
        }
    }
}
foreach ($personal_limpieza as $key => $value) {
    if ($value['cantidad'] > 0) {
        for ($index = 0; $index < $value['cantidad']; $index++) {
            $insert = $control->actualizar_personal_tmp($value['tipo'], $fecha_montaje, $horario_inicial_evento, $horario_final_evento, $hora_min, $hora_max, 1, $ensayo);
            if (!$insert)
                $confirm = false;
        }
    }
}
foreach ($personal_vigilancia as $key => $value) {
    if ($value['cantidad'] > 0) {
        for ($index = 0; $index < $value['cantidad']; $index++) {
            $insert = $control->actualizar_personal_tmp($value['tipo'], $fecha_montaje, $horario_inicial_evento, $horario_final_evento, $hora_min, $hora_max, 1, $ensayo);
            if (!$insert)
                $confirm = false;
        }
    }
}
$timestamp = $control->obtener_ultimo_timestamp($insert);
$timestamp = mysqli_fetch_array($timestamp);
echo json_encode(
        array("respuesta" => $confirm != false ? true : false,
            "timestamp" => $timestamp[0]
));
?>
