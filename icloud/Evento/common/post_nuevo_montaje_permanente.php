<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$fecha_solicitud = $_POST['fecha_solicitud'];
$solicitante = $_POST['solicitante'];
$tipo_evento = $_POST['tipo_evento'];
$lista_fecha_montaje = $_POST['fecha_montaje'];
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
$requerimientos_especiales = htmlspecialchars($_POST['requerimientos_especiales']);
$lugar_evento = $_POST['lugar_evento'];
$ensayos = $_POST['ensayos'];
$solo_cafe = $_POST['solo_cafe'];
$lugar_evento_solo_cafe = $_POST['lugar_evento_solo_cafe'];
$evento_con_cafe = $_POST['evento_con_cafe'];
$tipo_montaje = htmlspecialchars($_POST['tipo_montaje']);
$privilegios = intval($_POST['privilegios']);
$id_lugar = $lugar_evento == "" ? $lugar_evento_solo_cafe : $lugar_evento;
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
} else {
    if ($privilegios == 3):
        $hora_min = date("H:i:s", strtotime($horario_evento . "-3600 seconds"));
    else:
        $hora_min = date("H:i:s", strtotime($horario_evento . "-7200 seconds"));
    endif;
}
if ($horario_final_evento == "22:00:00" || $horario_final_evento == "23:00:00") {
    $hora_max = $horario_final_evento;
} else {
    if ($privilegios == 3):
        $hora_max = date("H:i:s", strtotime($horario_final_evento . "+3599 seconds"));
    else:
        $hora_max = date("H:i:s", strtotime($horario_final_evento . "+7199 seconds"));
    endif;
}
//ultimo id
$ultimo_id_conexion = null;
switch ($tipo_evento) {
    case '1':
        $tipo_evento = "Servicio de café";
        $hora_min = date("H:i:s", strtotime($horario_evento . "-3600 seconds"));
        $hora_max = date("H:i:s", strtotime($horario_final_evento . "+3599 seconds"));
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
foreach ($lista_fecha_montaje as $value) {
    $fecha_montaje = $value['fecha'];
    $fecha_montaje_simple = $value['fecha_simple'];
    $ocupacion = $control->consulta_disponibilidad_lugar_edicion($horario_evento, $horario_final_evento, $id_lugar, 
            $fecha_montaje_simple, 0);
    if(mysqli_fetch_array($ocupacion)[0]>0){
        echo json_encode('¡El lugar, hora y fecha seleccionados ya estan ocupados!');
        return;
    }
    if ($solo_cafe == "true") {
        $ultimo_id_conexion = $control->nuevo_montaje_cafe($fecha_solicitud, $solicitante, $tipo_evento, $fecha_montaje, $fecha_montaje_simple, $horario_evento, $horario_final_evento, $nombre_evento, $responsable_evento, $cantidad_invitados, $valet_parking, $lugar_evento_solo_cafe, 0, $anexa_programa, 1, $tipo_repliegue, $requerimientos_especiales, $tipo_montaje);
    } else {
        $ultimo_id_conexion = $control->nuevo_montaje($fecha_solicitud, $solicitante, $tipo_evento, $fecha_montaje, $fecha_montaje_simple, $horario_evento, $horario_final_evento, $nombre_evento, $responsable_evento, $cantidad_invitados, $valet_parking, $anexa_programa, $tipo_repliegue, 0, 0, $requerimientos_especiales, 0, $lugar_evento, $evento_con_cafe, $tipo_montaje);
    }
    $control->ocupar_lugar_evento($ultimo_id_conexion, $id_lugar, $fecha_montaje_simple, $horario_evento,
            $horario_final_evento, $hora_min, $hora_max);
}
echo json_encode($ultimo_id_conexion);
