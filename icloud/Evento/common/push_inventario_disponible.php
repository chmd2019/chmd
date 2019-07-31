<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";

$control = new ControlEvento();

$timestamp_actual = $_GET['timestamp'];
$id_lugar = $_GET['id_lugar'];

$inventario_actual = $control->obtener_timestamp($id_lugar);
$inventario_actual = mysqli_fetch_array($inventario_actual);

$timestamp_db = $inventario_actual[0];
$nuevo_timestamp = $timestamp_db;
$inventario_disponible_final = array();

while ($timestamp_db == $timestamp_actual) {
    $aux = $control->obtener_timestamp($id_lugar);
    $aux = mysqli_fetch_array($aux);
    $timestamp_db = $aux[0];
    $nuevo_timestamp = $timestamp_db;

    $inventario_disponible = $control->obtener_inventario_disponible($id_lugar);
    $inventario_disponible_final = array();
    
    while ($row = mysqli_fetch_array($inventario_disponible)) {
        array_push($inventario_disponible_final, [
            "id" => $row[0],
            "articulo" => $row[1],
            "inventario" => $row[2],
            "asignado" => $row[3],
            "disponible" => $row[4]]);
    }
    
    usleep(10000);
}

$respuesta = array(
    "timestamp" => $nuevo_timestamp, "inventario_disponible" => $inventario_disponible_final);
echo json_encode($respuesta);
