<?php
require "ControlModulo.php";
$controlModulo = new ControlModulo();

$modulo = trim(strtoupper($_POST['modulo']));
$id_modulo = $_POST['id_modulo'];
echo json_encode($controlModulo->editar_modulo($modulo, $id_modulo));