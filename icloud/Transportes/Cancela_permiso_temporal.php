<?php

include_once './Control_temporal.php';
$id_permiso_temporal = htmlspecialchars($_POST['id_permiso_temporal']);
$objControlTemporal = new Control_temporal();
$respuesta = $objControlTemporal->cancela_permiso_temporal($id_permiso_temporal);
?>
