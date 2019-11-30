<?php
require '../../conexion.php';

// Ventana_permisos
$nfamilia = $_POST['nfamilia'];
$fecha_creacion = $_POST['fecha_creacion'];
$fecha_cambio = $_POST['fecha_cambio'];
$motivos = $_POST['motivos'];
$responsable = $_POST['responsable'];
$parentesco = $_POST['parentesco'];
$tipo_permiso = 4;
$idusuario = $_POST['idusuario'];
$estatus = $_POST['estatus'];
// Ventana_permisos_alumnos
$alumnos = $_POST['alumnos'];

if ($conexion) {
    $sql = "INSERT INTO Ventana_Permisos(
                nfamilia,
                fecha_creacion,
                fecha_cambio,
                comentarios,
                responsable,
                parentesco,
                tipo_permiso,
                idusuario,
                estatus)
                 VALUES (
                 '" . $nfamilia . "',
                 '" . $fecha_creacion . "',
                 '" . $fecha_cambio . "',
                 '" . $motivos . "',
                 '" . $responsable . "',
                 '" . $parentesco . "',
                 '" . $tipo_permiso . "',
                 '" . $idusuario . "',
                 '" . 1 . "')
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

            //asigna semestre I o II de acuerdo al mes del año
            $corte_semestral = intval(date("m")) <= 6 ? "-I" : "-II" ;
            $anio = date("Y");
            $idcursar = $alumno['idcursar'];

            if ($idcursar >= 14 && $idcursar <= 17 ) {
                $anio_creacion = "$anio"."$corte_semestral";
            }
            else{
                $anio_creacion = $anio;
            }
            $sql = "INSERT INTO Ventana_permisos_alumnos("
                    . "id_permiso,"
                    . "id_alumno,"
                    . "hora_salida, "
                    . "hora_regreso, "
                    . "regresa, "
                    . "estatus, "
                    . "anio_creacion) "
                    . "VALUES ('"
                    . $ultimo_id_conexion . "','"
                    . $alumno['id_alumno'] . "','"
                    . $alumno['hora_salida'] . "','"
                    . $alumno['hora_regreso'] . "','"
                    . $alumno['regresa'] . "','"
                    . $alumno['estatus'] . "','"
                    . $anio_creacion . "' )";

            $insert_alumnos = mysqli_query($conexion, $sql);
        }
        $sql = "COMMIT";
        mysqli_query($conexion, $sql);
        if ($insert_alumnos)
            echo 1;
    } else {
        $sql = "ROLLBACK";
        mysqli_query($conexion, $sql);
    }
    mysqli_close($conexion);
}
