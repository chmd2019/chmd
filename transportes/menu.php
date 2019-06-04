<?php 
include('sesion_admin.php');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>CHMD :: Menu</title>

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

    <div class="container">

      <div class="masthead">
        <a style="float:right;cursor:pointer;" href="cerrar_sesion.php" role="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-user"></span> Cerrar Sesión
        </a>
        <h3 class="text-muted">Colegio Hebreo Maguén David</h3>
        <hr>
      </div>

      <div class="row" style="margin-top:150px">
        <div class="col-lg-6">
          <center>
              <a href="PDiario.php">
              <button style="width:100%;height:150px;" class="btn btn-large btn-primary" type="button">Solicitudes</button>
            </a>
          </center>
        </div>
        <div class="col-lg-6">
          <center>
            <a href="HPDiario.php">
              <button style="width:100%;height:150px;" class="btn btn-large btn-success" type="button">Historial</button>
            </a>
          </center>
       </div>
        
      </div>

      <!-- Site footer -->
      <div class="footer">
        <p>&copy; Aplicaciones CHMD 2017</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
