<?php

require "./ControlAlumnos.php";
$control_alumnos = new ControlAlumnos();

$id_alumno = $_POST['id_alumno'];
$grupo = $_POST['grupo'];

echo json_encode($control_alumnos->eliminar_grupo($id_alumno, $grupo));