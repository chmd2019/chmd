<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";
require_once "../../Helpers/DateHelper.php";

$controlMinutas = new ControlMinutas();
$dateHelper = new DateHelper();

$dateHelper->set_timezone();
//datos de sesion
$id_usuario = $_POST['id_usuario'];
$id_session = $_POST['id_session'];
//datos de archivo
$file = $_FILES['filepond'];
$nombre = $file['name'];
$tiempo = strtotime(date("Y-m-d"));
$nombre_compuesto = "{$tiempo}_{$id_session}_{$nombre}";
$tmp_name = $file['tmp_name'];
$path = "../archivos/$nombre_compuesto";
$success = null;
if (!file_exists($path)) {
    $success = move_uploaded_file($tmp_name, $path);
    if ($success) {
        $controlMinutas->guardar_archivo_tmp($nombre, $nombre_compuesto, $tiempo, $id_session, $id_usuario);
    }
}
echo json_encode($success);
