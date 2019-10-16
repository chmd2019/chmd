<?php
$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
//datos de sesion
$id_usuario = $_POST['id_usuario'];
$id_session = $_POST['id_session'];
//datos de archivo
$file = $_FILES['filepond'];
$nombre = utf8_encode(htmlspecialchars($file['name']));
$nombre_compesto = "{$nombre}_{$id_session}_{$id_usuario}";
$tmp_name = $file['tmp_name'];
$path = "../archivos/$nombre_compesto";
$success = move_uploaded_file($tmp_name, $path);
if ($success){
    $controlMinutas->guardar_archivo_tmp($nombre_compesto, $id_session, $id_usuario);
}
echo json_encode($success);