<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . '/pruebascd/icloud';
require_once "$root_icloud/Transportes/common/ControlTransportes.php";

$id_permiso = $_GET['id'];
$control_temporal = new ControlTransportes();
//permisos
$permiso = $control_temporal->consultar_permiso($id_permiso);
$permiso = mysqli_fetch_array($permiso);
//alumnos
$alumnos_permiso = $control_temporal->consultar_alumnos_permiso($id_permiso);

if ($alumnos_permiso) {
    $response = array();
    while ($data = mysqli_fetch_array($alumnos_permiso)) {
        array_push($response, ["id_alumno" => $data[2]]);
    }
    array_push($permiso, ["alumnos"=>$response]);
    echo json_encode($permiso);
    return;
}
echo "Error al realizar consulta";