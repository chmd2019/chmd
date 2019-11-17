<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";
require "{$root}/Helpers/DateHelper.php";

$controlMinutas = new ControlMinutas();
$dateHelper = new DateHelper();

$dateHelper->set_timezone();
//datos de sesion
$id_session = $_POST['id_session'];
//datos de archivo
$nombre = $_POST['archivo'];
$tiempo = strtotime(date("Y-m-d"));
$nombre_compuesto = "{$tiempo}_{$id_session}_{$nombre}";
$path = "../archivos/$nombre_compuesto";
$success = unlink($path);
if ($success) {
    echo json_encode($controlMinutas->elimina_archivo($nombre_compuesto, $id_session));
    return;
}
echo json_encode($success);
