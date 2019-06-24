<?php

include './Control_dia.php';
include_once '../../Helpers/DateHelper.php';

$control = new Control_dia();
$date_helper = new DateHelper();

$date_helper->set_timezone();
//fields
$id = $_POST['idusuario'];
$alumno_1 = $_POST['alumno_1'];
$alumno_2 = $_POST['alumno_2'];
$alumno_3 = $_POST['alumno_3'];
$alumno_4 = $_POST['alumno_4'];
$alumno_5 = $_POST['alumno_5'];
$calle_nuevo = $_POST['calle_nuevo'];
$colonia_nuevo = $_POST['colonia_nuevo'];
$cp = $_POST['cp'];
$ruta_diario = $_POST['ruta_diario'];
$comentarios_nuevo = $_POST['comentarios_nuevo'];
$talumnos = $_POST['talumnos'];
$familia = $_POST['familia'];
$fecha_solicitud_nuevo = $_POST['fecha_solicitud_nuevo'];
$fecha_permiso_nuevo = $_POST['fecha_permiso_nuevo'];

$hora_limite = $date_helper->obtener_hora_limite();
if ($hora_limite && $date_helper->comprobar_igual_actual($fecha_permiso_nuevo)) {
    echo 0;
    return;
}
$model = array(
    $id,
    $alumno_1,
    $alumno_2,
    $alumno_3,
    $alumno_4,
    $alumno_5,
    $calle_nuevo,
    $colonia_nuevo,
    $cp,
    $ruta_diario,
    $comentarios_nuevo,
    $talumnos,
    $familia,
    $fecha_solicitud_nuevo,
    $fecha_permiso_nuevo
);
$data = $control->Diario_Alta($model);
if ($data) {
    echo 1;
    return;
}else{
    echo $data;
}
