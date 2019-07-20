<?php
header ( 'Content-type: application/json; charset=utf-8' );
require_once ('FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
header ( 'Content-type: application/json; charset=utf-8' );
include '../conexion.php';
if (isset ( $_GET ['getGruposPersonalizados'] )) {
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	$query = "SELECT * FROM personalizado ORDER BY nombre";
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$datos = array ();
	while ( $row = mysql_fetch_assoc ( $resultado ) ) {
		$datos [] = $row;
	}
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
if (isset ( $_GET ['addUsuarioPersonalizado'] )) {
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	$query = "SELECT * FROM personalizado ORDER BY nombre";
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$datos = array ();
	while ( $row = mysql_fetch_assoc ( $resultado ) ) {
		$datos [] = $row;
	}
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
if (isset ( $_GET ['getTodosUsuarios'] )) {
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	$query = "SELECT * FROM usuario_app";
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$datos = array ();
	while ( $row = mysql_fetch_assoc ( $resultado ) ) {
		$datos [] = $row;
	}
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
if (isset ( $_GET ['updateGrupoPerso'] )) {
	$id = $_GET ['qwert'];
	$nombre = $_GET ['nombre'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	$datos = mysql_query ( "SELECT * FROM personalizado WHERE nombre='$nombre'" );
	$datos = mysql_fetch_array ( $datos );
	if ($datos) {
		$datos = array (
				'existe' => '1' 
		);
	} else {
		$query = "UPDATE personalizado SET nombre= '" . $nombre . "' WHERE id=" . $id;
		$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
		$datos = array (
				'existe' => '0' 
		);
	}
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
if (isset ( $_GET ['EliminarGrupoPerso'] )) {
	$id = $_GET ['qwert'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	$query = "DELETE FROM personalizado WHERE id=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$query = "DELETE FROM usuario_personalizado WHERE id_personalizado=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$datos = array (
			true 
	);
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
if (isset ( $_GET ['insertGrupoUsuario'] )) {
	echo json_encode ( "a" );
	$id_grupo_personalizado = $_GET ['qwert'];
	$id_usuario = $_GET ['id_usuario'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	$query = "INSERT INTO usuario_personalizado ( id_usuario, id_personalizado) 
			          VALUES (" . $id_usuario . "," . $id_grupo_personalizado . ")";
	echo $query;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$id = mysql_insert_id ();
	$datos = array (
			true 
	);
	echo json_encode ( $id );
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
if (isset ( $_GET ['delNivel'] )) {
	$id = $_GET ['qwert'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	$query = "DELETE FROM nivel WHERE id=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$query = "DELETE FROM grado WHERE id_nivel=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$query = "DELETE FROM grupo WHERE id_nivel=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$datos = array (
			true 
	);
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
?>