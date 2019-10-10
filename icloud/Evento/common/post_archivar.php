<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$id_montaje = $_POST['id_montaje'];
$flag_archivar = $_POST['flag_archivar'];
$control = new ControlEvento();

echo json_encode($control->archivar($id_montaje, $flag_archivar));


