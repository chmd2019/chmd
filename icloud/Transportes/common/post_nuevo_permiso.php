<?php

require '../../Model/DBManager.php';
require '../../Helpers/DateHelper.php';

$db_manager = new DBManager();
$date_helper = new DateHelper();

$idusuario = $_POST['idusuario'];
$calle_numero = $_POST['calle_numero'];
$colonia = $_POST['colonia'];
$cp = $_POST['cp'];
$responsable = $_POST['responsable'];
$parentesco = $_POST['parentesco'];
$celular = $_POST['celular'];
$telefono = $_POST['telefono'];
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$turno = $_POST['turno'];
$comentarios = $_POST['comentarios'];
$nfamilia = $_POST['nfamilia'];
$tipo_permiso = $_POST['tipo_permiso'];

$connection = $db_manager->conectar1();
if ($connection) {
    $sql = "INSERT INTO Ventana_Permisos(
            idusuario,
            calle_numero, 
            colonia,
            cp,
            responsable,
            parentesco,
            celular,
            telefono, 
            fecha_inicial,
            fecha_final,
            turno,
            comentarios,
            nfamilia,
            tipo_permiso) 
                    VALUES (
             '" . $idusuario . "',
             '" . $calle_numero . "',
             '" . $colonia . "',
             '" . $cp . "',
             '" . $responsable . "',
             '" . $parentesco . "',
             '" . $celular . "', 
             '" . $telefono . "',
             '" . $fecha_inicial . "',
             '" . $fecha_final . "',
             '" . $turno . "',
             '" . $comentarios . "',
             '" . $nfamilia . "',
             '" . $tipo_permiso . "')";
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