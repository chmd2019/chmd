<?php

require_once "./ControlMinutas.php";

$controlMontajes = new ControlMinutas();

$invitado = htmlspecialchars(trim($_POST['invitado']));
$correo = htmlspecialchars(trim($_POST['correo']));
$id_creador = htmlspecialchars(trim($_POST['id_creador']));
$usuario = mysqli_fetch_array($controlMontajes->consultar_usuario($invitado));
$id_session = htmlspecialchars(trim($_POST['id_session']));

if ($correo == null) {
    $correo = $usuario[1];
}
echo json_encode($controlMontajes->eliminar_invitados_tmp($correo, $id_creador, $id_session));