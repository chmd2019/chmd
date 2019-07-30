<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

require "$root_icloud/Especial/common/ControlEspecial.php";

$id_alumno = $_GET['id_alumno'];
$idcursar = $_GET['idcursar'];
$corte_semestral = intval(date("m"));
$control = new ControlEspecial();
$respuesta = "";
if ($idcursar >= 0 && $idcursar <= 13 ) {
    $anio = date("Y");
    $num_permisos_este_anio = mysqli_fetch_array($control->aviso_tercer_permiso("$id_alumno", "$anio"));
    $num_permisos_este_anio = $num_permisos_este_anio[0];
    $respuesta = $num_permisos_este_anio >= 3 ? true : false;
}
elseif ($idcursar >= 14 && $idcursar <= 17 ) {
    $anio = date("Y");
    $corte_semestral = intval(date("m")) <= 6 ? "-I" : "-II" ;
    $anio = "$anio"."$corte_semestral";
    $num_permisos_este_anio = mysqli_fetch_array($control->aviso_tercer_permiso("$id_alumno", "$anio"));
    $num_permisos_este_anio = $num_permisos_este_anio[0];
    $respuesta = $num_permisos_este_anio >= 3 ? true : false;

}

echo json_encode($respuesta);