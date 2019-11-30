<?php
require "./ControlAdministrativos.php";
$control_administrativo = new ControlAdministrativos();

$usuarios = $_POST['usuarios'];
$grupos = $_POST['grupos'];

echo json_encode($control_administrativo->insert_administrativos($usuarios, $grupos));

