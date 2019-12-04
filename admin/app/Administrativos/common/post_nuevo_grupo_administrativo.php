<?php
require './ControlAdministrativos.php';
$controlAdministrativo = new ControlAdministrativos();
$nombre = strtoupper(trim($_POST['nombre']));
echo json_encode($controlAdministrativo->insert_grupo_administrativo($nombre));
