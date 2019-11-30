<?php
require '../../conexion.php';

$familia = $_POST['familia'];
$nombre = $_POST['nombre'];
$parentesco = $_POST['parentesco'];

if ($conexion) {
    $sql = "INSERT INTO Responsables (nombre, familia, parentesco) VALUES ('$nombre', '$familia', '$parentesco')";
    mysqli_set_charset($conexion, "utf8");
    $respuesta = mysqli_query($conexion, $sql);
    if ($respuesta) {
        mysqli_close($conexion);
        return true;
    }
}

echo false;
