<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
$id_invitado = htmlspecialchars(trim($_POST['id_invitado']));
$checked = htmlspecialchars($_POST['checked']);
$id_minuta = $_POST['id_minuta'];

echo json_encode($controlMinutas->actualizar_asistencia($id_invitado, $id_minuta, $checked));
