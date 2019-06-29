<?php
require '../../Model/DBManager.php';
$db_manager = new DBManager();
$connection = $db_manager->conectar1();
if ($connection) {
    $sql = "SELECT fecha FROM Calendario_escolar";
    $response = mysqli_query($connection, $sql);
    if ($response) {
        $calendario = array();
        $i = 0;
        while ($data = mysqli_fetch_array($response)){
            array_push($calendario,$data[0]);
        }
    }
    echo json_encode($calendario);
    return;
}
echo "Error al realizar consulta";