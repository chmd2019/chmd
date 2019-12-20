<?php
require './ControlCirculares.php';

$controlCirculares = new ControlCirculares();
$id_circular = $_POST['id_circular'];
$titulo = htmlspecialchars(trim($_POST['titulo']));
$descripcion = htmlspecialchars($_POST['descripcion']);
$contenido = htmlspecialchars($_POST['contenido']);
$niveles = $_POST['nivel'];
//ICS GOOGLE CALENDAR
$tema_ics = htmlspecialchars($_POST['tema_ics']);
$fecha_ics = htmlspecialchars($_POST['fecha_ics']);
$hora_inicial_ics = htmlspecialchars($_POST['hora_inicial_ics']);
$hora_final_ics = htmlspecialchars($_POST['hora_final_ics']);
$ubicacion_ics = htmlspecialchars($_POST['ubicacion_ics']);
$adjunto = false;
if (strlen($tema_ics) > 0 && strlen($fecha_ics) > 0 && strlen($hora_inicial_ics) > 0 &&
    strlen($hora_final_ics) > 0 && strlen($ubicacion_ics) > 0) {
    $adjunto = true;
}
//arreglo de grupos especiales, administrativos
$grp_especiales = $_POST['grp_especiales'];
$grp_administrativos = $_POST['grp_administrativos'];
//arreglo de usuarios
$usuarios = $_POST['usuarios'];
//usuarios por ruta
$coleccion_usuarios_manana = $_POST['coleccion_usuarios_manana'];

$update = $controlCirculares->update_circular($titulo, $descripcion, $contenido,
    $tema_ics, $fecha_ics, $hora_inicial_ics, $hora_final_ics, $ubicacion_ics, $adjunto, $id_circular, $niveles,
    $grp_especiales, $grp_administrativos, $usuarios, $coleccion_usuarios_manana);
echo json_encode($update);