<?php

require '../../Model/DBManager.php';
$db_manager = new DBManager();
$connection = $db_manager->conectar1();

$calle = $_POST['calle'];
$colonia = $_POST['colonia'];
$descripcion = $_POST['descripcion'];
$id_usuario = $_POST['id_usuario'];

if ($connection) {
    $sql = "INSERT INTO direccion_familias (`calle`, `colonia`, `descripcion`, `id_usuario`) "
            . "VALUES ('$calle', '$colonia', '$descripcion', '$id_usuario');";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
        die("error:" . mysqli_error($connection));
        echo "Registro fallido";
    }

    if ($insertar) {
        $sql = "COMMIT";
        mysqli_query($connection, $sql);
        echo "Registro exitoso";
    } else {
        $sql = "ROLLBACK";
        mysqli_query($connection, $sql);
    }
}
mysqli_close($connection);
return;

