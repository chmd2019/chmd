<?php
include '../sesion_admin.php';
include '../conexion.php';
if (!in_array('0', $capacidades)){
    header('Location: ../menu.php');
}
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
    id_ruta,
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
      <title>CHMD :: Alta Diario</title>
      <link href="../dist/css/bootstrap.css" rel="stylesheet">
      <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <link href="../css/menu.css" rel="stylesheet">
          <!-- Dependencias Globales -->
    <?php include '../components/header.php'; ?>
    <?php $perfil_actual='diario'; include ('../menus_dinamicos/perfiles_dinamicos_solicitudes.php'); ?>
    </head>
    <body>
       <div class="wrapper">
    <!-- Sidebar  -->
    <nav class="" id="sidebar">
      <div id="dismiss">
          <i class="fas fa-arrow-left"></i>
      </div>
        <div class="sidebar-header">
            <h3>TRANSPORTES</h3>
        </div>
        
                <?php $perfil_actual='-1'; include ('../menus_dinamicos/perfiles_dinamicos_solicitudes.php'); ?>
    
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

<a href="PDiario.php" style="cursor: pointer;" class="pull-right">
  <!-- Boton de Atras -->
  <?php include 'componentes/btn_atras.php'; ?>
</a>
    <center>
      <h2 class="text-primary">Nueva solicitud de diario:</h2>
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
      $familia=$_GET["nfamilia"];
      $direccion = mysqli_query($conexion, "SELECT calle,colonia,cp FROM usuarios WHERE numero='$familia' limit 1");
      while ($rows=mysqli_fetch_array($direccion))
      {
        $calle=$rows['calle'];
        $colonia=$rows['colonia'];
        $cp=$rows['cp'];
      }
      $datos = mysqli_query ($conexion, "SELECT id,nombre,correo from usuarios WHERE numero='$familia'" );
      ?>
      <center>
        <form id="diario"  name="diario" class="form-signin save-nivel" method='post'   onsubmit='Alta_diario(); return false'>
          <div class="alert-save"></div>
          <div class="modal-body">
            <table border="0" WIDTH="100%" >
              <tr>
                <td colspan="3" WIDTH="100%">Fecha de solicitud:
                  <input name="fecha" id="fecha" type="text" class="form-control" placeholder="Fecha"  value="<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>" readonly="readonly">
                </td>
              </tr>
              <tr >
                <td><br> </td>
              </tr>
              <tr>
                <td colspan="1"> Solicitante:</td>
              </tr>
              <tr>
                <td colspan="1">
                  <select class="form-control" name="solicitante" id="solicitante">
                    <?php
                    while ($rows=mysqli_fetch_array($datos))
                    {
                      $idusuario=$rows['id'];
                      $nombre= $rows['nombre'];
                      $correo= $rows['correo'];
                      ?>
                      <option value="<?=$idusuario?>"><?=$nombre?></option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
              </tr>
            </table>
            <table  style=""  WIDTH="100%" >
            <tr>
              <td WIDTH="100%" colspan="3">
                <h4><b>Alumnos Solicitantes:</b></h4><br>
              </td>
            </tr>
            <tr style="border-bottom: 1px solid #bbb">
              <th style="text-align:center;">Alumno</th>
              <th style="text-align:center;">Grado</th>
              <th style="text-align:center;">Grupo</th>
              <th style="text-align:center;">Selección</th>
            </tr>
            <?php
            $counter=0;
            $existe = mysqli_query ($conexion,  "SELECT * FROM alumnoschmd where idfamilia=$familia" );
            while($cliente=mysqli_fetch_array($existe))
            {
              $counter = $counter + 1;
              ?>
              <tr  style="border-bottom: 1px solid #eee" id="fila-<?php echo $cliente['id'] ?>">
                <td style="text-align:center;"><?php echo $cliente['nombre']?></td>
                <td style="text-align:center;"><?php echo $cliente['grupo']?></td>
                <td style="text-align:center;"><?php echo $cliente['grado'] ?></td>
    <td style="text-align:center;"><input type="checkbox"  id="alumno<?php echo $counter?>" name="alumno[]" class="form-control" value="<?php echo $cliente['id']; ?>" style= "box-shadow: none;"></td>
              </tr>
              <?php
            }
            $talumnos=$counter;
            ?>
          </table>
            <table border="0" WIDTH="100%">
              <tr>
                <td WIDTH="100%" colspan="10"><br>
                  <h4><b>Dirección de Actual:</b></h4><br>
                </td>
              </tr>

              <tr>
                <td WIDTH="50%" colspan="5">
                  Calle y Número: :
                  <input
                  name="calle1" id="calle1" type="text"
                  class="form-control" placeholder="Calle_numero"  value="<?php echo $calle ?>" readonly="" >
                </td>
                <td WIDTH="30%" colspan="3">
                  Colonia:
                  <input
                  name="colonia1" id="colonia1" type="text"
                  class="form-control" placeholder="Colonia1" value="<?php echo $colonia ?>" readonly="" >
                </td>

                <td WIDTH="20%" colspan="2">
                  CP:
                  <input
                  name="cp1" id="cp1" type="text"
                  class="form-control" placeholder="cp" maxlength="5" value="<?php echo $cp ?>" readonly="" >
                </td>
              </tr>
            </table>

            <table border="0" WIDTH="100%">
              <tr>
                <td WIDTH="100%" colspan="10"><br>
                  <h4><b>Dirección de cambio:</b></h4>
                </td>
              </tr>
              <tr>
                <td WIDTH="60%" colspan="6">
                  Calle:
                  <input
                  name="calle" id="calle" type="text"
                  class="form-control" placeholder="Calle_numero"   >
                </td>
                <td WIDTH="40%" colspan="4">
                  CP:
                  <input
                  name="cp" id="cp" type="text"
                  class="form-control" placeholder="Agrega cp"   maxlength="5" >
                </td>
              </tr>
              <tr>
                <td WIDTH="60%" colspan="6"><br>Colonia:
                  <input
                  name="colonia" id="colonia" type="text"
                  class="form-control" placeholder="Colonia" >
                </td>
                <td WIDTH="40%" colspan="4">
                  <br>Ruta:
                  <select type="select" name="ruta"  id="ruta" class="form-control">
                    <option value="0">selecciona opción </option>
                    <option value="1">[General 2:50 PM]</option>
                    <option value="2">[Taller 4:30 PM]</option>
                  </select>
                  </td>
                </tr>

                <tr>
                  <td><br>
                    Fecha del Permiso:
                    <div class="input-group date datepicker" data-date-format="dd/mm/yyyy">
                      <input class="form-control" size="15" id="fecha_permiso" name="fecha_permiso" placeholder="Seleccione una fecha" type="text" disabled required/>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </td>
                </tr>

              </table>
            </table>
            <br><b>Comentarios de solicitud:</b>
            <textarea class="form-control"  id="Comentarios" name="comentarios"  ></textarea>
          <!--  <input type="hidden" name="idusuario" id="idusuario"  value="<?php echo $idusuario ?>" />  -->
            <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $familia ?>" />
            <input type="hidden" name="talumnos" id="talumnos"  value="<?php echo $talumnos ?>" />
          </div>
          <div class="modal-footer">
            <button type="button" onclick="Cancelar();return false;" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
            <button type="submit" class="btn btn-primary" name="guardar"><b>GUARDAR</b></button>
          </div>
        </form>
      </center>
      <?php
    }
    ?>

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
  <script type="text/javascript" src="js/Alta_diario.js"></script>
  <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
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
<?php
}
