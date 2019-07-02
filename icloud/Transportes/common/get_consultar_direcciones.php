<?php

require '../../Model/DBManager.php';
$db_manager = new DBManager();
$connection = $db_manager->conectar1();

$id_usuario = $_GET['id_usuario'];

if ($connection) {
    mysqli_set_charset($connection, "utf8");
    $sql = "SELECT * FROM direccion_familias WHERE id_usuario ='$id_usuario' ORDER BY descripcion";
    $direcciones = mysqli_query($connection, $sql);
    if ($direcciones) {
        $response = array();
        while ($data = mysqli_fetch_array($direcciones)) {
            array_push($response, [
                "id_direccion" => $data[0],
                "calle" => $data[1],
                "colonia" => $data[2],
                "descripcion" => $data[3],
                "id_usuario" => $data[5],
                "cp" => $data[4]
            ]);
        }
        echo json_encode($response);
        return;
    }
}

echo "Error al realizar consulta";


