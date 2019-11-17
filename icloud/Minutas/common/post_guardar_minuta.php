<?php

require_once "./ControlMinutas.php";
require_once "../../Helpers/DateHelper.php";

$controlMontajes = new ControlMinutas();
$dateHelper = new DateHelper();

$dateHelper->set_timezone();

$convocante = $_POST['convocado_por'];
$id_comite = $_POST['id_comite'];
$director = $_POST['director'];
$titulo_evento = $_POST['titulo_evento'];
$fecha = $_POST['fecha'];
$fecha_simple = $_POST['fecha_evento'];
$horario_minuta = $_POST['horario_minuta'];
//datos de sesion
$id_usuario = $_POST['id_usuario'];
$id_session = $_POST['id_session'];
$timespamp = strtotime(date("Y-m-d"));

$res = $controlMontajes->guardar_minuta($titulo_evento, $fecha_simple, 
        $horario_minuta, $fecha, $convocante, $director, $id_comite, 1, $id_session, $id_usuario, $timespamp);

if (strcasecmp($res, "Ya existe un archivo con el nombre actual") === 0) {
    echo json_encode("Ya existe un archivo con el nombre actual");
    return;
}
if ($res) {
    echo json_encode($res);
    return;
}
