<?php

$root = dirname(dirname(__DIR__));
require "./ControlMinutas.php";
require "{$root}/Helpers/DateHelper.php";

$controlMinutas = new ControlMinutas();
$dateHelper = new DateHelper();

$dateHelper->set_timezone();
$timestamp = strtotime(date("Y-m-d"));
//datos de sesion
$id_session = $_POST['id_session'];

echo json_encode($controlMinutas->cancelar_minuta($id_session, $timestamp));
