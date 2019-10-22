<?php

$root = dirname(dirname(__DIR__));
require "{$root}/Minutas/common/ControlMinutas.php";

$controlMinutas = new ControlMinutas();
$acuerdos = htmlspecialchars(trim($_POST['acuerdos']));
$id_tema = htmlspecialchars(trim($_POST['id_tema']));

$tema = mysqli_fetch_array($controlMinutas->consulta_acuerdo($id_tema));
$version = $tema[1];
$tema_array = explode(";\n", htmlspecialchars_decode($tema[0], ENT_HTML5));
$aux = null;
for ($index = 0; $index < $version; $index++) {
    $aux .= "{$tema_array[$index]};\n";
}
$acuerdos = htmlspecialchars("{$aux}{$acuerdos};\n");
$res = $controlMinutas->guardar_nuevo_acuerdo_tema($acuerdos, $id_tema);

echo json_encode(array("res"=>$res, "acuerdos"=>$acuerdos));