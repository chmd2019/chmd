<?php

require_once "./ControlMinutas.php";

$controlMontajes = new ControlMinutas();

$id_usuario = htmlspecialchars(trim($_POST['id_usuario']));
$id_session = htmlspecialchars(trim($_POST['id_session']));
$tema = htmlspecialchars(trim($_POST['tema']));

if ($controlMontajes->eliminar_tema_tmp($tema, $id_session, $id_usuario)){
    echo json_encode(true);
}else{
    echo json_encode(false);
}