<?php
include './Control_dia.php';
$control = new Control_dia();

$calle = $_POST['calle'];
$colonia = $_POST['colonia'];
$descripcion = $_POST['descripcion'];
$id_usuario = $_POST['id_usuario'];
$campos = array($calle, $colonia, $descripcion, $id_usuario);
if ($control->recordar_direccion($campos)) {
    echo "Registro exitoso";
}else{
    echo "Registro fallido";
}

