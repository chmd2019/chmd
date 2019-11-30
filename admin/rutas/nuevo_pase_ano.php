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
// $existe = '';
// if (isset($_POST['id_ruta'])){
//   $id_ruta = htmlspecialchars(trim($_POST['id_ruta'])) ;
// }else{
//   header('Location: Prutas.php');
// }

// $datos = mysqli_query ( $conexion, "SELECT * FROM rutas WHERE id_ruta='$id_ruta';");
// while ($r = mysqli_fetch_assoc($datos) ){
//   $nombre_ruta= $r['nombre_ruta'];
//   $camion = $r['camion'];
//   $prefecta = $r['prefecta'];
//   $cupos = $r['cupos'] ;
// }




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
      <title>CHMD :: Pase de Año</title>
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
    <a href="PpaseAno.php" style="cursor: pointer;" class="pull-right">
    <!-- Boton de Atras -->
    <?php include 'componentes/btn_atras.php'; ?>
    </a>
    <center>
      <h2 class="text-primary">Nuevo Pase de Año</h2>
    </center>
    <?php
    //  $familia=$_GET["nfamilia"];
    // //  $datos = mysqli_query ($conexion, "SELECT id,nombre,correo  from usuarios WHERE numero='$familia'" );
    // $solicitante_admin = $user_session;
    // $solicitante_id = $id_user_session;
    //
    // $datos = mysqli_query ($conexion, "SELECT adm.id, adm.usuario, usu.id as id_usuario, usu.correo  from usuarios usu INNER JOIN Administrador_usuarios adm ON usu.perfil_admin =adm.id  WHERE usu.id='$solicitante_id' LIMIT 1" );
    //
    ?>
    <center>
      <form id="eventos"  name="eventos" class="form-signin save-nivel"   >
        <div class="modal-body text-left">
          <table border="0" WIDTH="100%" >
            <tr class="row">
              <td class="col-sm text-justify">
                <p>EL pase de año es un procedimiento que desvincula los alumnos de 6to Semestre de Bachillerato de las rutas Generales. Además, desvincula los alumnos de Preprimaria de las Rutas de Kinder. </p>
                <p>Al darle al boton <b>Generar</b>, se creará un nuevo listado generado de las rutas bases, donde se excluyen a los alumnos de 6to Semestre de Bachillerato y son liberados los de Preprimaria para su reubicación en las rutas generales.</p>
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer" style="border:none">
          <button type="button" class="btn btn-danger" onclick="cancelar()">CANCELAR</button>
          <button type="button" class="btn btn-primary" onclick="enviar_formulario()"><b>GENERAR</b></button>
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
  <script type="text/javascript" src="js/nuevo_pase_ano.js"></script>
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
<?php
$i = 0;
$lista_fechas;
$sql = "SELECT * FROM Calendario_escolar";
$fecha_calendario_escolar = mysqli_query($conexion, $sql);
if ($fecha_calendario_escolar) {
    while ($respuesta_calendario_escolar = mysqli_fetch_array($fecha_calendario_escolar)) {
        $lista_fechas[$i] = $respuesta_calendario_escolar[1];
        $i++;
    }
}
?>
<script type="text/javascript">
    var calendario_escolar = <?php echo json_encode($lista_fechas) ;?>;
    $('.datepicker').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 0,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      startDate: '+0d',
      daysOfWeekDisabled: [0, 6],
      datesDisabled: calendario_escolar,
      forceParse: 0,
      format: "DD, dd MM yyyy"
    });
</script>
</body>
</html>
