<?php
include '../sesion_admin.php';
include '../conexion.php';
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

  $nfamilia= htmlspecialchars(trim($_POST['nfamilia']));
  $nombres_chofer = htmlspecialchars(trim($_POST['nombres_chofer']));
  $apellidos_chofer = htmlspecialchars(trim($_POST['apellidos_chofer']));

  $nombre = $nombres_chofer. ' '. $apellidos_chofer;

  $sql="INSERT INTO usuarios(nombre, numero, tipo, celular, telefono, correo, calle, colonia, cp, correo2 )VALUES('$nombre','$nfamilia', 7, '0000000000','0000000000', 'sin correo', 'sin calle', 'sin colonia', 'sin cp', 'sin correo'  )";
  mysqli_set_charset($connection, "utf8");
  mysqli_query ($conexion, $sql );
  echo 'Solicitud Guardada';

}else{
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
      <link href="../css/menu.css" rel="stylesheet">
    </head>
    <body>
      <div class="container">
        <div class="masthead">
          <a href="cerrar_sesion.php" style="float: right; cursor: pointer;"
          role="button" class="btn btn-default btn-sm"> <span
          class="glyphicon glyphicon-user"></span> Cerrar Sesión
        </a> &nbsp <a href="menu.php">
          <button style="float: right; cursor: pointer;" type="button"
          class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-th"></span> Menu
        </button>
      </a>
      <h3 class="text-muted">Colegio Hebreo Maguén David</h3>
      <hr>
  <?php
//variable debe ser creada para el perfil
$perfil_actual='Choferes';
include ('perfiles_dinamicos.php');
   ?>
    </div>
    <br>
    <center><?php // echo isset($_POST['guardar']) ? $verificar=1 : '' ; ?></center>
    <!-- Button trigger modal -->
    <center>
      <h2>Nueva solicitud de diario:</h2>
    </center>
    <?php
    if (!$_GET)
    {
      ?>
      <form  method='get' action="Alta_chofer.php" >
        <input type="text" name="nfamilia" id="nfamilia"  placeholder="Agregar numero" size="5"  minlength="4" required>
        <input type="submit" value="Aceptar">
      </form>
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
        <form id="chofer"  name="chofer" class="form-signin save-nivel" method='post'   onsubmit='Alta_chofer(); return false'>
          <div class="alert-save"></div>
          <div class="modal-body">
            <table border="0" WIDTH="800" >
              <tr>
                <td colspan="3" WIDTH="100%">Fecha de solicitud:
                  <input name="fecha" id="fecha" type="text" class="form-control" placeholder="Fecha"  value="<?php echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').",".date("H:i:s");?>" readonly="readonly">
                </td>
              </tr>
              <tr >
                <td><br> </td>
              </tr>
            </table>

            <table border="0" WIDTH="800">
              <tr>
                <td WIDTH="100%" colspan="3"><br>
                  <h4><b>Padres</b></h4><br>
                </td>
              </tr>
              <tr>
                <td  WIDTH="100%" colspan="3">
                  Nombre de Papá:
                  <input
                  name="papa" id="papa" type="text"
                  class="form-control" placeholder="Sin papa"   value="<?php echo $calle ?>" readonly="" >
                </td>
              </tr>
              <tr>
                <td><br> </td>
              </tr>
              <tr>
                <td  WIDTH="100%" colspan="3">
                  Nombre de Mama:
                  <input
                  name="colonia1" id="colonia1" type="text"
                  class="form-control" placeholder="Colonia1"   value="<?php echo $colonia ?>" readonly="" >
                </td>
              </tr>
              <tr>
                <td WIDTH="100%" colspan="3"><br>
                  <h4><b>Datos de Chofer</b></h4>
                </td>
              </tr>
              <tr>
                <td>
                  Nombres:
                  <input
                  name="nombres_chofer" id="nombres_chofer" type="text"
                  class="form-control" placeholder="Agrege los nombres del chofer"  >
                </td>
                <td colspan="2">
                  Apellidos:
                  <input
                  name="apellidos_chofer" id="apellidos_chofer" type="text"
                  class="form-control" placeholder="Agrege los apellidos del chofer"  >
                </td>
              </tr>
              </table>

            <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $familia ?>" />
          </div>
          <div class="modal-footer">
            <button type="button" onclick="Cancelar(); return false;" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
          </div>
        </form>
      </center>
      <?php
    }
    ?>
    <!-- Site footer -->
    <div class="footer">
      <p>&copy; Aplicaciones CHMD 2017</p>
    </div>
  </div>
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript"
  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../dist/js/bootstrap.js"></script>
  <script type="text/javascript" src="js/Alta_chofer.js"></script>

</body>
</html>
<?php
}
