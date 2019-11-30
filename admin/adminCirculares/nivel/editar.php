<?php
include '../../sesion_admin.php';
include '../../conexion.php';
include 'ControlNiveles.php';
if (!in_array('2', $capacidades)){
    header('Location: ../../menu.php');
}
$conexion = mysqli_connect ( $host, $usuario, $password ) or die ( "Fallo en el establecimiento de la conexión" );
mysqli_select_db ($conexion, $db );
$tildes = $conexion->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
require_once ('../../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();
$existe = '';
$id=$_GET["id"];
$datos = mysqli_query ( $conexion,"SELECT id,nivel from Catalogo_nivel WHERE id=".$id);
$dato = mysqli_fetch_assoc ($datos);
$nombre=$dato['nivel'];
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
    <title>CHMD (Administrador de circulares) :: Niveles</title>
    <link href="../../dist/css/bootstrap.css" rel="stylesheet">

  </head>
  <body>


  <div class="reload"></div>
    <div class="container" id='principal'>
      <div class="masthead">
        <a href="../../cerrar_sesion.php" style="float: right; cursor: pointer;"
          role="button" class="btn btnfamilia-default btn-sm">
          <span class="glyphicon glyphicon-user"></span> Cerrar Sesión
        </a> &nbsp
        <a href="../../menu.php">
          <button style="float: right; cursor: pointer;" type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-th"></span> Menu
          </button>
        </a>
        <h3 class="text-muted">Colegio Hebreo Maguén David</h3>
        <hr>
       
      </div>

<center>
      <h2>Mantenimiento de niveles (Modificar Nivel)</h2>
      <form action="common/actualizarNivel.php" method="POST">
            <table class="table" id="niveles_table">
              
            <tr>
            <td>Código del nivel</td>
            <td><input name="id" id="id" readonly="true" value="<?echo $id?>" /></td>
            
            </tr> 
            
            <tr>
            <td>Nombre del nivel</td>
            <td><input name="nnivel" id="nnivel" value="<?echo $nombre;?>" placeholder="Nombre"></td>
            </tr> 


            <tr>
            <td><a href="PNivel.php" class="btn btn-info">Retornar</a></td>
            <td><input type="submit" class="btn btn-success" value="Actualizar"></td>
            
            </tr>

            </table>
      </form>
</center>



    <div class="footer">
  <p>&copy; Aplicaciones CHMD 2019</p>
</div>
</div>
<!-- /container -->
<!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">
    function descargarpdf(id){
      setTimeout(() => {
         window.location='./common/pdf_chofer.php?idchofer='+id;
       }, 1000);
    }
  </script>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../../dist/js/bootstrap.js"></script>
   <script type="text/javascript" src="../../js/1min_inactivo.js" ></script>
</body>

    </div>
    


  </body>
  </html>