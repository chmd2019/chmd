<?php

require "./ControlAlumnos.php";
$control_alumnos = new ControlAlumnos();

$alumnos = $_POST['alumnos'];
$grupos = $_POST['grupos'];

echo json_encode($control_alumnos->insert_alumnos($alumnos, $grupos));

