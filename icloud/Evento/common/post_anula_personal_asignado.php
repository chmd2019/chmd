    
<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";
$control = new ControlEvento();
$timestamp = $_POST['timestamp'];
echo json_encode($control->anular_personal_asignado($timestamp));