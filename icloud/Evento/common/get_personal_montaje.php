<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$fecha = $_GET['fecha'];
$horario_inicial = $_GET['horario_inicial'];
$horario_final = $_GET['horario_final'];

$control = new ControlEvento();
//se consulta el numero del personal total contratado en la escuelta para los montajes
$consulta_personal_total_montaje = $control->obtener_personal_total(1);
$consulta_personal_total_montaje = intval(mysqli_fetch_array($consulta_personal_total_montaje)[0]);
//se consulta el numero del personal total contratado en la escuelta para los montajes
$consulta_personal_total_auditorio = $control->obtener_personal_total(2);
$consulta_personal_total_auditorio = intval(mysqli_fetch_array($consulta_personal_total_auditorio)[0]);
//se consulta el numero del personal total contratado en la escuelta para los limpieza
$consulta_personal_total_limpieza = $control->obtener_personal_total(3);
$consulta_personal_total_limpieza = intval(mysqli_fetch_array($consulta_personal_total_limpieza)[0]);
//se consulta el numero del personal total contratado en la escuelta para los limpieza
$consulta_personal_total_vigilancia = $control->obtener_personal_total(4);
$consulta_personal_total_vigilancia = intval(mysqli_fetch_array($consulta_personal_total_vigilancia)[0]);

//consulta todo el -Personal de montaje- asignado para la fecha consultada
$consulta_personal_montaje = $control->obtener_personal_ocupado($fecha, 1, $horario_inicial, $horario_final);
$consulta_personal_montaje = mysqli_fetch_array($consulta_personal_montaje);
$consulta_personal_montaje = intval($consulta_personal_montaje[0]);
//consulta todo el -Personal cabina de auditorio- asignado para la fecha consultada
$consulta_personal_cabina_auditorio = $control->obtener_personal_ocupado($fecha, 2, $horario_inicial, $horario_final);
$consulta_personal_cabina_auditorio = mysqli_fetch_array($consulta_personal_cabina_auditorio);
$consulta_personal_cabina_auditorio = intval($consulta_personal_cabina_auditorio[0]);
//consulta todo el -Personal de limpieza- asignado para la fecha consultada
$consulta_personal_limpieza = $control->obtener_personal_ocupado($fecha, 3, $horario_inicial, $horario_final);
$consulta_personal_limpieza = mysqli_fetch_array($consulta_personal_limpieza);
$consulta_personal_limpieza = intval($consulta_personal_limpieza[0]);
//consulta todo el -Personal de vigilancia- asignado para la fecha consultada
$consulta_personal_vigilancia = $control->obtener_personal_ocupado($fecha, 4, $horario_inicial, $horario_final);
$consulta_personal_vigilancia = mysqli_fetch_array($consulta_personal_vigilancia);
$consulta_personal_vigilancia = intval($consulta_personal_vigilancia[0]);

$personal_montaje = array(
    "total_personal" => $consulta_personal_total_montaje,
    "total_ocupado" => $consulta_personal_montaje,
    "total_disponible" => $consulta_personal_total_montaje - $consulta_personal_montaje
);
$personal_cabina_auditorio = array(
    "total_personal" => $consulta_personal_total_auditorio,
    "total_ocupado" => $consulta_personal_cabina_auditorio,
    "total_disponible" => $consulta_personal_total_auditorio - $consulta_personal_cabina_auditorio
);
$personal_limpieza = array(
    "total_personal" => $consulta_personal_total_limpieza,
    "total_ocupado" => $consulta_personal_limpieza,
    "total_disponible" => $consulta_personal_total_limpieza - $consulta_personal_limpieza
);
$personal_vigilancia = array(
    "total_personal" => $consulta_personal_total_vigilancia,
    "total_ocupado" => $consulta_personal_vigilancia,
    "total_disponible" => $consulta_personal_total_vigilancia - $consulta_personal_vigilancia
);

$personal = array(
    "personal_montaje" => $personal_montaje,
    "personal_cabina_auditorio" => $personal_cabina_auditorio,
    "personal_limpieza" => $personal_limpieza,
    "personal_vigilancia" => $personal_vigilancia
);

echo json_encode($personal);
