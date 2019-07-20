<?php
include '../../sesion_admin.php';
include 'conexion.php';
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
      <title>CHMD :: Alta Choferes y Autos</title>
      <link href="../../dist/css/bootstrap.css" rel="stylesheet">
      <link href="../../css/menu.css" rel="stylesheet">
    </head>
    <body>
      <div class="container">
        <div class="masthead">
          <a href="../../cerrar_sesion.php" style="float: right; cursor: pointer;"
          role="button" class="btn btn-default btn-sm"> <span
          class="glyphicon glyphicon-user"></span> Cerrar Sesión
        </a> &nbsp <a href="../../menu.php">
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
      <h2>Crear un Nuevo Chofer en la Familia:</h2>
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

      include ('./vistas/view_agregar_auto_chofer.php');
    }
    ?>
    <!-- Site footer -->
    <div class="footer">
      <p>&copy; Aplicaciones CHMD 2019</p>
    </div>
  </div>
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript"
  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../../dist/js/bootstrap.js"></script>
  <script type="text/javascript" src="js/Alta_chofer.js"></script>


</body>
</html>
<?php
}
