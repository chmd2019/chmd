<?php
include 'include/user_session.php';
$session = new UserSession();
if ($session->existeSession()){
  header ( 'Location: menu.php' );
}else{
	$error=false;
	if (isset($_GET['error']) && $_GET['error']==100){
		$error = true;
	}	
  $session->closeSession();
  require_once ('FirePHPCore/FirePHP.class.php');
  $firephp = FirePHP::getInstance ( true );
  ob_start ();
  include ('vistas/login.php');
}
?>
