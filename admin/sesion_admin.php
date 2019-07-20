<?php
session_start();
if($_SESSION['contrasena'] != 1 && $_SESSION['usuario'] != 1){
	echo "<script>location.href = 'http://aplicaciones.chmd.edu.mx/transportes/'</script>";
	//header("Location: http://aplicaciones.chmd.edu.mx/app/admin/");
	$acceso=  $_SESSION ['acceso'] ;
	exit();
}
?>
