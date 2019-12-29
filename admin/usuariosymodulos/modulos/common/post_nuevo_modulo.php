<?php
require "ControlModulo.php";
$controlModulo = new ControlModulo();

echo json_encode($controlModulo->nuevo_modulo(trim(strtoupper($_POST['modulo']))));