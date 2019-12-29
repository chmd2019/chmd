<?php
require "ControlModulo.php";
$controlModulo = new ControlModulo();
echo json_encode($controlModulo->delete_modulo($_POST['id_modulo']));