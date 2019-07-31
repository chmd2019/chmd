<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$fecha_solicitud = $_POST['fecha_solicitud'];
$solicitante = $_POST['solicitante'];
$tipo_evento = $_POST['tipo_evento'];
$fecha_montaje = $_POST['fecha_montaje'];
$nombre_evento = $_POST['nombre_evento'];
$id_lugar_evento = $_POST['id_lugar_evento'];
$cantidad_invitados = $_POST['cantidad_invitados'];
$horario_evento = $_POST['horario_evento'];
$fecha_ensayo = $_POST['fecha_ensayo'];
$horario_ensayo = $_POST['horario_ensayo'];
$responsable_evento = $_POST['responsable_evento'];
//aarray de inventarios
$inventario_evento = $_POST['inventario_evento'];
$inventario_equipo_tecnico_evento = $_POST['inventario_equipo_tecnico_evento'];

$data = array(
    $fecha_solicitud,
    $solicitante,
    $tipo_evento,
    $fecha_montaje,
    $nombre_evento,
    $cantidad_invitados,
    $horario_evento,
    $fecha_ensayo,
    $horario_ensayo,
    $responsable_evento,
    $id_lugar_evento
);
//guarda un nuevo montaje en db y recibe el ultimo id generado de esa conexión
$nuevo_evento = $control->nuevo_evento_montaje($data);
//registra el inventario asignado para el evento
foreach ($inventario_evento as $value) {
    $control->registro_evento_mobiliario($nuevo_evento, $value['id'], $id_lugar_evento, $value['asignado']);
}
//registra en equipo tecnico utilizado para el eventi
if (count($inventario_equipo_tecnico_evento) > 0) {
    foreach ($inventario_equipo_tecnico_evento as $value) {
        $control->registro_evento_equipo_tecnico($nuevo_evento, $value['id'], $value['asignado']);
    }
}   
            
            
            
            
            
