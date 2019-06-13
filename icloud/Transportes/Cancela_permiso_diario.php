<?php

include_once './Control_dia.php';
$id_permiso_diario = htmlspecialchars($_POST['id_permiso_diario']);
$objControlDia = new Control_dia();
$respuesta = $objControlDia->cancela_permiso_diario($id_permiso_diario);
?>
