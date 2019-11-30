
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="img/favicon.png">
    <!-- Dependencias Globales --> 
  <?php include '../components/header.php'; ?>
        
<title>CHMD :: Nivel</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/menu.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php
				require_once ('FirePHPCore/FirePHP.class.php');
				$firephp = FirePHP::getInstance ( true );
				ob_start ();

				if (isset ( $_POST ['guardar'] )) {
					$nombre = $_POST ['nombre_nivel'];
					$funcion = $_POST ['funcion'];

					if ($nombre == '') {
						$verificar = '<div class="alert alert-warning alert-dismissable">' . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . '<h4>¡Verificar!</h4>' . 'Inserta el nombre del Nivel' . '</div>';
					} else {

						header ( 'Content-type: application/json; charset=utf-8' );
						include 'conexion.php';

						$conexion = mysql_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
						mysql_select_db ( $db );
						mysql_query ( "SET NAMES 'utf8'" );
						if ($funcion == 0)
                                                {
							$query = "INSERT INTO nivel (nombre) VALUES ('" . $nombre . "')";
						} else if ($funcion > 0) {
							$query = "UPDATE nivel SET nombre = '" . $nombre . "' WHERE id=" . $funcion;
						}

						mysql_query ( $query );

						header ( 'Location: nivel.php' );
					}
				}

				?>
     <?php include_once "../components/navbar.php"; ?>
    <div class="container">
		<div class="masthead">
			<ul class="nav nav-justified">
				<li class="active"><a href="#">Niveles</a></li>
				<li><a href="grado.php">Grados</a></li>
				<li><a href="grupo.php">Grupos</a></li>
				<li><a href="usuario.php">Usuarios</a></li>
			</ul>
		</div>
		<br>
		<center><?php echo $verificar; ?></center>
		<!-- Button trigger modal -->
		<button style="float: right;" class="btn btn-primary btn-default"
			data-toggle="modal" data-target="#agregarNivel">
			<span class="glyphicon glyphicon-plus"></span> Agregar Nivel
		</button>
		<h2>Niveles</h2>
		<input type="text" class="form-control filter"
			placeholder="Buscar Nivel..."><br>
		<br>
		<div style="">
			<table style="width: 100%;" class="talbe table-striped"
				id="niveles_table">
				<thead
					style="display: block; margin: 0px; cell-spacing: 0px; left: 0px;">
					<td style="width: 50px;"><b>#</b></td>
					<td style="width: 900px;"><b>Nivel</b></td>
					<td align="center" style="width: 300px;"><b>Acciones</b></td>
				</thead>
				<tbody class="searchable"
					style="display: block; overflow: auto; height: 500px;">
				</tbody>
			</table>
		</div>

		<!-- Modal -->
		<div class="modal " id="agregarNivel" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="modalNivelTitulo">Agregar Nivel</h4>
					</div>
					<form class="form-signin" method='post' action=''>
						<div class="modal-body">
							<input name="funcion" id="funcion" type="text"
								class="form-control" value="0" required style="display: none;">
							<input name="nombre_nivel" id="nombre_nivel" type="text"
								class="form-control" placeholder="Nombre Nivel" required
								autofocus>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">CANCELAR</button>
							<button type="submit" class="btn btn-primary" name="guardar"><b>GUARDAR</b></button>
						</div>
					</form>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->


	</div>
	<!-- /container -->

  <!-- Site footer -->
<?php include_once '../components/footer.php'; ?>
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript"
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="js/admin.js"></script>
</body>
</html>
