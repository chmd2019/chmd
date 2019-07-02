<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . '/pruebascd/icloud';
require_once "$root_icloud/Transportes/common/ControlTransportes.php";

$id_permiso = $_GET['id'];
$tipo_permiso = $_GET['tipo_permiso'];
$control_temporal = new ControlTransportes();
//alumnos
$alumnos_permiso = $control_temporal->consultar_alumnos_permiso($id_permiso);

if ($tipo_permiso == 1) {
    
} else if ($tipo_permiso == 2) {
    //permisos
    $permiso = $control_temporal->consultar_permiso($id_permiso);
    $permiso = mysqli_fetch_array($permiso);
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
} else if ($tipo_permiso == 3) {
    //permisos
    $permiso = $control_temporal->consultar_permiso_permanente($id_permiso);
    $permiso = mysqli_fetch_array($permiso);
    if ($alumnos_permiso) {
        $response = array();
        while ($data = mysqli_fetch_array($alumnos_permiso)) {
            $alumno = $control_temporal->consultar_nombre_alumno($data[2]);
            $alumno = mysqli_fetch_array($alumno);
            array_push($response, ["alumno" => $alumno[0]]);
        }
        $permiso = [
            "responsable" => $permiso[0],
            "fecha_creacion" => $permiso[1],
            "idusuario" => $permiso[2],
            "lunes" => $permiso[3],
            "martes" => $permiso[4],
            "miercoles" => $permiso[5],
            "jueves" => $permiso[6],
            "viernes" => $permiso[7],
            "calle_numero" => $permiso[8],
            "colonia" => $permiso[9],
            "comentarios" => $permiso[10],
            "mensaje" => $permiso[11],
            "ruta" => $permiso[12],
            "cp" => $permiso[13],
            "alumnos" => $response
        ];
        echo json_encode($permiso);
        return;
    }
    return;
}


echo "Error al realizar consulta";
