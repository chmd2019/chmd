<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
require "$root_icloud/Evento/common/ControlEvento.php";
require "$root_icloud/Helpers/DateHelper.php";

$control = new ControlEvento();
$date_helper = new DateHelper();
$date_helper->set_timezone();

$archivo = $_FILES['archivo'];
$id_montaje = $_POST['id_montaje'];
$name_no_encripted = null;
$extension = null;
$success = false;
$timestamp = null;

switch ($archivo['type']) {
    case 'text/plain':
        $extension = ".txt";
        break;
    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
        $extension = ".docx";
        break;
    case 'application/msword':
        $extension = ".doc";
        break;
    case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
        $extension = ".pptx";
        break;
    case 'application/vnd.ms-powerpoint':
        $extension = ".ppt";
        break;
    case 'application/pdf':
        $extension = ".pdf";
        break;
}

$max_size = intval($archivo['size']) / 1048576;

if ($max_size > 3) {
    echo json_encode(array("success" => false, "msg" => "El archivo debe tener un tamaño máximo de 3mb!"));
    return;
}

if ($archivo['type'] == 'text/plain' or
        $archivo['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' or
        $archivo['type'] == 'application/msword' or
        $archivo['type'] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' or
        $archivo['type'] == 'application/vnd.ms-powerpoint' or
        $archivo['type'] == 'application/pdf') {

    $name_encrypted = md5($archivo['tmp_name']);
    $name = explode(".", $archivo['name'])[0];
    $name = "$name" . "_cod_unique_" . "$name_encrypted" . $extension;
    $name_no_encripted = explode("_cod_unique_", $name)[0];
    $path = "../archivos/$name";
    $success = move_uploaded_file($archivo['tmp_name'], $path);
    $timestamp = date("Y-m-d h:i:s");
}

if ($success) {
    $url =  "https://".$_SERVER["HTTP_HOST"] . dirname(dirname($_SERVER["REQUEST_URI"])) . "/archivos/$name";
    $control->nuevo_archivo_montaje($id_montaje, $name, $name_no_encripted, $path, 
                                        substr(intval($archivo['size'])/1048576, 0, 4)." mb", $timestamp, $url);
    echo json_encode(true);
    return;
}
echo json_encode(false);
