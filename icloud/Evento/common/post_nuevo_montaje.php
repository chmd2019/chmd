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
//personal asignado
//$check_equipo_tecnico = $_POST['check_equipo_tecnico'];
$timestamp_inventario = $_POST['timestamp_inventario'];
$timestamp_inventario_manteles = $_POST['timestamp_inventario_manteles'];
$timestamp_equipo_tecnico = $_POST['timestamp_equipo_tecnico'];
$timestamp_personal_montaje = $_POST['timestamp_personal_montaje'];
$timestamp_personal_montaje_ensayos = $_POST['timestamp_personal_montaje_ensayos'];

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

$ultimo_id_conexion = $control->nuevo_montaje($fecha_solicitud, $solicitante, $tipo_evento, $fecha_montaje, $fecha_montaje_simple, $horario_evento, $horario_final_evento, $nombre_evento, $responsable_evento, $cantidad_invitados, $valet_parking, $anexa_programa, $tipo_repliegue, $requiere_ensayo, $cantidad_ensayos, $requerimientos_especiales, 0, $lugar_evento);
if ($ultimo_id_conexion > 0) {

    $control->finalizar_mobiliario_asignado($ultimo_id_conexion, $timestamp_inventario);
    $control->finalizar_manteles_asignados($ultimo_id_conexion, $timestamp_inventario_manteles);
    $control->finalizar_equipo_tecnico_asignado($ultimo_id_conexion, $timestamp_equipo_tecnico);
    $control->finalizar_personal_montaje_asignado($ultimo_id_conexion, $timestamp_personal_montaje);

    foreach ($timestamp_personal_montaje_ensayos as $value) {
        $control->finalizar_personal_montaje_asignado($ultimo_id_conexion, $value['timestamp']);
    }
    foreach ($ensayos as $value) {
        if (array_key_exists('fecha_ensayo' , $value) && $value['fecha_ensayo'] !="") {
            $control->finalizar_ensayo($ultimo_id_conexion, $value['fecha_ensayo'], 
                    $value['hora_inicial'], $value['hora_final'], $value['requerimientos_especiales'], 
                    $value['index']);
        }
    }
}

echo json_encode($ultimo_id_conexion);
