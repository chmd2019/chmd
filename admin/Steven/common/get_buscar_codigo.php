<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Especial/common/ControlEspecial.php";

$codigo = $_GET['codigo'];
$familia = $_GET['familia'];
$control = new ControlEspecial();

$estado_inscripcion = $control->verificar_estado_evento($codigo);
$estado_inscripcion = mysqli_fetch_array($estado_inscripcion);
$estado_inscripcion = $estado_inscripcion[0];

if ($estado_inscripcion == 2) {
    echo json_encode($estado_inscripcion);
    return;
}
if ($estado_inscripcion == 3) {
    echo json_encode($estado_inscripcion);
    return;
}
if ($estado_inscripcion == 4) {
    echo json_encode($estado_inscripcion);
    return;
}

$inscripcion = $control->verificar_inscripcion($codigo, $familia);
$inscripcion = mysqli_fetch_array($inscripcion);

if ($inscripcion[0] > 0) {
    echo json_encode(1);
    return;
}

$evento = $control->buscar_codigo_invitacion($codigo);
$resuldado = mysqli_num_rows($evento);
$evento = mysqli_fetch_array($evento);
if ($resuldado > 0) {
    $info_evento = array(
        "id_permiso" => $evento[0],
        "fecha_invitacion" => $evento[1],
        "familia" => $evento[2],
        "tipo_evento" => $evento[3],
        "codigo_invitacion" => $evento[4]);
    echo json_encode($info_evento);
    return;
}
echo json_encode(false);
