<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Especial/common/ControlEspecial.php";

$familia = $_POST['familia'];
$nombre = $_POST['nombre'];
$parentesco = $_POST['parentesco'];

$control = new ControlEspecial();
$consulta = $control->nuevo_responsable($nombre, $parentesco, $familia);
if ($consulta) {
   echo true; 
   return;
}
echo false;