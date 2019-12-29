<?php

require "ControlPerfiles.php";

$control_perfiles = new ControlPerfiles();
echo json_encode($control_perfiles->cambiar_activo($_POST['id_perfil'], $_POST['activo']));