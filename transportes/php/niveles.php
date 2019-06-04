<?php
header ( 'Content-type: application/json; charset=utf-8' );
require_once ('FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();

header ( 'Content-type: application/json; charset=utf-8' );
include '../conexion.php';
/*
if (isset ( $_GET ['getNiveles'] )) {
	
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "SELECT * FROM nivel";
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

if (isset ( $_GET ['getGruposPersonalizados'] )) {
	
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "SELECT * FROM personalizado";
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

if (isset ( $_GET ['getNivelesGrados'] )) {
	
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "SELECT n.id as id_nivel, n.nombre as nombre_nivel, 
				         g.id as id_grado, g.nombre as nombre_grado 
				  FROM nivel n, grado g WHERE n.id = g.id_nivel ORDER BY n.id";
	
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
 * */
 /******************Permiso de Diario******************************************/
/*cacelacion de permiso*/
if (isset ( $_GET ['delNivel'] )) {
	$id = $_GET ['qwert'];
	$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	 mysqli_select_db ($conexion, $db );
           $tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
	
	$query = "update Ventana_Permiso_diario set archivado=1 where id=" . $id;
	$resultado = mysqli_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	/*
	$query = "DELETE FROM grado WHERE id_nivel=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$query = "DELETE FROM grupo WHERE id_nivel=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	*/
	$datos = array (
			true 
	);
	
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}




/*Autorizar permiso*/
/*
if (isset ( $_GET ['Autoriza'] )) 
    {
	$id = $_GET ['qwert'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "update Ventana_Permiso_diario set estatus=2,notificacion1=0,notificacion3=0 where id=" . $id;
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
/******************************************************************************/


/***************************Permiso Permanente****************************************************/
/*cacelacion de permiso*/
if (isset ( $_GET ['CancelaP'] )) {
	$id = $_GET ['qwert'];
	$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysqli_select_db ( $conexion,$db );
	$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
	
	$query = "update Ventana_Permiso_permanente set archivado=1 where id=" . $id;
	$resultado = mysqli_query ($conexion, $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array (
			true 
	);
	
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}




/*Autorizar permiso*/
/*
if (isset ( $_GET ['AutorizaP'] )) 
    {
	$id = $_GET ['qwert'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "update Ventana_Permiso_permanente set estatus=2,notificacion1=0,notificacion3=0 where id=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array (
			true 
	);
	
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}*/
/********************************************************************/

/*************************Permiso de Viaje********************************************/
/*cacelacion de permiso*/
if (isset ( $_GET ['CancelaV'] )) {
	$id = $_GET ['qwert'];
	$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysqli_select_db ($conexion, $db );
	$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
	
	$query = "update Ventana_Permiso_viaje set archivado=1 where id=" . $id;
	$resultado = mysqli_query ($conexion,$query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array (
			true 
	);
	
	if (isset ( $_GET ['callback'] )) { // Si es una petición cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}




/*Autorizar permiso*/

if (isset ( $_GET ['AutorizaV'] )) 
    {
	$id = $_GET ['qwert'];
	$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
	mysqli_select_db ( $conexion,$db );
	$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
	
	$query = "update Ventana_Permiso_viaje set estatus=2,notificacion1=0,notificacion3=0 where id=" . $id;
	$resultado = mysqli_query ($conexion, $query ) or die ( "Error de base de datos: " . mysql_error () );
	
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