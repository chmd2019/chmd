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
        $sql = "COMMIT";
        mysqli_query($connection, $sql);
        if ($insert_alumnos && enviar_mail_evento($codigo_invitacion))
            echo json_encode($codigo_invitacion);
    } else {
        $sql = "ROLLBACK";
        mysqli_query($connection, $sql);
    }
    mysqli_close($connection);
}

function enviar_mail_evento($codigo_invitacion_mail) {
    $email = $_POST['correo'];
    $asunto_email = 'Eventos CHMD';
    $msj_img = '<a style="display: block"><img src="https://www.chmd.edu.mx/wp-content/uploads/2018/07/iconMiMaguen.png"/></a>';
    $msj = "$msj_img<br><br>"
            . "Hemos recibido su solicitud de evento <b>{$_POST['tipo_evento']}</b> con los siguientes datos: <br>"
            . "<b>Responsable: </b>{$_POST['responsable']}.<br>"
            . "<b>Tipo de evento: </b>{$_POST['tipo_evento']}.<br>"
            . "<b>Código de evento: </b><b><span style='color:#00C2EE'>{$codigo_invitacion_mail}</span></b>.<br>"
            . "<b>Fecha del evento: </b>{$_POST['fecha_cambio']}.<br>"
            . "Puede compartir el siguiente enlace para sus invitados:<br>"
            . " https://www.chmd.edu.mx/pruebascd/icloud/Especial/Codigo/vistas/vista_inscritos_evento.php?"
            . "familia={$_POST['nfamilia']}&&codigo_evento={$codigo_invitacion_mail}";
    $mail = new PHPMailer;
    $mail->setFrom('eventos@chmd.edu.mx', 'Eventos CHMD');
    $mail->addAddress($email, '');
    $mail->Subject = $asunto_email;
    $mail->msgHTML($msj);
//This should be the same as the domain of your From address
    $mail->DKIM_domain = 'chmd.edu.mx';
//See the DKIM_gen_keys.phps script for making a key pair -
//here we assume you've already done that.
//Path to your private key:
    $mail->DKIM_private = 'dkim_private.pem';
//Set this to your own selector
    $mail->DKIM_selector = 'phpmailer';
//Put your private key's passphrase in here if it has one
    $mail->DKIM_passphrase = '';
//The identity you're signing as - usually your From address
    $mail->DKIM_identity = $mail->From;
//Suppress listing signed header fields in signature, defaults to true for debugging purpose
    $mail->DKIM_copyHeaderFields = false;
//Optionally you can add extra headers for signing to meet special requirements
    $mail->DKIM_extraHeaders = ['List-Unsubscribe', 'List-Help'];
    if (!$mail->send()) {
        //return para debug (visualizacion de errores)
        //return $mail->ErrorInfo;
        return false;
    }
    return true;
}
