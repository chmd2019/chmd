<?php
require '../../conexion.php';
require "ControlEspecial.php";
// Ventana_permisos
$idusuario = $_POST['idusuario'];
$motivos = $_POST['motivos'];
$comentarios=$motivos;
$nfamilia = $_POST['nfamilia'];
$responsable = $_POST['responsable'];
$parentesco = $_POST['parentesco'];
$fecha_creacion = $_POST['fecha_creacion'];
$fecha_cambio = $_POST['fecha_cambio'];
$tipo_permiso = 5;
$tipo_evento = $_POST['tipo_evento'];
$estatus = $_POST['estatus'];
$empresa= $_POST['empresa'];
// Ventana_permisos_alumnos
$alumnos = $_POST['alumnos'];

/*******Generacion de codigo de evento****/
$control= new ControlEspecial();
$codigo_invitacion = "";
do {
    $codigo_invitacion = $control->generador_codigo_invitacion();
    $codigo_verificado = $control->verificar_existe_codigo_verificacion($codigo_invitacion);
    $codigo_verificado = mysqli_fetch_array($codigo_verificado);
    $codigo_verificado = $codigo_verificado[0];
} while ($codigo_verificado != 0);
/*******ENd - Generacion de codigo de evento****/

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
                estatus,
                empresa_transporte,
                codigo_invitacion,
                tipo_evento
                )
                 VALUES (
                 '" . $nfamilia . "',
                 '" . $fecha_creacion . "',
                 '" . $fecha_cambio . "',
                 '" . $comentarios . "',
                 '" . $responsable . "',
                 '" . $parentesco . "',
                 '" . $tipo_permiso . "',
                 '" . $idusuario . "',
                 '" . 1 . "',
                 '" . $empresa. "',
                 '" . $codigo_invitacion . "',
                 '" . $tipo_evento . "')
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
                            . "id_alumno, "
                            . "estatus, "
                            . "familia, "
                            . "codigo_invitacion) "
                            . "VALUES ('"
                            . $ultimo_id_conexion . "','"
                            . $alumno . "','"
                            . 1 . "','"
                            . $nfamilia . "','"
                            . $codigo_invitacion . "')";

                    $insert_alumnos = mysqli_query($conexion, $sql);
        }
        $sql = "COMMIT";
        mysqli_query($conexion, $sql);
        //if ($insert_alumnos)
          echo json_encode(array ("codigo_invitacion" => $codigo_invitacion, "estatus"=> $insert_alumnos) );
    } else {
        $sql = "ROLLBACK";
        mysqli_query($conexion, $sql);
        echo json_encode(array ("codigo_invitacion" => 'sin codigo', "estatus"=> 1) );
    }
    mysqli_close($conexion);
}
