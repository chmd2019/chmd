<?php

$root_server = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/admin";
$host_server = $_SERVER['HTTP_HOST'] . "/pruebascd/admin";
$root_close_session = 'https://' . $host_server . '/cerrar_sesion.php';
$root_menu_session = 'https://' . $host_server . '/menu.php';

/* Produccion
  $root_server = $_SERVER['DOCUMENT_ROOT'] ."/chmd/admin";
  $host_server= $_SERVER['HTTP_HOST']."/chmd/admin";
  $root_close_session = 'http://'.$host_server.'/cerrar_sesion.php';
  $root_menu_session = 'http://'.$host_server.'/menu.php';
 */

include $root_server . '/include/user_session.php';
include $root_server . '/conexion.php';
//crear objeto de session
$session = new UserSession();
if (!$session->existeSession()) {
    $session->closeSession();
    header("Location: https://$host_server/index.php");
} else {
    date_default_timezone_set('America/Mexico_city');
    $user_session = $session->getCurrentUser();
    $id_user_session = $session->getCurrentIdUser();
    //creo un arreglo de permisos
    $capacidades = array();
    $sql = "SELECT * FROM Administrador_capacidades_usuarios WHERE id_usuario='$user_session'";
    $_capacidades = mysqli_query($conexion, $sql);
    while ($row = mysqli_fetch_array($_capacidades)) {
        $capacidad = $row['id_capacidad'];
        //agregar en array;
        array_push($capacidades, $capacidad);
    }
}
if (!in_array('31', $capacidades)) {
    header("Location: https://$host_server/menu.php");
}