<?php
include 'user_session.php';
$session = new UserSession();
if ($session->existeSession()){
  header ( 'Location: menu.php' );
}else{
  $session->closeSession();
  require_once ('FirePHPCore/FirePHP.class.php');
  $firephp = FirePHP::getInstance ( true );
  ob_start ();
  include ('vistas/login.php');
}
?>
