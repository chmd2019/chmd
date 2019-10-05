<?php

$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";

require "$root_icloud/Model/DBManager.php";
require "$root_icloud/Helpers/DateHelper.php";
require "$root_icloud/Especial/common/ControlEspecial.php";

//librerias de correo
use PHPMailer\PHPMailer\PHPMailer;

require '../../Helpers/vendor/autoload.php';

$db_manager = new DBManager();
$date_helper = new DateHelper();
$control = new ControlEspecial();
//setea el uso horario para ciudad de mexico
$date_helper->set_timezone();

// Ventana_permisos
$idusuario = $_POST['idusuario'];
$comentarios = $_POST['comentarios'];
$nfamilia = $_POST['nfamilia'];
$responsable = $_POST['responsable'];
$parentesco = $_POST['parentesco'];
$fecha_cambio = $_POST['fecha_cambio'];
$fecha_creacion = $_POST['fecha_creacion'];
$tipo_permiso = $_POST['tipo_permiso'];
$estatus = $_POST['estatus'];
$empresa_transporte = $_POST['empresa_transporte'];
$tipo_evento = $_POST['tipo_evento'];
$alumnos = $_POST['alumnos'];
$coleccion_alumnos_invitados = $_POST['coleccion_alumnos_invitados'];

$connection = $db_manager->conectar1();
$codigo_invitacion = "";
do {
    $codigo_invitacion = $control->generador_codigo_invitacion();
    $codigo_verificado = $control->verificar_existe_codigo_verificacion($codigo_invitacion);
    $codigo_verificado = mysqli_fetch_array($codigo_verificado);
    $codigo_verificado = $codigo_verificado[0];
} while ($codigo_verificado != 0);

if ($connection) {
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
  '" . $empresa_transporte . "',
  '" . $codigo_invitacion . "',
  '" . $tipo_evento . "')
  ";
    mysqli_set_charset($connection, "utf8");
    $insertar = mysqli_query($connection, $sql);
    if (!$insertar) {
        die("error:" . mysqli_error($connection));
        echo "Registro fallido";
    }
    if ($insertar) {
        $ultimo_id_conexion = mysqli_insert_id($connection);
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
            $insert_alumnos = mysqli_query($connection, $sql);
        }
        foreach ($coleccion_alumnos_invitados as $value) {
            $control->inscripcion_invitado($ultimo_id_conexion, $value, 1, $codigo_invitacion, $nfamilia);
        }
        $sql = "COMMIT";
        mysqli_query($connection, $sql);
        if ($insert_alumnos)
            echo json_encode($codigo_invitacion);
    } else {
        $sql = "ROLLBACK";
        mysqli_query($connection, $sql);
    }
    mysqli_close($connection);
}
