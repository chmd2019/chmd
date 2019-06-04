<?php

session_start ();
if (isset ( $_SESSION ['usuario'] ) && isset ( $_SESSION ['contrasena'] )) 
    {
	header ( 'Location: menu.php' ); 
} else {
	unset ( $_SESSION ['usuario'] );
	unset ( $_SESSION ['contrasena'] );
	session_destroy ();
	
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="author" content="@AnahiAnndroid">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="img/favicon.png">

<title>edd</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/index.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="dist/js/ie8-responsive-file-warning.js"></script><![endif]-->

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
    if (isset ( $_POST ['entrar'] )) 
            
            {
        $usuario_get = $_POST ["usuario"];
       $contrasena_get = $_POST ["contrasena"];
       echo "$usuario_get";
       if ($usuario_get && $usuario_get)
       {
           include 'conexion.php';
           
          
           
           
           
           $conexion = mysqli_connect ( $host, $usuario, $password );
           
	   mysqli_select_db ($conexion, $db );
           $tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
           
           $resultado = mysqli_query ($conexion, "SELECT * FROM usuarios1 WHERE usuario = '" . $usuario_get . "' LIMIT 1" );
	
           if ($resultado) 
          {
        if ( $extraido = mysqli_fetch_array ( $resultado ) )
        {
            session_start ();
              $usuario = $extraido ["usuario"];
	$contrasena = $extraido ["contrasena"];
        $_SESSION ['usuario'] = 1;
	$_SESSION ['contrasena'] = 1;
        $_SESSION ['id'] =$extraido ["id"];
        mysqli_free_result($resultado);
        mysqli_close($conexion);
           
           
                    
          header('Location: menu.php');
            
        }
        else
        {
            $_SESSION ['usuario'] = 0;
	$_SESSION ['contrasena'] = 0;
header('Location: https://www.chmd.edu.mx/');
            
        }
        
      
               
               
               
           }
         
        
           
       } 
       else 
       {
           header('Location: https://www.chmd.edu.mx/');
       }
      //  header('Location: https://www.google.com/');
//exit;
        
    }
    /*
	
	//require_once ('FirePHPCore/FirePHP.class.php');
	//$firephp = FirePHP::getInstance ( true );
	//ob_start ();
	
	if (isset ( $_POST ['entrar'] )) 
            
            {
            echo "ldñdñlñd";
		$usuario_get = $_POST ["usuario"];
		$contrasena_get = $_POST ["contrasena"];
		if ($usuario_get && $usuario_get)
                    {
			header ( 'Content-type: application/json; charset=utf-8' );
			//include 'conexion.php';
                        echo "hola";
			/*
			$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
			mysqli_select_db ( $db );
			$resultado = mysqli_query ( "SELECT * FROM usuarios1 WHERE usuario = '" . $usuario_get . "' LIMIT 1" ) or die ( "Error en query, el error  es: " . mysql_error () );
			mysql_close ( $conexion );
			
			if ($resultado) {
                            
				if ( $usr = mysqli_fetch_array ( $resultado ) )
                                        {
					session_start ();
                                    
					$usuario = $usr ["usuario"];
					$contrasena = $usr ["contrasena"];
                                        $_SESSION ['usuario'] = 1;
					$_SESSION ['contrasena'] = 1;
                                         $_SESSION ['id'] =$usr ["id"];
                                      header ( 'Location: index.php' );
				}
				
				 else {
					 $result = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Oops!</strong><br>Usuario y/o Contraseña incorrectos</div>';
					$_SESSION ['usuario'] = 0;
					$_SESSION ['contrasena'] = 0;
					header ( 'Location: index.php' );
				}
			}
                        
                        
                      
                        
                        
		} else 
                    {
			// $result = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Oops!</strong><br>Usuario no Registrado</div>';
			$_SESSION ['usuario'] = 0;
			$_SESSION ['contrasena'] = 0;
			//header ( 'Location: index.php' );
		}
	}
	*/
	?>

    <div class="container">
       
		<form class="form-signin" method='post' action=''>
			<h2 class="form-signin-heading">Transportes CHMD</h2>

			<input name="usuario" type="text" class="form-control"
				placeholder="Usuario" required autofocus> <input name="contrasena"
				type="password" class="form-control" placeholder="Contraseña"
				required> <label class="checkbox"> <input type="checkbox"
				value="remember-me"> Recordar
			</label>
			<button class="btn btn-lg btn-primary btn-block" type="submit"
				name="entrar">Entrar</button>
			<br> <br> <br> <br>
        <?php //echo $result; ?>
      </form>

	</div>
	<!-- /container -->


	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
<?php
}
?>