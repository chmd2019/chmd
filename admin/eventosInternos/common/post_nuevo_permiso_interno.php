<?php
require '../../conexion.php';

// Ventana_permisos
//$nfamilia = $_POST['nfamilia'];
$motivos = $_POST["motivos"];
$fecha_creacion = $_POST["fecha_creacion"];
$fecha_cambio = $_POST['fecha_cambio'];
$responsable = $_POST['responsable'];
$parentesco = $_POST['parentesco'];
$tipo_permiso = 6;
$tipo_evento = $_POST['tipo_evento'];
$idusuario = $_POST['idusuario'];
$area = $_POST['area'];
//$idusuario = null;
$estatus = $_POST['estatus'];
//horarios
$hora_salida = $_POST['hora_salida'];
$hora_regreso = $_POST['hora_regreso'];
$regresa = $_POST ['regresa'];
// Ventana_permisos_alumnos
$alumnos = $_POST['alumnos'];

if ($conexion) {
    $sql = "INSERT INTO Ventana_Permisos(
                idusuario,
                fecha_creacion,
                fecha_cambio,
                comentarios,
                responsable,
                parentesco,
                tipo_permiso,
                estatus,
                tipo_evento,
                nfamilia)
                 VALUES (
                 '" . $idusuario . "',
                 '" . $fecha_creacion . "',
                 '" . $fecha_cambio . "',
                 '" . $motivos . "',
                 '" . $responsable . "',
                 '" . $parentesco . "',
                 '" . $tipo_permiso . "',
                 '" . 2 . "',
                 '" . $tipo_evento . "',
                 '" . $area . "'
                  )
                ";
    mysqli_set_charset($conexion, "utf8");
    $insertar = mysqli_query($conexion, $sql);
    if (!$insertar) {
        die("error:" . mysqli_error($conexion));
        echo "Registro fallido";
    }
    if ($insertar) {
        $ultimo_id_conexion = mysqli_insert_id($conexion);
        $insert_alumnos = null;
        foreach ($alumnos as $key => $alumno) {

            $sql = "INSERT INTO Ventana_permisos_alumnos("
                    . "id_permiso,"
                    . "id_alumno,"
                    . "hora_salida, "
                    . "hora_regreso, "
                    . "regresa, "
                    . "estatus) "
                    . "VALUES ('"
                    . $ultimo_id_conexion . "','"
                    . $alumno. "','"
                    . $hora_salida . "','"
                    . $hora_regreso . "','"
                    . $regresa . "','"
                    . '2'. "')";

            $insert_alumnos = mysqli_query($conexion, $sql);
        }
        $sql = "COMMIT";
        mysqli_query($conexion, $sql);
        if ($insert_alumnos)
            echo json_encode(array ("estatus"=> true) );
    } else {
        $sql = "ROLLBACK";
        mysqli_query($conexion, $sql);
        echo json_encode(array ("estatus"=> false) );
    }
    mysqli_close($conexion);
}
