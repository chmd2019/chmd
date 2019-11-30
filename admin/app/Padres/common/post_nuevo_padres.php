<?php
require "./ControlPadres.php";

$control_padres = new ControlPadres();

$nombre = trim($_POST['nombre']);
$apellidos = trim($_POST['apellidos']);
$responsable = strtoupper(trim($_POST['rol']));
$correo = trim($_POST['email']);
$familia = trim($_POST['familia']);
$tipo = $responsable == "PADRE" ? 3 : 4;

echo json_encode($control_padres->insert_padres($nombre, $apellidos, $responsable, $correo, $familia, $tipo));
