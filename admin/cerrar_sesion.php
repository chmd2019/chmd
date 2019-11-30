<?php
include 'include/user_session.php';
$session  =   new UserSession();
if ($session->existeSession()){
  $session->closeSession();
}
//redireciono al Index de la administracion.
header("Location: index.php");
exit();
?>
