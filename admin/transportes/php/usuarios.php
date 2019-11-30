<?php
error_reporting ( E_ERROR | E_PARSE );
header ( 'Content-type: application/json; charset=utf-8' );

include '../conexion.php';

if (isset ( $_GET ['getUsuarios'] )) {
	
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "SELECT id,nombre,correo, COUNT(*) AS nmr FROM usuario_app WHERE usuario_app.correo IN (SELECT DISTINCT correo FROM usuario_app) GROUP BY correo ORDER BY id";
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array ();
	
	while ( $row = mysql_fetch_assoc ( $resultado ) ) {
		$datos [] = $row;
	}
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}

if (isset ( $_GET ['buscaUsuario'] )) {
	
	$qwert = $_GET ['qwert'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "SELECT * FROM usuario_app WHERE id=" . $qwert;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array ();
	
	while ( $row = mysql_fetch_assoc ( $resultado ) ) {
		$datos [] = $row;
	}
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}

if (isset ( $_GET ['getCorreo'] )) {
	$correo = $_GET ['correo'];
	$datos = array (
			"false" 
	);
	if ($correo != "") {
		$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
		mysql_select_db ( $db );
		mysql_query ( "SET NAMES 'utf8'" );
		
		$query = "SELECT * FROM usuario_app WHERE correo ='" . $correo . "'";
		$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
		
		$row_cnt = mysql_num_rows ( $resultado );
		// $firephp->info($row_cnt);
		
		if ($row_cnt > 0) {
			$datos = array (
					"true" 
			);
		}
	}
	
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}

if (isset ( $_GET ['insertUsuario'] )) {
	$nombre_usuario = $_GET ['nombre_usuario'];
	$correo_usuario = $_GET ['correo_usuario'];
	// $firephp->info($nombre);
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$contrasena = generar_clave ( 6 );
	$query = "INSERT INTO usuario_app (nombre, correo,contrasena,primeravez) VALUES ('" . $nombre_usuario . "','" . $correo_usuario . "','" . crypt ( $contrasena ) . "',1)";
	// $firephp->info($query);
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	enviar_mail ( $correo_usuario, $nombre_usuario, $correo_usuario, $contrasena );
	$id = mysql_insert_id ();
	$datos = array (
			"id" => $id 
	);
	
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}

if (isset ( $_GET ['updateUsuario'] )) {
	$nombre_usuario = $_GET ['nombre_usuario'];
	$correo_usuario = $_GET ['correo_usuario'];
	$id_usuario = $_GET ['qwert'];
	// $firephp->info($nombre);
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "UPDATE usuario_app SET nombre='" . $nombre_usuario . "', correo='" . $correo_usuario . "', primeravez= 0 WHERE id='" . $id_usuario . "'";
	// $firephp->info($query);
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$query = "DELETE FROM usuario_grupo WHERE id_usuario=" . $id_usuario;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array (
			true 
	);
	
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}

if (isset ( $_GET ['insertGrupoUsuario'] )) {
	if (isset ( $_GET ['qwert'] )) {
		$id_grupo_personalizado = $_GET ['qwert'];
		$id_usuario = $_GET ['id_usuario'];
		
		// $firephp->info($nombre);
		$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
		mysql_select_db ( $db );
		mysql_query ( "SET NAMES 'utf8'" );
		
		$query = "INSERT INTO usuario_personalizado ( id_usuario, id_personalizado)
			          VALUES (" . $id_usuario . "," . $id_grupo_personalizado . ")";
		// $firephp->info($query);
		$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
		$id = mysql_insert_id ();
		// $firephp->info($id);
		
		$datos = array (
				true 
		);
		
		if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
			echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
		} else { // Si es una normal, respondemos de forma normal
			echo json_encode ( $datos );
		}
	} else {
		$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
		mysql_select_db ( $db );
		mysql_query ( "SET NAMES 'utf8'" );
		echo $query = "INSERT INTO usuario_grupo (id_nivel,id_grado,id_grupo,id_usuario,nombre_hijo) VALUES 
				($_GET[id_nivel],$_GET[id_grado],$_GET[id_grupo],$_GET[id_usuario],'$_GET[nombre_hijo]')";
		$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	}
}

if (isset ( $_GET ['getGrupoUsuario'] )) {
	$id_usuario = $_GET ['qwert'];
	// $firephp->info($nombre);
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "SELECT id_nivel, id_grado, id_grupo, id_usuario, nombre_hijo FROM usuario_grupo WHERE id_usuario = " . $id_usuario;
	// $firephp->info($query);
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	// $firephp->info($id);
	
	$datos = array ();
	
	while ( $row = mysql_fetch_assoc ( $resultado ) ) {
		$datos [] = $row;
	}
	
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}

