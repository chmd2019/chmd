<?php

require_once "./ControlMinutas.php";

$controlMontajes = new ControlMinutas();

$invitado = htmlspecialchars(trim($_POST['invitado']));
$correo = htmlspecialchars(trim($_POST['correo']));
$id_creador = htmlspecialchars(trim($_POST['id_creador']));
$usuario = mysqli_fetch_array($controlMontajes->consultar_usuario($invitado));
$id_invitado = $usuario[0];
$id_session = htmlspecialchars(trim($_POST['id_session']));

if ($correo == null) {
    $correo = $usuario[1];
}else{
    $id_invitado = 0;
}
echo json_encode($controlMontajes->guardar_invitados_tmp($id_invitado, $invitado, $correo, $id_creador, $id_session));


