<?php

require "ControlPerfiles.php";

$control_perfiles = new ControlPerfiles();
echo json_encode($control_perfiles->nuevo_perfil($_POST['perfil']));