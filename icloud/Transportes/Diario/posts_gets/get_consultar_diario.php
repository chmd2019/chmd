<?php

include './Control_dia.php';
$control = new Control_dia();

$id = $_GET['id'];
$familia = $_GET['familia'];

$registro_diario = $control->mostrar_permiso_diario($id);
if ($registro_diario) {
    $registro_diario = mysqli_fetch_array($registro_diario);
    //consulta de alumnos
    $alumno1 = mysqli_fetch_array($control->consulta_alumno($registro_diario[11]));
    $alumno2 = mysqli_fetch_array($control->consulta_alumno($registro_diario[12]));
    $alumno3 = mysqli_fetch_array($control->consulta_alumno(registro_diario[13]));
    $alumno4 = mysqli_fetch_array($control->consulta_alumno($registro_diario[14]));
    $alumno5 = mysqli_fetch_array($control->consulta_alumno($registro_diario[15]));
    $alumnos = array(
        'alumno1' => $alumno1[0],
        'alumno2' => $alumno2[0],
        'alumno3' => $alumno3[0],
        'alumno4' => $alumno4[0],
        'alumno5' => $alumno5[0]
    );
    $registro_diario = array(
        'folio' => $registro_diario[0],
        'fecha_solicitud' => $registro_diario[1],
        'correo' => $registro_diario[2],
        'calle' => $registro_diario[3],
        'colonia' => $registro_diario[4],
        'cp' => $registro_diario[5],
        'ncalle' => $registro_diario[6],
        'ncolonia' => $registro_diario[7],
        'ncp' => $registro_diario[8],
        'ruta' => $registro_diario[9],
        'alumnos' => $alumnos,
        'comentarios' => $registro_diario[10],
        'mensaje' => $registro_diario[16],
        'fecha_permiso' => $registro_diario[17]);
}
echo json_encode($registro_diario)
?>