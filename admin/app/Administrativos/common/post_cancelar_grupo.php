<?php

require "./ControlAdministrativos.php";

$control_administrativo = new ControlAdministrativos();

$id_usuario = $_POST['id_usuario'];
$grupo = $_POST['grupo'];
$id_grupo = $control_administrativo->select_id_grupo_administrativo($grupo);

echo json_encode($control_administrativo->cancelar_grupo_adm($id_usuario, $id_grupo));
