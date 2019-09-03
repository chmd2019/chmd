<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$id = $_POST['id'];
$tipo_montaje = htmlspecialchars($_POST['tipo_montaje']);
$hora_inicial = $_POST['hora_inicial'];
$hora_final = $_POST['hora_final'];
$tipo_repliegue = $_POST['tipo_repliegue'];
$nombre = $_POST['nombre'];
$responsable = $_POST['responsable'];
$cantidad_invitados = $_POST['cantidad_invitados'];
$estacionamiento = $_POST['estacionamiento'];
$requerimientos_especiales = $_POST['requerimientos_especiales'];

$respuesta = $control->actualizar_montaje($tipo_montaje,$hora_inicial,$hora_final,$tipo_repliegue,$nombre,$responsable,
        $cantidad_invitados,$estacionamiento,$requerimientos_especiales,$id);

echo json_encode($respuesta);
