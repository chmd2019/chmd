<?php

$id = $_POST['id'];
$familia = $_POST['familia'];

include './Control_dia.php';
$objDia = new Control_dia();
$registro_diario = $objDia->mostrar_permiso_diario($id);

if ($registro_diario) {
    $registro_diario = mysqli_fetch_array($registro_diario);
    $folio = $registro_diario[0];
    $fecha_solicitud = $registro_diario[1];
    $correo2 = $registro_diario[2];
    $calle = $registro_diario[3];
    $colonia = $registro_diario[4];
    $cp = $registro_diario[5];
    $ncalle = $registro_diario[6];
    $ncolonia = $registro_diario[7];
    $ncp = $registro_diario[8];
    $ruta = $registro_diario[9];
    $comentaios = $registro_diario[10];
    $alumno1 = $registro_diario[11];
    $alumno2 = $registro_diario[12];
    $alumno3 = $registro_diario[13];
    $alumno4 = $registro_diario[14];
    $alumno5 = $registro_diario[15];
    $mensaje = $registro_diario[16];
    $fecha_formateada = date("m-d-Y", strtotime(str_replace('/', '-', $registro_diario[17])));
    $consulta_alumnos = $objDia->mostrar_alumnos_permiso($alumno1, $alumno1, $alumno3, $alumno4, $alumno5);
    if ($consulta_alumnos) {
        $consulta_alumnos = mysqli_fetch_array($consulta_alumnos);
    }
    $registro_diario = array('folio' => $folio, 'fecha_solicitud' => $fecha_solicitud, 'correo' => $correo2, 'calle' => $calle,
        'colonia' => $colonia, 'cp' => $cp, 'ncalle' => $ncalle, 'ncolonia' => $ncolonia, 'ncp' => $ncp,
        'ruta' => $ruta, 'comentarios' => $comentaios, 'alumno1' => $alumno1, 'alumno2' => $alumno2,
        '$alumno3' => $alumno3, 'alumno4' => $alumno4, 'alumno4' => $alumno4, 'alumno5' => $alumno5,
        'mensaje' => $mensaje, 'fecha_permiso' => $fecha_formateada, 'alumnos' => $consulta_alumnos);
}
echo json_encode($registro_diario);
?>
                        
