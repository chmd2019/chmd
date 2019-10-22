<?php

require_once "./ControlMinutas.php";

$controlMontajes = new ControlMinutas();

$id_minuta = $_POST['id_minuta'];
$temas = $_POST['temas'];
$res = $controlMontajes->cerrar_minuta($id_minuta);
if ($res) {
    foreach ($temas as $value) {
        $controlMontajes->cerrar_temas($value, $id_minuta);
        $controlMontajes->cerrar_temas_pendientes($value);
    }
}
echo json_encode($res);
