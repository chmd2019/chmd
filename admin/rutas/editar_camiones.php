
<?php
include '../sesion_admin.php';
include '../conexion.php';

if (!in_array('32', $capacidades)){
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
if (isset($_GET['id_ruta'])){
  $id_ruta = htmlspecialchars(trim($_GET['id_ruta'])) ;
}else{
  header('Location: Pcamiones.php');
}
$sql ="SELECT * FROM rutas r WHERE id_ruta='$id_ruta' LIMIT 1;";
$datos = mysqli_query ( $conexion, $sql);
while ($r = mysqli_fetch_assoc($datos) ){
  $nombre_ruta= $r['nombre_ruta'];
  $camion = $r['camion'];
  $auxiliar = $r['auxiliar'];
  $cupos = $r['cupos'];
  $tipo_ruta = $r['tipo_ruta'];
}
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
      <title>CHMD :: Editar Ruta</title>
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
    <center><?php // echo isset($_POST['guardar']) ? $verificar=1 : '' ; ?></center>
    <!-- Button trigger modal -->
    <a href="Pcamiones.php" style="cursor: pointer;" class="pull-right">
    <!-- Boton de Atras -->
    <?php include 'componentes/btn_atras.php'; ?>
    </a>
    <center>
      <h2 class="text-primary">Editar la Ruta - <?=$nombre_ruta?></h2>
    </center>
    <?php
    //  $familia=$_GET["nfamilia"];
    //  $datos = mysqli_query ($conexion, "SELECT id,nombre,correo  from usuarios WHERE numero='$familia'" );
    $solicitante_admin = $user_session;
    $solicitante_id = $id_user_session;

    $datos = mysqli_query ($conexion, "SELECT adm.id, adm.usuario, usu.id as id_usuario, usu.correo  from usuarios usu INNER JOIN Administrador_usuarios adm ON usu.perfil_admin =adm.id  WHERE usu.id='$solicitante_id' LIMIT 1" );
    ?>
    <input id="camion_old" name="camion_old"  type="hidden" value="<?=$camion?>" >
    <table border="0" WIDTH="100%" >

            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Nombre de la Ruta:
                <input name="nombre_ruta" id="nombre_ruta" type="text" class="form-control" placeholder="Agrege el Nombre de la Nueva ruta"  value="<?=$nombre_ruta?>">
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Auxiliar:
                <select name="auxiliar" id="auxiliar" type="text" class="form-control">
                    <option value='0'>SELECCIONAR AUXILIAR</option>
                    <?php    //auxiliares
                        $sql ="SELECT id, nombre FROM usuarios WHERE tipo ='9'";
                        $query = mysqli_query($conexion, $sql);
                        while($r = mysqli_fetch_array($query)){
                      ?>
                    <option value="<?php echo $r[0]; ?>"  <?php if( $r[0] == $auxiliar) echo 'selected' ?>><?php echo strtoupper($r[1]); ?></option>
                     <?php
                        }
                     ?>
                  </select>
              </td>
            </tr>
          </table>
          <table border="0" WIDTH="100%">
            <tr class="row">
              <td class="col-sm" colspan="1" WIDTH="50%">Tipo de Ruta:
                <select class="form-control" name="tipo_ruta" id="tipo_ruta"  onchange="existe_camion()">
                  <option value="0" selected disabled>SELECIONE UN TIPO DE RUTA</option>
                  <option value="1" <?php if( $tipo_ruta == '1') echo 'selected' ?>>GENERAL</option>
                  <option value="2" <?php if( $tipo_ruta == '2') echo 'selected' ?>>KINDER</option>
                </select>
              </td>
              <td class="col-sm" colspan="1" WIDTH="50%">Número de Camión:
                <input onchange="existe_camion()" name="camion" id="camion" type="number" class="form-control" placeholder="Agrege el Número de camión" value="<?=$camion?>" max="99" step="1" min="01">
                <small id="existe_camion" class="text-danger" style="display:none">Ya existe el Número de Camión</small>
              </td>
            </tr>
            <tr class="row">
              <td class="col-sm-6" colspan="1" WIDTH="50%">Número de Cupos:
                <input name="cupos" id="cupos" type="number" class="form-control" placeholder="Agrege el Número de cupos"  value="<?=$cupos?>" max="99" step="1" min="01">
              </td>
            </tr>

            <tr class="row">
              <td  class="col-sm text-right p-3"  >
                <button class="btn btn-primary" id="button_editar" onclick="editar_inputs(<?=$id_ruta?>)"><b><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;EDITAR</b></button>
              </td>
            </tr>
        </table>
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
  <script type="text/javascript" src="js/editar_camiones.js"></script>
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
