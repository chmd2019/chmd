<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Especial/common/ControlEspecial.php";

$control = new ControlEspecial();
$estatus = $_POST['estatus'];
$id_permiso_alumno = $_POST['id_permiso_alumno'];
echo json_encode($control->aprovacion_padre($estatus, $id_permiso_alumno));
