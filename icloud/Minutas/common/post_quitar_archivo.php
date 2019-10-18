<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
//datos de sesion
$id_session = $_POST['id_session'];
//datos de archivo
$nombre = $_POST['archivo'];
$tiempo = strtotime(date("Y-m-d"));
$nombre_compuesto = "{$tiempo}_{$id_session}_{$nombre}";
$path = "../archivos/$nombre_compuesto";
$success = unlink($path);
echo json_encode($success);