if (isset ( $_GET ['delUsuario'] )) {
	$id = $_GET ['qwert'];
	
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "DELETE FROM usuario_app WHERE id=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$query = "DELETE FROM usuario_grupo WHERE id_usuario=" . $id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array (
			true 
	);
	
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}

if (isset ( $_GET ['delUsuarioGrupo'] )) {
	$id = $_GET ['qwert'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "DELETE FROM usuario_grupo WHERE id=" . $id;
	echo $query;
	// $query = "DELETE FROM usuario_grupo WHERE id_usuario=".$id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	$datos = array (
			true 
	);
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
if (isset ( $_GET ['delUsuarioGrupoPers'] )) {
	
	$id = $_GET ['qwert'];
	$id_per = $_GET ['id_pers'];
	$id_nivel = $_GET ['id_nivel'];
	$id_grado = $_GET ['id_grado'];
	$id_grupo = $_GET ['id_grupo'];
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "DELETE FROM usuario_personalizado WHERE id_usuario=" . $id . " AND id_personalizado=" . $id_per;
	// $query = "DELETE FROM usuario_grupo WHERE id_usuario=".$id;
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array (
			true 
	);
	
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}

if (isset ( $_GET ['getPadresGrupos'] )) {
	$id_nivel = $_GET ['qwert_nivel'];
	$id_grado = $_GET ['qwert_grado'];
	$id_grupo = $_GET ['qwert_grupo'];
	
	$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexi√≥n" );
	mysql_select_db ( $db );
	mysql_query ( "SET NAMES 'utf8'" );
	
	$query = "SELECT ua.id, ua.nombre, ug.nombre_hijo
					  , n.id as id_nivel, n.nombre as nivel
					  , gra.id as id_grado, gra.nombre as grado
					  , gru.id as id_grupo, gru.nombre as grupo 
					  FROM usuario_grupo ug, usuario_app ua, nivel n, grado gra, grupo gru 
			          WHERE ua.id = ug.id_usuario 
			          AND ug.id_nivel = n.id 
			          AND ug.id_grado = gra.id 
			          AND ug.id_grupo = gru.id 
			          AND ug.id_nivel=" . $id_nivel . " AND ug.id_grado=" . $id_grado . " AND ug.id_grupo=" . $id_grupo;
	
	$resultado = mysql_query ( $query ) or die ( "Error de base de datos: " . mysql_error () );
	
	$datos = array ();
	
	while ( $row = mysql_fetch_assoc ( $resultado ) ) {
		$datos [] = $row;
	}
	if (isset ( $_GET ['callback'] )) { // Si es una petici√≥n cross-domain
		echo $_GET ['callback'] . '(' . json_encode ( $datos ) . ')';
	} else { // Si es una normal, respondemos de forma normal
		echo json_encode ( $datos );
	}
}
function generar_clave($longitud) {
	$cadena = "[^A-Z0-9]";
	return substr ( eregi_replace ( $cadena, "", md5 ( rand () ) ) . eregi_replace ( $cadena, "", md5 ( rand () ) ) . eregi_replace ( $cadena, "", md5 ( rand () ) ), 0, $longitud );
}
function enviar_mail($mail, $nombre, $usuario, $contrasena) {
	$url = "http://aplicaciones.chmd.edu.mx/logo.png";
	$dest = $mail;
	$asunto = "Claves Acceso App CHMD Mensajes"; // Asunto
	$cuerpo = "<html>" . "<body>" . "<img style='width:150px;' src='" . $url . "'/><br>" . "<h1>¡Bienvenido " . $nombre . " a CHMD App!</h1>" . "<h4>Nuestro propósito es que recibas al instante las circulares correspondientes a las áreas  que pertenecen tus hijos." . "Te enviamos tu nombre de usuario con el que podrás tener acceso a los avisos del Colegio Hebreo Maguen David.</h4>" . "<h3>Tu nombre de usuario es: " . $usuario . "</h3>" . "<h3>Establece la contraseña que desees </h3>" . "<h4>!Te deseamos un excelente dia</h4>" . "</body>" . "</html>"; // Cuerpo del mensaje
	require '../../servicio/PHPMailerAutoload.php';
	$mail = new PHPMailer ();
	$mail->charSet = "UTF-8";
	$mail->isSMTP (); // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = true; // Enable SMTP authentication
	$mail->Username = 'soportebwm@gmail.com'; // SMTP username
	$mail->Password = '20283370'; // SMTP password
	$mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
	$mail->From = 'chmd@chmd.edu.mx';
	$mail->FromName = 'Colegio Hebreo Maguen David ';
	$mail->addAddress ( $mail ); // Add a recipient
	$mail->WordWrap = 50; // Set word wrap to 50 characters
	$mail->isHTML ( true ); // Set email format to HTML
	$mail->Subject = $asunto;
	$mail->Body = $cuerpo;
	if (! $mail->send ()) {
		return false;
	} else {
		return true;
	}
}

?>