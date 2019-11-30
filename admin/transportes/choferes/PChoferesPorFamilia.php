<?php
include '../../sesion_admin.php';
include '../../conexion.php';
if (!in_array('2', $capacidades)){
    header('Location: ../../menu.php');
}

$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
'Miercoles', 'Jueves', 'Viernes', 'Sabado');
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('../../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="img/favicon.png">
      <title>CHMD :: Choferes</title>
      <link href="../../dist/css/bootstrap.css" rel="stylesheet">
      <link href="../../css/menu.css" rel="stylesheet">
          <!-- Dependencias Globales -->
  <?php include '../../components/header.php'; ?>

    </head>
    <body>
      <div class="wrapper">
    <!-- Sidebar  -->
    <nav class="" id="sidebar">
      <div id="dismiss">
          <i class="fas fa-arrow-left"></i>
      </div>
        <div class="sidebar-header">
            <h3>EVENTOS</h3>
        </div>
        
        <?php  $perfil_actual='10';    include ('../../menus_dinamicos/perfiles_dinamicos_choferes.php');
       ?>
      
    </nav>

    <!-- Page Content  -->
    <div id="content">
    <?php include_once "../../components/navbar.php"; ?>
      <div class="container-fluid">
        <div class="masthead">
    </div>
    <br>
    <center><?php // echo isset($_POST['guardar']) ? $verificar=1 : '' ; ?></center>
    <!-- Button trigger modal -->
     <a href="../../menu.php" style="cursor: pointer;" class="pull-right">
      <!-- Boton de Atras -->
      <?php include 'componentes/btn_atras.php'; ?>
    </a>
    <center>
      <h2 class="text-primary">Busqueda de chofere por Familia</h2>
    </center>
    <?php
    if (!$_GET)
    {
      ?>
      <form class="navbar-form navbar-right" role="search" method='get' action="">
        <div class="form-row">
          <div class="col-sm-9">
            <input type="text" class="form-control"  name="nfamilia" id="nfamilia" placeholder="Número de Familia" size="30"  minlength="4" required>
          </div>
          <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">
              <span class="glyphicon glyphicon-search"></span>
              <b> BUSCAR</b></button>
            </div>
          </div>
        </form>
        <hr width="100%">

      <?php
    }else {
      include ('./vistas/view_por_familia.php');
    }
    ?>

  </div>
     <!-- Site footer -->
<?php include_once '../../components/footer.php'; ?>
  <?php include_once "../components/footer.php"; ?>
    </div>
    <div class="overlay"></div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script type="text/javascript" src="js/Alta_chofer.js"></script>
   <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">
  $(document).ready(function () {
      $("#sidebar").mCustomScrollbar({
          theme: "minimal"
      });

      $('#dismiss, .overlay').on('click', function () {
          $('#sidebar').removeClass('active');
          $('.overlay').removeClass('active');
      });

      $('#sidebarCollapse').on('click', function () {
          $('#sidebar').addClass('active');
          $('.overlay').addClass('active');
          $('.collapse.in').toggleClass('in');
          $('a[aria-expanded=true]').attr('aria-expanded', 'false');
      });
  });
</script>
</body>
</html>
