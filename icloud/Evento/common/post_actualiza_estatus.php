<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$id =  $_POST['id'];
$estatus =  $_POST['estatus'];

echo json_encode($control->actualizar_estaus($id, $estatus));