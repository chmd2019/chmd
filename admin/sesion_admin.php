<?php
//$root_server = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/admin";
$root_server = $_SERVER['DOCUMENT_ROOT'] ."/chmd/admin";
include  $root_server.'/user_session.php';
include  $root_server.'/conexion.php';
//crear objeto de session
$session= new UserSession();
if (!$session->existeSession()){
	$session->closeSession();
	header('Location:'.$root_server );
}else{
	date_default_timezone_set('America/Mexico_city');
	$user_session=$session->getCurrentUser();
	//creo un arreglo de permisos
	$capacidades= array();
	$sql = "SELECT * FROM Administrador_capacidades_usuarios WHERE id_usuario='$user_session'";
	$_capacidades	=	mysqli_query($conexion, $sql );
	while ($row 	=	mysqli_fetch_array($_capacidades)) {
		$capacidad = $row['id_capacidad'];
		//agregar en array;
		array_push($capacidades, $capacidad);
	}
}
?>
