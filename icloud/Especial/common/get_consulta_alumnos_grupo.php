<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

require "$root_icloud/Especial/common/ControlEspecial.php";

$grupo = $_GET['grupo'];
$id_anfitrion = $_GET['id_anfitrion'];
$control = new ControlEspecial();

$alumnos = $control->consulta_alumnos_grupo($grupo, $id_anfitrion);
$alumnos_array = array();

while ($row = mysqli_fetch_array($alumnos)) {
    array_push($alumnos_array, [
        "id"=>$row[0],
        "idfamilia"=>$row[1],
        "nombre"=>$row[2],
        "nivel"=>$row[3],   
        "sexo"=>$row[4],        
    ]);
}

echo json_encode($alumnos_array);
