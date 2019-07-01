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
        $alumno = $control_temporal->consultar_nombre_alumno($data[2]);
        $alumno = mysqli_fetch_array($alumno);
        array_push($response, ["alumno" => $alumno[0]]);
    }
    $permiso = [
        "id_permiso" => $permiso[0],
        "id_usuario" => $permiso[1],
        "calle_numero" => $permiso[2],
        "colonia" => $permiso[3],
        "cp" => $permiso[4],
        "comentarios" => $permiso[5],
        "nfamilia" => $permiso[6],
        "responsable" => $permiso[7],
        "parentesco" => $permiso[8],
        "celular" => $permiso[9],
        "telefono" => $permiso[10],
        "fecha_inicial" => $permiso[11],
        "fecha_final" => $permiso[12],
        "turno" => $permiso[13],
        "tipo_permiso" => $permiso[14],
        "estatus" => $permiso[15],
        "fecha_creacion" => $permiso[16],
        "mensaje" => $permiso[17],
        "alumnos" => $response
    ];
    echo json_encode($permiso);
    return;
}
echo "Error al realizar consulta";
