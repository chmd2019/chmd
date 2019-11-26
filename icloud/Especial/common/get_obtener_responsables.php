<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Especial/common/ControlEspecial.php";

$familia = $_GET['familia'];

$control = new ControlEspecial();
$consulta_padres = $control->obtener_responsables_padre($familia);
$consulta_responsables = $control->obtener_responsables($familia);
$respuesta = array();

if ($consulta_padres) {
    while ($data = mysqli_fetch_array($consulta_padres)) {
        array_push($respuesta, [
            "id" => $data[0], 
            "nombre" => strtoupper($data[1]),
            "tipo" => $data[2],
            "responsable"=>$data[3]
                ]);
    }
}
if ($consulta_responsables) {
    while ($data = mysqli_fetch_array($consulta_responsables)) {
        array_push($respuesta, ["id" => $data[0], "nombre" => strtoupper($data[1]), "parentesco" => $data[2]]);
    }
}
echo json_encode($respuesta);
