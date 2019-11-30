
<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('26', $capacidades)){
  header('Location: ../menu.php');
}

$root_imagenes=' http://chmd.chmd.edu.mx:65083';
$time = time();
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
'Miercoles', 'Jueves', 'Viernes', 'Sabado');
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
//$datos = mysql_query ( "select papa,calle,colonia,cp from usuarios where password='$fam'" );

if(isset($_POST['submit']))
{

  $idusuario= htmlspecialchars(trim($_POST['idusuario']));
  $calle = htmlspecialchars(trim($_POST['calle']));
  $colonia = htmlspecialchars(trim($_POST['colonia']));
  $cp = htmlspecialchars(trim($_POST['cp']));
  $ruta = htmlspecialchars(trim($_POST['ruta']));
  $comentarios = htmlspecialchars(trim($_POST['comentarios']));
  $talumnos = htmlspecialchars(trim($_POST['suma']));
  $nfamilia = htmlspecialchars(trim($_POST['nfamilia']));
  $fecha = htmlspecialchars(trim($_POST['fecha']));
  $fecha_permiso = htmlspecialchars(trim($_POST['fecha_permiso']));
  $alumnos= htmlspecialchars(trim($_POST['alumnos']));
  $tipo_permiso=1 ; //permiso Diario.
  $alumnos_array = explode('|', $alumnos);

  //crear permiso
  $query = "INSERT INTO Ventana_Permisos(
    idusuario,
    calle_numero,
    colonia,
    cp,
    ruta,
    comentarios,
    nfamilia,
    tipo_permiso,
    fecha_creacion,
    fecha_cambio)
    VALUES (
    '".$idusuario."',
    '".$calle."',
    '".$colonia."',
    '".$cp."',
    '".$ruta."',
    '".$comentarios."',
    '".$nfamilia."',
    '".$tipo_permiso."',
    '".$fecha."',
    '".$fecha_permiso."')";
    mysqli_query ($conexion, $query );

    $ultimo_id = mysqli_insert_id($conexion);
    $id_permiso= $ultimo_id; // Por resolver (1)
    //almacenar Alumno
    foreach($alumnos_array as $id_alumno){
      $sql = "INSERT INTO Ventana_permisos_alumnos(
      id_permiso, id_alumno
      ) VALUES ('".$id_permiso."','".$id_alumno."' )";

      mysqli_query ($conexion, $sql );

    }

    echo 'Solicitud Guardada';

  }
  else
  {

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
      <title>CHMD :: Alta Rutas</title>
      <link href="../dist/css/bootstrap.css" rel="stylesheet">
      <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <link href="../css/menu.css" rel="stylesheet">
      <link rel="stylesheet" href=" https://cdn.jsdelivr.net/npm/timepicker/jquery.timepicker.css">
        <!-- Dependencias Globales -->
  <?php include '../components/header.php'; ?>
    </head>
    <body>
      <div class="wrapper">
    <!-- Sidebar  -->
    <nav class="" id="sidebar">
      <div id="dismiss">
          <i class="fas fa-arrow-left"></i>
      </div>
        <div class="sidebar-header">
            <h3>RUTAS</h3>
        </div>
      <?php $perfil_actual='-1'; include ('../menus_dinamicos/perfiles_dinamicos_rutas.php'); ?>
    </nav>
    <!-- Page Content  -->
    <div id="content">
      <?php include_once "../components/navbar.php"; ?>

      <div class="container-fluid">
        <div class="masthead">
    </div>
    <br>
    <!-- Button trigger modal -->
<a href="Prutas.php" style="cursor: pointer;" class="pull-right">
<!-- Boton de Atras -->
<?php include 'componentes/btn_atras.php'; ?>
</a>
    <center>
      <h2 class="text-primary">Nueva Ruta:</h2>
    </center>
    <center>
      <form id="eventos"  name="eventos" class="form-signin save-nivel"   >
        <div class="alert-save"></div>
        <div class="modal-body">
          <table border="0" WIDTH="100%" >
            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Nombre de la Ruta:
                <input name="nombre_ruta" id="nombre_ruta" type="text" class="form-control" placeholder="Agrege el Nombre de la Nueva ruta"  value="" >
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Prefecta:
                <input name="prefecta" id="prefecta" type="text" class="form-control" placeholder="Agrege la Prefecta"  value=""  >
              </td>
            </tr>
          </table>
          <table border="0" WIDTH="100%">
            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Número de Camión:
                <input name="camion" id="camion" type="number" class="form-control" placeholder="Agrege el Número de camión"  value="" max="99" step="1" min="01">
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Número de Cupos:
                <input name="cupos" id="cupos" type="number" class="form-control" placeholder="Agrege el Número de cupos"  value="" max="99" step="1" min="01">
              </td>
            </tr>
          </table>
        <div class="modal-footer" style="border:none">
          <button type="button" class="btn btn-danger" onclick="cancelar()">CANCELAR</button>
          <button type="button" class="btn btn-primary" onclick="enviar_formulario()"><b>ENVIAR</b></button>
        </div>
      </form>
    </center>
  </div>
   <!-- Site footer -->
<?php include_once '../components/footer.php'; ?>
</div>
<div class="overlay"></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script type="text/javascript" src="js/alta_rutas.js"></script>
  <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
  <script src="https://cdn.jsdelivr.net/npm/timepicker/jquery.timepicker.min.js"></script>
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
<?php
}
