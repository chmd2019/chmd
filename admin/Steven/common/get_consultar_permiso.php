<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

require "$root_icloud/Especial/common/ControlEspecial.php";

$id_permiso = $_GET['id_permiso'];
$control = new ControlEspecial();

$permiso = $control->consultar_permiso($id_permiso);
$permiso = mysqli_fetch_array($permiso);
$fecha_creacion = $permiso[0];
$idusuario = $permiso[1];
$fecha_cambio = $permiso[2];
$responsable = $permiso[3];
$parentesco = $permiso[4];
$comentarios = $permiso[5];

$nombre_usuario = $control->consultar_nombre_usuario($idusuario);
$nombre_usuario = mysqli_fetch_array($nombre_usuario);
$solicitante = $nombre_usuario[0];
$consulta_permiso = array(
    "fecha_creacion" => $fecha_creacion, 
    "solicitante" => $solicitante,  
    "fecha_cambio" => $fecha_cambio, 
    "responsable" => $responsable, 
    "parentesco" => $parentesco, 
    "comentarios" => $comentarios);

echo json_encode($consulta_permiso);
