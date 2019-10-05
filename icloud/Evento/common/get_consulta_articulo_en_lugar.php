<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$mobiliario_guardado = $_GET['mobiliario_guardado'];
$id_lugar = $_GET['id_lugar'];
$articulos_no_admitidos_en_lugar = array();

foreach ($mobiliario_guardado as $value) {
    if (mysqli_fetch_array($control->consultar_articulo_en_lugar($value['id_articulo'], $id_lugar))[0] == 0) {
        array_push($articulos_no_admitidos_en_lugar, $value['articulo']);
    }
}

echo json_encode($articulos_no_admitidos_en_lugar);
