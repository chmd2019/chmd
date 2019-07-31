<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

require "$root_icloud/Especial/common/ControlEspecial.php";

$id_permiso = $_GET['id_permiso'];
$control = new ControlEspecial();

$permiso = $control->consultar_evento($id_permiso);
$permiso = mysqli_fetch_array($permiso);

$idusuario = $permiso[0];
$fecha_creacion = $permiso[1];
$fecha_cambio = $permiso[2];
$tipo_evento = $permiso[3];
$responsable = $permiso[4];
$parentesco = $permiso[5];
$empresa_transporte = $permiso[6];
$codigo_invitacion = $permiso[7];
$comentarios = $permiso[8];

$nombre_usuario = $control->consultar_nombre_usuario($idusuario);
$nombre_usuario = mysqli_fetch_array($nombre_usuario);
$solicitante = $nombre_usuario[0];

$consulta_permiso = array(
    "solicitante" => $solicitante,
    "fecha_creacion" => $fecha_creacion,
    "fecha_cambio" => $fecha_cambio,
    "tipo_evento" => $tipo_evento,
    "responsable" => $responsable,
    "parentesco" => $parentesco,
    "empresa_transporte" => $empresa_transporte,
    "codigo_invitacion" => $codigo_invitacion,
    "comentarios" => $comentarios);

echo json_encode($consulta_permiso);
