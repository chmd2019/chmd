<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$fecha_solicitud = $_POST['fecha_solicitud'];
$solicitante = $_POST['solicitante'];
$tipo_evento = $_POST['tipo_evento'];
$fecha_montaje = $_POST['fecha_montaje'];
$fecha_montaje_simple = $_POST['fecha_montaje_simple'];
$horario_evento = $_POST['horario_evento'];
$horario_final_evento = $_POST['horario_final_evento'];
$nombre_evento = $_POST['nombre_evento'];
$responsable_evento = $_POST['responsable_evento'];
$cantidad_invitados = $_POST['cantidad_invitados'];
$valet_parking = $_POST['valet_parking'];
$anexa_programa = $_POST['anexa_programa'];
$tipo_repliegue = $_POST['tipo_repliegue'];
$requiere_ensayo = $_POST['requiero_ensayo'];
$cantidad_ensayos = $_POST['select_ensayos'];
$requerimientos_especiales = $_POST['requerimientos_especiales'];
$lugar_evento = $_POST['lugar_evento'];
$ensayos = $_POST['ensayos'];
$solo_cafe = $_POST['solo_cafe'];
$lugar_evento_solo_cafe = $_POST['lugar_evento_solo_cafe'];
$evento_con_cafe = $_POST['evento_con_cafe'];
$tipo_montaje = htmlspecialchars($_POST['tipo_montaje']);
$id_lugar = $lugar_evento == ""?$lugar_evento_solo_cafe:$lugar_evento;
//personal asignado
//$check_equipo_tecnico = $_POST['check_equipo_tecnico'];
$timestamp_inventario = $_POST['timestamp_inventario'];
$timestamp_inventario_manteles = $_POST['timestamp_inventario_manteles'];
$timestamp_equipo_tecnico = $_POST['timestamp_equipo_tecnico'];
$timestamp_personal_montaje = $_POST['timestamp_personal_montaje'];
$timestamp_personal_montaje_ensayos = $_POST['timestamp_personal_montaje_ensayos'];
//horarios segun disponibilidad establecida, 2 horas antes de la hora inicial y 2 posterior a la hora final
if ($horario_evento == "00:00:00" || $horario_evento == "01:00:00") {
    $hora_min = $horario_evento;
}else{
    $hora_min = date("H:i:s", strtotime($horario_evento . "-7200 seconds"));
}
if ($horario_final_evento == "22:00:00" || $horario_final_evento == "23:00:00") {
    $hora_max = $horario_final_evento;
}else{
    $hora_max = date("H:i:s", strtotime($horario_final_evento . "+7199 seconds"));
}
//ultimo id
$ultimo_id_conexion = null;
switch ($tipo_evento) {
    case '1':
        $tipo_evento = "Servicio de café";
        break;
    case '2':
        $tipo_evento = "Montaje de evento interno";
        break;
    case '3':
        $tipo_evento = "Montaje de evento combinado o externo";
        break;
    case '4':
        $tipo_evento = "Montaje de evento especial";
        break;
}

if ($solo_cafe == "true") {
    $ultimo_id_conexion = $control->nuevo_montaje_cafe($fecha_solicitud, $solicitante, $tipo_evento, $fecha_montaje, 
            $fecha_montaje_simple, $horario_evento, $horario_final_evento, $nombre_evento, $responsable_evento, 
            $cantidad_invitados, $valet_parking, $lugar_evento_solo_cafe, 0, $anexa_programa, 1, $tipo_repliegue,
            $requerimientos_especiales,$tipo_montaje);
} else {
    $ultimo_id_conexion = $control->nuevo_montaje($fecha_solicitud, $solicitante, $tipo_evento, $fecha_montaje, 
            $fecha_montaje_simple, $horario_evento, $horario_final_evento, $nombre_evento, $responsable_evento, 
            $cantidad_invitados, $valet_parking, $anexa_programa, $tipo_repliegue, $requiere_ensayo, 
            $cantidad_ensayos, $requerimientos_especiales, 0, $lugar_evento, $evento_con_cafe,$tipo_montaje);
}
if ($ultimo_id_conexion > 0) {
    //se finaliza en tabla Evento_articulos_asignados
    $control->finalizar_mobiliario_asignado($ultimo_id_conexion, $timestamp_inventario);
    $control->finalizar_articulos_asignados($ultimo_id_conexion, $timestamp_inventario);
    //manteles
    $control->finalizar_manteles_asignados($ultimo_id_conexion, $timestamp_inventario_manteles);
    $control->finalizar_articulos_asignados($ultimo_id_conexion, $timestamp_inventario_manteles);
    //equipo tecnico
    $control->finalizar_equipo_tecnico_asignado($ultimo_id_conexion, $timestamp_equipo_tecnico);
    $control->finalizar_articulos_asignados($ultimo_id_conexion, $timestamp_equipo_tecnico);
    //personal
    $control->finalizar_personal_montaje_asignado($ultimo_id_conexion, $timestamp_personal_montaje);

    foreach ($timestamp_personal_montaje_ensayos as $value) {
        $control->finalizar_personal_montaje_asignado($ultimo_id_conexion, $value['timestamp']);
    }
    foreach ($ensayos as $value) {
        if (array_key_exists('fecha_ensayo', $value) && $value['fecha_ensayo'] != "") {
            $control->finalizar_ensayo($ultimo_id_conexion, $value['fecha_ensayo'], $value['hora_inicial'], $value['hora_final'], $value['requerimientos_especiales'], $value['index']);
        }
    }
    $control->ocupar_lugar_evento($ultimo_id_conexion, $id_lugar,$fecha_montaje_simple, $horario_evento, $horario_final_evento, $hora_min, $hora_max);
}

echo json_encode($ultimo_id_conexion);
