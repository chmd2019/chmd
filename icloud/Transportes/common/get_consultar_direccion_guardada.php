<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require_once "$root_icloud/Transportes/common/ControlTransportes.php";
$control = new ControlTransportes();
$familia = $_GET['nfamilia'];
$direccion_guardada = $control->mostrar_domicilio($familia);
$direccion_guardada = mysqli_fetch_array($direccion_guardada);
$respuesta = [
    "calle" => $direccion_guardada[0],
    "colonia" => $direccion_guardada[1],
    "cp" => $direccion_guardada[2],
];
echo json_encode($respuesta);
