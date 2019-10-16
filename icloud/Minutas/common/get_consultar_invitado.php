<?php

require_once "./ControlMinutas.php";

$controlMinutas = new ControlMinutas();
$key = $_GET['key'];
$todos = $_GET['todos'];
$invitados = array();
if ($todos == "false") {
    $consulta = $controlMinutas->consultar_invitado($key);
    while ($row = mysqli_fetch_array($consulta)) {
        array_push($invitados, strtoupper($row[0]));
    }
    echo json_encode($invitados);
} else {
    $consulta = $controlMinutas->consultar_todos_invitados();
    while ($row = mysqli_fetch_array($consulta)) {
        array_push($invitados, strtoupper($row[0]));
    }
    echo json_encode($invitados);
}