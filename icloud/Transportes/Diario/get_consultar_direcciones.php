<?php

include './Control_dia.php';
$control = new Control_dia();

$id_usuario = $_GET['id_usuario'];
$direcciones = $control->consulta_direccion($id_usuario);
$json;
if ($direcciones) {
    $response = array();
    while ($data = mysqli_fetch_array($direcciones)) {
        array_push($response, [
            "id_direccion" => $data[0],
            "calle" => $data[1],
            "colonia" => $data[2],
            "descripcion" => $data[3],
            "id_usuario" => $data[4]
        ]);
    }
    echo json_encode($response);
    return;
}
echo "Error al realizar consulta";


