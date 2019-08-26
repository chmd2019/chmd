<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$catindad_invitados = $_GET['cantidad_invitados'];
$inventario_servicio = $control->consulta_servicio_cafe($catindad_invitados);

$servicio = array();
while ($row = mysqli_fetch_array($inventario_servicio)) {
    $cantidad = 0;
    if (intval($row['cantidad_servicio']) < 1) {
        $cantidad = bcdiv($row['cantidad_servicio'], 1, 2);
    } else {
        $cantidad = round($row['cantidad_servicio']);
    }
    array_push($servicio, [
        "ingrediente" => $row['ingrediente'],
        "cantidad_servicio" => $cantidad,
        "ruta_img"=>$row['ruta_img']
    ]);
}
echo json_encode($servicio);
